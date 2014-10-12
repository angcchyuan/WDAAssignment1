<html>
<head>
<title>Hi Welcome to WINESTORE </title>
</head>

<body>

<?php
$connection = @mysqli_connect("localhost", "root", "", "winestore");
if(mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
?>

<h1>Hi Welcome to WINESTORE</h1>
<form method="get" action="c.php">
Search Wine Name:<div> <input type="text" name="wineName" id="wineName"><br><br></div>

Search Region:<div> <?php
					$result = mysqli_query($connection, "SELECT * FROM region");
					echo "<select name='region' value=''>Dropdown</option>";
					while ($row = mysqli_fetch_array($result))
						echo "<option value = ".$row['region_name'].">".$row['region_name']."</option>";
					echo"</select>";
				?>
<br><br></div>

Search Winery Name: <div><input type="text" name="wineryName" id="wineryName"><br><br></div>

Search Range of Years: <div>Starting <input type="text" name="sYear" id="sYear"></div>
				<div>Ending &nbsp<input type="text" name="eYear" id="eYear"><br><br></div>

Search Minimum number of Customer who have purchase each Wine: <div><input type = "text" name="cusNum" id="cusNum"><br><br></div>

Search Minimum Number of Wines in Stock per Wine: <div><input type="text" name="stockNum" id="stockNum"><br><br></div>

Search Dollar cost range: <div>MAX($): <input type="text" name="maxDollar" id="maxDollar"></div> 
							<div>MIN($): <input type="text" name="minDollar" id="minDollar"><br><br></div>

<input type="submit" value="Search" name="submit">

</form>

</body>

</html>
