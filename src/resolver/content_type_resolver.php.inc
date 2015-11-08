<?php
namespace ws\rest\resolver;

/**
 * Can resolve a content type
 */
abstract class ContentTypeResolver {
	protected $nextResolver;

	// public function __construct($resolver) {
	// 	$this->nextResolver = $resolver;
	// }

	public function setNextResolver($resolver) {
		$this->nextResolver = $resolver;
	}

	/**
	 * Resolves a type to a content server
	 * 
	 * @param  string $contentType mimetype trying to resolve
	 * @return IServe the content server used for the type resolved or NULL
	 */
	public function resolveType($contentType) {
		if ($this->nextResolver === NULL) {
			return NULL;
		}

		return $this->nextResolver->resolveType($contentType);
	}
}
?>