<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Panel</title>
</head>

<body>
    <?php
    include 'components/db_conn.php';
    include 'components/header.php';
    ?>
    <div class="mainBd">
        <table>
            <tr>
                <th>Firstname</th>
                <th>
                    <div class="main">
                        <li>dish</li>
                        <li>qty</li>
                        <li>price</li>
                    </div>
                </th>
                <th>total price</th>
                <?php
                if ($_SESSION['role'] == 'admin') {
                    $url =  $_SERVER['REQUEST_URI'];
                    $url_components = parse_url($url);
                    $curYr = date("Y");
                    parse_str($url_components['query'], $params);
                    if ($params['date'] == 'tday') {
                        $pass = 0;
                        $curDay = date("Y-m-d");
                        $sql = "SELECT *,SUM(total),DATE(orderDate),TIME(orderDate),MONTH(orderDate),YEAR(orderDate) FROM `admin`  WHERE DATE(orderDate)='$curDay'  GROUP BY orderDate";
                    } else if ($params['date'] == 'tmnth') {
                        $pass = 1;
                        $curMnth = date("m");
                        $sql = "SELECT *,SUM(total),TIME(orderDate),MONTH(orderDate),YEAR(orderDate),DATE(orderDate) FROM `admin`  WHERE MONTH(orderDate)=$curMnth && YEAR(orderDate)=$curYr GROUP BY orderDate";
                    } else if ($params['date'] == 'mnth') {
                        $pass = 1;
                        $lstMnth = date("m", strtotime("-1 month"));
                        $sql = "SELECT *,SUM(total),TIME(orderDate),MONTH(orderDate),YEAR(orderDate),DATE(orderDate) FROM `admin`  WHERE MONTH(orderDate)=$lstMnth && YEAR(orderDate)=$curYr GROUP BY orderDate";
                    } else {
                        $pass = 1;
                        $sql = "SELECT *,SUM(total),TIME(orderDate),DATE(orderDate) FROM `admin` GROUP BY orderDate";
                    }
                    if ($pass == 1) {
                        echo  '<th>date</th>
                    </tr>';
                    } else {
                        echo  '<th>time</th>
                    </tr>';
                    }
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $name = $row['client'];
                        $date = $row['orderDate'];
                        $time = $row['TIME(orderDate)'];
                        $total = $row['SUM(total)'];
                        $dateOth = $row['DATE(orderDate)'];
                        
                        echo '
                    <tr>
                <td>' . $name . '</td>
                <td>
                    <div class="otMn">';
                        $allOdr = "SELECT * FROM `admin` where `orderDate`= '$date'";
                        $resultOdr = mysqli_query($conn, $allOdr);
                        while ($row = mysqli_fetch_assoc($resultOdr)) {
                            $dish = $row['orders'];
                            $qty = $row['quantity'];
                            $pr = $row['price'];
                            echo '<div class="main">
                            <li>' . $dish . '</li>
                            <li>' . $qty . '</li>
                            <li>' . $pr . '</li>
                        </div>';
                        }
                        echo '</div>
                </td>
                <td>' . $total . '</td>';
                        if ($pass == 1) {
                            echo  '<td>' . $dateOth . '</td>';
                        } else {
                            echo  '<td>' . $time . '</td>';
                        }
                        echo '</tr> ';
                    }
                } else {
                    echo '<script type="text/javascript">
            window.location.href = "error.php";
            </script>';
                }

                ?>
        </table>
    </div>

</body>

</html>