<?php

$basePath = "../processor-io";

$basePath .= "/000-009";

$totalRecords = 0;
$infoStep = 1000;
foreach (glob("{$basePath}/**/*") as $filename) {
	//echo "$filename size " . filesize($filename) . "\n";
	$json = json_decode (file_get_contents($filename));

	// id
	if (empty($json->id)) {
		echo "\n[ERROR] Id jest puste!";
		var_export($json);
		echo "\n";
		continue;
	}

	$totalRecords++;
	if ($totalRecords % $infoStep === 0) {
		echo "\n[INFO] Records read: $totalRecords.";
	}
	
	// adres
	if (!empty($json->adres)) {
		echo "\n[WARNING] ({$json->id}) Niepusty adres!";
		var_export($json);
		die();
	} else {
		//echo "\n[INFO] ({$json->id}) Pusty adres.";
	}
}

echo "\n";
echo "\n[INFO] Total: $totalRecords.";
