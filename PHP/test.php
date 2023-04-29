
<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');

include('db.class.php');

$db = new Db();
$result = $db->updateTask(23, "finish");

echo json_encode($result);