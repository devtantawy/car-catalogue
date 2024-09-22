BIN = ./vendor/bin
SAIL = $(BIN)/sail

# Docker --------------------------------------------------------------------- #
up:
	$(SAIL) up -d

down:
	$(SAIL) down

rebuild:
	make down;
	$(SAIL) build --no-cache;
	make restart;

restart:
	make down;make up;

# App ------------------------------------------------------------------------ #
local-setup:
	$(SAIL) artisan key:generate;
	$(SAIL) artisan storage:link;
	make migrate;

prod-setup:
	$(SAIL) artisan storage:link;
	make migrate;

post-pull:
	$(SAIL) composer install;
	make migrate;
	make restart;
	make clean;

local-update:
	$(SAIL) composer install;
	$(SAIL) artisan migrate
	make restart;
	make clean;

migrate:
	$(SAIL) artisan migrate:fresh --seed;

clean:
	$(SAIL) artisan view:clear;
	$(SAIL) artisan config:clear;
	$(SAIL) artisan optimize:clear;
	$(SAIL) artisan route:clear;

sniffer: ## Run the php code sniffer and fixes anything it can
	$(SAIL) php -d memory_limit=-1 $(BIN)/phpcbf --colors  app/Http/Controllers && \
		$(BIN)/phpcbf --colors  app/Providers && \
		$(BIN)/phpcbf --colors  app/Http && \
		$(BIN)/phpcbf --colors  app/Console && \
		$(BIN)/phpcbf --colors  app/Events && \
		$(BIN)/phpcbf --colors  app/Listeners && \
		$(BIN)/phpcbf --colors  app/Mail && \
		$(BIN)/phpcbf --colors  app/Notifications && \
		$(BIN)/phpcbf --colors  app/Http/Middleware && \
		$(BIN)/phpcbf --colors  app/Http/Requests

test:
	$(SAIL) artisan test;

# Linters-php ---------------------------------------------------------------- #
stan:
	$(SAIL) php -d memory_limit=-1 $(BIN)/phpstan analyse;

ide-helper:
	$(SAIL) artisan ide-helper:models --write --smart-reset;

# --set-baseline
stan-sbl:
	$(SAIL) php -d memory_limit=-1 $(BIN)/phpstan analyse --generate-baseline;

cs-fixer:
	$(SAIL) php $(BIN)/php-cs-fixer fix --config ./.php-cs-fixer --allow-risky=yes;

rector:
	$(SAIL) php $(BIN)/rector process;

pmd: ## Run the PHP mess detector
	$(SAIL) php $(BIN)/phpmd ./app text codesize;

# Runs the security checker
security-checker:
	$(SAIL) exec laravel.test ./local-php-security-checker

# Ci ------------------------------------------------------------------------- #
ci:
	$(SAIL) composer dump;
	make rector;
	make ide-helper;
#	make stan;
	make cs-fixer;
	make sniffer;
	make pmd;
	make security-checker;
	make test;
