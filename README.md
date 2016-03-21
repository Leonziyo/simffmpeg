# simffmpeg

This project is a simple PHP wrapper for [FFmpeg](https://www.ffmpeg.org/). It focuses on simple tasks that can be beneficial when handling user uploads of multimedia files. 
- Extracting thumbnails from videos.
- Splitting video and audio files.
- Add/remove audio to a video.
- Replacing or overlapping the original audio of a video. 
- Converting video and images to black and white.
- Creating a Gif from a video.
- Extract audio from a video.
- Converting to different file formats.
- Changing the video resolution.
- And more.

# Requirements

- FFmpeg (preferably newer versions to avoid unsupported issues)
- PHP version >= 5.5.9

# Installation
**STEP 1:**

You must install FFmpeg before attempting to use this library.
Make sure FFmpeg is runnable from the terminal and its location is included in apache's PATH.
To make sure of that check the output of you `phoinfo()` look under Apache Environment and search for PATH. The path to FFmpeg in MAC OSX installed through [homebrew](http://brew.sh/) is like this:

`/usr/local/bin/ffmpeg`

You could also check the path to your FFmpeg by running this command:

`which ffmpeg`

**Optional**

If you are not able to set the path, you can set the path in your PHP script by running this before making any other calls:

`Simffmpeg::$binaryPath = 'path/to/your/ffmpeg';`

**STEP 2:**

You can install this library via composer. It is currently not under packagist so you will need to specify it as a repository in your composer.json.

**composer.json:**
```
"require": {
  ...
  "leonziyo/simffmpeg":"dev-master"
},
"repositories": [{
	"type": "vcs",
	"url": "https://github.com/Leonziyo/simffmpeg"
}]
```

After that run:

`composer update`

**STEP 3**

That's it you are all set and ready to go! Check out the documentation.

# Documentation

All calls to the library are static so just make sure you import the right namespace and do the call.
These are all the namespaces.

```
require '../vendor/autoload.php'; // Make sure to call composer's autoload!

use Leonziyo\Simffmpeg\Thumbnail;
use Leonziyo\Simffmpeg\Image;
use Leonziyo\Simffmpeg\Raw;
use Leonziyo\Simffmpeg\Gif;
use Leonziyo\Simffmpeg\Video;
use Leonziyo\Simffmpeg\Sound;
use Leonziyo\Simffmpeg\Simffmpeg;
```

Through this documentation you will see that some functions require to pass time as a string, that is because FFmpeg uses that format so it will give you more flexibility check out their [site](https://www.ffmpeg.org/ffmpeg-utils.html#time-duration-syntax) for more info.

**Errors**

All library calls return an array of strings if the array is empty then the command was successfull otherwise there was an error.
Errors are pretty self explanatory so just print them out to figure out what the issue is, most likely your version of FFmpeg does not suport that operation so you should install the latest version or there is a problem with your paths.

```
$errors = Thumbnail::getImageFromVideo($videoPath, $imagePath, $size, $time);

if($errors) {
	foreach($errors as $next) {
		echo $next; // Print error
	}	
}
else {
	echo 'Success!';
}
```

**Thumbnails**

- Paths can be absolute or relative.
- $size has the format WxH example: 1280x720
- $time has the format SS or HH:MM:SS example: 55 or 00:10:22
- $skipeTime same format than $time, but this specifies the time to start processing, so you would skip or ignore that part of the file.
- $offsetSeconds this is an integer and is the number of seconds to skip between each thumbnail. So a value of 5 would generate a thumbnail every 5 seconds of video.

`Thumbnail::getImageFromVideo($videoPath, $imagePath, $size, $time)`

**NOTE:** This will create images with a postfix number like this: img-1.jpeg, img-2.jpeg, img-3.jpeg ...

`Thumbnail::getAllFramesFromVideo($videoPath, $imageOutputPath, $size, $time)`

**NOTE:** This will create images with a postfix number like this: img-1.jpeg, img-2.jpeg, img-3.jpeg ...

`Thumbnail::getFramesEveryOffset($videoPath, $imageOutputPath, $imageSize, $offsetSeconds, $skipTime) `

**Video**

- $sourcePathPrefix a string with this fomat: **filename-*.jpeg** so your images should be named: filename-1.jpeg, filename-2.jpeg, filename-3.jpeg, ...
- $frameRate the framerate for the video.
- $size has the format WxH example: 1280x720
- $duration has the format SS or HH:MM:SS example: 55 or 00:10:22
- $timeStart same format than $duration, specifies the time to start proccessing the input, everything else before that time will be ignored.

`Video::createVideoFromImages($sourcePathPrefix, $destinationPath, $frameRate, $size)`

`Video::changeVideoFormat($sourcePath, $destinationPath)`

`Video::resizeVideo($sourcePath, $destinationPath, $size)`

`Video::removeAudioFromVideo($sourcePath, $destinationPath)`

`Video::addAudioToVideo($sourceVideoPath, $sourceAudioPath, $destinationPath)`

`Video::addOverlappingAudioToVideo($sourceVideoPath, $sourceAudioPath, $destinationPath)`

`Video::getVideoSplit($sourceVideoPath, $destinationPath, $timeStart, $duration)`

`Video::getBlackAndWhiteVideo($sourceVideoPath, $destinationPath)`

**Sound**
- $duration has the format SS or HH:MM:SS example: 55 or 00:10:22
- $timeStart same format than $duration, specifies the time to start proccessing the input, everything else before that time will be ignored.
- $outputMp3 a boolean true for getting an mp3 audio file

**NOTE:** $timeStart and $duration are optional in this call, if not provided it will start from the beggining of the file and the complete duration.

`Sound::extractAudioFromVideo($sourceAudioPath, $destinationPath, $outputMp3, $timeStart, $duration)`

**NOTE:** the file type will be infered from the extension, $timeStart and $duration are optional.
`Sound::convertAudio($sourceAudioPath, $destinationPath, $timeStart, $duration)`

**Gif**

- $timeStart and $duration are optional.
- $size has the format WxH example: 1280x720
- $duration has the format SS or HH:MM:SS example: 55 or 00:10:22
- $timeStart same format than $duration, specifies the time to start proccessing the input, everything else before that time will be ignored.

`Gif::createGifFromVideo($sourceVideoPath, $gifOutputPath, $size, $timeStart, $duration)`

**Image**

- $size has the format WxH example: 1280x720

`Image::getBlackAndWhiteVideo($sourcePath, $destinationPath)`

`Image::resizeImage($sourcePath, $destinationPath, $size)`

`Image::convertImage($sourcePath, $destinationPath)`

**Raw**

- $command a raw command in case non of the other library calls work for your needs. 

**NOTE: you must ignore the ffmpeg part and add `-hide_banner -loglevel error 2>&1` at the end if you want to receive errors like all the other calls. Example:** 

Original command: (will not work)

`ffmpeg -i input.mov -y -ss 20 -t 5 output.mp4`

Correct format: (will work)

`-i input.mov -y -ss 20 -t 5 output.mp4 -hide_banner -loglevel error 2>&1`


`Raw::runRawCommand($command)`



