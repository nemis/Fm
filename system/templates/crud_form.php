<form method="post" action="<?=Router::createUrl(array(), false, false)?>" class="crud-form">
<fieldset>
<table>
<?php

foreach ($model->fields() as $column => $name)
{
	echo '<tr>';
	echo '<td>'.$name.'</td>';
	echo '<td><input type="text" name="data['.$column.']" value="'.htmlspecialchars($model->$column).'"/>';
}

?>
</table>
<input type="hidden" name="id" value="<?=$model->id?>"/>
<input type="submit" class="submit" value="<?=Dict::word('Save')?>"/>
</fieldset>
</form>