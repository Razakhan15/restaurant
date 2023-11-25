<?php
session_start();
session_destroy();
//NULL session after destroying it
$_SESSION = NULL;
header("Location: /resturant/components/sign.php");
exit();
