<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->GetNamePage()?></title>
<link rel="shortcut icon" href="images/favicon.gif" />
<?php
Script::Render('Jquery');
Script::Render('HtmlHelper');
?>
</head>
<body>

<div id="midrow">
	<div class="center">
    <div class="textbox2">
	<p> <?php while ($this->GetContent('center')) echo '</p><p>'; ?></p>
     	</div>
	</div>
</div>

<div id="footer">
<div class="foot">Powerd By Tunnel</div>
</div>

</body>
</html>
