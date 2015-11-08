<?php
namespace ws\rest\resolver;

require_once('content_type_resolver.php.inc');
require_once('src/serve/serve_xml.php.inc');

class XMLResolver extends ContentTypeResolver {
	public function resolveType($contentType) {
		if (preg_match('/^application\/xml.*$/', $contentType) === 1 || $contentType === '*/*') {
			return new \ws\rest\serve\ServeXML();
		}

		return parent::resolveType($contentType);
	}
}
?>