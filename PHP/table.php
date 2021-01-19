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
    
</head>

<body>
    <table class="styled-table">        
        <tbody>
            <?php    
            // PHP DÜnya verilerini toladtık ilk satıra sabit ekle        
            $wordQuery = "SELECT SUM(cases)as 'Cases', SUM(deaths)as 'Deaths', SUM(recovered) as 'Recovered', SUM(active)as 'Active', SUM(critical) as 'Critical' FROM generaltable";
            $result = mysqli_query($conn, $wordQuery);
            $json = mysqli_fetch_object($result);
            $encode = json_encode($json);
            $Cases = number_format($json->Cases);
            $Deaths = number_format($json->Deaths);
            $Recovered = number_format($json->Recovered);
            $Active = number_format($json->Active);
            $Critical = number_format($json->Critical);
            echo "<tr>";
            echo "<td style=\"width:60px !important;\"></td>";
            echo "<td style=\"width:120px !important;\"><img src=\"https://bit.ly/39M6fkO\"></td>";
            echo "<td style=\"width:120px !important;\">World</td>";
            echo "<td style=\"width:120px !important;\">{$Cases}</td>";
            echo "<td style=\"width:100px !important;\">{$Deaths}</td>";
            echo "<td style=\"width:110px !important;\">{$Recovered}</td>";
            echo "<td style=\"width:110px !important;\">{$Active}</td>";
            echo "<td style=\"width:100px !important;\">{$Critical}</td>";
            echo "<td style=\"width:100px !important;\"></td>";
            echo "<td  style=\"width:100px !important;\"></td>";
            echo "<td style=\"width:120px !important;\"></td>";
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
                $todayCases = number_format($row[3]);
                $todayDeaths  = number_format($row[5]);
                $todayRecovered = number_format($row[7]);
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
                echo "<td style=\"width:120px !important;\"><img src=\"$flag\">";
                echo "<td style=\"width:120px !important;\">{$country}</td>";
                echo "<td style=\"width:120px !important;\">{$todayCases}</td>";
                echo "<td style=\"width:100px !important;\">{$todayDeaths}</td>";
                echo "<td style=\"width:110px !important;\">{$todayRecovered}</td>";
                echo "<td style=\"width:110px !important;\">{$active}</td>";
                echo "<td style=\"width:100px !important;\">{$critical}</td>";
                echo "<td style=\"width:100px !important;\">{$casesPerOneMillion}</td>";
                echo "<td style=\"width:100px !important;\">{$deathsPerOneMillion}</td>";
                echo "<td style=\"width:120px !important;\">{$tests}</td>";
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