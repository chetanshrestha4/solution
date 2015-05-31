<?php
//reading two csv files
$fileName1 = fopen('awards.csv', 'r');
$fileName2 = fopen('contracts.csv', 'r');

while (($data = fgetcsv($fileName1, 0, ",")) !== FALSE) {

    $awards[]=$data;
}
while (($data = fgetcsv($fileName2, 0, ",")) !== FALSE) {

    $contracts[]=$data;
}
// Merging two csv files

$newfile=array();
$empty=array("","","","","");
$currenrcon=0;

foreach($contracts as $dt2 ){
    $flag=FALSE;
    foreach($awards as $dt1){
        if(strtolower($dt2[0])==strtolower($dt1[0]))
        {
            array_shift($dt1);
            $dt2 = array_merge_recursive($dt2, $dt1);
            $flag=TRUE;
        }
    }
    if($flag!=TRUE){
        $dt2 = array_merge_recursive($dt2, $empty);
    }

    if(strtolower($dt2[1])=="current" )
    {
        $currenrcon=$currenrcon+$dt2[12];
    }
    $newfile[] = $dt2;
}

print_r("Total Amount of current contracts: ".$currenrcon );

// Writing on final.csv

$fileName3 = fopen('final.csv', 'w');

foreach ($newfile as $fields) {
    fputcsv($fileName3, $fields);
}
fclose($fileName3);
?>
