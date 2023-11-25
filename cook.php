<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--  refresh a page every 10 sec  -->
    <meta http-equiv="refresh" content="10" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cook.css">

    <title>Cook's side</title>
</head>

<body>
    <?php
    // Handling error of back page
    header('Cache-Control: no cache'); //no cache
    session_cache_limiter('private_no_expire');
    include 'components/db_conn.php'; ?>
    <?php
    include 'components/header.php';
    ?>
    <div class="frst">
        <?php
        if ($_SESSION['role'] == 'cook') {
            // GROUPED ALL THE SAME user_id IN ONE USEING "GROUP BY".
            $sql = 'SELECT *,COUNT(*) as count  FROM `orders` group by user_id ';
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            while ($row = mysqli_fetch_assoc($result)) {
                $sno = $row['sno'];
                $user = $row['user_id'];
                $noDish = $row['count'];
                echo '
                    <div class="main">
                        <div class="container">
                            <div class="side">';
                $userSql = "SELECT *  FROM `users` WHERE `sno` = $user";
                $userResult = mysqli_query($conn, $userSql);
                $userRow  = mysqli_fetch_assoc($userResult);
                echo  '<h1>' . $userRow['username'] . '</h1>';
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == 'POST' && $user == $_POST['val']) {
                    echo '<div id="countdown"></div>';
                }
                echo '<div class="btn-1">';
                $orderSql = "SELECT *, SUM(qty) FROM `orders` WHERE `user_id`= $user GROUP BY `user_id`, `dish_id`";
                $orderResult = mysqli_query($conn, $orderSql);
                $sum = 0;
                while ($orderRow = mysqli_fetch_assoc($orderResult)) {
                    $id = $orderRow['dish_id'];
                    $qty = $orderRow['SUM(qty)'];
                    $menuSql = "SELECT * FROM `menu` WHERE `sno` = $id";
                    $result1 = mysqli_query($conn, $menuSql);
                    $dishRow  = mysqli_fetch_assoc($result1);
                    $sum = ($dishRow['price'] * $qty);
                    echo '<a class="btn" href="info.php?sno=' . $dishRow['sno'] . '">' . $dishRow['name'] . ':' . $qty . '</a>';
                    if ($method == 'POST' && $user == $_POST['val']) {
                        sleep(2);
                        $name = $userRow['username'];
                        $order = $dishRow['name'];
                        $pr = $dishRow['price'];
                        $sqlin = "INSERT INTO `admin` ( `client`, `orders`, `price`,`quantity`, `orderDate`, `total`) VALUES ( '$name', '$order', '$pr','$qty', current_timestamp(), '$sum')";
                        $resultin = mysqli_query($conn, $sqlin);
                        $del = "DELETE FROM orders WHERE user_id=$user";
                        $resultDel = mysqli_query($conn, $del);
                    }
                }
                echo '
                    </div>
                            <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
                                <button class="btn" value="' . $user . '" name="val" type="submit">DONE</button>
                            </form>
                    </div>
                </div>
            </div>
    ';
            }
        } else {
            echo '
            <script type="text/javascript">
                window.location.href = "error.php";
            </script>';
        }
        ?>
    </div>
</body>

</html>
<script>
    var timeleft = 10;
    var downloadTimer = setInterval(function() {
        if (timeleft <= 0) {
            clearInterval(downloadTimer);
            document.getElementById("countdown").innerHTML = "Finished";
        } else {
            document.getElementById("countdown").innerHTML = "Submitting in " + timeleft + " seconds...";
        }
        timeleft -= 1;
    }, 1000);
</script>