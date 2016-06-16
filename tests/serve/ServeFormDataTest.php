<?php
namespace web\ws\rest\test {
	use PHPUnit\Framework\TestCase;
	use \web\ws\rest\serve;
	
	class ServeFormDataTest extends TestCase {
		protected static $server;

		public static function setUpBeforeClass() {
			self::$server = new serve\ServeFormData();
		}

		public function testServeSimpleFormData() {
			// arrange
			$obj = [ 'test' => 'test' ];

			// act
			$result = self::$server->serveContent($obj);

			// assert
			$this->markTestIncomplete('not implemented');
		}

		public function testServeFormData() {
			// arrange
			$obj = [ 'test' => 13, 'testArray' => [ 'some' => 'other' ] ];

			// act
			$result = self::$server->serveContent($obj);
			
			// assert
			$this->markTestIncomplete('not implemented');
		}

		public function testProcessSimpleFormData() {
			// arrange
			$formData = 'test=test&other=some';
			
			// act
			$result = self::$server->processContent($formData);
			
			// assert
			$this->assertArraySubset([ 'test' => 'test', 'other' => 'some' ], $result);
		}

		public function testProcessFormData() {
			// arrange
			$formData = 'test=test&other=some&some=other+one&percent=%25';
			
			// act
			$result = self::$server->processContent($formData);
			
			// assert
			$this->assertArraySubset([ 'test' => 'test', 'other' => 'some', 'some' => 'other one', 'percent' => '%' ], $result);
		}
	}
}
?>