<?php
	ob_start();
    
    function __autoload($sClassName) {
        require_once("classes/$sClassName.class.php");
    }
	
	// Member-only page
    if (!isset($_COOKIE['user'])) {
        header('Location: /');
    } else {
		//$user = unserialize($_COOKIE['user']);
		$user = $_COOKIE['userid'];
        $user = new User($user);

		//echo "<script>alert('$user->uid " . $_COOKIE['userjson'] . "');</script>";
		//echo "" . $user->email ." ". $user->name ." ". $user->alias;
    }
	
	if (!isset($_REQUEST['email'])) {
        // stay on this page
    } else {
        // create new user and redirect to manage.php
		$updateResult = $user->UpdateUserMeta($_REQUEST['email'], $_REQUEST['name'], $_REQUEST['alias']);
		
		if ($updateResult == 1)
		{
			$error = "Settings saved!";
		}
		else
		{
			$error = $updateResult;
		}
    }
//echo "Magic quotes is " . (get_magic_quotes_gpc() ? "ON" : "OFF");
?>

<div class="left bold title">Settings</div>
<div class="white h-spaced v-spaced separated shadow" id="message">
	<form id="settings-form" action="settings.php" method="POST">
		<div>
            <?php
                echo isset($error) ? $error : "";
            ?>
        </div>
		<div class="row">
            <div class="label"><label for="email">Email</label></div>
            <input name="email" id="email" autofocus maxlength="30" tabindex="1"
                    <?php
						echo "value=\"" . $user->email . "\"";
                    ?> 
			/> 
            <!-- <div class="note" id="emailNote">First, we need your email.</div> -->
        </div>
        <div class="row">
            <div class="label"><label for="name">Name</label></div>
            <input name="name" id="name" maxlength="30" tabindex="4"
                    <?php
						echo "value=\"" . $user->name . "\"";
                    ?>
            />
            <!-- <div class="note" id="nameNote"></div> -->
        </div>
        <div class="row">
            <div class="label"><label for="alias">Alias</label></div>
            <input name="alias" id="alias" maxlength="30" tabindex="5"
                    <?php
						echo "value=\"" . $user->alias . "\"";
                    ?>
            />
            <!-- <div class="note" id="aliasNote"></div> -->
        </div>
        <div class="centred" tabindex="6">
            <div class="button" id="settings" style="width: auto; padding: 0 10px;" tabindex="7">Save Changes</div>
			<input type="submit" value="save" />
        </div>
	</form>
</div>


<?php
    $sTitle = "Settings";
    require_once("wrapper/wrapper.php");
?>
