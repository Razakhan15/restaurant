<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="info.css">
    <title>Document</title>
</head>

<body>
    <?php include 'components/db_conn.php'; ?>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="upBox">
            <?php
            $id = $_GET['sno'];
            $sql = "SELECT * FROM `menu` WHERE sno=$id";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $img = base64_encode($row['img']);
                $desc = $row['description'];
                $name = $row['name'];
                $ingredient = $row['ingredient'];
                echo ' <img src="data:image/jpeg;base64,' . $img . ' " alt="">
            <div class="itemInfo">
                <h1 class="name">' . $name . '</h1>
                <p class="ing"><b>ingredients: </b>' . $ingredient . '</p>';
                if ($_SESSION['role'] == 'cook') {
                    echo '<p class="ing"><b>Description: </b>' . $desc . '</p>';
                }
                '</div>
            ';
            }
            ?>
        </div>
    </div>
</body>

</html>