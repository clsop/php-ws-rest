<?php
namespace web\ws\rest\resolver {
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