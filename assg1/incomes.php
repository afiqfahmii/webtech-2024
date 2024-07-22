<?php
header("Content-type:text/plain");
header("Access-Control-Allow-Origin: *");
$month = $_REQUEST['month'];
$incomes = array('5453', '5453', '5453', '5453', '5453', '5453', 
                 '5453', '5453', '5453', '5918', '5352', '5651');
echo $incomes[$month - 1];
?>
