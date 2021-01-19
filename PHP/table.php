<?php
$servername = "localhost";
$database = "covidservice";
$username = "root";
$password = null;

$conn = mysqli_connect($servername, $username, $password, $database);
// postlanan veriyi çek  anahtar kelimesyle
$queryValues = $_POST['queryValues'];
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <table class="styled-table">
        <tbody>
            <?php
            // PHP DÜnya verilerini toladtık ilk satıra sabit ekle        
            $wordQuery = "SELECT SUM(cases)as 'Cases', SUM(deaths)as 'Deaths', SUM(recovered) as 'Recovered', SUM(active)as 'Active', SUM(critical) as 'Critical', SUM(todayCases) as 'todayCases', SUM(todayDeaths) as 'todayDeaths' , SUM(todayRecovered) as 'todayRecovered' FROM  generaltable";
            $result = mysqli_query($conn, $wordQuery);
            $json = mysqli_fetch_object($result);
            $encode = json_encode($json);
            $Cases = number_format($json->Cases);
            $todayCases = number_format($json->todayCases);
            $Deaths = number_format($json->Deaths);
            $todayDeaths = number_format($json->todayDeaths);
            $Recovered = number_format($json->Recovered);
            $todayRecovered = number_format($json->todayRecovered);
            $Active = number_format($json->Active);
            $Critical = number_format($json->Critical);
            echo "<tr>";
            echo "<td style=\"width:60px !important;\"></td>";
            echo "<td style=\"width:100px !important;\"><img src=\"https://bit.ly/39M6fkO\"></td>";
            echo "<td style=\"width:100px !important;\">World</td>";
            echo "<td style=\"width:100px !important;\">{$Cases}</td>";
            echo "<td style=\"width:100px !important;\">{$todayCases}</td>";
            echo "<td style=\"width:100px !important;\">{$Deaths}</td>";
            echo "<td style=\"width:100px !important;\">{$todayDeaths}</td>";
            echo "<td style=\"width:100px !important;\">{$Recovered}</td>";
            echo "<td style=\"width:100px !important;\">{$todayRecovered}</td>";
            echo "<td style=\"width:100px !important;\">{$Active}</td>";
            echo "<td style=\"width:100px !important;\">{$Critical}</td>";
            echo "<td style=\"width:100px !important;\"></td>";
            echo "<td style=\"width:100px !important;\"></td>";
            echo "<td style=\"width:100px !important;\"></td>";
            echo "<td style=\"width:100px !important;\"></td>";
            echo "<td style=\"width:130px !important;\"></td>";
            echo "<td style=\"width:120px !important;\"></td>";
            echo "</tr>";
            ?>

            <?php
            $result = mysqli_query($conn, $queryValues);
            $count = 1;
            // while donguusyle asıl verileri cek
            while ($row = mysqli_fetch_array($result)) {
                $country = $row[1];
                $flag = $row[2];
                $cases = number_format($row[3]);
                $todayCases = number_format($row[4]);
                $deaths  = number_format($row[5]);
                $todayDeaths  = number_format($row[6]);
                $recovered = number_format($row[7]);
                $todayRecovered = number_format($row[8]);
                $active = number_format($row[9]);
                $critical = number_format($row[10]);
                $casesPerOneMillion = number_format($row[11]);
                $deathsPerOneMillion = number_format($row[12]);
                $tests = number_format($row[13]);
                $testsPerOneMillion = number_format($row[14]);
                $population = number_format($row[15]);
                $continent = $row[16];

                echo "<tr>";
                echo "<td style=\"width:60px !important;\">{$count}</td>";
                echo "<td style=\"width:100px !important;\"><img src=\"$flag\">";
                echo "<td style=\"width:100px !important;\">{$country}</td>";
                echo "<td style=\"width:100px !important;\">{$cases}</td>";
                echo "<td style=\"width:100px !important;\">{$todayCases}</td>";
                echo "<td style=\"width:100px !important;\">{$deaths}</td>";
                echo "<td style=\"width:100px !important;\">{$todayDeaths}</td>";
                echo "<td style=\"width:100px !important;\">{$recovered}</td>";
                echo "<td style=\"width:100px !important;\">{$todayRecovered}</td>";
                echo "<td style=\"width:100px !important;\">{$active}</td>";
                echo "<td style=\"width:100px !important;\">{$critical}</td>";
                echo "<td style=\"width:100px !important;\">{$casesPerOneMillion}</td>";
                echo "<td style=\"width:100px !important;\">{$deathsPerOneMillion}</td>";
                echo "<td style=\"width:100px !important;\">{$tests}</td>";
                echo "<td style=\"width:100px !important;\">{$testsPerOneMillion}</td>";
                echo "<td style=\"width:130px !important;\">{$population}</td>";
                echo "<td style=\"width:120px !important;\">{$continent}</td>";
                echo "</tr>";
                $count++;
            }
            ?>

        </tbody>
    </table>
</body>

</html>
