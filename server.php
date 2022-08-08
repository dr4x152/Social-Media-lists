<?php
include('base.php');
session_start();
if (isset($_REQUEST['reg_user'])) {

    $name = strip_tags(ltrim($_REQUEST['name']));
    $username = strip_tags(ltrim($_REQUEST['username']));
    $email = strip_tags(ltrim($_REQUEST['email']));
    $password_1 = strip_tags($_REQUEST['password_1']);
    $password_2 = strip_tags($_REQUEST['password_2']);
    $checkbox = strip_tags($_REQUEST['checkbox']);

    if (empty($name)) {
        $errorMsg[] = ("Please enter name");
    } else if (empty($username)) {
        $errorMsg[] = ("Please enter username");
    } else if (empty($email)) {
        $errorMsg[] = ("Please enter email");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg[] = ("Please enter a valid email address");
    } else if (empty($password_1)) {
        $errorMsg[] = ("Please enter password");
    } else if (empty($password_2)) {
        $errorMsg[] = ("Please enter repassword");
    } else if ($password_1 != $password_2) {
        $errorMsg[] = ("The two passwords do not match");
    } else if (strlen($password_1) < 6) {
        $errorMsg[] = ("Password must be atleast 6 characters");
    } else if (empty($checkbox)) {
        $errorMsg[] = ("You must accept the terms and privacy policy");
    }
    else
    {
        try
        {
            $select_stmt = $db->prepare("SELECT username, email FROM users WHERE username=:uname OR email=:uemail");
            $select_stmt->execute(array(':uname' => $username, ':uemail' => $email));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['username'] == $username) {
                $errorMsg[] = "Sorry username already exists";
            } else if ($row["email"] == $email) {
                $errorMsg[] = "Sorry email already exists";
            } else if (!isset($errorMsg)) {
                $new_password = password_hash($password_1, PASSWORD_DEFAULT);
                $insert_stmt = $db->prepare("INSERT INTO users (name,username,email,password,status,token) VALUES (:uuname,:uname,:uemail,:upassword,:ustatus,:token)");
                if ($insert_stmt->execute(array(
                    'uuname' => $name,
                    'uname' => $username,
                    'uemail' => $email,
                    'upassword' => $new_password,
                    'ustatus' => 0,
                    'token' => $token = bin2hex(random_bytes(16))
                ))) {
                    $registerMsg = "Register Successfully!";
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);

                    $to      = $email;
                    $subject = 'Account Activation';
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
                                    <p>Hi, '.$name.' </p><br>
                                    <p>Here is your activation link, click and activate your account</p><br>
                                    <p><a href="https://influence.promo/activate.php?email='.$email.'&code='.$token.'"><b>ACTIVATE ACCOUNT</b></a></p><br>
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
            echo $e->getMessage();
        }
    }
}
if(isset($_REQUEST['login_user'])) {
    $username	=strip_tags($_REQUEST["username"]);
    $email		=strip_tags($_REQUEST["username"]);
    $password	=strip_tags($_REQUEST["password"]);
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $secret = '6LcEHMkdAAAAAHfsdyFH4dXHuY7pMfb0-5HyfE_U';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
    }
    if(empty($username)){
        $errorMsg[]="Please enter username or email";
    } else if(empty($email)){
        $errorMsg[]="Please enter username or email";
    } else if(empty($password)){
        $errorMsg[] = "Please enter password";
    } else if (!$responseData->success){
        $errorMsg[] = "Please confirm you are not a robot";
    }
    else
    {
        try
        {
            $select_stmt = $db->prepare("SELECT * FROM users WHERE username=:uname OR email=:uemail");
            $select_stmt->execute(array(':uname' => $username, ':uemail' => $email));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($select_stmt->rowCount() > 0) {
                if ($username == $row["username"] or $email == $row["email"]) {
                    if (password_verify($password, $row["password"])) {
                        if ($row['status'] == 1) {
                            $_SESSION["user_login"] = $row["username"];
                            $_SESSION["user_type"] = 1; // User
                            $loginMsg = "Successfully Login...";
                            header("location: user/acc_dashboard.php");
                        } else {
                            $errorMsg[] = "Your account is inactive, check your mailbox";
                        }
                    } else {
                        $errorMsg[] = "Wrong password";
                    }
                } else {
                    $errorMsg[] = "Wrong username or email";
                }
            } else {
                $errorMsg[] = "Wrong username or email";
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}
if(isset($_REQUEST['login_admin'])) {
    $username	=strip_tags($_REQUEST["username"]);
    $email		=strip_tags($_REQUEST["username"]);
    $password	=strip_tags($_REQUEST["password"]);
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $secret = '6LcEHMkdAAAAAHfsdyFH4dXHuY7pMfb0-5HyfE_U';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
    }
    if(empty($username)){
        $errorMsg[]="Please enter username or email";
    } else if(empty($email)){
        $errorMsg[]="Please enter username or email";
    } else if(empty($password)){
        $errorMsg[] = "Please enter password";
    } else if (!$responseData->success){
        $errorMsg[] = "Please confirm you are not a robot";
    }
    else
    {
        try
        {
            $select_stmt = $db->prepare("SELECT * FROM admins WHERE username=:uname OR email=:uemail");
            $select_stmt->execute(array(':uname' => $username, ':uemail' => $email));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($select_stmt->rowCount() > 0) {
                if ($username == $row["username"] or $email == $row["email"]) {
                    if (password_verify($password, $row["password"])) {
                        $_SESSION["user_login"] = $row["username"];
                        $_SESSION["user_type"] = 2; // Admin
                        $loginMsg = "Successfully Login...";
                        header("location: acc_dashboard.php");
                    } else {
                        $errorMsg[] = "Wrong password";
                    }
                } else {
                    $errorMsg[] = "Wrong username or email";
                }
            } else {
                $errorMsg[] = "Wrong username or email";
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}
if(isset($_REQUEST['forgot_password'])) {
    $email = strip_tags($_REQUEST["email"]);
    if (empty($email)) {
        $errorMsg[] = "Please enter email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg[] = ("Please enter a valid email address");
    }
    else {
        try {
            $select_stmt = $db->prepare("SELECT * FROM users WHERE email=:uemail");
            $select_stmt->execute(array(
                ':uemail' => $email,
            ));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($select_stmt->rowCount() > 0) {
                $token = $row['token'];
                if ($email == $row["email"] && $token == $row['token']) {
                    $forgotMsg = "Email send check your mail box";

                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);

                    $to      = $email;
                    $subject = 'Reset Password';
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
                                    <p>Hi, '.$row['name'].' </p><br>
                                    <p>Here is your link, click and reset your paswword</p><br>
                                    <p><a href="https://influence.promo/reset_password.php?email='.$email.'&code='.$token.'"><b>RESET PASSWORD</b></a></p><br>
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
            } else {
                $errorMsg[] = "Email address does not exist";
            }
        } catch
        (PDOException $e) {
            $e->getMessage();
        }
    }
}