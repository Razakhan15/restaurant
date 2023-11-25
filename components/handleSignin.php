<?php
$showerr = 'false';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include 'db_conn.php';
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $existSql = "SELECT * FROM `users` WHERE email='$email'";
    $result = mysqli_query($conn, $existSql);
    $numOfRow = mysqli_num_rows($result);
    $existSql2 = "SELECT * FROM `users` WHERE  username='$username'";
    $result2 = mysqli_query($conn, $existSql2);
    $numOfRow2 = mysqli_num_rows($result2);
    if ($numOfRow > 0) {
        $showerr = "Email already in use";
    } elseif ($numOfRow2 > 0) {
        $showerr = "Username already in use";
    } else {
        if ($password == $cpassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES ( '$username', '$email', '$hash')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                header("Location: /resturant/components/sign.php?signupsuccess=true");
                exit();
            }
        } else {
            $showerr = "Password does not match";
        }
    }
    header("Location: /resturant/components/sign.php?signupsuccess=false&error=$showerr");
}

