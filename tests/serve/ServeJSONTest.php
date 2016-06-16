<?php
namespace web\ws\rest\test {
	use PHPUnit\Framework\TestCase;
	use \web\ws\rest\serve;
	
	class ServeJSONTest extends TestCase {
		protected static $server;

		public static function setUpBeforeClass() {
			self::$server = new serve\ServeJSON();
		}

		public function testServeSimpleJSON() {
			// arrange
			$obj = [ 'test' => 'test' ];

			// act
			$result = self::$server->serveContent($obj);

			// assert
			$this->assertJsonStringEqualsJsonString('{ "test": "test" }', $result);
		}

		public function testServeJSON() {
			// arrange
			$obj = [ 'test' => 13, 'testArray' => [ [ 'some' => 'other' ], [ 'other' => 'some' ] ] ];

			// act
			$result = self::$server->serveContent($obj);
			
			// assert
			$this->assertJsonStringEqualsJsonString('{ "test": 13, "testArray": [ { "some": "other" }, { "other": "some" } ] }', $result);
		}

		public function testProcessSimpleJSON() {
			// arrange
			$json = '{ "test": "test" }';
			
			// act
			$result = self::$server->processContent($json);
			
			// assert
			$this->assertArrayHasKey('test', $result);
			$this->assertArraySubset([ 'test' => 'test' ], $result);
		}

		public function testProcessJSON() {
			// arrange
			$json = '{ "test": "test", "var": [ { "test1": "text" }, { "test2": "text" } ] }';
			
			// act
			$result = self::$server->processContent($json);
			
			// assert
			$this->assertArrayHasKey('test', $result);
			$this->assertArrayHasKey('var', $result);
			$this->assertArraySubset([ 'var' => [ [ "test1" => "text" ], [ "test2" => "text" ] ] ], $result);
		}
	}
}
?>