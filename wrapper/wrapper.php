<?php
	//gather all output from the output buffer and place it in a variable
	$sContent = ob_get_clean();
	//the previous line STOPS output, so we restart output
	ob_start();
?>
<!-- BEGIN THEME -->
<?php require 'opener.php'; ?>
<?php require 'userbar.php'; ?>

<div class="centred" id="wrapper">

    <div class="main centred" id="content">
		
		<?php echo $sContent; ?>
		
		<?php require 'footer.php'; ?>
    </div>
</div>
<?php require 'closer.php'; ?>
<!-- END THEME -->