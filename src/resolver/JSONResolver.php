<?php
namespace web\ws\rest\resolver {
	use web\ws\rest\serve as servers;

	class JSONResolver extends ContentTypeResolver {
		public function resolveType($contentType) {
			if (preg_match('/^application\/json.*$/', $contentType) === 1) {
				return new servers\ServeJSON();
			}

			return parent::resolveType($contentType);
		}
	}
}
?>