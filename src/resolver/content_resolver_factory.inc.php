<?php
namespace web\ws\rest\resolver {
	require_once('xml_resolver.inc.php');
	require_once('json_resolver.inc.php');
	require_once('formdata_resolver.inc.php');

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