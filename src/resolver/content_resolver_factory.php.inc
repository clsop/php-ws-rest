<?php
namespace ws\rest\resolver;

require_once('src/singleton.php.inc');
require_once('xml_resolver.php.inc');
require_once('json_resolver.php.inc');
require_once('formdata_resolver.php.inc');

class ContentResolverFactory {
	use \ws\rest\Singleton;

	public function createResolvers() {
		$formDataResolver = new FormDataResolver();
        $jsonResolver = new JSONResolver();
        $xmlResolver = new XMLResolver();

        $xmlResolver->setNextResolver($jsonResolver);
        $jsonResolver->setNextResolver($formDataResolver);

        return $xmlResolver;
	}
}
?>