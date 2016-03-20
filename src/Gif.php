<?php

namespace Leonziyo\Simffmpeg;

use Leonziyo\Simffmpeg\Simffmpeg;

class Gif {
	
	/**
	 * Generates a gif from the video, the image frame is taken at the time specified by $time with format SS or HH:MM:SS
	 *
	 * Returns true if success otherwise returns an array of stirngs, each element for an error.
	 *
	 * @param string $videoPath
	 * @param string $gifOutputPath
	 * @param string $imageSize
	 * @param string $startTime
	 * @param string $duration
	 * @return array
	 */	
	public static function createGifFromVideo($videoPath, $gifOutputPath, $imageSize, $startTime = 0, $duration = -1) {
		if($duration === -1)
			$command = Simffmpeg::$binaryPath . " -i '$videoPath' -ss $startTime -pix_fmt rgb24 -y -s $imageSize '$gifOutputPath' -hide_banner -loglevel error 2>&1";
		else
			$command = Simffmpeg::$binaryPath . " -i '$videoPath' -ss $startTime -t $duration -pix_fmt rgb24 -y -s $imageSize '$gifOutputPath' -hide_banner -loglevel error 2>&1";
				
		exec($command, $errors);
		
		return $errors;
	}
}

/*
Hard way to get GIF from video
ffmpeg -y -ss 5 -t 3 -i intro.mp4 -vf fps=10,scale=320:-1:flags=lanczos,palettegen img/palette.png
ffmpeg -ss 5 -t 3 -i intro.mp4 -i img/palette.png -filter_complex "fps=10,scale=320:-1:flags=lanczos[x];[x][1:v]paletteuse" img/output.gif
*/