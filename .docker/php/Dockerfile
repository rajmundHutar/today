FROM php:8.2

# Move our PHP file into the container
# COPY ../../www/index.php /usr/src/www/index.php

# Make things easier if you shell in
WORKDIR /usr/src

# Our PHP will be running on port 80
EXPOSE 80

# RUN docker-php-ext-install pdo_mysql

# Set up a web server
CMD ["php", "-S", "0.0.0.0:80", "-t", "."]
