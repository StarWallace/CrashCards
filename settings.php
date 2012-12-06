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
		else if ($updateResult == 0)
        {
            $error = "No changes to save.";
        }
        else
		{
			$error = $updateResult;
		}
    }
//echo "Magic quotes is " . (get_magic_quotes_gpc() ? "ON" : "OFF");
?>

<link rel="stylesheet" type="text/css" href="wrapper/css/settings.css"/>

<div class="settingsInfo v-spaced h-spaced white shadow">
    <div class="left bold title">Settings</div>
    <div class="floatLine"></div>
    <div class="fields">
        <form id="settings-form" action="settings.php" method="POST">
            <div id="error">
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
            </div>
            <div class="row">
                <div class="label"><label for="name">Name</label></div>
                <input name="name" id="name" maxlength="30" tabindex="2"
                    <?php
                        echo "value=\"" . $user->name . "\"";
                    ?>
                />
            </div>
            <div class="row">
                <div class="label"><label for="alias">Alias</label></div>
                <input name="alias" id="alias" maxlength="30" tabindex="3"
                    <?php
                        echo "value=\"" . $user->alias . "\"";
                    ?>
                "/>
            </div>
        </form>
        <div class="centred" tabindex="6">
            <div class="button right bottom" id="settings-submit" style="width: auto; padding: 0 10px;" tabindex="7">Save Changes</div>
        </div>
    </div>
</div>

<?php
    $sTitle = "Settings";
    require_once("wrapper/wrapper.php");
?>

<script type="text/javascript" src="scripts/settings.js"></script>
