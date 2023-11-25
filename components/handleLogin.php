<?php
$showError = "false";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_conn.php';
    $logged = false;
    $name = $_POST['nameLog'];
    $pass = $_POST['passwordLog'];
    $sql = "Select * from users where username='$name'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row['password'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['name'] = $name;
            $_SESSION['role'] = $row['role'];
            $logged = true;
        }
    }
    if ($logged && $_SESSION['role'] == 'user') {
        header('Location: /resturant/index.php');
        exit();
    } else if ($logged && $_SESSION['role'] == 'cook') {
        header("Location: /resturant/cook.php");
        exit();
    } else if ($logged && $_SESSION['role'] == 'admin') {
        header("Location: /resturant/admin.php?date=tday");
        exit();
    } else {
        $showError = "Invalid password or username";
        header("Location: /resturant/components/sign.php?loginsuccess=false&error=$showError");
        exit();
    }
}
