<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include 'components/db_conn.php';
    include 'components/header.php';
    $arr = array();
    for ($i = 1; $i <= 12; $i++) {
        $sqlAna = "SELECT *,SUM(total),MONTH(orderDate) FROM `admin` WHERE MONTH(orderDate)=$i";
        $resultAna = mysqli_query($conn, $sqlAna);
        $rowAna = mysqli_fetch_assoc($resultAna);
        array_push($arr, $rowAna['SUM(total)']);
    }
    $dataPoints = array(
        array("y" =>  $arr[0] - 7000, "label" => "jan"),
        array("y" =>  $arr[1] - 1000, "label" => "feb"),
        array("y" =>  $arr[2] - 200, "label" => "mar"),
        array("y" =>  $arr[3] - 10000, "label" => "apr"),
        array("y" =>  $arr[4] - 4000, "label" => "may"),
        array("y" =>  $arr[5] - 7000, "label" => "june"),
        array("y" =>  $arr[6] - 8000, "label" => "july"),
        array("y" =>  $arr[7] - 5000, "label" => "aug"),
        array("y" =>  $arr[8] - 6000, "label" => "sep"),
        array("y" =>  $arr[9] - 3000, "label" => "oct"),
        array("y" =>  $arr[10] - 2000, "label" => "nov"),
        array("y" =>  $arr[11] - 7500, "label" => "dec")
    );
    $dataPoints1 = array(
        array("y" => 7000, "label" => "jan"),
        array("y" => 1000, "label" => "feb"),
        array("y" => 200, "label" => "mar"),
        array("y" => 10000, "label" => "apr"),
        array("y" => 4000, "label" => "may"),
        array("y" => 7000, "label" => "june"),
        array("y" => 8000, "label" => "july"),
        array("y" => 5000, "label" => "aug"),
        array("y" => 6000, "label" => "sep"),
        array("y" => 3000, "label" => "oct"),
        array("y" => 2000, "label" => "nov"),
        array("y" => 7500, "label" => "dec")
    );
    $dataPoints2 = array(
        array("y" => $arr[0], "label" => "jan"),
        array("y" => $arr[1], "label" => "feb"),
        array("y" => $arr[2], "label" => "mar"),
        array("y" => $arr[3], "label" => "apr"),
        array("y" => $arr[4], "label" => "may"),
        array("y" => $arr[5], "label" => "june"),
        array("y" => $arr[6], "label" => "july"),
        array("y" => $arr[7], "label" => "aug"),
        array("y" => $arr[8], "label" => "sep"),
        array("y" => $arr[9], "label" => "oct"),
        array("y" => $arr[10], "label" => "nov"),
        array("y" => $arr[11], "label" => "dec")
    );
    ?>
    <div id="chartContainer" style="margin:3rem; height: 370px; width: 95%; z-index: -1;"></div>
    <div id="chartContainer1" style="margin:3rem; height: 370px; width: 95%;"></div>


    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Expenses and Revenue of Restaurant"
                },
                axisY: {
                    includeZero: true,
                    prefix: "₹",
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "center",
                    horizontalAlign: "right",
                    itemclick: toggleDataSeries
                },
                data: [{
                    type: "column",
                    name: "Expenses in ₹",
                    indexLabel: "{y}",
                    yValueFormatString: "₹#0.##",
                    showInLegend: true,
                    dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                }, {
                    type: "column",
                    name: "Revenue in ₹",
                    indexLabel: "{y}",
                    yValueFormatString: "₹#0.##",
                    showInLegend: true,
                    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

            function toggleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }

            var chart1 = new CanvasJS.Chart("chartContainer1", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Simple Column Chart with Index Labels"
                },
                axisY: {
                    includeZero: true,
                    prefix: "₹",
                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    indexLabel: "{y}", //Shows y value on all Data Points
                    indexLabelFontColor: "#5A5757",
                    indexLabelPlacement: "outside",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart1.render();

        }
    </script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>