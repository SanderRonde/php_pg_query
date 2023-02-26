CC ?= cc

php_pg_query: ../../bin/pg_query

../../bin/pg_query: pg_query.cpp
	$(CC) pg_query.cpp -Linclude -pthread -lpg_query  -o ../../bin/pg_query