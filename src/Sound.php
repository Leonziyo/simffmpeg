<?php

namespace Leonziyo\Simffmpeg;

use Leonziyo\Simffmpeg\Simffmpeg;

class Sound {
	
		
	/**
	 * Extracts sound from a video.
	 *
	 *
	 * @param string $videoSourcePath
	 * @param string $destinationPath
	 * @param boolean $outputMp3
	 * @param string $startTime
	 * @param string $duration
	 * @return array
	 *
	 */	
	public static function extractAudioFromVideo($videoSourcePath, $destinationPath, $outputMp3, $startTime = 0, $duration = -1) {		
		// acc & mp3
		if($outputMp3)
			$command = Simffmpeg::$binaryPath . " -i '$videoSourcePath' -ss $startTime ". (($duration !== -1) ? " -t $duration" : "") ." -y -b:a 192K -vn '$destinationPath' -hide_banner -loglevel error 2>&1";
		else
			$command = Simffmpeg::$binaryPath . " -i '$videoSourcePath' -ss $startTime ". (($duration !== -1) ? " -t $duration" : "") ." -y -vn -acodec copy '$destinationPath' -hide_banner -loglevel error 2>&1";

		exec($command, $errors);
		
		return $errors;
	}
	
	/**
	 * Extract portion of audio file. 
	 *
	 *
	 * @param string $audioSourcePath
	 * @param string $destinationPath 
	 * @param string $startTime
	 * @param string $duration
	 * @return array
	 *
	 */	
	public static function getAudioSplit($audioSourcePath, $destinationPath, $startTime = 0, $duration = -1) {		
		$command = Simffmpeg::$binaryPath . " -i '$audioSourcePath' -ss $startTime ". (($duration !== -1) ? " -t $duration" : "") ." -y '$destinationPath' -hide_banner -loglevel error 2>&1";

		exec($command, $errors);
		
		return $errors;
	}		
	
	/**
	 * Convert audio file to different extension. 
	 *
	 *
	 * @param string $audioSourcePath
	 * @param string $destinationPath 
	 * @param string $startTime
	 * @param string $duration
	 * @return array
	 *
	 */	
	public static function convertAudio($audioSourcePath, $destinationPath, $startTime = 0, $duration = -1) {						
		return Sound::getAudioSplit($audioSourcePath, $destinationPath, $startTime, $duration);
	}	
}