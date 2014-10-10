<html>
<head>
<title>Hi Welcome to WINESTORE </title>
</head>

<body>

<?php
include 'connect.php';
?>

<h1>Hi Welcome to WINESTORE</h1>
<form method="get" action="ssWelcome.php">
Search Wine Name: <input type="text" name="wineName" id="wineName"><br><br>

Search Region: <?php
					$result = mysqli_query($connection, "SELECT * FROM region");
					echo "<select name='region' value=''>Dropdown</option.";
					while ($row = mysqli_fetch_array($result))
						echo "<option value = ".$row['region_name'].">".$row['region_name']."</option>";
					echo"</select>";
				?>
<br><br>

Search Winery Name: <input type="text" name="wineryName" id="wineryName"><br><br>

Search Range of Years: Starting <input type="text" name="sYear" id="sYear">
				Ending <input type="text" name="eYear" id="eYear"><br><br>

Search Minimum number of Customer who have purchase each Wine: <input type = "text" name="cusNum" id="cusNum"><br><br>

Search Minimum Number of Wines in Stock per Wine: <input type="text" name="stockNum" id="stockNum"><br><br>

Search Dollar cost range: MAX($): <input type="text" name="maxDollar" id="maxDollar"> 
							MIN($): <input type="text" name="minDollar" id="minDollar"><br><br>

<input type="submit" value="Search" name="submit">

</form>
</body>

</html>