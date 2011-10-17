<?php
	require_once(dirname(__FILE__).'/inc/redirect.php');
	require_once(dirname(__FILE__).'/inc/Caramel.php');
	
	$caramel = new Caramel();

?>
<!DOCTYPE HTML>
<?php print($caramel->versionInformation()); ?>

<html lang="<?php print($caramel->languageCode()); ?>">

<head>

<?php print($caramel->headTag()); ?>

</head>

<body>
<a id="top"></a>


<div id="header"></div>


<div id="mainContent">  
<?php print($caramel->content()); ?>  
</div>


<div id="nav">
<?php print($caramel->navigation()); ?>
</div>


<div id="footer">
<?php print($caramel->footer()); ?>
</div>


</body>

</html>