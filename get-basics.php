<?php
/**
 * Get basic data from JSON.
 */
date_default_timezone_set('Europe/Warsaw');

require_once './inc/Parser.php';
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
// Parse/Dump
//
$sql_head = "INSERT INTO naukowiec ("
		. "np_id"
		. ", imie1, imie2, nazwisko"
		. ", glownyStopienNaukowy, pelenTytul"
		. ", specjalnosci, klasyfikacjaKbn"
	. ") VALUES"
;
$sql = $sql_head;
$numAdded = 0;
$parser = new Parser();
$parser->parse($baseInputPath, function($json) {
	//var_export($json);
	global $sql, $numAdded;
	$sql .= "\n("
			. "{$json->id}"
			. ", '{$json->imie1}', '{$json->imie2}', '{$json->nazwisko}'"
			. ", '{$json->glownyStopienNaukowy}', '{$json->pelenTytul}'"
			. ", '{$json->specjalnoscP}', '{$json->klasyfikacjaKbnP}'"
		. "),"
	;
	$numAdded++;
	if ($numAdded > 10) {
		return FALSE;
	}
});
echo $sql;

//
// Info/summary
//
$parser->dumpInfo();
