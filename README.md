



## Pokémon Web Application
Pré-requisitos
Docker e Docker Compose instalados
Node.js e npm instalados para rodar o frontend sem Docker
Comandos Docker
## 1. Build e subir os containers
Execute o comando abaixo na raiz do projeto para construir as imagens Docker e subir os containers:


```bash
docker-compose up --build
```
## 2. Parar os containers
Para parar e remover os containers, execute:

```bash
docker-compose down
```
## 3. Reconstruir um serviço específico
Se precisar reconstruir um serviço específico (por exemplo, o app), use:

Copiar código
```bash
docker-compose up --build app
```
## 4. Acessar o container do backend (Laravel)
Se precisar acessar o container do backend para executar comandos Artisan, use:

Copiar código
```bash
docker-compose exec app bash
```
Rodando o Frontend sem Docker
## 1. Instalar dependências
Na pasta frontend, instale as dependências necessárias com npm:

```bash
cd frontend
npm install
```
## 2. Rodar o frontend em modo de desenvolvimento
Para rodar o frontend com hot-reload e desenvolvimento, use:

```bash
npm run serve
```
O frontend estará disponível em http://localhost:3000.

## 3. Build para produção
Se quiser fazer o build para produção (gerando os arquivos otimizados), use:

```bash
npm run build
```
Os arquivos de build serão gerados na pasta dist.

