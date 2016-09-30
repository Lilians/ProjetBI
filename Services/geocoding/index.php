<DOCTYPE html>
<html>
	<body>
<?php

if(isset($_GET["latitude"]) && isset($_GET["longitude"]))
{
	$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$_GET["latitude"].",".$_GET["longitude"]."&sensor=true";
    $data = @file_get_contents($url);
	echo "<script>console.log(".$data.");</script>";
    $jsondata = json_decode($data,true);
	if(count($jsondata["results"])<1)
	{
		die("Error");
	}
	
	$addComponents = [];
    
	for($i=0; $i<count($jsondata["results"][0]["address_components"]); $i++)
	{
		//print($i." : ".$jsondata["results"][0]["address_components"][$i]["long_name"]."<br/>");
		$addComponents[$jsondata["results"][0]["address_components"][$i]["types"][0]] = $jsondata["results"][0]["address_components"][$i]["long_name"];
	}
	
	$resultArr = [];
	$resultArr["fulladdress"] = $jsondata["results"][0]["formatted_address"];
	$resultArr["components"] = $addComponents;
	
	print(json_encode($resultArr));
	
	
	
}
else
{
	die("Error");
}

?>
	</body>
</html>