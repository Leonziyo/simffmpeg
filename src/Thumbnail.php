<?php

namespace Leonziyo\Simffmpeg;

use Leonziyo\Simffmpeg\Simffmpeg;

class Thumbnail {
	
	/**
	 * Generates a single image from the video, the image frame is taken at the time specified by $time with format SS or HH:MM:SS
	 *
	 * Returns true if success otherwise returns an array of stirngs, each element for an error.
	 *
	 * @param string $videoPath
	 * @param string $imageOutputPath
	 * @param string $imageSize
	 * @param string $time
	 * @return array
	 */
	public static function getImageFromVideo($videoPath, $imageOutputPath, $imageSize, $time = '1') {				
		$fileOutput = 'mjpeg'; // use when trying to get a single image			
		 
		$command = Simffmpeg::$binaryPath . ' -ss '.$time.' -t 00:00:01 -i "'.$videoPath.'" -s '.$imageSize.' -deinterlace -an -r 1 -y -vcodec mjpeg -f '.$fileOutput.' "'.$imageOutputPath.'" -hide_banner -loglevel error 2>&1';
		
		exec($command, $errors);
		
		if($errors) {
			//Thumbnail::handleErrors($errors);
		}
		
		return $errors;
	}
	
	/**
	 * Generates one image for every second of video. Optionally starting from time $time with format SS or HH:MM:SS
	 *
	 * Returns true if success otherwise returns an array of stirngs, each element for an error.
	 *
	 * @param string $videoPath
	 * @param string $imageOutputPath
	 * @param string $imageSize
	 * @param string $time
	 * @return array
	 */
	public static function getAllFramesFromVideo($videoPath, $imageOutputPath, $imageSize, $time = '1') {		
		$outPathParts = pathinfo($imageOutputPath);

		$filename = $outPathParts['filename'] . '-' . '%01d.' . $outPathParts['extension'];
		$imageOutputPath = $outPathParts['dirname'] . '/' . $filename;		
		$fileOutput = 'image2'; // use when trying to get a multiple image				
		 
		$command = Simffmpeg::$binaryPath . ' -ss '.$time.' -i "'.$videoPath.'" -s '.$imageSize.' -deinterlace -an -r 1 -y -vcodec mjpeg -f '.$fileOutput.' "'.$imageOutputPath.'" -hide_banner -loglevel error 2>&1';
		
		exec($command, $errors);
		
		if($errors) {
			//Thumbnail::handleErrors($errors);			
		}
		
		return $errors;
	}
	
	/**
	 * Generates one image for every X seconds.
	 *
	 * Returns true if success otherwise returns an array of stirngs, each element for an error.
	 *
	 * @param string $videoPath
	 * @param string $imageOutputPath
	 * @param string $imageSize
	 * @param int $offsetSeconds
	 * @param string $skipTime
	 * @return array
	 */
	public static function getFramesEveryOffset($videoPath, $imageOutputPath, $imageSize, $offsetSeconds, $skipTime = '0') {
		$outPathParts = pathinfo($imageOutputPath);

		$filename = $outPathParts['filename'] . '-' . '%01d.' . $outPathParts['extension'];
		$imageOutputPath = $outPathParts['dirname'] . '/' . $filename;
		$offsetSeconds = 60 / $offsetSeconds;
		
		$command = Simffmpeg::$binaryPath . " -i '$videoPath' -ss $skipTime -s $imageSize -f image2 -vf fps=fps=$offsetSeconds/60 '$imageOutputPath' -hide_banner -loglevel error 2>&1";

		exec($command, $errors);
		
		if($errors) {
			//Thumbnail::handleErrors($errors);			
		}
		
		return $errors;
	}
	
	
	/**
	 * handleErrors
	 *
	 * @param array $errors
	 * @return void
	 */
	private static function handleErrors($errors) {
		foreach($errors as $next) {
			if(strpos($next, ': No such file or directory') !== false) {
				$path = explode(':', $next);

				if($path[0] == $videoPath)
					echo "Your Video path: $videoPath does not exist.";
				else if($path[0] == $imageOutputPath)
					echo "Your image output path: $imageOutputPath does not exist.";
				else
					echo $next;
			}
			else
				echo $next;				
		}
	}
}

// ffmpeg options
//
// error = all errors
// fatal = only fatal errors
// quiet = no errors

// -i input file path
// -s image size wxh
// -an disable audio
// -r framerate		
// -ss
// -t
// -y Overwrite output files without asking.
// -vcodec output codec.
// -f Force input or output file format.
// -hide_banner (obvious) hides banner to make error detection easier when using exec()
// -loglevel (obvious) only errors to make error detection easier
// 2>&1 redirect output

// More about options here:
// https://ffmpeg.org/ffmpeg.html
// https://ffmpeg.org/ffmpeg-utils.html#time-duration-syntax