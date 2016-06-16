<?php
namespace web\ws\rest\test {
	use PHPUnit\Framework\TestCase;
	use \web\ws\rest\serve;
	
	class ServeXMLTest extends TestCase {
		protected static $server;

		public static function setUpBeforeClass() {
			self::$server = new serve\ServeXML();
		}

		public function testServeSimpleXML() {
			// arrange
			$obj = [ 'test' => 'test' ];

			// act
			$result = self::$server->serveContent($obj);

			// assert
			$this->assertXmlStringEqualsXmlString('<?xml version="1.0" ?><array><test>test</test></array>', $result);
		}

		public function testServeXML() {
			// arrange
			$obj = [ 'test' => 13, 'testArray' => [ 'some' => 'other' ] ];

			// act
			$result = self::$server->serveContent($obj);
			
			// assert
			$this->assertXmlStringEqualsXmlString('<?xml version="1.0" ?><array><test>13</test><testArray><some>other</some></testArray></array>', $result);
		}

		public function testProcessSimpleXML() {
			// arrange
			$xml = '<?xml version="1.0" encoding="UTF-8" ?><root><test>test</test></root>';
			
			// act
			$result = self::$server->processContent($xml);
			
			// assert
			$this->assertEquals(1, $result->count());
			$this->assertEquals(1, $result->children()->count());
		}

		public function testProcessXML() {
			// arrange
			$xml = '<?xml version="1.0" ?><root><tests><test>test1</test><test>test1</test><test>test1</test><test>test1</test><tests1><test>test1</test><test>test1</test><test>test1</test></tests1></tests></root>';
			
			// act
			$result = self::$server->processContent($xml);
			
			// assert
			$this->assertEquals(1, $result->count());
			$this->assertEquals(1, $result->children()->count());
			$this->assertEquals(5, $result->children()->children()->count());
		}
	}
}
?>