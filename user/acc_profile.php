<?php
require_once '../base.php';
include('../header.php');
session_start();

if(!isset($_SESSION['user_login']))
{
    header("location: ../login.php");
}

if($_SESSION['user_type'] == 1){

$id = $_SESSION['user_login'];

if (isset($_REQUEST['a_change_password'])) {
    $password_1 = strip_tags($_REQUEST['password_1']);
    $password_2 = strip_tags($_REQUEST['password_2']);

    if (empty($password_1)) {
        $errorMsg[] = ("Please enter password");
    } else if (empty($password_2)) {
        $errorMsg[] = ("Please enter repassword");
    } else if ($password_1 != $password_2) {
        $errorMsg[] = ("The two passwords do not match");
    } else if (strlen($password_1) < 6) {
        $errorMsg[] = ("Password must be atleast 6 characters");
    }
    else {
        try {
            if (!isset($errorMsg)) {
                $new_password = password_hash($password_1, PASSWORD_DEFAULT);
                $insert_stmt = $db->prepare("UPDATE users SET password=:upassword WHERE username=:uid");
                if ($insert_stmt->execute(array(
                    'uid' => $id,
                    'upassword' => $new_password
                ))) {
                    $passMsg = "Your password has been changed successfully";
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                }
            }
        }
        catch(PDOException $e)
        {
            $e->getMessage();
        }
    }
}
if (isset($_REQUEST['a_change_email'])) {
    $email_1 = strip_tags($_REQUEST['email_1']);
    $email_2 = strip_tags($_REQUEST['email_2']);

    if (empty($email_1)) {
        $errorMsg[] = ("Please enter email");
    } else if (empty($email_2)) {
        $errorMsg[] = ("Please enter email");
    } else if ($email_1 != $email_2) {
        $errorMsg[] = ("The two email do not match");
    } else if (!filter_var($email_1, FILTER_VALIDATE_EMAIL)) {
        $errorMsg[] = ("Please enter a valid email address");
    } else {
        try {
            $select_stmt = $db->prepare("SELECT * FROM users WHERE email=:uemail");
            $select_stmt->execute(array(':uemail' => $email_1));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if($email_1 == $row["email"]){
                $errorMsg[] = ("Email address already exists");
            } else if (!isset($errorMsg)) {
                $insert_stmt = $db->prepare("UPDATE users SET token=:utoken WHERE username='$id'");
                if ($insert_stmt->execute(array(
                    'utoken' => $token = bin2hex(random_bytes(16))
                ))) {
                    $emailMsg = "Email activation link has been sent";
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);

                    $to = $email_1;
                    $subject = 'Email Activation';
                    $message = '
                            <html>
                            <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title></title>
                            </head>
                            <body>
                                <center>
                                    <div id="email-wrap" style="padding: 30px;">
                                    <div class="t-logo"</div>
                                    <img src="https://influence.promo/style/img/logo.png"/>
                                    <p>Hi, ' .$id. ' </p><br>
                                    <p>Here is your activation link, click and activate your email</p><br>
                                    <p><a href="https://influence.promo/activate_email.php?email=' . $email_1 . '&code=' . $token . '"><b>ACTIVATE EMAIL</b></a></p><br>
                                    <p>Thank you,</p>
                                    <p>Influence Team</p>
                                    <p>contact: business@influence.promo</p>
                                    <a href=""><img style="width: 35px;" src="https://influence.promo/style/img/icon_facebook.png"/></a>
                                    <a href=""><img style="width: 35px;" src="https://influence.promo/style/img/icon_instagram.png"/></a>
                                    <a href=""><img style="width: 35px;" src="https://influence.promo/style/img/icon_website.png"/></a>
                                </center>
                                </div>
                            </body>
                            </html>
                    ';
                    $headers[] = 'MIME-Version: 1.0';
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                    $headers[] = 'From: bot@influence.promo' . "\r\n" .
                        'Reply-To: webmaster@example.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    mail($to, $subject, $message, implode("\r\n", $headers));
                    header("refresh:2; login.php");

                }
            }
        }
        catch(PDOException $e)
        {
            $e->getMessage();
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
        <div class="a-menu">
            <a href="acc_dashboard.php"><div class="a-text"><img src="../style/img/homepage.png"/>Dashboard</div></a>
            <a href="acc_mylinks.php"><div class="a-text"><img src="../style/img/edit.png"/>My links</div></a>
            <a href="acc_profile.php"><div class="a-text a-active"><img src="../style/img/user.png"/>Profile</div></a>
            <a href="logout.php"><div class="a-text"><img src="../style/img/logout.png"/>Logout</div></a>
        </div>
        <div class="a-container">
            <div class="a-edit">
                <div class="a-title">Profile Settings</div>
                <form method="post" action="acc_profile.php">
                    <div class="a-text-c">Change password</div>
                    <?php
                        if (isset($_REQUEST['a_change_password'])) {
                            if(isset($errorMsg)){
                                foreach($errorMsg as $error){
                                    ?>
                                    <div class="alert error"><?php echo $error; ?></div>
                                    <?php
                                }
                            }
                            if(isset($passMsg)){
                                ?><div class="alert success"><?php echo $passMsg; ?></div>
                                <?php
                            }
                        }
                    ?>
                    <input type="password" name="password_1" placeholder="New password..."/>
                    <input type="password" name="password_2" placeholder="Repeat new password..."/>
                    <button class="btn-acc" type="submit" name="a_change_password">Change</button>
                </form>
                <form method="post" action="myaccount.php" style="margin-top:30px">
                    <div class="a-text-c">Change email</div>
                    <?php
                        if (isset($_REQUEST['a_change_email'])){
                            if(isset($errorMsg)){
                                foreach($errorMsg as $error){
                                    ?>
                                    <div class="alert error"><?php echo $error; ?></div>
                                    <?php
                                }
                            }
                            if(isset($emailMsg)){
                                ?><div class="alert success"><?php echo $emailMsg; ?></div>
                                <?php
                            }
                        }
                    ?>
                    <input type="email" placeholder="New email..." name="email_1"/>
                    <input type="email" placeholder="Repeat new email..." name="email_2"/>
                    <button class="btn-acc" type="submit" name="a_change_email">Change</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?
}