# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Expone el puerto 10000 (Render usa este puerto)
EXPOSE 10000

# Comando para iniciar el servidor embebido de PHP
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/var/www/html"]
