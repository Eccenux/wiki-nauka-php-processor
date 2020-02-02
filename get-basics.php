<?php
/**
 * Get basic data from JSON.
 */
date_default_timezone_set('Europe/Warsaw');

require_once './inc/Parser.php';
require_once './inc/SqlGenerator.php';
//require_once './inc/Ticks.php';
//$ticks = new cTicks();

//
// Settings
//
$basePath = "../processor-io";
$baseInputPath = "{$basePath}/000-009";
$outputPath = "data_basics.sql";

// progress info
$infoStep = 1000;

//
// Prepare header
//
$arrays = array(
	"zatrudnienie",
	"pelnioneFunkcje",
	"czlonkostwo",
	"ukonczoneStudia",
	"profesury",
	"praceBadawcze",
	"stopnieNaukowe",
	"publikacje",
);
$sqlHeader = "\n\nINSERT INTO naukowiec ("
		. "np_id"
		. "\n, pierwszeStudiaRokUkonczenia"
		. "\n, imie1, imie2, nazwisko"
		. "\n, glownyStopienNaukowy, pelenTytul"
		. "\n, specjalnosci, klasyfikacjaKbn"
		. "\n"
;
foreach ($arrays as $key) {
	$sqlHeader .= ", {$key}Count";
}
$sqlHeader .= "\n) VALUES";


//
// Parse/Dump
//
$sqlGenerator = new SqlGenerator($sqlHeader, $outputPath);
$sqlGenerator->clearFile();
$numAdded = 0;
$parser = new Parser();
$parser->parse($baseInputPath, function($json) {
	//var_export($json);
	global $sqlGenerator, $numAdded, $parser, $arrays;

	$countUkonczoneStudia = 0;
	$pierwszeStudiaRok = '';
	if (!empty($json->ukonczoneStudia) && is_array($json->ukonczoneStudia)) {
		$countUkonczoneStudia = count($json->ukonczoneStudia);
		$pierwszeStudia = $parser->getPierwszeStudia($json);
		if (is_object($pierwszeStudia)) {
			$pierwszeStudiaRok = $pierwszeStudia->rokUkonczenia;
		}
	}

	$sql = "("
			. "{$json->id}"
			. ", {$countUkonczoneStudia}, '{$pierwszeStudiaRok}'"
			. ", '{$json->imie1}', '{$json->imie2}', '{$json->nazwisko}'"
			. ", '{$json->glownyStopienNaukowy}', '{$json->pelenTytul}'"
			. ", '{$json->specjalnoscP}', '{$json->klasyfikacjaKbnP}'"
	;
	foreach ($arrays as $key) {
		if (!empty($json->$key) && is_array($json->$key)) {
			$sql .= ", ".count($json->$key);
		} else {
			$sql .= ", 0";
		}
	}
	$sql .= ")";

	$sqlGenerator->appendRow($sql);
	$numAdded++;
	if ($numAdded > 10) {
		//return FALSE;
	}
});
$sqlGenerator->dumpPortion();

//
// Info/summary
//
$parser->dumpInfo();
