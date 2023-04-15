<?php
//consistent with the rest of the code
require_once("db.class.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$pdo = new PDO('mysql:host=localhost;dbname=coecsa_room_scheduling', 'root', null);
$mysqli = new mysqli('localhost', 'root', null, 'coecsa_room_scheduling');

DB::$user = 'root';
DB::$password = '';
DB::$dbName = 'coecsa_room_scheduling';
