<?php
/**
 * Get basic data from JSON.
 */
date_default_timezone_set('Europe/Warsaw');

require_once './inc/Ticks.php';
$ticks = new cTicks();

//
// Settings
//
$basePath = "../processor-io";
$baseInputPath = "{$basePath}/000-009";
$outputPath = "data_basics.sql";

// progress info
$infoStep = 1000;

//
// Parse/Dump
//
$totalRecords = 0;
$stepsCount = 1;
$ticks->pf_insTick('parse');
$ticks->pf_insTick('parse-step-'.$stepsCount);
foreach (glob("{$baseInputPath}/**/*") as $filename) {
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
		$ticks->pf_endTick('parse-step-'.$stepsCount);
		$stepsCount++;
		$ticks->pf_insTick('parse-step-'.$stepsCount);
		//break; // quick test
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
$ticks->pf_endTick('parse-step-'.$stepsCount);
$ticks->pf_endTick('parse');

//
// Info/summary
//
echo "\n";
echo "\n[INFO] Total: $totalRecords.";

$arrTicks = $ticks->pf_getDurations();
echo "\n[INFO] Timers [s]:";
foreach ($arrTicks as $strTickName=>$intDurtation) {
	echo sprintf("\n%s: %.4f", $strTickName, $intDurtation);
}
