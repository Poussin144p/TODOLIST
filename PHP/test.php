<?php

include("db.class.php");

$pdo = new Db();

$num = $pdo->lastInsertId();

var_dump($num);

