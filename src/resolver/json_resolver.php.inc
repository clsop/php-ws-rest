<?php
namespace ws\rest\resolver;

require_once('content_type_resolver.php.inc');
require_once('src/serve/serve_json.php.inc');

class JSONResolver extends ContentTypeResolver {
	public function resolveType($contentType) {
		if (preg_match('/^application\/json.*$/', $contentType) === 1) {
			return new \ws\rest\serve\ServeJSON();
		}

		return parent::resolveType($contentType);
	}
}
?>