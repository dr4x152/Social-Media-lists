<?php
include('base.php');
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<?
$table_name = 'facebook/instagram/youtube/snapchat/tiktok/twitter/pinterest/website';
$table = explode('/',$table_name);
$il = $table;
for($il=0; $il<=7; $il++){
    for($i=0; $i < 25; $i++){
        $date = date('Y-m-d H:i:s');
        $insert_stmt = $db->prepare("INSERT INTO list (title,subtitle,description,category1,category2,category3,country,social,verified,ammount,username,link,creation_date,refresh_date,promo_date,image) VALUES (:utitle,:usubtitle,:udescription,:ucategory1,:ucategory2,:ucategory3,:ucountry,:usocial,:uverified,:uammount,:uusername,:ulink,:ucd,:urd,:upd,:uimage)");
        if ($insert_stmt->execute(array(
            'utitle' => 'Rhoncus mattis rhoncus urna neque viverra justo nec ultrices',
            'usubtitle' => 'Vitae et leo duis ut diam quam nulla porttitor massa id neque aliquam vestibulum morbi bla',
            'udescription' => 'felis imperdiet proin fermentum leo vel orci porta non pulvinar neque laoreet suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam non nisi est sit amet facilisis magna etiam tempor orci eu lobortis elementum nibh tellus molestie',
            'ucategory1' => 'Actor',
            'ucategory2' => 'Music',
            'ucategory3' => 'Food',
            'ucountry' => 'Egypt',
            'usocial' => $table[$il],
            'uverified' => 0,
            'uammount' => 100000,
            'uusername' => 'admin',
            'ulink' => 'http://'.$table[$il].'.com/test',
            'ucd' => $date,
            'urd' => date("Y-m-d H:i:s", strtotime("+10 days", strtotime($date))),
            'upd' => '',
//            'upd' => date("Y-m-d H:i:s", strtotime("+100 days", strtotime($date))),
            'uimage' => 'dr4x152_1643624199.png',
        ))){}
    }
}
?>

</body>

</html>