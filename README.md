# Proyecto PHP con Docker y Doctrine

## Descripción

Este proyecto es una aplicación PHP que utiliza Docker para la contenedorización y Doctrine para la gestión de la base de datos. Proporciona una configuración sencilla para el desarrollo y la ejecución de pruebas.

## Requerimientos

- Docker
- Docker Compose
- Make

## Configuración del Proyecto

1. Clona el repositorio:

```sh
git clone https://github.com/wdevmaster/docfav-test.git
cd docfav-test
```

### Pasos con make

Si prefieres usar `make` para simplificar la configuración inicial del proyecto.

Ejecuta el comando de configuración:

```sh
make setup
```

Esto realizará las siguientes acciones:

- Copiar el archivo [.env.example](http://_vscodecontentref_/1) a [.env](http://_vscodecontentref_/2)
- Construir las imágenes de Docker y levantar los servicios
- Instalar las dependencias de PHP
- Crear la base de datos
- Ejecutar las migraciones de la base de datos

Para ejecutar las pruebas, utiliza uno de los siguiente comando:

```sh
make test
```

### Pasos manuales

Copia el archivo de ejemplo [.env.example](http://_vscodecontentref_/3) a [.env](http://_vscodecontentref_/4):

```sh
cp .env.example .env
```

Construye las imágenes de Docker y levanta los servicios:

```sh
docker compose up -d --build
```

Instala las dependencias de PHP:

```sh
docker compose exec app composer install
```

Crea la base de datos:

```sh
docker compose exec mysql mysql -u root -p$(grep DB_PASSWORD .env | cut -d '=' -f2) -e "CREATE DATABASE IF NOT EXISTS $(grep DB_DATABASE .env | cut -d '=' -f2);"
```

Ejecuta las migraciones de la base de datos:

```sh
docker compose exec app ./doctrine migrations:migrate --no-interaction --all-or-nothing
```

Para ejecutar las pruebas, utiliza uno de los siguiente comando:

```sh
docker compose exec app ./vendor/bin/phpunit
```

## Estructura del Proyecto

- [config](http://_vscodecontentref_/5): Archivos de configuración.
- [docker](http://_vscodecontentref_/6): Archivos relacionados con Docker.
- [migrations](http://_vscodecontentref_/7): Archivos de migraciones de la base de datos.
- [public](http://_vscodecontentref_/8): Punto de entrada de la aplicación.
- [src](src): Código fuente de la aplicación.
    - [Application](src/Application): Código relacionado con la lógica de la aplicación.
        - [PortIn](src/Application/PortIn): Interfaces son utilizadas para desacoplar la lógica de la aplicación de los detalles de implementación de la infraestructura.
    - [Domain](src/Domain): Código relacionado con la lógica del dominio.
        - [Entity](src/Domain/Entity): Entidades del dominio.
        - [Event](src/Domain/Event): Eventos del dominio.
        - [Exception](src/Domain/Exception): Excepciones del dominio.
        - [Repository](src/Domain/Repository): Repositorios del dominio.
        - [ValueObject](src/Domain/ValueObject): Objetos de valor del dominio.
    - [Infrastructure](src/Infrastructure): Código relacionado con la infraestructura.
        - [Exception/ExceptionHandler.php](src/Infrastructure/Exception/ExceptionHandler.php): Esta excepciones manejan errores específicos que ocurren permitiendo una gestionar  los errores y una respuesta adecuada a los fallos del sistema.
        - [Persistence](src/Infrastructure/Persistence): Código relacionado con la persistencia de datos.
            - [Entity](src/Infrastructure/Persistence/Entity): Entidades de persistencia.
            - [Mapper/UserMapper.php](src/Infrastructure/Persistence/Mapper/UserMapper.php): Estos mapeadores se encargan de convertir las entidades del dominio en entidades de persistencia y viceversa. 
        - [Service](src/Infrastructure/Service): Servicios de la infraestructura.
    - [Presentation](src/Presentation): Esta capa se encarga de manejar la interacción con el usuario final. Incluye los controladores que gestionan las solicitudes del usuario y los objetos de transferencia de datos (DTO) que facilitan la comunicación entre las demás capas.
        - [Controller](src/Presentation/Controller): Controladores de la presentación.
        - [DTO](src/Presentation/DTO): Objetos de transferencia de datos.
- [tests](tests): Pruebas unitarias y de integración.
- [routes.php](routes.php): Este archivo define las rutas de la aplicación.

## Nota

El resultado del [UserRegisteredEvent](src/Domain/Event/UserRegisteredEvent.php) se está almacenando en el archivo de log ***event.log***. Asegúrate de revisar este archivo para verificar los eventos registrados.
