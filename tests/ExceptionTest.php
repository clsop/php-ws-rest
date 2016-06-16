<?php
namespace web\ws\rest\test {
	use PHPUnit\Framework\TestCase;

	class RestTest extends \web\ws\rest\REST {
		public function get() {
			
		}
	}

	class ExceptionTest extends TestCase {
		public static function setupBeforeClass() {
			$_SERVER['REQUEST_METHOD'] = 'GET';
			$_SERVER['HTTP_ACCEPT'] = 'application/json,application/xml';
			$_SERVER['CONTENT_TYPE'] = 'application/json';
		}

		public function testCannotProvideContent() {
			// arrange
			$_SERVER['HTTP_ACCEPT'] = NULL;
			$rest = new RestTest();

			// assert
			$this->expectException(\web\ws\rest\exception\EndPointException::class);

			// act
			$rest->initialize();
		}
	}
}
?>