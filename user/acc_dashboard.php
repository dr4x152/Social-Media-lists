<?php
require_once '../base.php';
include('../header.php');
include('../action.php');
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
    <?php echo $top ?>
    <div class="container">
        <div class="a-menu">
            <a href="acc_dashboard.php"><div class="a-text a-active"><img src="../style/img/homepage.png"/>Dashboard</div></a>
            <a href="acc_mylinks.php"><div class="a-text"><img src="../style/img/edit.png"/>My links</div></a>
            <a href="acc_profile.php"><div class="a-text"><img src="../style/img/user.png"/>Profile</div></a>
            <a href="logout.php"><div class="a-text"><img src="../style/img/logout.png"/>Logout</div></a>
        </div>
        <div class="a-container">
            <div class="a-edit">
                <div class="a-title">Dashboard</div>
                <div class="c-cafle">
                    <div class="c-c-fle" style="margin-left:0;">
                        <div class="fle-menu">
                            <div class="fle-a">
                                <? echo $_SESSION['user_login'];?>
                            </div>
                            <div class="fle-t">Welcome</div>
                        </div>
                    </div>
                    <div class="c-c-fle">
                        <img src="../style/img/link.png"/>
                        <div class="fle-menu">
                            <div class="fle-a">
                                <?
                                    $query_count = "SELECT COUNT(*) AS total from list WHERE username='$id'";
                                    $result_count = $db->query($query_count);
                                    $row_count = $result_count->fetch();
                                    if($row_count['total'] > 0){
                                        echo $row_count['total'];
                                    } else {
                                        echo 0;
                                    }
                                ?>
                            </div>
                            <div class="fle-t">All links</div>
                        </div>
                    </div>
                    <div class="c-c-fle">
                        <img src="../style/img/view.png"/>
                        <div class="fle-menu">
                            <div class="fle-a">
                                <?
                                $query_sum_view = "SELECT sum(view_stats) AS total from list where username='$id'";
                                $result_sum_view = $db->query($query_sum_view);
                                $row_sum_view = $result_sum_view->fetch();
                                if($row_sum_view['total'] > 0){
                                    echo $row_sum_view['total'];
                                } else {
                                    echo 0;
                                }
                                ?>
                            </div>
                            <div class="fle-t">All views</div>
                        </div>
                    </div>
                    <div class="c-c-fle">
                        <img src="../style/img/click.png"/>
                        <div class="fle-menu">
                            <div class="fle-a">
                                <?
                                $query_sum_click = "SELECT sum(click_stats) AS total from list where username='$id'";
                                $result_sum_click = $db->query($query_sum_click);
                                $row_sum_click = $result_sum_click->fetch();
                                if($row_sum_click['total'] > 0){
                                    echo $row_sum_click['total'];
                                } else {
                                    echo 0;
                                }
                                ?>
                            </div>
                            <div class="fle-t">All clicks</div>
                        </div>
                    </div>
                </div>
                <div class="c-list">
                    <table style="width:100%">
                        <tr>
                            <th>Name link</th>
                            <th>Views</th>
                            <th>Clicks</th>
                        </tr>
                        <?
                        while($row = $result_mylinks->fetch()) {
                            echo'
                                <tr>
                                    <td>'.$row["title"].'</td>
                                    <td>'.$row["view_stats"].'</td>
                                    <td>'.$row["click_stats"].'</td>
                                </tr>
                            ';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?
}