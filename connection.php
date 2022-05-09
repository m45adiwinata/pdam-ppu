<?php
$servername = "103.135.24.11:3309";
$username = "bimasakti";
$password = "bimasaktisanjaya2017";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo("koneksi berhasil");

?>