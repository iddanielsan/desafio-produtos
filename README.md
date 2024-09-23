# README

## Executando o Projeto Laravel 11

Este projeto foi desenvolvido com Laravel 11 utilizando Test-Driven Development (TDD) e Docker Sail. Siga as instruções abaixo para configurar e executar o projeto.

### Pré-requisitos

- Docker e Docker Compose instalados em sua máquina.

### Instalando as Dependências

Para instalar todas as dependências do projeto, execute o seguinte comando:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

### Executando o sail

./vendor/bin/sail up

### Executando migrations e seeds

./vendor/bin/sail php artisan migrate --seed

### Executando os testes

./vendor/bin/sail php artisan test
