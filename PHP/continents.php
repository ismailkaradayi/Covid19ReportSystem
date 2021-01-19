<?php
$servername = "localhost";
$database = "covidservice";
$username = "root";
$password = null;

$conn = mysqli_connect($servername, $username, $password, $database);

$query = "SELECT * From continents";

?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>

</head>

<body>
    <table class="styled-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Continent</th>
                <th>Cases</th>
                <th>Deaths</th>
                <th>Recovered</th>
                <th>Active</th>
                <th>Critical</th>
                <th>Tests</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, $query);
            $count = 1;
            while ($row = mysqli_fetch_array($result)) {
                $continent = $row[0];
                $cases = number_format($row[1]);
                $testByPop  = number_format($row[2]);
                $deaths = number_format($row[3]);
                $recovered = number_format($row[4]);
                $active = number_format($row[5]);
                $tests = number_format($row[6]);
                $population = number_format($row[7]);

                echo "<tr>";
                echo "<td>{$count}</td>";
                echo "<td>{$continent}</td>";
                echo "<td>{$cases}</td>";
                echo "<td>{$testByPop}</td>";
                echo "<td>{$deaths}</td>";
                echo "<td>{$recovered}</td>";
                echo "<td>{$active}</td>";
                echo "<td>{$tests}</td>";
                echo "<td>{$population}</td>";
                echo "</tr>";
                $count++;
            }
            ?>
        </tbody>
</body>

</html>
