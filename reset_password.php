<?php
include('base.php');
include('header.php');

$email = $_GET['email'];
$token = $_GET['code'];
$select_stmt = $db->prepare("SELECT token, email FROM users WHERE token=:utoken AND email=:uemail");
$select_stmt->execute(array(':utoken' => $token, ':uemail' => $email));
$row = $select_stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_REQUEST['reset_password'])) {
    $password_1 = strip_tags($_REQUEST['password_1']);
    $password_2 = strip_tags($_REQUEST['password_2']);

    if (empty($password_1) ) {
        $errorMsg[] = ("Please enter password");
    } else if (empty($password_2)) {
        $errorMsg[] = ("Please enter repassword");
    } else if ($password_1 != $password_2) {
        $errorMsg[] = ("The two passwords do not match");
    } else if (strlen($password_1) < 6) {
        $errorMsg[] = ("Password must be atleast 6 characters");
    }
    else
    {
        try
        {
            if ($token == $row['token'] && $email == $row['email'])
            {
                if ($password_1 == $password_2) {
                    $new_password = password_hash($password_1, PASSWORD_DEFAULT);
                    $insert_stmt = $db->prepare("UPDATE users SET password=:upassword, token=:utoken WHERE email='$email'");
                    if ($insert_stmt->execute(array(
                        'upassword' => $new_password,
                        'utoken' => $token = bin2hex(random_bytes(16))
                    ))) {
                        $resetMsg = "Your password has been changed";
                        header("refresh:2; login.php");
                    }
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
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
        <?php
        if($select_stmt->rowCount() > 0)
        {
            echo '
            <div class="acc" data-id="login">
                <div class="text">Reset Password</div>
                <div class="subtext">Enter your new password</div>
                <form method="post" action="reset_password.php?email='.$email.'&code='.$token.'">
                    ';if(isset($errorMsg))
                    {
                        foreach($errorMsg as $error)
                        {
                           echo '<div class="alert error">'.$error.'</div>';

                        }
                    }
                    if(isset($resetMsg))
                    {
                        echo '<div class="alert success">'.$resetMsg.'</div>';
                    }
                    echo '
                    <input type="password" name="password_1" placeholder="New password..."/>
                    <input type="password" name="password_2" placeholder="Re new password..."/>
                    <button type="submit" name="reset_password">Send</button>
                </form>
                <a href="login.php">
                    <div class="replace rel" data-id="login">Log in</div>
                </a>
                <div class="replace" style="margin-top: 5px;">or</div>
                <a href="signup.php">
                    <div class="replace rel" style="margin-bottom: 30px;" data-id="signup">Sign up</div>
                </a>
            </div>
                ';
                    } else {$errorMsg[] = "The password has already been changed";
                        header("refresh:2; login.php");
                        if(isset($errorMsg))
                        {
                            foreach($errorMsg as $error)
                            {
                                echo '<div class="acc" style="padding:30px" data-id="login"><div class="alert error">'.$error.'</div></div>';

                            }
                        }
                    }
            ?>
    </div>
</body>
</html>