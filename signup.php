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
        <div class="acc" data-id="signup">
            <div class="text">Sign Up</div>
            <div class="subtext">Create an account using the correct details</div>
            <form method="post" action="signup.php">
                <?php
                if(isset($errorMsg))
                {
                    foreach($errorMsg as $error)
                    {
                        ?>
                        <div class="alert error">WRONG ! <?php echo $error; ?></div>
                        <?php
                    }
                }
                if(isset($registerMsg))
                {
                    ?>
                    <div class="alert success"><?php echo $registerMsg; ?></div>
                    <?php
                }
                ?>
                <input type="text" name="name" placeholder="Name..."/>
                <input type="text" name="username" maxlength="50" minlength="5" placeholder="Username..."/>
                <input type="password" minlength="8" maxlength="50" name="password_1" placeholder="Password..."/>
                <input type="password" minlength="8" maxlength="50" name="password_2" placeholder="Repeat Password..."/>
                <input type="email" name="email" placeholder="Email..."/>
                <div class="regulations">
                    <input type="checkbox" name="checkbox" class="checkbox">I accept the website<a href="regulations.php">&nbsp;regulations&nbsp;</a>and<a href="regulations.php">&nbsp;privacy policy</a>.
                </div>
                <button type="submit" name="reg_user">Signup</button>
            </form>
            <div class="replace" style="margin-top: 5px;">Already have an account?</div>
            <a href="login.php">
                <div class="replace rel" style="margin-bottom: 30px;" data-id="login">Log In</div>
            </a>
        </div>
    </div>
</body>
</html>