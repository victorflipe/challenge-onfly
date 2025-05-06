# Etapa 1 - Build
FROM node:20 AS builder

WORKDIR /app

# Copia os arquivos do projeto
COPY . .

# Instala dependências
RUN npm install

# Injeta a variável no ambiente do build
ARG VITE_API_URL
RUN VITE_API_URL=${VITE_API_URL}

# Compila o frontend para produção
RUN npm run build

# Etapa 2 - Servidor estático
FROM nginx:alpine

# Remove a config padrão do nginx
RUN rm -rf /usr/share/nginx/html/*

# Copia os arquivos compilados para o nginx
COPY --from=builder /app/dist /usr/share/nginx/html

# Copia uma configuração customizada (opcional)
# COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expõe a porta padrão do nginx
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
