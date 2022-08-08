<?php
include '../action.php';
include('../header.php');
session_start();

if(!isset($_SESSION['user_login']))
{
    header("location: ../login.php");
}

if($_SESSION['user_type'] == 1){

$id = $_SESSION['user_login'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $header ?>
</head>
<body>
<div class="pop-alert">
    <div class="pop-container"></div>
</div>
<?php echo $top ?>
<div class="fd-background">
    <div class="fd-title fd-background">Your followed socials</div>
</div>
<div class="fd-container">
    <div class='p-links'>
        <?php
            $row_user = $result_user_data -> fetch();
            $followed_id = explode('/',$row_user['followed']);
            $followed_count = count($followed_id);
            $data_id = '';
            if($followed_count > 1){
                foreach($followed_id as $value){
                $query_followed_links = "SELECT * FROM list WHERE id='$value'";
                $result_followed_links = $db->query($query_followed_links);
                while($row = $result_followed_links ->fetch()) {
                    echo '
                    <div class="p-box ff" data-id="' . $row['id'] . '" data-s="' . $row['social'] . '">
                        <div class="p-l-img" style="margin-top:10px;">
                            <img src="../style/img/upload/' . $row['image'] . '"/>
                            <div class="p-l-icon">
                                <img src="../style/img/img_' . $row['social'] . '.png"/>
                            </div>
                        </div>
                        <div class="p-text-title" style="margin-top: 20px; font-weight:600">' . $row['title'] . '</div>
                        <div class="p-subtitle" style="font-size:0.7rem;">' . $row['subtitle'] . '</div>
                        <div class="p-text" style="font-size:1rem;"><img src="../style/img/crowd.png"/>' . $row['ammount'] . '</div>
                        <div class="p-text" style="font-size:0.8rem;">#' . $row['category1'] . ' #' . $row['category2'] . ' #' . $row['category1'] . '
                            <div class="p-love ff" data-id="' . $row['id'] . '" data-f="on"></div>
                        </div>
                    </div>';
                    }
                }
            } else {
                echo "
                    <div class='fd-none'>
                    <div class='fd-x'>x</div>
                        You haven't followed socials yet
                    </div>
                ";
            }
        ?>
    </div>
</div>
<?php echo $footer ?>
</body>
</html>
<?
}