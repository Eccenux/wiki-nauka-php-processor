<?php
require_once './inc/Ticks.php';

class Parser
{
	private $ticks;
	private $infoStep = 1000;	//!< Progress info
	private $totalRecords = 0;	//!< Records read

	/**
	 * Init.
	 * @param integer $infoStep Progress info step.
	 */
	public function __construct($infoStep = null)
	{
		$this->ticks = new cTicks();
		if (!empty($infoStep)) {
			$this->infoStep = $infoStep;
		}
	}

	/**
	 * Parser loop.
	 *
	 * Assumes all files are JSON files.
	 * 
	 * @param string $baseInputPath Base path (subdirectories will be searched for files).
	 * @param callback $recordCallback
	 *	Callback for getting data (gets json object as 1st param).
	 *	Return false to break the loop.
	 */
	public function parse($baseInputPath, $recordCallback = null) {
		//
		// Parse/Dump
		//
		$this->totalRecords = 0;
		$stepsCount = 1;
		$this->ticks->pf_insTick('parse');
		$this->ticks->pf_insTick('parse-step-'.$stepsCount);
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

			$this->totalRecords++;
			if ($this->totalRecords % $this->infoStep === 0) {
				echo "\n[INFO] Records read: $this->totalRecords.";
				$this->ticks->pf_endTick('parse-step-'.$stepsCount);
				$stepsCount++;
				$this->ticks->pf_insTick('parse-step-'.$stepsCount);
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

			if (is_callable($recordCallback)) {
				$result = $recordCallback($json);
				if ($result === false) {
					break;
				}
			}
		}
		$this->ticks->pf_endTick('parse-step-'.$stepsCount);
		$this->ticks->pf_endTick('parse');
	}

	/**
	 * Just dump some parser summary.
	 */
	public function dumpInfo() {
		echo "\n";
		echo "\n[INFO] Total: $this->totalRecords.";

		$arrTicks = $this->ticks->pf_getDurations();
		echo "\n[INFO] Timers [s]:";
		foreach ($arrTicks as $strTickName=>$intDurtation) {
			echo sprintf("\n%s: %.4f", $strTickName, $intDurtation);
		}
	}

	/**
	 * Get 1st finished studies.
	 * 
	 * @param object $json
	 * @return object|null
	 */
	public function getPierwszeStudia($json)
	{
		$pierwszeStudia = null;
		foreach ($json->ukonczoneStudia as $studia) {
			if ($pierwszeStudia == null) {
				$pierwszeStudia = $studia;
				continue;
			}
			if ($pierwszeStudia->rokUkonczenia > $studia->rokUkonczenia) {
				$pierwszeStudia = $studia;
			}
		}
		return $pierwszeStudia;
	}

}