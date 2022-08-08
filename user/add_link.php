<?php
include('../action.php');
include('../header.php');
session_start();

if(!isset($_SESSION['user_login']))
{
    header("location: ../login.php");
}

if($_SESSION['user_type'] == 1){

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
        <a href="acc_dashboard.php"><div class="a-text a-active"><img src="../style/img/homepage.png"/>Dashboard</div></a>
        <a href="acc_mylinks.php"><div class="a-text"><img src="../style/img/edit.png"/>My links</div></a>
        <a href="acc_profile.php"><div class="a-text"><img src="../style/img/user.png"/>Profile</div></a>
        <a href="logout.php"><div class="a-text"><img src="../style/img/logout.png"/>Logout</div></a>
    </div>
    <div class="a-container">
        <div class="a-edit">
            <div class="a-title">Add Link</div>
            <div class="screen">
                <div class="s-menu">
                    <div class="s-m-button s-m-b-active" data-id="desk">Desktop</div>
                    <div class="s-m-button" data-id="mob">Mobile</div>
                </div>
                <div class="s-result">
                    <div class="s-r-desk">
                        <div class="s-r-d-container">
                            <div class="a-p-c-img">
                                <img data-id="" src="../style/img/none.png"/>
                            </div>
                            <div class="a-p-c-category"></div>
                            <div class="a-p-c-ammount"></div>
                            <div class="a-p-c-flag"></div>
                        </div>
                    </div>
                    <div class="s-r-mob"></div>
                </div>
            </div>
            <div class="alert"></div>
                <div class="s-f-container s-f-addlink">
                    <button class="a-b-upload">Choose file</button>
                    <input type="file" id="upload" hidden>
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Social Media</div>
                    <div class="s-f-select" data-id="add-sm">
                        <div class="s-f-text" data-id="add-sm">-</div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown m-drop" data-id="add-sm">
                        <?php
                        while($row = $result_add_sm->fetch()) {
                            echo '<div class="s-f-name s-f-n-drop" data-id="'.$row["name"].'">'.$row["name"].'</div>';
                        }
                        ?>
                    </div>
                    <input style="display: none" type="text" name="socialmedia"/>
                </div>
                <div class="s-f-container s-f-addlink">
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Category 1</div>
                    <div class="s-f-select" data-id="add-c1">
                        <div class="s-f-text" data-id="add-c1">-</div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown m-drop" data-id="add-c1">
                        <?php
                        while($row = $result_add_c1->fetch()) {
                            echo '<div class="s-f-name s-f-n-drop" data-id="'.$row["name"].'">'.$row["name"].'</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="s-f-container s-f-addlink">
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Category 2</div>
                    <div class="s-f-select" data-id="add-c2">
                        <div class="s-f-text" data-id="add-c2">-</div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown m-drop" data-id="add-c2">
                        <?php
                        while($row = $result_add_c2->fetch()) {
                            echo '<div class="s-f-name s-f-n-drop" data-id="'.$row["name"].'">'.$row["name"].'</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="s-f-container s-f-addlink">
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Category 3</div>
                    <div class="s-f-select" data-id="add-c3">
                        <div class="s-f-text" data-id="add-c3">-</div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown m-drop" data-id="add-c3">
                        <?php
                        while($row = $result_add_c3->fetch()) {
                            echo '<div class="s-f-name s-f-n-drop" data-id="'.$row["name"].'">'.$row["name"].'</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="s-f-container s-f-addlink">
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Country/Language</div>
                    <div class="s-f-select" data-id="add-cl">
                        <div class="s-f-text" data-id="add-cl">-</div>
                        <div class="s-f-icon"><img src="../style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown m-drop" data-id="add-cl">
                        <?php
                        while($row = $result_add_cl->fetch()) {
                            echo '<div class="s-f-name s-f-n-drop" data-code="'.$row['code'].'" data-id="'.$row["name"].'">'.$row["name"].'</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="s-f-container s-f-addlink ">
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Follow/Subscription/People</div>
                    <input class="i-a-l" maxlength="9" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="ammount"/>
                </div>
                <div class="s-f-container i-a-l s-f-addlink">
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Title</div>
                    <div class="s-f-c-container">
                        <input class="i-a-l" maxlength="60" name="title" type="text"/>
                        <div class="count-text" name="title">0/60</div>
                    </div>
                </div>
                <div class="s-f-container i-a-l s-f-addlink">
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Subtitle</div>
                    <div class="s-f-c-container">
                        <input class="i-a-l" maxlength="90" name="subtitle" type="text"/>
                        <div class="count-text" name="subtitle">0/90</div>
                    </div>
                </div>
                <div class="s-f-container i-a-l s-f-addlink">
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Description</div>
                    <div class="s-f-c-container">
                        <textarea class="i-a-l" maxlength="255" style="height: 150px;" name="description" type="text"></textarea>
                        <div class="count-text" name="description">0/255</div>
                    </div>
                </div>

                <div class="s-f-container i-a-l s-f-addlink">
                    <div class="s-f-name" style="padding: 10px 0 5px 0;">Link</div>
                    <input class="i-a-l" name="link" type="text"/>
                </div>
                <button type="submit" data-id="link" name="addlink">Add Link</button>
        </div>
    </div>
</div>
</body>
</html>
<?
}