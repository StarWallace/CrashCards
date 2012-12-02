<script type="text/javascript" src="scripts/jquery.placeholder.min.js"></script>

<?php
    $loginResult = "";
    if (isset($_POST) && (isset($_POST['email']) || isset($_POST['password']))) {
        $user = isset($_POST['email']) ? $_POST['email'] : "";
        $pass = isset($_POST['password']) ? $_POST['password'] : "";
        require_once("classes/User.class.php");
        $User = new User();
        $loginResult = $User->Login($user, $pass);
        if ($loginResult === true) {
            //header('Location: ' . $_SERVER['REQUEST_URI']);
			header('Location: index.php');
        } else {
            $loginResult = strip_tags($loginResult);
        }
    }
?>

<div class="top fixed" id="topBar">
    <div class="centred white loginBar" id="userBar">
        <a href="index.php?"><div class="banner" title="CrashCards"></div></a>
        <div class="loginBar">
            <div id="loginMessage" class="err"><?php echo $loginResult; ?></div>
            <form id="login-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                <input name="email" class="login" placeholder="Email" tabindex="101"/>
                <input name="password" class="login" type="password" placeholder="Password" tabindex="102"/>
                <div id="login" class="button" tabindex="103">Log In</div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="scripts/login.js"></script>