<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responsive Navbar</title>
  <style>
    <?php session_start();
    include 'components/headStyle.css'; ?>
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
  <div class="page-header">
    <div class="logo">
      <p>Logo</p>
    </div>
    <a id="menu-icon" class="menu-icon" onclick="onMenuClick()">
      <i class="fa fa-bars"></i>
    </a>

    <div id="navigation-bar" class="nav-bar">
      <?php
      include 'db_conn.php';
      if ($_SESSION['role'] == 'cook') {
        echo '<a href="/resturant/cook.php" class="active">Home</a>
        <a href="#">Services</a>
        <a href="#">Profile</a>
        <a href="#">About</a>
        <a href="#">Contact us</a>';
      }
      if ($_SESSION['role'] == 'admin') {
        echo '<a href="/resturant/admin.php?date=tday" class="active">Home</a>
        <a href="/resturant/analyt.php">Analytics</a>
        <a href="/resturant/InsMenu.php">Menu</a>
        <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Data</a>
    <div class="dropdown-content">
      <a href="/resturant/admin.php?date=all">All</a>
      <a href="/resturant/admin.php?date=mnth">Last Month</a>
      <a href="/resturant/admin.php?date=tmnth">This Month</a>
      <a href="/resturant/admin.php?date=tday">Today</a>
    </div>
  </li>';
      }
      if ($_SESSION['role'] == 'user') {
        echo '<a href="/resturant" class="active">Home</a>
        <a href="#">Services</a>
        <a href="#">Profile</a>
        <a href="#">About</a>
        <a href="#">Contact us</a>';
      }
      ?>
    </div>

    <a href="components/logout.php" class="button-9">Logout</a>

  </div>
</body>

</html>


<script>
  function onMenuClick() {
    var navbar = document.getElementById("navigation-bar");
    var responsive_class_name = "responsive";
    navbar.classList.toggle(responsive_class_name);
  }
</script>