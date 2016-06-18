<?php
namespace web\ws\rest\exception {
	abstract class ExceptionMessage {
		const DEFAULT_ENDPOINT_ERROR = 'Could not find endpoint (most likely web server rewrite rules missing)';
		const DEFAULT_INTERNAL_ERROR = 'An internal server error has occured.';
		const UNACCEPTED_CONTENT = 'Endpoint cannot deliver any of the acceptable content.';
		const UNSUPPORTED_METHOD = 'Method not supported.';
		const UNKNOWN_STATUS = 'Unknown status code.';
		const INVALID_ARRAY_STRUCTURE = 'response data must be $key => $value pairs with keys non-numeric (also starting with numerics isn\'t allowed).';
	}
}
?>