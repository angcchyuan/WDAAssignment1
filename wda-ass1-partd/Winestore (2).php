<html>
<head>
<title>Hi Welcome to WINESTORE </title>
</head>

<body>


<h1>Hi Welcome to WINESTORE</h1>
<form method="get" action="dd.php">
Search Wine Name:<div> <input type="text" name="wineName" id="wineName"><br><br></div>

Search Region:<div> <?php

set_include_path('C:/wamp1/bin/php/php5.5.12/pear');
	require_once "DB.php";
	$username="root";
	$password="";
	$hostname="localhost";
	$dbname="winestore";
	$dsn="mysql://{$username}:{$password}@{$hostname}/{$dbname}";
	
	//when no database found
	$connection = new DB();
	$connection= @DB::connect($dsn);
	if (@DB::isError($connection)) {
    die("Unable to connect to database: " . $connection->getMessage() . "\n"
                                          . $connection->getDebugInfo() . "\n");
}


	
					
					$result = @$connection->query("SELECT * FROM region");
					echo "<select name='region' value=''>Dropdown</option>";
					while ($row = $result->fetchRow())
						echo "<option value = ".$row[1].">".$row[1]."</option>";
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
