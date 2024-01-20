<?php

class LibInstaller {
	private const LIBPG_QUERY_GIT = 'libpg_query_git';

	public static function install(): void {
		// Clone
		if (!is_dir(self::LIBPG_QUERY_GIT)) {
			$folder = self::LIBPG_QUERY_GIT;
			exec("git clone -b 15-latest --single-branch https://github.com/pganalyze/libpg_query.git $folder");
		}

		// Build library
		chdir(self::LIBPG_QUERY_GIT);
		$cFlags = "";
		if (PHP_OS_FAMILY == 'Darwin') {
			$cFlags = "-mmacosx-version-min=10.7";
		}
		print("Building libpg_query...\n");
		exec("make CFLAGS=$cFlags PG_CFLAGS=$cFlags build");

		// Copy over output files
		if (!copy("libpg_query.a", "../src/cpp/include/libpg_query.a")) {
			throw new Exception("Failed to copy libpg_query.a");
		}
		if (!copy("pg_query.h", "../src/cpp/include/pg_query.h")) {
			throw new Exception("Failed to copy pg_query.h");
		}
		
		// Build raw query now
		chdir("../src/cpp");
		exec("mkdir -p ../../bin");
		exec("make php_pg_query");

		// Check if file exists
		if (!file_exists("../../bin/pg_query")) {
			throw new Exception("Failed to build pg_query");
		}
		chmod("../../bin/pg_query", 0755);
		print("Done!\n");
	}
}

LibInstaller::install();