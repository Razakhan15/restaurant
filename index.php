<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
  <link rel="stylesheet" href="indStyle.css">
</head>

<body>
  <?php
  //Handling error of back page
  header('Cache-Control: no cache'); //no cache
  session_cache_limiter('private_no_expire');
  include 'components/db_conn.php';?>
  <?php
  include 'components/header.php';
  ?>

  <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include 'components/menu.php';
  } else {
    header("Location: /resturant/components/sign.php");
    exit();
  } ?>

</body>


</html>