<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  
  <div class="main">
    <ul class="cards">
      <?php
      if ($_SESSION['role'] == 'user') {
        $sql = 'SELECT * FROM `menu`';
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['sno'];
          $img = base64_encode($row['img']);
          $desc = $row['description'];
          $name = $row['name'];
          $price = $row['price'];
          echo '<li class="cards_item">
        <div class="card">
          <div class="card_image"><img  src="data:image/jpeg;base64,' . $img . ' "  
          ></div>
          <div class="card_content">
            <h2 class="card_title">' . $name . '</h2>
            <p class="card_text">' . substr($desc, 0, 100) . '...</p>
            <div class="setBtn">
            <form action="' . $_SERVER["REQUEST_URI"] . '" method="post" class="frm">
              <input type="number" name="qty" placeholder="Qty" class="inp" min="1" max="10" required>
              <input type="hidden" name="sno" value="' . $_SESSION["sno"] . '">
              <input type="hidden" name="dish_id" value="' . $id . '">
              <button onClick="onClick()" class="btn card_btn btn1" type="submit">Order: ' . $price  . '₹ per QTY</button>
              </form>
            <a class="btn card_btn btn1" href="info.php?sno=' . $id . '">Read more</a>
            </div>
          </div>
        </div>
      </li>';
        }
      } 
      else {
        echo '<script type="text/javascript">
        window.location.href = "error.php";
        </script>';
      }

      ?>
      <?php
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'POST') {
        // sleep(5);
        $qty = $_POST['qty'];
        $user_id = $_POST['sno'];
        $dish_id = $_POST['dish_id'];
        $sql = "INSERT INTO `orders` ( `user_id`, `qty`, `dish_id`) VALUES ( '$user_id', '$qty', '$dish_id')";
        $result = mysqli_query($conn, $sql); 
      }
      ?>
    </ul>
  </div>
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <?php
    $sum = 0;
    $sql = 'SELECT * FROM `orders` WHERE user_id=' . $_SESSION['sno'] . '  GROUP BY user_id ';
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if($num>0){
    while ($row = mysqli_fetch_assoc($result)) {
      $sno = $row['sno'];
      $user = $row['user_id'];
      $orderSql = "SELECT *, SUM(qty) FROM `orders` WHERE `user_id`= $user GROUP BY `user_id`, `dish_id`";
      $orderResult = mysqli_query($conn, $orderSql);
      while ($orderRow = mysqli_fetch_assoc($orderResult)) {
        $id = $orderRow['dish_id'];
        $qty = $orderRow['SUM(qty)'];
        $menuSql = "SELECT * FROM `menu` WHERE `sno` = $id";
        $result1 = mysqli_query($conn, $menuSql);
        $dishRow  = mysqli_fetch_assoc($result1);
        $sum = $sum + ($dishRow['price'] * $qty);
        echo '<a>' . $dishRow['name'] . ':' . $qty . '</a>';
      }
    }
    echo '<a>Total: ' . $sum . '</a>';
  }
  else{
    echo '<a>Add Something...</a>';
  }
    ?>
  </div>
  <span class="menu-ic" onclick="openNav()">
    <img class="img-ic" src="https://cdn-icons-png.flaticon.com/512/1950/1950715.png" alt=""></span>
  <script>
      function onClick(){
        alert("Check the order list in bottom left corner");
      }

    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
    
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
  </script>
</body>

</html>