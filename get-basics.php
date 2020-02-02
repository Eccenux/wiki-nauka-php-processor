<?php
date_default_timezone_set('Europe/Warsaw');

require_once './inc/Ticks.php';
$ticks = new cTicks();

$basePath = "../processor-io";

$basePath .= "/000-009";

$totalRecords = 0;
$infoStep = 1000;
$stepsCount = 1;
$ticks->pf_insTick('parse');
$ticks->pf_insTick('parse-step-'.$stepsCount);
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

echo "\n";
echo "\n[INFO] Total: $totalRecords.";

$arrTicks = $ticks->pf_getDurations();
echo "\n[INFO] Timers [s]:";
foreach ($arrTicks as $strTickName=>$intDurtation) {
	echo sprintf("\n%s: %.4f", $strTickName, $intDurtation);
}
