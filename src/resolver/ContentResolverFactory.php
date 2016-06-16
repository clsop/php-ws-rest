<?php
namespace web\ws\rest\resolver {
	class ContentResolverFactory {
		use \base\Singleton;

		public function createResolvers() {
			$formDataResolver = new FormDataResolver();
	        $jsonResolver = new JSONResolver();
	        $xmlResolver = new XMLResolver();

	        $xmlResolver->setNextResolver($jsonResolver);
	        $jsonResolver->setNextResolver($formDataResolver);

	        return $xmlResolver;
		}
	}
}
?>