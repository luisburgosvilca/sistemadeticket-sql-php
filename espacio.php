<?php 
$df_c = disk_free_space("C:");

$Bytes = disk_total_space("C:");

function dataSize($Bytes)
{
$Type=array("", "kilo", "mega", "giga", "tera");
$counter=0;
    while($Bytes>=1024){
        $Bytes/=1024;
        $counter++;
    }
    return("".$Bytes." ".$Type[$counter]."bytes");
}
echo "<br>";
echo $total = round(dataSize($Bytes), 2);
echo "<br>";
echo $free = round(dataSize($df_c),2);
echo "<br>";
echo round((($free/$total)*100),2)." %";

echo "<br>////////////////////////////<br>";

    $bytes = disk_free_space("."); 
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;
    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
    echo $bytes . '<br />';
    echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '<br />';
    echo "<br>".pow(2,3);
    echo "<br>". pow(512,(1/3));