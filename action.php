<?php
include('base.php');
session_start();

$load_elements = 20;
$date = date('Y-m-d H:i:s');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sid = $_SESSION['user_login'];
$select_stmt = $db->prepare("SELECT * FROM users WHERE username=:uid");
$select_stmt->execute(array(":uid"=>$sid));

$query_promolinks = "SELECT * FROM (SELECT * FROM list ORDER BY RAND() LIMIT 20) T1 ORDER BY promo_date DESC";
$result_promolinks = $db->query($query_promolinks);

$query_mylinks = "SELECT * FROM list WHERE username='$sid' ORDER BY refresh_date DESC";
$result_mylinks = $db->query($query_mylinks);
$result_check_mylinks = $db->query($query_mylinks);

$query_user_data = "SELECT * FROM users WHERE username='$sid'";
$result_user_data = $db->query($query_user_data);
$result_user_data_followed = $db->query($query_user_data);

$query_menu = "SELECT * FROM social";
$result_menu = $db->query($query_menu);
$result_menu_s = $db->query($query_menu);
$result_add_sm = $db->query($query_menu);

$query_list = "SELECT * FROM list ORDER BY id ASC LIMIT 0, $load_elements";
$result_list = $db->query($query_list);
$result_verified_s = $db->query($query_list);

$query_categories = "SELECT * FROM category ORDER BY name ASC;";
$result_categories = $db->query($query_categories);
$result_categories_s = $db->query($query_categories);
$result_add_c1 = $db->query($query_categories);
$result_add_c2 = $db->query($query_categories);
$result_add_c3 = $db->query($query_categories);

$query_countries = "SELECT * FROM country ORDER BY name ASC";
$result_countries_s = $db->query($query_countries);
$result_add_cl = $db->query($query_countries);

// Admin
$query_links = "SELECT * FROM list ORDER BY RAND() LIMIT 20";
$result_check_links = $db->query($query_links);
$result_links = $db->query($query_links);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Loop category (comedy,music, etc.) and their count
if ($_POST['action'] == 'count'){
    $social = $_POST['cat'];
    while($row = $result_categories->fetch()) {
        $name = $row['name'];
        $query_count = "SELECT COUNT(*) AS total from list WHERE (category1='$name' OR category2='$name' OR category3='$name') AND social='$social'";
        $result_count = $db->query($query_count);
        while ($row_count = $result_count->fetch()) {
            echo '<div class="s-t-c-name" data-c='.$row["name"].'>
                                    <img src="../style/img/dot.png"/> '.$row["name"].'
                                    <div class="count" style="font-size:0.5rem;margin-left:2px"> ('.$row_count['total'].')</div>
                                </div>';
        }
    }
}

// Filter (social, value, verifi, etc.)
if ($_POST['action'] == 'change'){
    $part = $_POST['part'];
    $id_category = $_POST['cat'];
    $id_subcategory = $_POST['scat'];
    $id_country = $_POST['coun'];
    $id_follow_1= $_POST['follow1'];
    $id_follow_2= $_POST['follow2'];
    $id_verifi = $_POST['verifi'];
    $id_sort = $_POST['sort'];
    $div = $_POST['class'];

    $query_l = "SELECT * FROM (SELECT * FROM list WHERE ";
    if(!empty($id_category)) $query_l .= "social = '$id_category'";
    if(!empty($id_subcategory)) $query_l .= " AND (category3 = '$id_subcategory' OR category2 = '$id_subcategory' OR category1 = '$id_subcategory')";
    if(!empty($id_country)) $query_l .= " AND country = '$id_country'";
    if(!empty($id_follow_1)) $query_l .= " AND (ammount >= '$id_follow_1' AND ammount <= '$id_follow_2')";
    if(!empty($id_verifi)) $query_l .= " AND verified = '$id_verifi'";
    $limit = 'LIMIT '.(($part*$load_elements)).', '.$load_elements;
    if($id_sort == 0) $query_l .= "ORDER BY refresh_date DESC) t1 ORDER BY promo_date DESC, refresh_date DESC $limit";
    if($id_sort == 1) $query_l .= "ORDER BY ammount ASC) t1 ORDER BY promo_date DESC, ammount DESC $limit";
    if($id_sort == 2) $query_l .= "ORDER BY ammount ASC) t1 ORDER BY promo_date DESC, ammount ASC $limit";
    $result = $db->query($query_l);

    $query_sum = "SELECT COUNT(*) AS total FROM list WHERE ";
    if(!empty($id_category)) $query_sum .= "social = '$id_category'";
    if(!empty($id_subcategory)) $query_sum .= " AND (category3 = '$id_subcategory' OR category2 = '$id_subcategory' OR category1 = '$id_subcategory')";
    if(!empty($id_country)) $query_sum .= " AND country = '$id_country'";
    if(!empty($id_follow_1)) $query_sum .= " AND (ammount >= '$id_follow_1' AND ammount <= '$id_follow_2')";
    if(!empty($id_verifi)) $query_sum .= " AND verified = '$id_verifi'";
    $result_sum = $db->query($query_sum);
    $row = $result_sum->fetch();
    $sumLinks = $row['total'];

    if($part >= 1) {
       while(
            $row = $result->fetch()){
            $country_flag = $row['country'];
            $query_countries_flag = "SELECT * FROM country WHERE name='$country_flag'";
            $result_countries_flag = $db->query($query_countries_flag);
            $row_flag = $result_countries_flag->fetch();
            generateElement($row,$row_flag);
        }
        generateButton($sumLinks,$load_elements,$part);
    } else if($part <= 0) {
        echo '
        <div class="c-all-a">
            <div class="c-a-1">> '.$sumLinks.' LINK OFFERS</div>
            <div class="c-a-2">
                <div class="s-f-container f-sort">
                    <div class="s-f-select ss-sort" data-id="so">
                        <div class="s-f-text t-sort" data-id="so"></div>
                        <div class="s-f-icon"><img src="style/img/down.png"/></div>
                    </div>
                    <div class="s-f-dropdown d-sort" data-id="so">
                        <li class="l-select-drop s-f-n-drop s-sort" data-id="0">The lastest</li>
                        <li class="l-select-drop s-f-n-drop s-sort" data-id="1">The greatest amount</li>
                        <li class="l-select-drop s-f-n-drop s-sort" data-id="2">Minimal amount</li>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-l" data-s="' . $id_category . '" data-c="' . $id_subcategory . '" data-parts="1">';
        while ($row = $result->fetch()){
            $country_flag = $row['country'];
            $query_countries_flag = "SELECT * FROM country WHERE name='$country_flag'";
            $result_countries_flag = $db->query($query_countries_flag);
            $row_flag = $result_countries_flag->fetch();
            generateElement($row,$row_flag);
        }
        generateButton($sumLinks,$load_elements,$part);
        echo '</div>';
    }
}
function generateButton($sumLinks,$load_elements,$part){
    if($sumLinks>$load_elements){
        $left = $sumLinks - ($load_elements * ($part +1));
        if($left > 0){
            echo '<div class=load-container>('.$left.' left)<button class="load-more">LOAD</button></div>';
        }
    }
}
// Function generate links
function generateElement($row,$row_flag){
    $date = date('Y-m-d H:i:s');
    $date_promo = $row['promo_date'];
    $int = (int) $row['ammount'];
    $conf = '';
    $diff = (strtotime($date_promo) - strtotime($date))/(60*60*24);
    if($row['ammount'] < 1000){
        $conf = $int;
    } else {
        if ($row['ammount'] >= 1000 and $row['ammount'] < 1000000) {
            $conf = ((number_format($int/1000,1)) + 0). 'K';
        } else if ($row['ammount'] > 1000000) {
            $conf = ((number_format($int/1000000,1)) + 0) . 'M';
        }
    }
    $echo = '
            <div class="l-c-1" data-verified="' . $row['verified'] . '">
                <img src="../style/img/upload/'. $row['image'] . '"/>
                <div class="l-c-1-icon">
                    <img src="../style/img/img_'.$row['social'].'.png"/>
                </div>
            </div>
            <div class="l-c-2">
                <div class="l-c-name">' . $row['title'] . '</div>
                <div class="l-c-sub">' . $row['subtitle'] . '</div>
                <div class="l-c-category">#' . $row['category1'] . ' #' . $row['category2'] . ' #' . $row['category3'] . '</div>
            </div>
            <div class="l-c-3" data-s="' . $row['social'] . '">
                <div class="l-c-3-c">
                    <div class="l-c-3-t">'. $conf. '</div>
                    <div class="l-c-3-text"></div>
                </div>
                <div class="l-c-3-f"><img src="../style/img/'.$row_flag['flag_4x3'].'"/></div>
            </div>';
    $echo_admin = '                        
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
            </div>';
    if ($_SESSION['user_type'] != 2){
        if ($diff > 0){
            echo '<div class="list promo" data-id="' . $row['id'] . '" data-s="'.$row['social'].'">'.$echo.'</div>';
        } else {
            echo '<div class="list" data-id="' . $row['id'] . '" data-s="'.$row['social'].'">'.$echo.'</div>';
        }
    } else {
        if ($diff > 0){
            echo '
            <div class="e-list my-links" data-id="'.$row['id'].'" style="border-bottom:1px solid #dbdbdb;">
                <div class="list promo" data-id="' . $row['id'] . '" data-s="'.$row['social'].'">'.$echo.'
            </div>'.$echo_admin.'</div>';
        } else {
            echo '            
            <div class="e-list my-links" data-id="'.$row['id'].'" style="border-bottom:1px solid #dbdbdb;">
                <div class="list promo" data-id="' . $row['id'] . '" data-s="'.$row['social'].'">'.$echo.'
            </div>'.$echo_admin.'</div>';
        }
    }
}

// Delete link (user)
if ($_POST['action'] == 'waste'){
    $id = $_POST['id'];
    $query = "SELECT * FROM list WHERE ";
    if($_SESSION['user_type'] == 2) $query .= "id='$id'";
    if($_SESSION['user_type'] == 1) $query .= "id='$id' AND username='$sid'";
    $result = $db -> query($query);
    if ($result > 0){
        $delete = "DELETE FROM list WHERE id=$id";
        if($_SESSION['user_type'] == 2) $query .= "id='$id'";
        if($_SESSION['user_type'] == 1) $query .= "id='$id' AND username='$sid'";
        $resultDelete = $db -> query($delete);
        echo $id;
    }
}

// Bonus link (user)
if ($_POST['action'] == 'bonus'){
    $id = $_POST['id'];
    $query_b = $db->prepare("SELECT * FROM list WHERE id=:uid AND username=:usid");
    $query_b->execute(array(
        ':uid'=>$id,
        ':usid'=>$sid
        ));
    $row = $query_b->fetch();
    $date_promo = date($row['promo_date']);
    if($date_promo > $date){
        $diff = (abs(strtotime($date_promo) - strtotime($date))) / (60 * 60 * 24);
        echo $diff;
        if ($diff < 0) {
            echo '
            <div class="p-alert">
                <div class="p-text h">Do you want to promote your link?</div>
                <div class="p-text s">(Your link will be displayed at the top of the page)</div>
                <div class="p-text h b">5$ / 30days</div>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="TH5K4H2CURTYS">
                    <input type="image" src="https://www.paypalobjects.com/en_US/PL/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
                </form>                     
                <div class="p-menu">
                    <button class="p-btn" name="close">Close</button>
                </div>
            </div>
            ';
        } else {
            echo '
            <div class="p-alert">
                <div class="p-text h">Your link will cease to be promoted on:</br> ' . $row['promo_date'] . '</div>
                <div class="p-menu">
                <button class="p-btn" name="close">Close</button>
            </div>
            </div>';
        }
    } else {
        echo '
            <div class="p-alert">
                <div class="p-text h">Do you want to promote your link?</div>
                <div class="p-text s">(Your link will be displayed at the top of the page)</div>
                <div class="p-text h b">5$ / 30days</div>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="TH5K4H2CURTYS">
                    <input type="image" src="https://www.paypalobjects.com/en_US/PL/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
                </form>    
                <div class="p-menu">
                    <button class="p-btn" name="close">Close</button>
                </div>
            </div>
            ';
            }
}

// Refresh link 10 days (user)
if ($_POST['action'] == 'refresh'){
    // Update refresh
    function updateRefresh($id,$sid,$db){
        $date = date('Y-m-d H:i:s');
        $newDate = date("Y-m-d H:i:s", strtotime("+10 days", strtotime($date)));
        $update = "UPDATE list SET refresh_date='$newDate' WHERE ";
        if($_SESSION['user_type'] == 2) $update .= "id='$id'";
        if($_SESSION['user_type'] == 1) $update .= "id='$id' AND username='$sid'";
        $resultUpdate = $db -> query($update);
        echo 'Your ad has been refreshed!';
    }

    $id = $_POST['id'];
    $query = "SELECT * FROM list WHERE ";
    if($_SESSION['user_type'] == 1) $query .= " id='$id' AND username='$sid'";
    if($_SESSION['user_type'] == 2) $query .= " id='$id'";
    $result = $db -> query($query);
    $count = $result->fetch();
    $date_refresh = date($count['refresh_date']);
    if($date_refresh > $date) {
        if($_SESSION['user_type'] == 2) updateRefresh($id,$sid,$db);
        $diff = (abs(strtotime($date_refresh) - strtotime($date))) / (60 * 60 * 24);
        if ($diff < 0) {
            updateRefresh($id,$sid,$db);
        } else {
            if($_SESSION['user_type'] == 1){
                if ($diff < 1) {
                    $d_h = ceil($diff * 24);
                    echo 'Your ad may be refreshed in ' . $d_h . ' hours';
                } else echo 'Your ad may be refreshed in ' . ceil($diff) . ' days';
            }
        }
    } else updateRefresh($id,$sid,$db);
}

// View link (all)
if ($_POST['viewlink'] == 'viewlink'){
    $id = $_POST['id'];

    $query = $db->prepare("SELECT * FROM list WHERE id=:id");
    $query->execute(array(
        'id' => $id,
    ));
    $row = $query->fetch();
    $country_flag = $row['country'];
    $query_countries_flag = "SELECT * FROM country WHERE name='$country_flag'";
    $result_countries_flag = $db->query($query_countries_flag);
    $row_flag = $result_countries_flag->fetch();
    $row_f = $result_user_data_followed->fetch();
    $followed_id = explode('/', $row_f['followed']);
    $data_id = '';
    foreach ($followed_id as $value) {
        if ($value == $row['id']) {
            $data_id = 'on';
            break;
        } else {
            $data_id = 'off';
        }
    }

    echo '
        <div class="pop-container">
            <div class="p-c-f" data-s="'.$row['social'].'">
                <div class="p-c-exit"></div>
                <div class="p-c-img">
                    <img src="../style/img/upload/'.$row['image'].'"/>
                    <div class="p-c-i-ico">
                        <img src="../style/img/img_'.$row['social'].'.png"/>
                    </div>
                </div>
                <div class="p-c-v" data-verified="'.$row['verified'].'"></div>
                <div class="p-c-category">
                    <div class="p-c-c-cat">#'.$row['category1'].' #'.$row['category2'].' #'.$row['category3'].'</div>
                </div>
                <div class="p-c-ammount"><img src="../style/img/crowd.png"/> '.$row['ammount'].'</div>
                <div class="p-c-flag"><img src="../style/img/'.$row_flag['flag_4x3'].'"/>'.$row_flag['name'].'</div>
                <div class="p-c-title">'.$row['title'].'</div>
                <div class="p-c-subtitle">'.$row['subtitle'].'</div>
                <div class="p-c-description">'.$row['description'].'</div>
                <div class="p-c-btn" data-id="'.$row['id'].'">Go to social</div>';
    if(isset($_SESSION['user_login'])){
        if($_SESSION['user_type'] == 1){
        echo '
            <div class="love-container">
                <div class="p-love view" data-id="' . $row['id'] . '" data-f="' . $data_id . '"></div>
            </div>';
        }
    }
    echo '
            </div>
        </div>';
}

// Add view stats
if ($_POST['addview'] == 'addview'){
    $id_list = $_POST['id'];
    $query = $db->prepare("UPDATE list SET view_stats=(view_stats+1) WHERE id=:uid");
    $query->execute(array(':uid'=>$id_list));
}

// Add click stats
if ($_POST['addclick'] == 'addclick'){
    if(isset($_SESSION['user_login'])){
        if($_SESSION['user_type'] == 1){
            $id_list = $_POST['id'];
            $query = $db->prepare("UPDATE list SET click_stats=(click_stats+1) WHERE id=:uid and username=:usid");
            $query->execute(array(
                ':uid'=>$id_list,
                ':usid'=>$sid,
            ));
            $query_link = $db->prepare("SELECT * FROM list WHERE id=:id");
            $query_link->execute(array(
                'id' => $id_list,
            ));
            $row = $query_link->fetch();
            echo $row['link'];
        }
    } else echo 0;
}

// Category change (filter)
if ($_POST['action'] == 'category_change'){
    $id_social = $_POST['social'];
    while($row = $result_categories_s->fetch()) {
        $category = $row["name"];
        $query_count_category = "SELECT COUNT(*) AS total from list WHERE (category1='$category' or category2='$category' or category3='$category') and social='$id_social'";
        $result_count_category = $db->query($query_count_category);
        $row_count = $result_count_category->fetch();
        if($row_count['total'] > 0) {
            echo '<div class="s-f-name s-f-n-drop s-f-remove" data-id="' . $category . '">' . $category . '</div>';
        }
    }
}

// Country change (filter)
if ($_POST['action'] == 'country_change') {
    $id_social = $_POST['social'];
    while($row = $result_countries_s->fetch()) {
        $country = $row["name"];
        $query_count_country = "SELECT COUNT(*) AS total from list WHERE country='$country' and social='$id_social'";
        $result_count_country = $db->query($query_count_country);
        $row_count = $result_count_country->fetch();
        if($row_count['total'] > 0) {
            echo '<div class="s-f-name s-f-n-drop s-f-remove" data-id="' . $country . '">' . $country . '</div>';
        }
    }
}

// Follow
if ($_POST['followed'] == 'change') {
    $data_id = $_POST['data_id'];
    $data_f = $_POST['data_f'];
    $query_f = "SELECT * FROM users WHERE username='$sid'";
    $result_f = $db->query($query_f);
    $row = $result_f -> fetch();
    $data_table = explode('/',$row['followed']);
    $data_table_array = $data_table;
    if(isset($_SESSION['user_login'])){
        if($_SESSION['user_type'] == 1){
            if ($data_f == 'off') {
                if(count($data_table) >= 41) echo 'limit';
                else if (($key = array_search($data_id, $data_table)) == false) {
                    $data_table_array[] = $data_id;
                    $new_data = implode('/', $data_table_array);
                    $query = $db->prepare("UPDATE users SET followed=:ufollowed WHERE username=:usid");
                    $query->execute(array(
                        ':usid' => $sid,
                        ':ufollowed' => $new_data,
                    ));
                    echo 'on';
                }
            } else if ($data_f == 'on') {
                if (($key = array_search($data_id, $data_table)) !== false) {
                    unset($data_table_array[$key]);
                    $new_data = implode('/', $data_table_array);
                    $query = $db->prepare("UPDATE users SET followed=:ufollowed WHERE username=:usid");
                    $query->execute(array(
                        ':usid' => $sid,
                        ':ufollowed' => $new_data,
                    ));
                    echo 'off';
                }
            }
        }
    } else echo 'false';
}

// Add Link (user)
if ($_POST['links'] == 'links'){
    $data_action = $_POST['data_action'];
    $add_category = strtolower($_POST['socialmedia']);
    $add_subcategory1 = $_POST['subcategory1'];
    $add_subcategory2 = $_POST['subcategory2'];
    $add_subcategory3 = $_POST['subcategory3'];
    $add_countryl = $_POST['countryl'];
    $add_ammount = strip_tags($_POST['ammount']);
    $add_title = strip_tags(ltrim($_POST['title']));
    $add_subtitle = strip_tags(ltrim($_POST['subtitle']));
    $add_description = strip_tags(ltrim($_POST['description']));
    $add_verified ='';
    $add_username = $sid;
    $add_link_pre = strip_tags(ltrim($_POST['link']));
    $add_link = '';
    $date = date('Y-m-d H:i:s');
    $add_img = $_POST['image'];
    $old_img = $_POST['old_image'];

    $scheme = parse_url($add_link_pre, PHP_URL_SCHEME);

    if(empty($scheme)){
        $add_link = 'http://'.$add_link_pre;
    } else {
        $add_link = $add_link_pre;
    }
    $host = parse_url($add_link, PHP_URL_HOST);
    $trim_host = ltrim($host, 'w.');

    if (empty($add_img)) {
        $errorMsg[] = ("Please add a photo");
    }else
    if (empty($add_category)) {
            $errorMsg[] = ("Please check social media");
    } else if (empty($add_subcategory1)) {
        $errorMsg[] = ("Please check category 1");
    } else if (empty($add_subcategory2)) {
        $errorMsg[] = ("Please check category 2");
    } else if (empty($add_subcategory3)) {
        $errorMsg[] = ("Please check category 3");
    } else if ($add_subcategory1 == $add_subcategory2 || $add_subcategory1 == $add_subcategory3 || $add_subcategory2 == $add_subcategory3){
        $errorMsg[] = ("The categories must be different");
    } else if (empty($add_countryl)) {
        $errorMsg[] = ("Please check country");
    } else if (empty($add_ammount)) {
        $errorMsg[] = ("Please enter the number of Follow/Subscription/People");
    } else if (strlen($add_ammount) > 9) {
        $errorMsg[] = ("The value must be less than 9 digits");
    } else if (!is_numeric($add_ammount)){
        $errorMsg[] = ("Please enter only numbers");
    } else if ($add_ammount < 1){
        $errorMsg[] = ("The number cannot start with 0");
    } else if (empty($add_title)) {
        $errorMsg[] = ("Please enter title");
    } else if (strlen($add_title) > 60) {
        $errorMsg[] = ("The title value must be less than 60 letters");
    } else if (!ctype_alpha(str_replace(' ', '', $add_title))) {
        $errorMsg[] = ("Please use only letters in the title");
    } else if (empty($add_subtitle)) {
        $errorMsg[] = ("Please enter subtitle");
    } else if (strlen($add_subtitle) > 90) {
        $errorMsg[] = ("The subtitle value must be less than 100 letters");
    } else if (empty($add_description)) {
        $errorMsg[] = ("Please enter description");
    } else if (strlen($add_description) > 255) {
        $errorMsg[] = ("The description value must be less than 255 letters");
    } else if (empty($add_link_pre)) {
        $errorMsg[] = ("Please enter social media link");
    } else if ($add_category == 'facebook' & $trim_host !== 'facebook.com') {
        $errorMsg[] = ('Invalid link, please use facebook.com/...');
    } else if ($add_category == 'youtube' & $trim_host !== 'youtube.com') {
        $errorMsg[] = ('Invalid link, please use youtube.com/...');
    } else if ($add_category == 'instagram' & $trim_host !== 'instagram.com') {
        $errorMsg[] = ('Invalid link, please use instagram.com/...');
    } else if ($add_category == 'snapchat' & $trim_host !== 'snapchat.com') {
        $errorMsg[] = ('Invalid link, please use snapchat.com/...');
    } else if ($add_category == 'twitter' & $trim_host !== 'twitter.com') {
        $errorMsg[] = ('Invalid link, please use twitter.com/...');
    } else if ($add_category == 'pinterest' & $trim_host !== 'pinterest.com') {
        $errorMsg[] = ('Invalid link, please use pinterest.com/...');
    } else if ($add_category == 'website') {
        echo 'web';
    } else if ($add_category == 'reddit' & $trim_host !== 'reddit.com') {
        $errorMsg[] = ('Invalid link, please use reddit.com/...');
    }
    else
    {
        try
        {
            if($data_action == 'add'){
                $insert_stmt = $db->prepare("INSERT INTO list (title,subtitle,description,category1,category2,category3,country,social,verified,ammount,username,link,creation_date,refresh_date,image) VALUES (:utitle,:usubtitle,:udescription,:ucategory1,:ucategory2,:ucategory3,:ucountry,:usocial,:uverified,:uammount,:uusername,:ulink,:ucd,:urd,:uimg)");
                $add_img_name = $sid.'_'.time().'.png';
                if ($insert_stmt->execute(array(
                    'utitle' => $add_title,
                    'usubtitle' => $add_subtitle,
                    'udescription' => $add_description,
                    'ucategory1' => $add_subcategory1,
                    'ucategory2' => $add_subcategory2,
                    'ucategory3' => $add_subcategory3,
                    'ucountry' => $add_countryl,
                    'usocial' => $add_category,
                    'uverified' => $add_verified,
                    'uammount' => $add_ammount,
                    'uusername' => $add_username,
                    'ulink' => $add_link,
                    'ucd' => $date,
                    'urd' => date("Y-m-d H:i:s", strtotime("+10 days", strtotime($date))),
                    'uimg' => $add_img_name,
                ))) {
                    list($type, $add_img) = explode(';', $add_img);
                    list(, $add_img) = explode(',', $add_img);
                    $add_img = base64_decode($add_img);
                    file_put_contents('style/img/upload/' . $add_img_name, $add_img);
                    $addlinkMsg = "Your link has been added!";
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                }
            }else if ($data_action == 'upload'){
                $id_link = $_POST['link_id'];
                $upl = $_POST['upl'];
                $insert_stmt = $db->prepare("UPDATE list SET title=:utitle,subtitle=:usubtitle,description=:udescription,category1=:ucategory1,category2=:ucategory2,category3=:ucategory3,country=:ucountry,social=:usocial,ammount=:uammount,link=:ulink,image=:uimg WHERE username=:uusername AND id=:uid");
                $add_img_name = '';
                if($upl == 'true'){
                    $add_img_name = $sid.'_'.time().'.png'; 
                }else{
                    $add_img_name = $add_img;
                }
                if ($insert_stmt->execute(array(
                    'utitle' => $add_title,
                    'usubtitle' => $add_subtitle,
                    'udescription' => $add_description,
                    'ucategory1' => $add_subcategory1,
                    'ucategory2' => $add_subcategory2,
                    'ucategory3' => $add_subcategory3,
                    'ucountry' => $add_countryl,
                    'usocial' => $add_category,
                    'uammount' => $add_ammount,
                    'ulink' => $add_link,
                    'uimg' => $add_img_name,
                    'uusername' => $add_username,
                    'uid' => $id_link,
                ))) {
                    if($upl == 'true'){
                        $img_unlink = 'style/img/upload/'.$old_img;
                        echo $img_unlink;
                        unlink($img_unlink);
                        list($type, $add_img) = explode(';', $add_img);
                        list(, $add_img) = explode(',', $add_img);
                        $add_img = base64_decode($add_img);
                        file_put_contents('style/img/upload/' . $add_img_name, $add_img);
                   }
                    $addlinkMsg = "Your link has been update!";
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    if(isset($errorMsg)) foreach($errorMsg as $error) echo '<div class="error">'.$error.'</div>';
    if(isset($addlinkMsg)) echo '<div class="success">'.$addlinkMsg.'</div>';
}