# Use a imagem oficial do Node.js como base
FROM node:18-alpine

# Defina o diretório de trabalho dentro do container
WORKDIR /frontend

# Copie o package.json e o package-lock.json
COPY package*.json ./

# Instale as dependências do projeto
RUN npm install

# Copie todo o código da aplicação para o diretório de trabalho dentro do container
COPY . .

# Build do projeto para produção
RUN npm run build

# Instale o servidor HTTP para servir a aplicação
RUN npm install -g serve

# Exponha a porta que será usada pelo servidor
EXPOSE 3000

# Comando para iniciar o servidor e servir a aplicação
CMD ["serve", "-s", "dist", "-l", "3000"]
