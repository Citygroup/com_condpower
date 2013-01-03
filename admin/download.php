<?php
//    $file_name = __DIR__.'/com_condpower.csv';
//var_dump($_GET);exit;
    $file_name = $_GET['path'];
    header('Content-disposition: attachment; filename=com_condpower.csv');
    header('Content-type: application/vnd.ms-excel');
    readfile($file_name);
//    readfile('com_condpower.csv');
?>
