<?php

namespace PgQuery;

class PgQuery {
	public static function parse(string $query) {
		$out = exec(__DIR__ . "/../../bin/pg_query " . escapeshellarg($query));
		print_r("Out=$out");
	}
}

PgQuery::parse("SELECT 1");