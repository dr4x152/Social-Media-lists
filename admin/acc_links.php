<?php
include '../action.php';
include('../header.php');
session_start();

if(!isset($_SESSION['user_login']))
{
    header("location: ../login.php");
}

if($_SESSION['user_type'] == 2){

$id = $_SESSION['user_login'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $header ?>
</head>
<body>
    <div class="pop-alert" style="margin-top: -10px">
        <div class="pop-container"></div>
    </div>
    <div class="admin-container">
        <div class="a-menu">
            <a href="acc_dashboard.php"><div class="a-text"><img src="../style/img/homepage.png"/>Dashboard</div></a>
            <a href="acc_links.php"><div class="a-text a-active"><img src="../style/img/edit.png"/>All links</div></a>
            <a href="acc_profile.php"><div class="a-text"><img src="../style/img/user.png"/>All users</div></a>
            <a href="logout.php"><div class="a-text"><img src="../style/img/logout.png"/>Logout</div></a>
        </div>
        <div class="a-container">
            <div class="a-edit" style="width: 90%;padding:0;">
                <div class="a-title" style="padding: 30px 0 0 0;margin: 0 0 -10px 0;">All Social Link</div>
            </div>  
        </div>
    </div>       
        <div class="b-search" style="max-width: 1300px; margin: 0 auto;">
            <div class="search" style="box-shadow: none;">
                <?php
                    while($row = $result_menu->fetch()) {
                        echo '<div class="s-social" data-s='.$row["name"].'><img src="../style/img/'.$row["icon"].'"/>'.$row["name"].'</div>';
                    }
                ?>
            </div>
            <div class="s-table">
                <div class="s-t-container">
                    <div class="s-t-all"><img src="../style/img/dot.png"/><div class="r-social"></div></div>
                    <div class="s-t-c-container"></div>
                </div>
            </div>
            <div class="s-filter">
                <div class="s-f-container">
                    <div class="s-f-name">Social Media</div>
                    <div class="s-f-select" data-id="sm">
                        <div class="s-f-text" data-id="sm"></div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown" data-id="sm">
                        <?php
                            while($row = $result_menu_s->fetch()) {
                                echo '<div class="s-f-name s-f-n-drop" data-id="'.$row["name"].'">'.$row["name"].'</div>';
                            }
                        ?>
                    </div>
                </div>
                <div class="s-f-container">
                    <div class="s-f-name">Category</div>
                    <div class="s-f-select" data-id="c">
                        <div class="s-f-text" data-id="c">-</div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown" data-id="c">
                        <li class="s-f-name s-f-n-drop" data-id="All">All</li>
                    </div>
                </div>
                <div class="s-f-container">
                    <div class="s-f-name">Country/Language</div>
                    <div class="s-f-select" data-id="cl">
                        <div class="s-f-text" data-id="cl">-</div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown" data-id="cl">
                        <li class="s-f-name s-f-n-drop" data-id="All">All</li>
                    </div>
                </div>
                <div class="s-f-container">
                    <div class="s-f-name">Follow/Subscription/People</div>
                    <div class="s-f-select" data-id="f">
                        <div class="s-f-text" data-id="f">-</div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown" data-id="f">
                        <li class="l-select-drop s-f-n-drop" data-id="All">All</li>
                        <li class="l-select-drop s-f-n-drop" data-id="1">0 - 1k</li>
                        <li class="l-select-drop s-f-n-drop" data-id="2">1k - 5k</li>
                        <li class="l-select-drop s-f-n-drop" data-id="3">5k - 10k</li>
                        <li class="l-select-drop s-f-n-drop" data-id="4">10k - 50k</li>
                        <li class="l-select-drop s-f-n-drop" data-id="5">50k - 100k</li>
                        <li class="l-select-drop s-f-n-drop" data-id="6">100k - 500k</li>
                        <li class="l-select-drop s-f-n-drop" data-id="7">500k - 1m</li>
                        <li class="l-select-drop s-f-n-drop" data-id="8">> 1m</li>
                    </div>
                </div>
                <div class="s-f-container">
                    <div class="s-f-name">Verified</div>
                    <div class="s-f-select" data-id="v">
                        <div class="s-f-text" data-id="v">-</div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown" data-id="v">
                        <li class="l-select-drop s-f-n-drop">All</li>
                        <li class="l-select-drop s-f-n-drop" data-id="1">Yes</li>
                        <li class="l-select-drop s-f-n-drop" data-id="0">No</li>
                    </div>
                </div>
            </div>
        </div>
        <div class="container"></div>
</body>
</html>
<?
}