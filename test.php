<?php

?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body{
        margin: 0;
    }
    .container{
        width: 500px;
        display: flex;
        flex-wrap: wrap;
        margin: 0 auto 0 auto;
    }
    .square{
        width: 8px;
        height: 8px;
        border: 1px solid white;
        background: black;
    }
     @media only screen and (max-width: 600px) {   
        .container{
            width: calc(100% - 10px);
            margin: 5px;
        }
        .square{
            width: calc(2% - 2px);
            background: red;
        }
    }
</style>
</head>
<div class="container">
    <?php
        for($i=1; $i<=10000; $i++){
            $nr = 0 + $i;
            echo '<div alt="'.$nr.'" class="square"></div>';
        }
    ?>
</div>