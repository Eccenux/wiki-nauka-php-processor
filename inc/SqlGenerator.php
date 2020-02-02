<?php
/**
 * Description of SqlGenerator
 *
 * Usage:
 * $sqlGenerator = new SqlGenerator($sqlHeader, $outputPath);
 * $sqlGenerator->clearFile();		// this will init (clear) outputPath
 * for (...) {
 *	$sqlGenerator->appendRow($sql);	// this will regulary dump rows with `portionSize` as MAX rows.
 * }
 * $sqlGenerator->dumpPortion();	// this is required to dump final part of data.
 *
 * @author Maciej Nux Jaros
 */
class SqlGenerator
{
	private $header;
	private $sql;
	private $outputPath;
	private $portionSize = 900;
	private $hasData;

	public function __construct($header, $outputPath) {
		$this->header = $header;
		$this->outputPath = $outputPath;

		$this->numAdded = 0;
		$this->sql = "";
		$this->hasData = false;
	}

	/**
	 * Clear (remove) file contents.
	 */
	public function clearFile() {
		file_put_contents($this->outputPath, "");
	}

	/**
	 * Append prepared SQL.
	 *
	 * Note! The SQL should be only in braces (no comma at the end).
	 *
	 * Also note that this will dump portions of data to the output path.
	 *
	 * @param string $sql
	 */
	public function appendRow($sql) {
		$this->sql .= "\n" . $sql . ",";
		$this->numAdded++;
		$this->hasData = true;
		if ($this->numAdded > 1 && ($this->numAdded % $this->portionSize) == 0) {
			$this->dumpPortion();
		}
	}

	/**
	 * Dump data from internal buffer.
	 */
	public function dumpPortion() {
		if (!$this->hasData) {
			return;
		}
		$sql = trim($this->sql, ',') . ";\nGO\n";
		file_put_contents($this->outputPath, $this->header . $sql, FILE_APPEND);

		$this->sql = "";
		$this->hasData = false;
	}

	/**
	 * Escape string (for MS SQL).
	 */
	public static function escape($value) {
		return strtr($value, array(
			'\'' => '\'\'',
		));
	}
}
