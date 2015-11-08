<?php
namespace ws\rest\resolver;

require_once('content_type_resolver.php.inc');
require_once('src/serve/serve_formdata.php.inc');

class FormDataResolver extends ContentTypeResolver {
	public function resolveType($contentType) {
		if (preg_match('/^application\/x-www-form-urlencoded.*$/', $contentType) === 1) {
			return new \ws\rest\serve\ServeFormData();
		}

		return parent::resolveType($contentType);
	}
}
?>