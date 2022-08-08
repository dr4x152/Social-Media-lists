<?php
include('server.php');
include('header.php');

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
        <div class="text">Forgot Password</div>
        <div class="subtext">Enter your e-mail address and we will send you a link to reset your password</div>
        <form method="post" action="forgot_password.php">
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
            if(isset($forgotMsg))
            {
                ?><div class="alert success"><?php echo $forgotMsg; ?></div>
                <?php
            }
            ?>
            <input type="text" name="email" placeholder="Email..."/>
            <button type="submit" name="forgot_password">Send</button>
        </form>
        <a href="login.php">
            <div class="replace rel" data-id="login">Log in</div>
        </a>
        <div class="replace" style="margin-top: 5px;">or</div>
        <a href="signup.php">
            <div class="replace rel" style="margin-bottom: 30px;" data-id="signup">Sign up</div>
        </a>
    </div>
</div>
</body>
</html>