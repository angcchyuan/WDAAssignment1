<?php

	set_include_path('C:/wamp1/bin/php/php5.5.12/pear');
	require_once "HTML/Template/IT.php";
	require_once"DB.php";

	
	$template = new HTML_Template_IT();
	$template->loadTemplatefile("test_template.tpl",true,true);
	$message = "<h> NO Records is match your search!!</h>";
	$message2 = "Your minimum price($) is bigger than your maximum price($) " ;
	$message3 = "Your Starting year is bigger than your Eding Year ";

 function showerror()
   {
      die("Error " . mysql_errno() . " : " . mysql_error());
   }
 if (!($connection = @ mysql_connect("localhost","root","")))
      die("Could not connect");
 if (!mysql_select_db("winestore", $connection))
      showerror();

	
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
		$eYear = 8888;
		
	if($cusNum == "")
		$cusNum = 0;
		
	if($stockNum == "")
		$stockNum = 0;
	
	if($maxDollar == "")
		$maxDollar = 1000;
		
	if($minDollar == "")
		$minDollar = 0;
		
	if((is_numeric($sYear))&&(is_numeric($eYear))&&
		(is_numeric($cusNum))&&(is_numeric($stockNum))&&(
		is_numeric($minDollar))&&(is_numeric($maxDollar)))
	
	{
		if (!($sYear > $eYear))
		{
			if(!($minDollar > $maxDollar ))
				{
		
					$test = ("SELECT wine.wine_id,wine.wine_name,wine.year,
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
										AND winery_name LIKE '%".$wineryName."%'
										AND region.region_name LIKE '%".$region."%'
										AND inventory.on_hand >= '".$stockNum."'
										AND wine.year >='".$sYear."'
										AND wine.year <='".$eYear."'
										AND inventory.cost >= '".$minDollar."'
										AND inventory.cost <= '".$maxDollar."'
										
										GROUP BY wine.wine_id
										
										HAVING COUNT(wine.wine_id) >= '".$cusNum."'
										"
									);
									
		
		

		
			
			if(!($result = mysql_query( $test, $connection)))
	showerror();
			
			//Template
			$template->setCurrentBlock("fieldName");
			$template->setVariable("No.", "No.");
			$template->setVariable("WineName", "WineName");
			$template->setVariable("Year", "Year");
			$template->setVariable("Winery", "Winery");
			$template->setVariable("Region", "Region");
			$template->setVariable("WineVariety", "WineVariety");
			$template->setVariable("Costing", "Costing");
			$template->setVariable("numOfStocks", "No. of Stocks");
			$template->setVariable("numOfPurchased", "No. of Customer Purchased");
			$template->parseCurrentBlock();
			
	$count = 0;
			//$query = mysqli_query($connection, $test);
			
			while($row = mysql_fetch_assoc($result))
			{
			$count++;
				// use template
						$template->setCurrentBlock("query");
						$template->setVariable("No.", $row['wine_id']);
						$template->setVariable("WineName", $row['wine_name']);
						$template->setVariable("Year", $row['year']);
						$template->setVariable("Winery", $row['winery_name']);
						$template->setVariable("Region", $row['region_name']);
						$template->setVariable("WineVariety", $row['variety']);
						$template->setVariable("Costing", $row['cost']);
						$template->setVariable("numOfStocks", $row['on_hand']);
						$template->setVariable("numOfPurchased", $row['numOfCustomer']);
						$template->parseCurrentBlock();
			
				
			}
			
		 }	
		 
		else 
		{	
			$template->setCurrentBlock("NoResult");
			$template->setVariable("message",$message2);
			$template->parseCurrentBlock();
			
			
		}
	}	
		 
		else 
		{
			$template->setCurrentBlock("NoResult");
			$template->setVariable("message",$message3);
			$template->parseCurrentBlock();
			
			
			
		}
	}
	
	else
	{
		$template->setCurrentBlock("NoResult");
			$template->setVariable("message",$message);
			$template->parseCurrentBlock();
			
			
		
		
	}	
	
	$template->show();


?>
	

	