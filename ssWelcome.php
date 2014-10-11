<?php

//mysqli_close($connection);
	$connection = mysqli_connect("localhost", "root", "", "winestore");
	
	$wineName = $_GET["wineName"];
	$region = $_GET["region"];
	$wineryName = $_GET["wineryName"];
	$sYear = $_GET["sYear"];
	$eYear = $_GET["eYear"];
	$cusNum = $_GET["cusNum"];
	$stockNum = $_GET["stockNum"];
	$maxDollar	= $_GET["maxDollar"];
	$minDollar = $_GET["minDollar"];
	
	if($region == "ALL")
		$region = 1;
		
	if($sYear == "")
		$sYear = 0;
		
	if($eYear == "")
		$eYear = 3000;
		
	if($cusNum == "")
		$cusNum = 0;
		
	if($stockNum == "")
		$stockNum = 0;
	
	if($maxDollar == "")
		$maxDollar = 1000;
		
	if($minDollar == "")
		$minDollar = 0;
		
	if((is_numeric($sYear))&&(is_numeric($eYear))&&(is_numeric($cusNum))&&(is_numeric($stockNum)))
	
	{
		// if($region == 1)
		// {
			$test = ("SELECT wine.wine_id,wine.wine_name,wine.year,winery.winery_name,
												region.region_name, wine_variety.variety_id,
												grape_variety.variety, inventory.cost, inventory.on_hand,
												COUNT(wine.wine_id) AS numOfCustomer
										FROM wine
										
										INNER JOIN winery
										ON wine.wine_id = winery.winery_id
										
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
										AND winery_name LIKE '%".$wineryName."%'
										AND inventory.on_hand >= '".$stockNum."'
										AND inventory.cost >= '".$minDollar."'
										AND inventory.cost <= '".$maxDollar."'
										
										GROUP BY wine.wine_id
										
										HAVING COUNT(wine.wine_id) >= '".$cusNum."'
										"
									);
									
		// }
		

		$query = mysqli_query($connection, $test)
		or die("Error: ".mysqli_error($connection));
		// if(mysqli_connect_errno())
		// {
			// echo "Failed to connect to MySQL: ".mysqli_connect_error();
		// }
		
		
		// else
		// {
			// $result = mysqli_query($connection,"SELECT wine.wine_id,wine.wine_name,wine.year,winery.winery_name,
												// region.region_name, wine_variety.variety_id,
												// grape_variety.variety, inventory.cost, inventory.on_hand,
												// COUNT(wine.wine_id) AS numOfCustomer
										// FROM wine
										
										// INNER JOIN winery
										// ON wine.wine_id = winery.winery_id
										
										// INNER JOIN region
										// ON winery.region_id = region.region_id
										
										// INNER JOIN wine_variety
										// ON wine.wine_id = wine_variety.wine_id
										
										// INNER JOIN grape_variety
										// ON wine_variety.variety_id = grape_variety.variety_id
										
										// INNER JOIN inventory
										// ON wine.wine_id = inventory.wine_id
										
										// INNER JOIN items
										// ON items.wine_id = wine.wine_id
										
										// INNER JOIN customer
										// ON customer.cust_id = items.cust_id
										
										// WHERE wine_name LIKE '%".$wineName."%'
										// AND winery_name LIKE '%".$wineryName."%'
										// AND wine_year >= '".$sYear."'
										// AND wine_year <= '".$eYear."'
										// AND inventory.on_hand >= '".$stockNum."'
										// AND inventory.cost >= '".$minDollar."'
										// AND inventory.cost <= '".$maxDollar."'
										
										// GROUP BY wine.wine_id
										
										// HAVING COUNT(wine.wine_id) >= '".$cusNum."'
										// "
									// );
		// }
										
		// if(mysqli_num_rows($result) == 0)
		// {
			// echo "<h> NO Records is match your search!!</h>";
			// echo "<h><a href='http://localhost:12345/ASS1/Welcome.php'>Please Click HERE!!</a></h>";
		// }
		// else
		// {
			echo "<h> RESULT in Table </h><table border='1'>";
			echo "<tr>
					<th>No.</th>
					<th>WineName</th>
					<th>Year</th>
					<th>Winery</th>
					<th>Region</th>
					<th>WineVariety</th>
					<th>Costing</th>
					<th>No. of Stocks</th>
					<th>No. of Customer Purchased</th>
				</tr>";
				
			while($row = mysqli_fetch_array($query))
			{
				echo "<tr>
						<td>".$row['wine_id']."</td>
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
		// }	
	}
	
	else
	{
		echo "<h> NO Records is match your search!!</h>";
		echo "<h><a href='http://localhost:12345/ASS1/Welcome.php'>Please Click HERE!!</a></h>";
	}	
	

	
?>