<?php
	//gather all output from the output buffer and place it in a variable
	$sContent = ob_get_clean();
	//the previous line STOPS output, so we restart output
	ob_start();
?>
 <!DOCTYPE html> 
<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->

<!-- BEGIN THEME -->
<?php //require 'opener.php'; ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="wrapper/css/main.css"/>
        <script type="text/javascript" src="scripts/jquery.min.js"></script>
        <script type="text/javascript" src="scripts/jquery-ui.min.js"></script>
        <title>CrashCards - <?php echo $sTitle; ?></title>
		
        <!-- Include top scripts here -->
        
    </head>
    <body>

<?php
    if (isset($_COOKIE['user'])) {
        require 'userbar.php';
    } else {
        require 'loginbar.php';
    }
?>

<div class="centred" id="wrapper">

    <div class="main centred" id="content">
		
		<?php echo $sContent; ?>
		
		<?php require 'footer.php'; ?>
    </div>
</div>
<?php require 'closer.php'; ?>
<!-- END THEME -->