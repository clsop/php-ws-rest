<?php
namespace web\ws\rest\test {
	use PHPUnit\Framework\TestCase;
	use \web\ws\rest\resolver;
	use \web\ws\rest\serve;
	
	class ContentResolverTest extends TestCase {
		public function testResolverInstance() {
			// act
			$instance = resolver\ContentResolverFactory::instance();

			// assert
			$this->assertNotNull($instance);
		}

		/**
		 * @depends testResolverInstance
		 */
		public function testCreateResolvers() {
			// arrange
			$instance = resolver\ContentResolverFactory::instance();

			// act
			$resolvers = $instance->createResolvers();

			// assert
			$this->assertNotNull($resolvers);
		}

		/**
		 * @depends testResolverInstance
		 * @depends testCreateResolvers
		 */
		public function testFormDataResolver() {
			// arrange
			$instance = resolver\ContentResolverFactory::instance();
			$resolver = $instance->createResolvers();

			// act
			$server = $resolver->resolveType('application/x-www-form-urlencoded');

			// assert
			$this->assertInstanceOf(serve\ServeFormData::class, $server);
		}

		/**
		 * @depends testResolverInstance
		 * @depends testCreateResolvers
		 */
		public function testXMLResolver() {
			// arrange
			$instance = resolver\ContentResolverFactory::instance();
			$resolver = $instance->createResolvers();

			// act
			$server = $resolver->resolveType('application/xml');

			// assert
			$this->assertInstanceOf(serve\ServeXML::class, $server);
		}

		/**
		 * @depends testResolverInstance
		 * @depends testCreateResolvers
		 */
		public function testJSONResolver() {
			// arrange
			$instance = resolver\ContentResolverFactory::instance();
			$resolver = $instance->createResolvers();

			// act
			$server = $resolver->resolveType('application/json');

			// assert
			$this->assertInstanceOf(serve\ServeJSON::class, $server);
		}
	}
}
?>