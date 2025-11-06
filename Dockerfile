# Imagen base de PHP
FROM php:8.2-cli

# Carpeta de trabajo
WORKDIR /app

# Copia todo el contenido del proyecto dentro del contenedor
COPY . /app

# Expone el puerto que Render asignará
EXPOSE 10000

# Comando para iniciar el servidor PHP
CMD ["php", "-S", "0.0.0.0:10000"]
