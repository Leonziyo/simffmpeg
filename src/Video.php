<?php

namespace Leonziyo\Simffmpeg;

use Leonziyo\Simffmpeg\Simffmpeg;

class Video {
	
	/**
	 * Creates a video from images. 
	 *
	 *
	 * @param string $sourcePathPrefix Example: img/t-*.jpeg
	 * @param string $destinationPath
	 * @param int $frameRate
	 * @param string $size
	 * @return array
	 *
	 */	
	public static function createVideoFromImages($sourcePathPrefix, $destinationPath, $frameRate, $size) {
		$rawCommand = Simffmpeg::$binaryPath . " -f image2 -pattern_type glob -framerate $frameRate -i '$sourcePathPrefix' -y -s $size '$destinationPath' -hide_banner -loglevel error 2>&1";
		
		exec($rawCommand, $errors);
		
		return $errors;
	}
	
	/**
	 * Change video format. 
	 *
	 *
	 * @param string $sourcePath
	 * @param string $destinationPath
	 * @return array
	 *
	 */	
	public static function changeVideoFormat($sourcePath, $destinationPath) {
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourcePathPrefix' -y  '$destinationPath' -hide_banner -loglevel error 2>&1";
		
		exec($rawCommand, $errors);
		
		return $errors;
	}
	
	/**
	 * Resize Video.
	 *
	 *
	 * @param string $sourcePath
	 * @param string $destinationPath
	 * @param string $newSize
	 * @return array
	 *
	 */	
	public static function resizeVideo($sourcePath, $destinationPath, $newSize) {
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourcePathPrefix' -y -s $newSize '$destinationPath' -hide_banner -loglevel error 2>&1";
		
		exec($rawCommand, $errors);
		
		return $errors;
	}
	
	/**
	 * Remove audio. 
	 *
	 *
	 * @param string $sourcePath
	 * @param string $destinationPath
	 * @return array
	 *
	 */	
	public static function removeAudioFromVideo($sourcePath, $destinationPath) {
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourcePathPrefix' -y -an '$destinationPath' -hide_banner -loglevel error 2>&1";
		
		exec($rawCommand, $errors);
		
		return $errors;
	}
	
	/**
	 * Add audio. 
	 *
	 *
	 * @param string $sourcePath
	 * @param string $destinationPath
	 * @return array
	 *
	 */	
	public static function addAudioToVideo($sourceVideoPath, $sourceAudioPath, $destinationPath) {
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourceVideoPath' -i '$sourceAudioPath' -map 0:v -map 1:a -y '$destinationPath' -hide_banner -loglevel error 2>&1";
		
		exec($rawCommand, $errors);
		
		return $errors;
	}
	
	/**
	 * Add overlapping audio. 
	 *
	 * NOTE: this will generate a video file with the shortest input stream duration. So if a video file with duration 5:30 and audio file with duration 1:10 are provided then the 
	 * 			output video generated will have a duration of 1:10.
	 *
	 * @param string $sourcePath
	 * @param string $destinationPath
	 * @return array
	 *
	 */	
	public static function addOverlappingAudioToVideo($sourceVideoPath, $sourceAudioPath, $destinationPath) {		
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourceVideoPath' -i '$sourceAudioPath' -filter_complex \"[0:a][1:a]amerge=inputs=2[a]\" -map 0:v -map \"[a]\" -c:v copy -c:a aac -strict experimental -b:a 192k -ac 2 -y -shortest '$destinationPath' -hide_banner -loglevel error 2>&1";
		
		exec($rawCommand, $errors);
		
		return $errors;
	}
	
	/**
	 * Get a video split. 
	 *
	 *
	 * @param string $sourcePath
	 * @param string $destinationPath
	 * @param string $timeStart
	 * @param string $duration
	 * @return array
	 *
	 */	
	public static function getVideoSplit($sourcePath, $destinationPath, $timeStart, $duration) {
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourcePath' -y -ss $timeStart -t $duration '$destinationPath' -hide_banner -loglevel error 2>&1";

		exec($rawCommand, $errors);
		
		return $errors;
	}
	
	/**
	 * Get black and white video. 
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
	 * Get video length. 
	 *
	 *
	 * @param string $sourcePath
	 * @param string &$duration
	 * @return array
	 *
	 */	
	public static function getVideoLength($sourcePath, &$duration) {
		$rawCommand = Simffmpeg::$binaryPath . " -i '$sourcePath' -hide_banner 2>&1";
		
		exec($rawCommand, $errors);
		
		$duration = -1;
		//parse output to get duration
		foreach($errors as $next) {
			if(strpos($next, 'Duration: ') !== false) {
				$duration = str_replace('Duration: ', '', $next);		
				$duration = explode(',', $duration)[0];		
				$duration = explode('.', $duration)[0];		
				$duration = strtotime($duration) - strtotime('TODAY');		
			}		
		}
		
		return [];
	}
	
}