<?php
/**
 * Get basic data from JSON.
 */
date_default_timezone_set('Europe/Warsaw');

require_once './inc/Ticks.php';
require_once './inc/Parser.php';
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
$parser = new Parser();
$parser->parse($baseInputPath);

//
// Info/summary
//
$parser->dumpInfo();
