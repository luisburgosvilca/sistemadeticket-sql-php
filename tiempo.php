<?php
//tiempo en segundos
$t = 10800;

if($t<60){
    $r = $t." seg";
}elseif($t<3600){
    $r = round($t/60)." min";
}else{
    $r = round($t/3600)." hrs";
}

echo $r;