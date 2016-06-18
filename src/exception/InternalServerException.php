<?php
namespace web\ws\rest\exception {
	/**
	 * Throws an internal server error in php, giving back http response of same nature
	 */
	class InternalServerException extends \ErrorException {
		public function __construct($message = ExceptionMessage::DEFAULT_INTERNAL_ERROR) {
			parent::__construct($message, 500);
		}
	}
}
?>