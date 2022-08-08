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
    <div class="container">
        <div class="a-menu">
            <a href="acc_dashboard.php"><div class="a-text"><img src="../style/img/homepage.png"/>Dashboard</div></a>
            <a href="acc_mylinks.php"><div class="a-text a-active"><img src="../style/img/edit.png"/>My links</div></a>
            <a href="acc_profile.php"><div class="a-text"><img src="../style/img/user.png"/>Profile</div></a>
            <a href="logout.php"><div class="a-text"><img src="../style/img/logout.png"/>Logout</div></a>
        </div>
        <div class="a-container">
            <div class="a-edit" style="width: 90%;">
                <div class="a-title">My Social Link</div>
                <?php
                if (($result_check_mylinks->fetch()) > 0){
                    while($row = $result_mylinks->fetch()) {
                        $country_flag = $row['country'];
                        $query_countries_flag = "SELECT * FROM country WHERE name='$country_flag'";
                        $result_countries_flag = $db->query($query_countries_flag);
                        $row_flag = $result_countries_flag->fetch();
                        echo '
                    <div class="e-list my-links" data-id="'.$row['id'].'" style="border-bottom:1px solid #dbdbdb;">
                        <div class="list" data-id="'.$row['id'].'" data-s="'.$row['social'].'">
                            <div class="l-c-1" data-verified="'.$row['verified'].'">
                                <img src="../style/img/upload/'.$row['image'].'"/>
                                <div class="l-c-1-icon">
                                    <img src="../style/img/img_'.$row['social'].'.png"/>
                            </div>
                            </div>
                            <div class="l-c-2">
                                <div class="l-c-name">'.$row['title'].'</div>
                                <div class="l-c-sub">'.$row['subtitle'].'</div>
                                <div class="l-c-category">#'.$row['category1'].' #'.$row['category2'].' #'.$row['category3'].'</div>
                            </div>
                            <div class="l-c-3" data-s="'.$row['social'].'">
                            <div class="l-c-3-c">
                                <div class="l-c-3-t">'.$row['ammount'].'</div>
                                <div class="l-c-3-text"></div>
                            </div>
                            <div class="l-c-3-f"><img src="../style/img/'.$row_flag['flag_4x3'].'"/></div>
                            </div>
                        </div>
                        <div class="c-button">
                            <div class="m-button">
                                <button class="btn-myacc" name="waste" data-id="'.$row['id'].'"><img src="../style/img/waste.png"/></button>
                                <a href="edit_link.php?id='.$row['id'].'">
                                    <button class="btn-myacc" name="edit" data-id="'.$row['id'].'"><img src="../style/img/edit.png"/></button>
                                </a>
                            </div>
                            <div class="m-button">
                                <button class="btn-myacc" name="bonus" data-id="'.$row['id'].'"><img src="../style/img/bonus.png"/></button>
                                <button class="btn-myacc" name="refresh" data-id="'.$row['id'].'"><img src="../style/img/refresh.png"/></button>
                            </div>
                        </div>
                    </div>';
                    }
                } else {
                    echo "<div class='first-l'>
                            You don't have any links!
                            <a href='../user/add_link.php'>
                                <div class='t-m-add' style='margin:15px 0 0 0'>
                                    Create your first link
                                </div>
                            </a>
                          </div>
                    ";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
<?
}