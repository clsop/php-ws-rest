<?php
namespace web\ws\rest\resolver {
	require_once('content_type_resolver.inc.php');
	require_once('/serve/serve_xml.inc.php');

	use web\ws\rest\serve as servers;

	class XMLResolver extends ContentTypeResolver {
		public function resolveType($contentType) {
			if (preg_match('/^application\/xml.*$/', $contentType) === 1 || $contentType === '*/*') {
				return new servers\ServeXML();
			}

			return parent::resolveType($contentType);
		}
	}
}
?>