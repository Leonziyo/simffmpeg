<?php

namespace Leonziyo\Simffmpeg;

use Leonziyo\Simffmpeg\Simffmpeg;

class Image {
	
	/**
	 * Get black and white image. 
	 *
	 *
	 * @param string $sourcePath
	 * @param string $destinationPath
	 * @return array
	 *
	 */	
	public static function getBlackAndWhiteVideo($sourcePath, $destinationPath) {
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourcePath' -y -vf format=gray,format=yuv422p '$destinationPath' -hide_banner -loglevel error 2>&1";
		
		exec($rawCommand, $errors);
		
		return $errors;
	}
	
	/**
	 * Resize Image. 
	 *
	 *
	 * @param string $sourcePath
	 * @param string $destinationPath
	 * @param string $size
	 * @return array
	 *
	 */	
	public static function resizeImage($sourcePath, $destinationPath, $size) {
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourcePath' -s $size -y '$destinationPath' -hide_banner -loglevel error 2>&1";
		
		exec($rawCommand, $errors);
		
		return $errors;
	}
	
	/**
	 * Convert Image. 
	 *
	 *
	 * @param string $sourcePath
	 * @param string $destinationPath
	 * @return array
	 *
	 */	
	public static function convertImage($sourcePath, $destinationPath) {
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourcePath' -y '$destinationPath' -hide_banner -loglevel error 2>&1";
		
		exec($rawCommand, $errors);
		
		return $errors;
	}
}