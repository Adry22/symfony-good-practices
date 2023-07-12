# Define constant
CONTAINER_NAME = symfony_good_practices_app

# Docker execute command
define exec_cmd
	docker exec $(CONTAINER_NAME) bash -c $(1)
endef

# Docker-compose command with user and group
define docker_compose
	DOCKER_USER=$$(id -u) DOCKER_GROUP=$$(id -g) docker-compose $(1)
endef

run: ## Launches project in dev environment
	$(call docker_compose,"up")

# show_fixer_errors: ## Shows code style errors
# 	$(call exec_cmd,"symfony-good-practices/bin/phpcs")
#
# run_fixer: ## Fix code style errors
# 	$(call exec_cmd,"symfony-good-practices/bin/phpcbf")
#
# build_doc: ## Generate open api documentation
# 	$(call exec_cmd,"symfony-good-practices/composer run docs --quiet --no-interaction")

cc: ## Clear dev cache
	$(call exec_cmd,"symfony-good-practices/bin/console cache:clear --no-warmup --env=dev")

test: ## Runs tests
	$(call exec_cmd,"cd symfony-good-practices/ && ./bin/phpunit -d memory_limit=-1")

prompt: ## Opens terminal in docker container
	@docker exec -it $(CONTAINER_NAME) bash

