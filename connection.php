<?php
$serverName = 'localhost';
$username = 'root';
$password = '1235';
$dbName = 'niagahoster';

$conn = new mysqli($serverName, $username, $password, $dbName);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}