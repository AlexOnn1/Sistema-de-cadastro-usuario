# Usa a imagem oficial do PHP com Apache (Debian-based)
# Isso resolve o problema de pacotes do Alpine e a configuração do servidor web.
FROM php:8.2-apache

# 1. Instala dependências do sistema e limpa o cache para manter a imagem leve
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Instala as extensões do PHP necessárias para o seu projeto
# O docker-php-ext-install funciona perfeitamente aqui
RUN docker-php-ext-install pdo_mysql mysqli mbstring gd

# 3. Configura o Apache para rodar na porta 8080 (padrão do Fly.io)
# O Apache vem configurado na porta 80, mas o Fly geralmente espera 8080
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 4. Habilita a reescrita de URL (útil para rotas futuras)
RUN a2enmod rewrite

# 5. Copia o código da sua aplicação para a pasta pública do Apache
COPY . /var/www/html/

# 6. Ajusta permissões (para evitar erros de 'permission denied')
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 8080
EXPOSE 8080