FROM php:8.2-cli

# Installation des d�pendances de base
RUN apt-get update && apt-get install -y \
    nano \
    git \
    unzip \
    mariadb-client \
    libpq-dev \
    libzip-dev && \
    docker-php-ext-install pdo pdo_mysql zip

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# D�finir le dossier de travail
WORKDIR /var/www

# Copier le code source dans le conteneur
COPY . .

# Installer les d�pendances PHP avec Composer (y compris Symfony Maker et ORM Pack)
RUN composer install --optimize-autoloader
RUN composer require symfony/orm-pack
RUN composer require symfony/password-hasher
RUN composer require symfony/security-bundle

# Exposer le port utilis� par Symfony (optionnel pour dev)
EXPOSE 8000

# Lancer le serveur Symfony en mode dev
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]