<?php
$servername = "localhost";
$database = "covidservice";
$username = "root";
$password = null;

$conn = mysqli_connect($servername, $username, $password, $database);

$queryValues = $_POST['queryValues'];

?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <table class="styled-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Flag</th>
                <th>Country</th>
                <th>Case By Pop</th>
                <th>Test By Pop</th>
                <th>Case By Test</th>
                <th>Dead By Pop</th>
                <th>Dead By Case</th>
                <th>Recover By Pop</th>
                <th>Recover By Case</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, $queryValues);
            $count = 1;
            while ($row = mysqli_fetch_array($result)) {
                $country = $row[0];
                $caseByPop = $row[1];
                $testByPop  = $row[2];
                $caseByTest = $row[3];
                $deadByPop = $row[4];
                $deadByCase = $row[5];
                $recoverByPop = $row[6];
                $recoverByCase = $row[7];
                $flag = $row[8];

                echo "<tr>";
                echo "<td>{$count}</td>";
                echo "<td><img src=\"$flag\"></td>";
                echo "<td>{$country}</td>";
                echo "<td>{$caseByPop}</td>";
                echo "<td>{$testByPop}</td>";
                echo "<td>{$caseByTest}</td>";
                echo "<td>{$deadByPop}</td>";
                echo "<td>{$deadByCase}</td>";
                echo "<td>{$recoverByPop}</td>";
                echo "<td>{$recoverByCase}</td>";
                echo "</tr>";
                $count++;
            }
            ?>
        </tbody>
</body>

</html>
