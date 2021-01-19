<?php
$servername = "localhost";
$database = "covidservice";
$username = "root";
$password = null;
// Connecting the SQL.
$conn = mysqli_connect($servername, $username, $password, $database);

?>

<html>

<head>
	<title>Covid 19 Table</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<!-- OPEN LIBRARIES. -->
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		.styled-table {
			width: 100%;
			border-collapse: collapse;
			font-size: 0.9em;
			font-family: sans-serif;
			min-width: 400px;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
		}

		.styled-table thead tr {
			background-color: #8ACA2B;
			color: #ffffff;
			text-align: left;
		}

		.styled-table th,
		.styled-table td {
			padding: 10px;
		}

		.styled-table tbody tr {
			border-bottom: 1px solid #dddddd;
		}

		.styled-table tbody tr:nth-of-type(even) {
			background-color: #D6D6D6;
		}

		.styled-table tbody tr:last-of-type {
			border-bottom: 2px solid #009879;
		}

		img {
			width: 80px;
		}

		tbody {
			border-left: 1px solid #D6D6D6;
			border-right: 1px solid #D6D6D6;
		}

		.TopDiv {
			text-align: center;
			font-size: 50px;
			font-family: sans-serif;
			color: #303030;
		}

		.navbarDiv {
			height: 80px;
			width: 100%;
			font-size: 40px;
			background-color: #8ACA2B;
			text-align: left;
			padding-left: 40px;
			padding-top: 6px;
			color: white;
			font-weight: bold;
		}

		.txt {
			color: rgb(0, 0, 0);
			font-size: 20px;
			width: 80%;
			margin: auto;
			text-align: left;
			font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
		}

		.form-control {
			margin: auto;
			margin-top: 2px;
			border: 1px solid rgb(150, 150, 150);
			box-sizing: border-box;
			border-radius: .25rem;
			height: 30px;
		}

		#table-tab,
		#percent-tab,
		#continen-tab {
			padding: 14px;
			display: inline-block;
			box-sizing: border-box;
			text-align: center;
			cursor: pointer;
			font-weight: bold;
			border: 1px solid #ddd;
		}

		.active {
			background: #8ACA2B;
			color: white;
		}

		.inactice {
			color: black;
		}
	</style>
</head>

<body>
	<div class="navbarDiv">Covid-19 Report System</div>
	<div class="TopDiv">
		<div style="color:#555;font-weight: bold;">Coronavirus Cases</div>
		<?php
		// SQL SELECTION sum(cases) => Coronavirus Cases
		$query = "SELECT sum(cases) as 'sumValue' FROM generaltable";
		// Sending SQL Queery to the Database.
		$result = mysqli_query($conn, $query);
		// Pulling the database of SQL Query.
		$json = mysqli_fetch_object($result);
		// JSON Parse process
		$encode = json_encode($json);
		$div = $json->sumValue;
		// number_format has been used to better reading for human eye.
		$format = number_format($div);
		// Writing to div.
		echo "<div style=\"color:#aaa;font-weight: bold;\">$format</div>";
		?>

		<div style="margin-top: 20px; color:#555;font-weight: bold;">Deaths</div>
		<?php
		// SQL SELECTIONZ sum(deaths) => Coronavirus Cases
		$query = "SELECT sum(deaths) as 'sumValue' FROM generaltable";
		// SQL querry sending to the database.
		$result = mysqli_query($conn, $query);
		// Pulling the database of SQL Query.
		$json = mysqli_fetch_object($result);
		// JSON Parse process
		$encode = json_encode($json);
		$div = $json->sumValue;
		// Snumber_format has been used to better reading for human eye.
		$format = number_format($div);
		// Writing to div.
		echo "<div style=\"color:#696969;font-weight: bold;\">$format</div>";
		?>

		<div style="margin-top: 20px; color:#555;font-weight: bold;">Recovered</div>
		<?php
		$query = "SELECT sum(recovered ) as 'sumValue' FROM generaltable";
		$result = mysqli_query($conn, $query);
		$json = mysqli_fetch_object($result);
		$encode = json_encode($json);
		$div = $json->sumValue;
		$format = number_format($div);
		echo "<div style=\"color:#8ACA2B;font-weight: bold;\">$format</div>";
		?>

		<!-- Using a row from the bootstrap library gathering 2 equals rows. -->
		<div class="container" style="width: 40%; margin-top:50px;">
			<div class="row">
				<div class="col-md" style="border: 1px solid #ddd; margin:2px">
					<div style="font-size: 20px;  border-bottom: 1px solid #ddd; width: 100% !important;">ACTIVE CASES</div>
					<?php
					$query = "Select sum(active) as 'sumValue' from generaltable";
					$result = mysqli_query($conn, $query);
					$json = mysqli_fetch_object($result);
					$encode = json_encode($json);
					$div = $json->sumValue;
					$format = number_format($div);
					echo "<div style=\"font-size: 20px;\">$format</div>";
					?>

				</div>
				<div class="col-md" style="border: 1px solid #ddd; margin:2px; ">
					<div style="font-size: 20px; border-bottom: 1px solid #ddd; width: 100% !important;">CLOSED CASES</div>
					<?php
					$query = "Select (sum(cases)-sum(active)) as 'sumValue' from generaltable";
					$result = mysqli_query($conn, $query);
					$json = mysqli_fetch_object($result);
					$encode = json_encode($json);
					$div = $json->sumValue;
					$format = number_format($div);
					echo "<div style=\"font-size: 20px;\">$format</div>";
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- Tabs -->
	<div style="margin-top: 20px; margin-bottom:20px;">
		<div style="width: 70%; margin:auto; height: 40px;">
			<div class="container">
				<div class="row">
					<div class="col-md">
						<div style="width: 100% !important;" id="table-tab" class="inactice">World Record</div>
					</div>
					<div class="col-md">
						<div style="width: 100% !important;" id="percent-tab" class="active">Percentages</div>
					</div>
					<div class="col-md">
						<div style="width: 100% !important;" id="continen-tab" class="active">Continents</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div>
		<!-- World Record -->
		<div id="mTableContainer" style="width: 100%;">
			<div style="width: 70%; margin:auto;">
				<div style="margin-top: 10px;">
					<div class="post_div txt" style="float:left; width: 160px;">Search Country : </div>
					<div class="post_div" style="float:left; width: 200px"><input class="form-control" type="text" id="mSumbit"></div>
				</div>
			</div>

			<div style="padding-top:40px;">
				<div style=" width: 100%;  margin:auto;">
					<div style="width: 100%;" id="mtopTableDiv">
						<table class="styled-table">
							<thead>
								<tr>
									<th style="cursor:pointer; width:60px !important;">#</th>
									<th style="cursor:pointer; width:100px !important;">Flag</th>
									<th style="cursor:pointer; width:100px !important;">Country</th>
									<th id="mCases" style="cursor:pointer; width:100px !important;">Total Cases</th>
									<th style="cursor:pointer; width:100px !important;">Today Cases</th>
									<th id="mDeaths" style="cursor:pointer; width:100px !important;">Total Deaths</th>
									<th style="cursor:pointer; width:100px !important;">Today Deaths</th>
									<th id="mRecovered" style="cursor:pointer; width:100px !important;">Total Recovered</th>
									<th style="cursor:pointer; width:100px !important;">Today Recovered</th>
									<th id="mActive" style="cursor:pointer; width:100px !important;">Active</th>
									<th id="mCritical" style="cursor:pointer; width:100px !important;">Critical</th>
									<th id="mCasesPer" style="cursor:pointer; width:100px !important;">Cases Per 1M</th>
									<th id="mDeathsPer" style="cursor:pointer; width:100px !important;">Deaths Per 1M</th>
									<th id="mTests" style="cursor:pointer; width:100px !important;">Tests</th>
									<th id="mTestsPop" style="cursor:pointer; width:100px !important;">Tests 1M Pop</th>
									<th id="mPopulation" style="cursor:pointer; width:130px !important;">Population</th>
									<th style="width:120px;">Continent</th>
								</tr>
							</thead>
						</table>
					</div>
					<!-- table.php yi çektiğimiz div -->
					<div id='tableDiv' style="width: 100%; margin:auto;"></div>
				</div>
			</div>
		</div>

		<!-- Percentages -->
		<div id="mPercentContainer" style="width: 100%; display:none;">
			<div style="width: 70%; margin:auto;">
				<div style="margin-top: 10px;">
					<div class="post_div txt" style="float:left; width: 160px;">Search Country : </div>
					<div class="post_div" style="float:left; width: 200px"><input class="form-control" type="text" id="mPercentages"></div>
				</div>
			</div>
			<!-- percentages.php yi çektiğimiz div -->
			<div id="percentDiv" style="width: 70%; margin:auto; padding-top:40px;"></div>
		</div>

		<!-- Continents -->
		<div id="mContinentContainer" style="width: 100%; display:none;">
			<!-- continents.php yi çektiğimiz div -->
			<div id="continentDiv" style="width: 70%; margin:auto; padding-top:40px;"></div>
		</div>
	</div>

	<div style="height: 80px; margin-top:50px; width: 100%; background-color:#8ACA2B;"></div>

	<script type="text/javascript">
		var sorting = "DESC";
		var totalCases = true;
		var type = 0;

		//Checking the readiness of the Jquery in the head section.
		$(document).ready(function() {
			// readData is gathering the world record section.
			readData();

			//When the page is open if Jquery is ready, add the percentages.php into DIV which has the id of percentDiv
			$.post("percentages.php", {
				queryValues: "SELECT cp.country, caseByPop, testByPop, caseByTest, deadByPop, deadByCase, recoverByPop, recoverbyCase,  flag FROM casesPercentage AS cp JOIN testsPercentage AS tp ON cp.country = tp.country JOIN deathsPercentage AS dp ON tp.country = dp.country JOIN recoveredPercentage AS rp ON dp.country = rp.country JOIN generaltable AS gt ON rp.country = gt.country ORDER BY `cp`.`country` ASC"
			}, function(sendData) {
				$('#percentDiv').html(sendData);
			});

			//When the page is open if Jquery is ready, add the continents.php into the DIV whic has the id of continentDiv
			$("#continentDiv").load("continents.php");

			//When the click triggered on the world record. These lines has been executed.
			$("#table-tab").click(function() {
				// Show the table container and hide the rest of them.
				$("#mTableContainer").show();
				$("#mPercentContainer").hide();
				$("#mContinentContainer").hide();

				// tıklanan için css i .inactice yap gerisi için css .active classını yukle
				//Inactive the css which has been triggered by clicking and the other tabs will be active (css)
				$("#table-tab").addClass("inactice");
				$("#percent-tab").addClass("active");
				$("#continen-tab").addClass("active");

				//Active the css of clicked one and remove all.
				$("#table-tab").removeClass("active");
				$("#percent-tab").removeClass("inactice");
				$("#continen-tab").removeClass("inactice");
			});

			$("#percent-tab").click(function() {
				$("#mTableContainer").hide();
				$("#mPercentContainer").show();
				$("#mContinentContainer").hide();

				$("#table-tab").addClass("active");
				$("#percent-tab").addClass("inactice");
				$("#continen-tab").addClass("active");


				$("#table-tab").removeClass("inactice");
				$("#percent-tab").removeClass("active");
				$("#continen-tab").removeClass("inactice");
			});

			$("#continen-tab").click(function() {
				$("#mTableContainer").hide();
				$("#mPercentContainer").hide();
				$("#mContinentContainer").show();

				$("#table-tab").addClass("active");
				$("#percent-tab").addClass("active");
				$("#continen-tab").addClass("inactice");


				$("#table-tab").removeClass("inactice");
				$("#percent-tab").removeClass("inactice");
				$("#continen-tab").removeClass("active");
			});

			//When sorting of mCases has been clicked.
			$("#mCases").click(function() {
				//When clicked control if the totalCases true or false.
				if (totalCases) {
					// If the totalCases is true.
					sorting = "ASC"
					totalCases = false;
					//Change type 1 to 0 .
					type = 0;
					// readData() for compliting the sort opeartion for users.
					readData();
				} else {
					
					//Oppposite instructions of the if statement.
					sorting = "DESC"
					totalCases = true;				
					type = 0;
					readData();
				}
			});
			

			//Same instructions is valid for all the sorting by click operations.
			$("#mDeaths").click(function() {
				if (totalCases) {
					sorting = "ASC"
					totalCases = false;
					type = 1;
					readData();
				} else {
					sorting = "DESC"
					totalCases = true;
					type = 1;
					readData();
				}
			});

			$("#mRecovered").click(function() {
				if (totalCases) {
					sorting = "ASC"
					totalCases = false;
					type = 2;
					readData();
				} else {
					sorting = "DESC"
					totalCases = true;
					type = 2;
					readData();
				}
			});

			$("#mActive").click(function() {
				if (totalCases) {
					sorting = "ASC"
					totalCases = false;
					type = 3;
					readData();
				} else {
					sorting = "DESC"
					totalCases = true;
					type = 3;
					readData();
				}
			});

			$("#mCritical").click(function() {
				if (totalCases) {
					sorting = "ASC"
					totalCases = false;
					type = 4;
					readData();
				} else {
					sorting = "DESC"
					totalCases = true;
					type = 4;
					readData();
				}
			});

			$("#mCasesPer").click(function() {
				if (totalCases) {
					sorting = "ASC"
					totalCases = false;
					type = 5;
					readData();
				} else {
					sorting = "DESC"
					totalCases = true;
					type = 5;
					readData();
				}
			});

			$("#mDeathsPer").click(function() {
				if (totalCases) {
					sorting = "ASC"
					totalCases = false;
					type = 6;
					readData();
				} else {
					sorting = "DESC"
					totalCases = true;
					type = 6;
					readData();
				}
			});

			$("#mTests").click(function() {
				if (totalCases) {
					sorting = "ASC"
					totalCases = false;
					type = 7;
					readData();
				} else {
					sorting = "DESC"
					totalCases = true;
					type = 7;
					readData();
				}
			});

			$("#mTestsPop").click(function() {
				if (totalCases) {
					sorting = "ASC"
					totalCases = false;
					type = 8;
					readData();
				} else {
					sorting = "DESC"
					totalCases = true;
					type = 8;
					readData();
				}
			});

			$("#mPopulation").click(function() {
				if (totalCases) {
					sorting = "ASC"
					totalCases = false;
					type = 9;
					readData();
				} else {
					sorting = "DESC"
					totalCases = true;
					type = 9;
					readData();
				}
			});

			//On world record check the search box for any country is written or not.
			$('#mPercentages').on('input', function(e) {
				var txt = $('#mPercentages').val();
				if (txt != "") {
					// If it has some char.
					$.post("percentages.php", {
						queryValues: "SELECT cp.country, caseByPop, testByPop, caseByTest, deadByPop, deadByCase, recoverByPop, recoverbyCase, flag FROM casesPercentage AS cp JOIN testsPercentage AS tp ON cp.country = tp.country JOIN deathsPercentage AS dp ON tp.country = dp.country JOIN recoveredPercentage AS rp ON dp.country = rp.country JOIN generaltable AS gt ON rp.country = gt.country WHERE `cp`.`country` LIKE\'" + txt + "%\' ORDER BY `cp`.`country` ASC"
					}, function(sendData) {
						$('#percentDiv').html(sendData);
					});
				} else {
					// If it's empty.
					$.post("percentages.php", {
						queryValues: "SELECT cp.country, caseByPop, testByPop, caseByTest, deadByPop, deadByCase, recoverByPop, recoverbyCase,  flag FROM casesPercentage AS cp JOIN testsPercentage AS tp ON cp.country = tp.country JOIN deathsPercentage AS dp ON tp.country = dp.country JOIN recoveredPercentage AS rp ON dp.country = rp.country JOIN generaltable AS gt ON rp.country = gt.country ORDER BY `cp`.`country` ASC"
					}, function(sendData) {
						$('#percentDiv').html(sendData);
					});
				}
			});

			//For same operation of searchbox as World Record for PERCENTAGES.
			$('#mSumbit').on('input', function(e) {
				var txt = $('#mSumbit').val();
				if (txt != "") {
					$.post("table.php", {
						queryValues: "SELECT * FROM generaltable WHERE country LIKE \'" + txt + "%\' Order By country " + sorting
					}, function(gonderVeri) {
						$('#tableDiv').html(gonderVeri);
					});
				} else {
					$.post("table.php", {
						queryValues: "SELECT * FROM generaltable Order By cases " + sorting
					}, function(gonderVeri) {
						$('#tableDiv').html(gonderVeri);
					});
				}
			});

			//When read data is called it goes to a switch for it's type.
			function readData() {
				var queryValues = "SELECT * FROM generaltable Order By cases " + sorting;
				switch (type) {
					case 0:
						queryValues = "SELECT * FROM generaltable Order By cases " + sorting;
						break;
					case 1:
						queryValues = "SELECT * FROM generaltable Order By deaths " + sorting;
						break;
					case 2:
						queryValues = "SELECT * FROM generaltable Order By recovered " + sorting;
						break;
					case 3:
						queryValues = "SELECT * FROM generaltable Order By active " + sorting;
						break;
					case 4:
						queryValues = "SELECT * FROM generaltable Order By critical " + sorting;
						break;
					case 5:
						queryValues = "SELECT * FROM generaltable Order By casesPerOneMillion " + sorting;
						break;
					case 6:
						queryValues = "SELECT * FROM generaltable Order By deathsPerOneMillion " + sorting;
						break;
					case 7:
						queryValues = "SELECT * FROM generaltable Order By tests " + sorting;
						break;
					case 8:
						queryValues = "SELECT * FROM generaltable Order By testsPerOneMillion " + sorting;
						break;
					case 9:
						queryValues = "SELECT * FROM generaltable Order By population " + sorting;
						break;
					default:
				}
				//Sending the queryValues to the table.php and showing them in the tableDiv.
				$.post("table.php", {
					queryValues: queryValues
				}, function(gonderVeri) {
					$('#tableDiv').html(gonderVeri);
				});
			}
		});
	</script>
</body>

</html>
