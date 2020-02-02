<?php
/**
 * Time-ticks measurement (performance checkpoints).
 *
 * Example measurement:
 * $ticks = new cTicks();
 * $ticks->pf_insTick('TheThing');
 * // ...do the thing...
 * $ticks->pf_endTick('TheThing');
 *
 * Loop measurement (nesting):
 * $ticks = new cTicks();
 * $ticks->pf_insTick('TheThing');
 * for ($step = 1; $step < 3; $step++) {
 *	$ticks->pf_insTick('TheThing-step-'.$step);
 *  sleep(1);
 *  $ticks->pf_endTick('TheThing-step-'.$step);
 * }
 * $ticks->pf_endTick('TheThing');
 *
 * Note! You have to make sure the names are uniqe. Otherwise the results are undefined.
 *
 * Example dump:
	$arrTicks = $ticks->pf_getDurations();
	echo "\nTicks [s]:";
	foreach ($arrTicks as $strTickName=>$intDurtation) {
		echo sprintf("\n%s: %.4f", $strTickName, $intDurtation);
	}

Ticks [s]:
parse: 3.3371
parse-step-1: 1.2255
parse-step-2: 0.8945
parse-step-3: 0.9094
parse-step-4: 0.3076
total: 3.3372

 */
class cTicks
{
	private $dtStart;	//!< Start time set upon creation of this class
	private $dtEnd;		//!< End time set upon calling pf_getDurations
	private $arrTicks;	//!< Ticks array

	public function __construct()
	{
		$this->dtStart = $this->pf_getTickStamp();
	}

	/**
	 * Function gets tick stamp (microtime).
	 *
	 * @return float Time in seconds since Unix epoch with microseconds after coma.
	 */
	private function pf_getTickStamp()
	{
		$mtime = microtime();	// e.g. 0.65504100 1361641864
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		return $mtime;
	}

	/**
	 * Insert a named tick
	 *
	 * @warning Always call insert and end tick in pairs!
	 */
	public function pf_insTick($strTickName, $endPrevious = false)
	{
		if ($endPrevious && !empty($this->startedTickName)) {
			$this->pf_endTick($this->startedTickName);
		}
		$this->arrTicks[$strTickName] = $this->pf_getTickStamp();
		$this->startedTickName = $strTickName;
	}
	
	/** End a named tick (calculate duration) */
	public function pf_endTick($strTickName)
	{
		if (isset($this->arrTicks[$strTickName]))
		{
			$this->arrTicks[$strTickName] = $this->pf_getTickStamp() - $this->arrTicks[$strTickName];
		}
	}

	/**
	 * Get durations array.
	 * 
	 * @param boolean $boolAddTotal
	 * @return array
	 */
	public function pf_getDurations($boolAddTotal=true)
	{
		$this->dtEnd = $this->pf_getTickStamp();
		$this->arrTicks['total'] = $this->dtEnd - $this->dtStart;
		return $this->arrTicks;
	}
}

?>