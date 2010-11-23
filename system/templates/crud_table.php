<form method="get" action="<?=Router::createUrl(array('delete' => '1'))?>" id="crud-form">
<div>
<table class="crud-table">
<tr>
<th>&nbsp;</th>
<?php

foreach ($columns as $column => $name)
{
	echo '<th><a href="'.Router::createUrl(array('orderby' => $column, 'page' => $page)).'">'.$name.'</a></th>';
}

?>
</tr>
<tr class="crud-search-tr">
<td>&nbsp;</td>
<?php

foreach ($columns as $column => $name)
{
	echo '<td>';
	echo '<input type="text" class="crud-search-field" name="search['.$column.']" value="'.((isset($_GET['search']['column'])) ? htmlspecialchars($_GET['search']['column']) : '').'">';
	echo '</td>';
}

?>
</tr>
<?php 

foreach ($iterations as $row)
{
	echo '<tr>';
	echo '<td><input type="checkbox" name="ids['.$row->id.']"'.((isset($_GET['ids'][$row->id]) and ($_GET['ids'][$row->id] == 'on')) ? ' checked="checked"' : '').'/></td>';
	foreach ($columns as $column => $name)
	{
		echo '<td onclick="document.location = \''.Router::createUrl(array('id' => $row->id)).'\'">'.$row->$column.'</td>';
	}
	echo '</tr>';
}

?>
</table>
<?php if ($countAll > 0) { ?>
<a href="javascript:document.getElementById('crud-form').submit()"><?=Dict::word('delete marked')?></a>
|
<?php } ?>
<?php echo Dict::word('total'), ': ', $countAll, ' '?>

<?php if ($countAll > 0) { ?>
| <?=$pagination?>
<?php } ?>
</div>
</form>