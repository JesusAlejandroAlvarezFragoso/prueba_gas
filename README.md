# Prueba técnica

LA presente es una prueba técnica presentada con dos puntos simples. Obtener información de una API externa (precios públicos de gasolina https://api.datos.gob.mx/v1/precio.gasolina.publico) complementada con datos geográficos del correos de méxico, y con criterios de busqueda por estado, municipio y ordenamiento; todo desde el framework de PHP llamado Laravel en su versión 8.0. En segundo punto, un sitio responsivo en HTML5, con el framework para JS llamado VUEJS y su libreria llamada Vuetify, así como dos APIS de Google (maps y markerclustererplus) para la representación del mapa y sus pines de manera dinámica.

## Instalación
Para poder iniciar con la instalación del proyecto, cabe recordar que podemos usar GIT, para lo cuál basta con ejecutar el siguiente comando:
```bash
git clone
```
En caso de contar o querer usar GIT, simplemente descarguemos el proyecto a travéz del archivo ZIP y descomprimamoslo.

### Backend
Gracias al manejador de paquetes llamado Composer y Artisan que funcionan sobre PHP podemos realizar esta tarea. Pero debemos asegurarnos de tener instaladas en la maquina PHP en versión 7.3 o superior y Composer en su versión 1.9 o superior (esto debido a su próxima actualización).

Una vés cubiertos ambos requerimientos podemos proceder de la siguiente manera:

- En una terminal con permisos de usuario normal naveguemos a la carpeta raíz del proyecto
- Ejecutemos el comando ```bash composer install ``` y esperemos a que termine de ejecutarse
- Copiemos el archivo .env.example al archivo .env
- Ejecutemos el comanto ```bash php artisan key:generate ``` y esperemos a que termine de ejecutarse
- Ejecutemos el comanto ```bash php artisan serve ``` e ingresemos a la dirección retornada (usualmente http://localhost:8000)
- ¡Listo! deberíamos ver la página de inicio

### Frontend
En este caso, al ser un archivo HTML crudo y tener las dependencias agregadas, no se requiere ningún tipo de instalación o compoliación. Esta decisión se tomó con base en el tamaño del proyecto y a que evolucionando este principio, podemos tener una futura compilación del paquete generando un sitio estático de facil acceso e independiente al servidor del backend.

### Base de datos
Para terminar, montemos la base de datos que complementará la información del servicio consumido, para esto, aseguremonos de tener instalado MYSQL en su versión 5.8 o superior, así como tener acceso a un usuario por permisos de lectura/escritura.

Una vés cubiertos los requerimientos podemos proceder de la siguiente manera:

- Abramos una terminal o manejador de base de datos, como se prefiera.
- Conectemos con una base de datos generica
- Creemos la base de datos con el nombre que nos paresca (yo usé test_gas)
- Abramos la base de datos creada e importemos los archivos .sql alojados en la carpeta database. (contienen estructura y datos de la tabla usada)
- Abramos el archivo .env y configuremos los parametros de conexión a base de datos con las pertinentes (dirección, puerto, usuario, contraseña, y nombre de la base de datos)
- Guardemos el archivo .env
- vayamos a la uri /gasolina/mapa; en caso de habér un problema verémos una notificación.


## Condiciones importantes
El código fué desarrollado en un ambiente con Docker, por lo cuál se consume por el puerto de internet default (80), en caso de presentar algún problema con el puerto, por favor intenta consumirlo desde este puerto con MAMP, XAMP o con el mismo Docker.

¡Muchas Gracias por leer la documentación! Si tienes algún problema, puedes consultarme en este repo. Saludos.





## Readme default de laravel
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
