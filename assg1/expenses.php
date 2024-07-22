<?php
header("Content-type:text/plain");
header("Access-Control-Allow-Origin: *");
$month = $_REQUEST['month'];
$expenses = array('4726', '4679', '4764', '4572', '4583', '4460', 
                  '4501', '4582', '4552', '4560', '4235', '4502');
echo $expenses[$month - 1];
?>

