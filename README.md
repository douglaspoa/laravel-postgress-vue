Requisitos
Docker
Docker Compose

bash
Copiar código
docker-compose up -d --build
Instale as dependências do Laravel:

Execute o seguinte comando para acessar o contêiner do Laravel e instalar as dependências:

bash
Copiar código
docker exec -it laravel-app-1 sh
composer install
Gere a chave da aplicação Laravel:

Ainda dentro do contêiner do Laravel, execute:

bash
Copiar código
php artisan key:generate
Execute as migrações:

Ainda no contêiner do Laravel, execute:

bash
Copiar código
php artisan migrate
Instale as dependências do Vue.js:

Execute o seguinte comando para acessar o contêiner do frontend e instalar as dependências:

bash
Copiar código
docker exec -it frontend sh
npm install
Compile os assets do Vue.js:

No contêiner do frontend, execute:

bash
Copiar código
npm run build
Acesse a aplicação:

Backend Laravel: http://localhost:8989
Frontend Vue.js: http://localhost:3000
Adminer (para gerenciar o banco de dados): http://localhost:8080