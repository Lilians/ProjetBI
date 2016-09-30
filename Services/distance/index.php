<DOCTYPE html>
<html>
	<body>
<?php

if(isset($_GET["latitude1"]) && isset($_GET["longitude1"]) && isset($_GET["latitude2"]) && isset($_GET["longitude2"]))
{
	$latFrom = deg2rad($_GET["latitude1"]);
	$lonFrom = deg2rad($_GET["longitude1"]);
	$latTo = deg2rad($_GET["latitude2"]);
	$lonTo = deg2rad($_GET["longitude2"]);

	$latDelta = $latTo - $latFrom;
	$lonDelta = $lonTo - $lonFrom;

	$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
	cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	$resultArr ["distance"] = $angle * 6371000;
	print(json_encode($resultArr));
}
else
{
	die("Error");
}

?>
	</body>
</html>