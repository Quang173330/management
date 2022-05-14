.PHONY: web

lint:
	yarn lint
	composer sniff -d api

test:
	composer test -d api

