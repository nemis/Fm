<form method="post" action="">
<div>
<label for="name"><?=Dict::word('Name')?>:</label><br/>
<input type="text" class="wide" value="" name="name"/>
<br/>
<br/>
<textarea name="body" id="static-body" class="static-body">
</textarea>
<script type="text/javascript" src="<?=Router::baseUrl()?>public/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR.replaceAll('static-body');
</script>
<div class="right">
	<input type="submit" class="submit" value="<?=Dict::word('Save')?>"/>
</div>
</div>
</form>