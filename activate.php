<?php
include('base.php');
include('header.php');

$email = $_GET['email'];
$token = $_GET['code'];
$select_stmt = $db->prepare("SELECT token, email FROM users WHERE token=:utoken AND email=:uemail");
$select_stmt->execute(array(':utoken' => $token, ':uemail' => $email));
$row = $select_stmt->fetch(PDO::FETCH_ASSOC);

if($select_stmt->rowCount() > 0)
{
    if($token == $row['token'] && $email == $row['email']);
    {
        $insert_stmt = $db->prepare("UPDATE users SET status=:ustatus, token=:utoken WHERE email='$email'");
        if ($insert_stmt->execute(array(
            'ustatus' => 1,
            'utoken' => $token = bin2hex(random_bytes(16))
        ))) {
            $activateMsg = "From now on, your account is active. You will be redirected to login";
            header("refresh:2; login.php");
        }
    }
}
else {
    $errorMsg[] = "The email address has already been confirmed";
    header("refresh:2; login.php");}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $header ?>
</head>
<body>
    <?php echo $top ?>
    <div class="container">
        <div class="acc" data-id="login" style="padding: 30px;">
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
                if(isset($activateMsg))
                {
                    ?><div class="alert success"><?php echo $activateMsg; ?></div>
                    <?php
                }
                ?>
        </div>
    </div>
</body>
</html>