<?php
namespace web\ws\rest\resolver {
	require_once('content_type_resolver.inc.php');
	require_once('/serve/serve_formdata.inc.php');

	use web\ws\rest\serve as servers;

	class FormDataResolver extends ContentTypeResolver {
		public function resolveType($contentType) {
			if (preg_match('/^application\/x-www-form-urlencoded.*$/', $contentType) === 1) {
				return new servers\ServeFormData();
			}

			return parent::resolveType($contentType);
		}
	}
}
?>