## Intalar dependências do Laravel
`composer install`

## Intalar dependências do Vue
`npm install`

## Criar o docker com o banco de dados postgres
`docker-compose up -d`

## .env
É necessária copiar o arquivo .env.example e renomeá-lo para .env apenas.

Dentro do arquivo precisamos descomentar e alterar os valor de algumas linhas para que fiquem da seguinte maneira:
DB_CONNECTION=pgsql \
DB_HOST=127.0.0.1 \
DB_PORT=5432 \
DB_DATABASE=laravel_db \
DB_USERNAME=admin \
DB_PASSWORD=ob3twWctA4

## Gerar a chave da aplicação
`php artisan key:generate`

## Criar as tabelas no banco
`php artisan migrate`

## Para rodar o backend
`php artisan serve`

## Para rodar o frontend
`npm run dev`

## Pronto
Após seguir os passos anteriores o projeto estará rodando em [localhost:8000](http://localhost:8000)