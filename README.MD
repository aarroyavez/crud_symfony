# App con php symfony

Pequeño review de aplicación en DESARROLLO de symfony con creación de usuarios, visualización de usuarios registrados, consulta y creación de productos (para ejemplos prácticos del ejercicio, marcas de celulares). Manejo de rutas y solicitudes. API rest en desarrollo

## Descripción
Es una aplicación web desarrollada con Symfony, diseñada para facilitar la gestión de pedidos en línea. Con esta aplicación, los usuarios pueden crear pedidos, agregar productos a los pedidos y realizar un seguimiento de los detalles del pedido de forma sencilla y eficiente.

## Características principales
- Gestión de usuarios: Permite a los usuarios registrarse, iniciar sesión y gestionar su perfil de forma segura.
- Creación de pedidos: Los usuarios pueden crear nuevos pedidos y proporcionar la dirección de envío para el pedido.
- Añadir productos: Los usuarios pueden agregar diferentes productos a sus pedidos, especificando la cantidad y el precio del producto.
- Visualización de pedidos: Los usuarios pueden ver todos sus pedidos anteriores, incluidos los detalles de los productos y el total del pedido.
- Edición de pedidos: Los usuarios pueden editar los detalles de un pedido existente, como agregar o eliminar productos.
- Eliminación de pedidos: Los usuarios tienen la opción de eliminar pedidos que ya no necesitan.

## Tecnologías utilizadas
- Symfony: El marco de trabajo PHP de Symfony proporciona una base sólida para el desarrollo de aplicaciones web robustas y escalables
- Doctrine: El ORM (Object-Relational Mapping) de Doctrine facilita la interacción con la base de datos y la gestión de entidades.
- Twig: El motor de plantillas Twig se utiliza para la generación de vistas, lo que permite una separación clara entre la lógica y la presentación.
- Twig: El motor de plantillas Twig se utiliza para la generación de vistas, lo que permite una separación clara entre la lógica y la presentación.
- Heroku: La aplicación está preparada para el despliegue en la plataforma de alojamiento en la nube Heroku, lo que permite una implementación rápida y sencilla.

## Cómo utilizar
1. Registro e inicio de sesión: Los usuarios pueden registrarse con una dirección de correo electrónico y una contraseña. Una vez registrados, pueden iniciar sesión con sus credenciales.

2. Creación de pedidos: Una vez que el usuario ha iniciado sesión, puede crear un nuevo pedido proporcionando la dirección de envío y agregando productos al pedido.

3. Añadir productos: Para agregar productos a un pedido, el usuario debe especificar el nombre del producto, la cantidad deseada y el precio unitario.

4. Visualización y edición de pedidos: Los usuarios pueden ver todos sus pedidos anteriores en su perfil. Desde aquí, también pueden editar los detalles de un pedido existente, como agregar más productos o eliminar productos existentes.

5. Eliminación de pedidos: Si un pedido ya no es necesario, el usuario tiene la opción de eliminarlo.

## Instalación y configuración
Para utilizar esta app en tu propio entorno de desarrollo, sigue estos pasos:
1. Clona el repositorio de GitHub de [Nombre de tu aplicación].
2. Ejecuta el siguiente comando para instalar todas las dependencias requeridas:
`composer install`
Configura la base de datos editando el archivo .env y ajustando los parámetros de conexión a tu base de datos.

Ejecuta las migraciones para crear las tablas necesarias en la base de datos:
`php bin/console doctrine:migrations:migrate`

## Docs
Resumen de comandos para crear una aplicación Symfony con funcionalidades básicas:

1. composer require make: Este comando instala el paquete "symfony/maker-bundle", que proporciona herramientas para generar automáticamente código en Symfony, como controladores, entidades y formularios.

2. composer require doctrine/annotations: Symfony utiliza Doctrine para el mapeo objeto-relacional (ORM). Este comando instala el paquete "doctrine/annotations", que permite utilizar anotaciones para definir la configuración de las entidades.

3. php bin/console make:controller User(controller): Este comando genera un nuevo controlador llamado "UserController" en la ubicación adecuada del proyecto. El "(controller)" especifica que se creará un controlador con las acciones típicas (index, show, new, edit, etc.).

4. composer require orm: Con este comando, instalamos el paquete "symfony/orm-pack", que proporciona integración con Doctrine ORM y otros paquetes relacionados.

5. php bin/console doctrine:mapping:import: Este comando escanea el código y las anotaciones de las entidades existentes y genera los archivos de configuración XML correspondientes para el mapeo de las entidades.

6. php bin/console make:entity --regenerate: Usando este comando, podemos regenerar automáticamente las clases de entidades basadas en los archivos de configuración XML generados en el paso anterior.

7. composer require template: Aquí, instalamos el paquete "symfony/twig-bundle", que proporciona el motor de plantillas Twig para generar vistas en Symfony.

8. composer require form validator: Con este comando, agregamos el componente Form y el componente Validator de Symfony, que son útiles para crear formularios y validar datos.

9. php bin/console make:form Users: Este comando genera automáticamente un formulario para la entidad "Users". El formulario se configura automáticamente con campos y validaciones basados en las propiedades de la entidad.

