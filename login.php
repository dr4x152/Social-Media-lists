<?php
include('server.php');
include('header.php');

if(isset($_SESSION['user_login'])){
    if($_SESSION['user_type'] == 1){
        header("location: user/acc_dashboard.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $header ?>
</head>
<body>
<?php echo $top ?>
<div class="container">
    <div class="acc" data-id="login">
        <div class="text">Log In</div>
        <div class="subtext">Use your login and password to log in</div>
        <form method="post" action="login.php">
            <?php
            if(isset($errorMsg))
            {
                foreach($errorMsg as $error)
                {
                    ?>
                    <div class="alert error"><?php echo $error; ?></div>
                    <?php
                }
            }
            if(isset($loginMsg))
            {
                ?><div class="alert success"><?php echo $loginMsg; ?></div>
                <?php
            }
            ?>
            <input type="text" name="username" placeholder="Username..."/>
            <input type="password" name="password" placeholder="Password..."/>
            <div class="g-recaptcha" style="margin-top:10px;" name="recaptcha" data-sitekey="6LcEHMkdAAAAAOi_kvBBn4ZbdJGAt7BllVx_xB4q"></div>
            <button type="submit" name="login_user">Login</button>
        </form>
        <div class="replace" style="margin-top: 5px;">Not yet a member?</div>
        <a href="signup.php">
            <div class="replace rel" data-id="signup">Sign Up</div>
        </a>
        <a href="forgot_password.php"><div class="restore">Restore password</div></a>
    </div>
</div>
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
</script>
</body>
</html>