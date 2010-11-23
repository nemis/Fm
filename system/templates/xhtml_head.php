<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title><?=$title?></title>
<meta name="keywords" content="<?=$keywords?>" />
<meta name="description" content="<?=$description?>"/>
<meta name="allow-search" content="yes"/>
<meta name="doc-type" content="Web Page"/>
<meta name="doc-class" content="Published"/>
<meta name="doc-rights" content="Copywritten Work"/>
<?php foreach ($this->application->styles() as $style) { ?>
<link rel="stylesheet" href="<?=Router::baseUrl()?>/public/css/<?=$style?>.css"/>
<?php } ?>
</head>
<body>