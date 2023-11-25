<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'restaurant';
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    echo "Sorry! some internal problem occured";
}
