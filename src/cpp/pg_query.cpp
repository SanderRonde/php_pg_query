#include "include/pg_query.h"
#include <stdio.h>

int main(int argc, char **argv) {
	if (argc < 2) {
		printf("Usage: <query>");
		return 1;
	}
	PgQueryParseResult result = pg_query_parse(argv[1]);
	if (result.error) {
		printf("Error: %s, %s", result.error->message, result.stderr_buffer);
		return 1;
	}
	printf("%s", result.parse_tree);
	return 0;
}