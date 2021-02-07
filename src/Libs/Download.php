<?php
declare(strict_types=1);

namespace Sura\Libs;

use Sura\Contracts\DownloadInterface;

class Download implements DownloadInterface
{
	
	/** @var string[] */
	var array $properties = array('old_name' => "", 'new_name' => "", 'type' => "", 'size' => "", 'resume' => "", 'max_speed' => "");
	
	/** @var int */
	var int $range = 0;
	
	/**
	 * @param $path
	 * @param string $name
	 * @param int $resume
	 * @param int $max_speed
	 */
	function download(string $path, $name = "", $resume = 0, $max_speed = 0)
	{
		
		$name = ($name == "") ? substr(strrchr("/" . $path, "/"), 1) : $name;
		$name = explode("/", $name);
		$name = end($name);
		
		$file_size = @filesize($path);
		
		$this->properties = array('old_name' => $path, 'new_name' => $name, 'type' => "application/force-download", 'size' => $file_size, 'resume' => $resume, 'max_speed' => $max_speed);
		
		if ($this->properties['resume']) {
			
			if (isset($_SERVER['HTTP_RANGE'])) {
				
				$this->range = $_SERVER['HTTP_RANGE'];
				$this->range = str_replace("bytes=", "", $this->range);
				$this->range = str_replace("-", "", $this->range);
				
			} else {
				
				$this->range = 0;
				
			}
			
			if ($this->range > $this->properties['size']) $this->range = 0;
			
		} else {
			
			$this->range = 0;
			
		}
		
	}
	
	/**
	 *
	 */
	function download_file()
	{
		
		if ($this->range) {
			header($_SERVER['SERVER_PROTOCOL'] . " 206 Partial Content");
		} else {
			header($_SERVER['SERVER_PROTOCOL'] . " 200 OK");
		}
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header("Content-Type: " . $this->properties['type']);
		header('Content-Disposition: attachment; filename="' . $this->properties['new_name'] . '";');
		header("Content-Transfer-Encoding: binary");
		
		if ($this->properties['resume']) header("Accept-Ranges: bytes");
		
		if ($this->range) {
			
			header("Content-Range: bytes {$this->range}-" . ($this->properties['size'] - 1) . "/" . $this->properties['size']);
			header("Content-Length: " . ($this->properties['size'] - $this->range));
			
		} else {
			
			header("Content-Length: " . $this->properties['size']);
			
		}
		
		@ini_set('max_execution_time', 0);
//		@set_time_limit();
		
		$this->_download($this->properties['old_name'], $this->range);
	}
	
	/**
	 * @param $filename
	 * @param int $range
	 * @return bool
	 */
	function _download(string $filename, int $range = 0): bool
	{
		
		@ob_end_clean();
		
		if (($speed = $this->properties['max_speed']) > 0) $sleep_time = (8 / $speed) * 1e6; else $sleep_time = 0;
		
		$handle = fopen($filename, 'rb');
		fseek($handle, $range);
		
		if ($handle === false) {
			return false;
		}
		
		while (!feof($handle)) {
			print(fread($handle, 1024 * 8));
			ob_flush();
			flush();
			usleep($sleep_time);
		}
		
		fclose($handle);
		
		return true;
	}
	
}

