<?php
// URL zdalnego obrazu
$url  =  'https://websolutionstuff.com/frontTheme/assets/images/logo.png' ;

// Ścieżka obrazu
$img  =  'style/img/upload/codexworld.png' ;

// Zapisz obraz
file_put_contents($img, file_get_contents($url));