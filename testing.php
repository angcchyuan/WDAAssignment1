<?php
$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "winestore";

$con = mysqli_connect ( "$db_host" , "$db_username" , "$db_pass", "$db_name") or die ("Could not connect to Mysql");

if(mysqli_connect_errno())
	echo "Failed to connect to MySQL :".mysqli_connect_error();
	
	
	$wineName = $_GET["wineName"];
	$region = $_GET["region"];
	$wineryName = $_GET["wineryName"];
	$startY = $_GET["startY"];
	$endY = $_GET["endY"];
	$stockNum = $_GET["stockNum"];
	$purchaserNum = $_GET["purchaserNum"];
	$maxCost = $_GET["maxCost"];
	$minCost = $_GET["minCost"];
	
	if($region == "All")
		$checkRegion = 1;

	if( $startY == "" )
		$startY = 0;
	if( $endY == "" )
		$endY = 3000;
	if( $stockNum == "")
		$stockNum = 0;
	if( $maxCost == "" )
		$maxCost = 1000;
	if( $minCost == "" )
		$minCost = 0;
	if( $purchaserNum == "" )
		$purchaserNum = 0;	
		
	if( (is_numeric($stockNum))&&(is_numeric($startY))&&
		(is_numeric($endY))&&(is_numeric($purchaserNum)))
	{
		if($checkRegion  == 1)
		{
		$result = mysqli_query($con,"SELECT wine.wine_id,wine.wine_name,wine.year,
											winery.winery_name, region.region_name, 
											wine_variety.variety_id, grape_variety.variety,
											inventory.cost, inventory.on_hand,
											COUNT(wine.wine_id) AS numOfCustomer
									FROM wine 
									
									INNER JOIN winery
									ON wine.winery_id = winery.winery_id
									
									INNER JOIN region
									ON winery.region_id = region.region_id
									
									INNER JOIN wine_variety
									ON wine.wine_id = wine_variety.wine_id
									
									INNER JOIN grape_variety
									ON wine_variety.variety_id = grape_variety.variety_id
									
									INNER JOIN inventory
									ON wine.wine_id = inventory.wine_id
									
									INNER JOIN items
									ON items.wine_id = wine.wine_id

									INNER JOIN customer
									ON customer.cust_id = items.cust_id
									
									
									WHERE wine_name LIKE '%".$wineName."%'
									AND	winery_name LIKE '%".$wineryName."%'
									AND wine.year >= '".$startY."'
									AND wine.year <= '".$endY."'
									AND inventory.on_hand >= '".$stockNum."'
									AND inventory.cost  >= '".$minCost."'
									AND inventory.cost  <= '".$maxCost."'
									
									GROUP BY wine.wine_id
									
									HAVING COUNT(wine.wine_id) >= '".$purchaserNum."'
									"
								);
		}
		else
		{	
		$result = mysqli_query($con,"SELECT wine.wine_id,wine.wine_name,wine.year,
											winery.winery_name, region.region_name, 
											wine_variety.variety_id, grape_variety.variety,
											inventory.cost, inventory.on_hand,
											COUNT(wine.wine_id) AS numOfCustomer
									FROM wine 
									
									INNER JOIN winery
									ON wine.winery_id = winery.winery_id
									
									INNER JOIN region
									ON winery.region_id = region.region_id
									
									INNER JOIN wine_variety
									ON wine.wine_id = wine_variety.wine_id
									
									INNER JOIN grape_variety
									ON wine_variety.variety_id = grape_variety.variety_id
									
									INNER JOIN inventory
									ON wine.wine_id = inventory.wine_id
									
									INNER JOIN items
									ON items.wine_id = wine.wine_id

									INNER JOIN customer
									ON customer.cust_id = items.cust_id
									
									
									WHERE wine_name LIKE '%".$wineName."%'
									AND	winery_name LIKE '%".$wineryName."%'
									AND region.region_name LIKE '%".$region."%'
									AND wine.year >= '".$startY."'
									AND wine.year <= '".$endY."'
									AND inventory.on_hand >= '".$stockNum."'
									AND inventory.cost  >= '".$minCost."'
									AND inventory.cost  <= '".$maxCost."'
									
									GROUP BY wine.wine_id
									
									HAVING COUNT(wine.wine_id) >= '".$purchaserNum."'
									"
								);
		}
		if(mysqli_num_rows($result) == null)
		{
			echo "<h1>No records match your search criteria</h1>";
			echo "<h1><a href='http://localhost/assignment1/search.php'>Click here to back the search engine</a></h1>";
		}
		else
		{
			echo"<html><head></head>";
			echo "<h1><a href='http://localhost/assignment1/search.php'>Click here to back the search engine</a></h1>";
			echo"<body><h1>Wine table</h1><table border='1'>";
			echo"<tr>
					<th>No.</th>
					<th>Wine Name</th>
					<th>Year</th>
					<th>Winery</th>
					<th>Region</th>
					<th>Wine Varieties</th>
					<th>Cost($)</th>
					<th>Stock</th>
					<th>Number Of Customer Who purchase the wine</th>
				</tr>";
			
			
			
			while($row = mysqli_fetch_array($result))
			{
				echo"<tr>	<td>".$row['wine_id']."</td>
							<td>".$row['wine_name']."</td>
							<td>".$row['year']."</td>
							<td>".$row['winery_name']."</td>
							<td>".$row['region_name']."</td>
							<td>".$row['variety']."</td>
							<td>".$row['cost']."</td>
							<td>".$row['on_hand']."</td>
							<td>".$row['numOfCustomer']."</td>
					</tr>";
			}
			echo "</table>";
		}
	}
	else
	{
		echo "<h1>No records match your search criteria</h1>";
		echo "<h1><a href='http://localhost/assignment1/search.php'>Click here to back the search engine</a></h1>";
	}
	echo "</body></html>";
	

?>