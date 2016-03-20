<?php

namespace Leonziyo\Simffmpeg;

class Raw {
	
	/**
	 * Runs a command specified by $command.
	 * 
	 * NOTE: Ommit the binary path in the command string.
	 *
	 * Returns true if success otherwise returns an array of stirngs, each element for an error. 
	 */
	public static function runRawCommand($command) {
		exec(Simffmpeg::$binaryPath . ' ' . $command, $errors);
		
		if($errors) {
			//Thumbnail::handleErrors($errors);
		}
		
		return $errors;
	}
}