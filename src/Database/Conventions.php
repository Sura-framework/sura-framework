<?php

declare(strict_types=1);

namespace Sura\Database;

use Sura\Database\Conventions\AmbiguousReferenceKeyException;


interface Conventions
{
	/**
	 * Returns primary key for table.
	 * @return string|string[]|null
	 */
	function getPrimary(string $table);

	/**
	 * Returns referenced table & referenced column.
	 * Example:
	 *     (author, book) returns [book, author_id]
	 *
	 * @return array|null   [referenced table, referenced column]
	 * @throws AmbiguousReferenceKeyException
	 */
	function getHasManyReference(string $table, string $key): ?array;

	/**
	 * Returns referenced table & referencing column.
	 * Example
	 *     (book, author)      returns [author, author_id]
	 *     (book, translator)  returns [author, translator_id]
	 *
	 * @return array|null   [referenced table, referencing column]
	 */
	function getBelongsToReference(string $table, string $key): ?array;
}


interface_exists(IConventions::class);
