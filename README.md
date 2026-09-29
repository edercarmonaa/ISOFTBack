# ISOFTBack

API y vista web para registrar operaciones de una estacion de servicio, generar tickets de venta y administrar promociones por puntos para clientes.

El proyecto esta construido sobre Laravel y expone endpoints para usuarios, estaciones, bombas, combustibles, ventas, detalles de venta, tickets, promociones, premios, puntos y datos de facturacion.

## El problema

Una estacion de servicio necesita relacionar ventas de combustible con tickets, clientes y promociones. Si esa informacion se maneja en registros separados, es facil perder el rastro de que venta corresponde a que bomba, operador, producto o cliente, y tambien se complica calcular puntos, consultar premios disponibles o validar si un ticket puede participar en una promocion vigente.

Este tipo de problema afecta a negocios que venden combustible y quieren ofrecer programas de lealtad o premios sin depender de revisiones manuales de tickets, hojas de calculo o validaciones informales.

## La solucion

ISOFTBack centraliza la informacion principal de la operacion:

1. Se registran estaciones, combustibles, bombas, operadores, productos y grupos de productos.
2. Se crean ventas y detalles de venta.
3. La vista web permite consultar una venta y generar visualmente el ticket de servicio.
4. Los usuarios pueden registrarse e iniciar sesion mediante JWT.
5. Un ticket de combustible puede asociarse a una promocion vigente.
6. El sistema calcula puntos segun las reglas de la promocion.
7. Los puntos acumulados permiten consultar premios y registrar premios ganados.
8. El usuario puede guardar datos fiscales para facturacion.

## Funcionalidades principales

- Registro, autenticacion y actualizacion de usuarios.
- Autenticacion por JSON Web Token mediante `tymon/jwt-auth`.
- Registro de estaciones, combustibles, tipos de gasolina, bombas y operadores.
- Registro de insumos, grupos de productos y productos.
- Registro de ventas y detalles de venta.
- Consulta web de una venta para construir un ticket de servicio con QR.
- Registro de promociones con fecha de inicio, fecha de fin y estado activo.
- Registro de reglas de promocion basadas en litros y puntos.
- Registro de premios asociados a promociones.
- Registro de tickets para acumular puntos cuando el ticket corresponde a consumo de combustible.
- Consulta de puntos, premio alcanzable y avance hacia el siguiente premio.
- Registro y consulta de premios ganados.
- Registro y actualizacion de datos fiscales del usuario.

Algunas acciones de administracion existen solo como endpoints API; no hay un panel administrativo completo en la interfaz web.

## Que mejora este proyecto

- Reduce la separacion entre ventas, productos, tickets y promociones.
- Permite validar tickets contra ventas registradas antes de asignar puntos.
- Automatiza el calculo de puntos a partir de reglas de promocion.
- Facilita consultar cuantos puntos tiene un usuario y que premio puede alcanzar.
- Da una base para digitalizar tickets de servicio y generar codigos QR.
- Centraliza datos fiscales necesarios para facturacion.

## Para quien esta pensado

El proyecto esta orientado a:

- Estaciones de servicio o negocios similares que registran ventas de combustible.
- Administradores que necesitan cargar catalogos de estaciones, bombas, productos, promociones y premios.
- Clientes que acumulan puntos por tickets de consumo.
- Desarrolladores que quieran continuar una API Laravel para tickets, lealtad y facturacion.

## Capturas

El proyecto tiene una vista web en `/` para consultar una venta y mostrar el ticket de servicio. Actualmente no existe una carpeta `docs/images/` ni capturas documentadas en el repositorio.

Cuando se agreguen capturas, una estructura sugerida seria:

```markdown
## Capturas

### Consulta de venta

![Consulta de venta](docs/images/consulta-venta.png)

### Ticket generado

![Ticket generado](docs/images/ticket-generado.png)
```

## Tecnologias utilizadas

- PHP `^7.3|^8.0`: lenguaje principal del backend.
- Laravel `^8.54`: framework de la aplicacion y API.
- MySQL: conexion predeterminada configurada en `config/database.php`.
- JWT Auth (`tymon/jwt-auth`): autenticacion por token.
- Laravel Sanctum: dependencia instalada, aunque las rutas actuales usan JWT.
- Laravel Mix: compilacion de assets frontend.
- JavaScript, jQuery y Bootstrap: interaccion de la vista de tickets y estilos.
- Sass: estilos fuente compilados con Laravel Mix.
- PHPUnit: pruebas automatizadas de Laravel.

## Requisitos

Segun `composer.json` y `package.json`, el proyecto requiere:

- PHP `^7.3` o `^8.0`.
- Composer.
- MySQL o un motor compatible configurado mediante Laravel.
- Node.js y npm para compilar assets con Laravel Mix.
- Extension PHP compatible con la base de datos usada, por ejemplo `pdo_mysql` para MySQL.

El proyecto no fija una version exacta de Node.js en `package.json`.

## Instalacion

```bash
git clone URL_DEL_REPOSITORIO
cd ISOFTBack
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate
npm install
npm run prod
```

Si estas trabajando en desarrollo frontend, puedes usar:

```bash
npm run dev
```

## Configuracion

La configuracion se realiza en `.env`. No subas ese archivo a Git.

Variables principales:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

JWT_SECRET=change_me
```

Descripcion breve:

- `APP_KEY`: clave interna de Laravel. Se genera con `php artisan key:generate`.
- `APP_DEBUG`: debe estar en `false` para entornos publicos o productivos.
- `DB_*`: datos de conexion a la base de datos.
- `JWT_SECRET`: secreto usado para firmar tokens JWT. Se genera con `php artisan jwt:secret`.
- `MAIL_*`, `AWS_*`, `PUSHER_*`: configuraciones opcionales heredadas de Laravel y servicios externos.

## Base de datos

El proyecto usa migraciones de Laravel para crear tablas como:

- `users`
- `stations`
- `fuels`
- `pumps`
- `operators`
- `supplies`
- `product_groups`
- `products`
- `sales`
- `details`
- `promotions`
- `rules`
- `prizes`
- `tickets`
- `points`
- `wins`
- `taxes`

Para crear la estructura:

```bash
php artisan migrate
```

Existen seeders individuales en `database/seeders`, pero `DatabaseSeeder.php` no los ejecuta actualmente de forma automatica. Si necesitas datos de ejemplo, revisa los seeders disponibles y llamalos explicitamente o registra sus llamadas en `DatabaseSeeder`.

## Ejecutar el proyecto

Servidor local de Laravel:

```bash
php artisan serve
```

URL local habitual:

```text
http://127.0.0.1:8000
```

La ruta `/` muestra la vista `resources/views/ventas.blade.php`, donde se puede consultar una venta por ID y generar el ticket visual.

## Uso

Flujo basico esperado:

1. Configurar la base de datos y ejecutar migraciones.
2. Registrar catalogos base: estacion, combustible, bomba, operador, insumos, grupos y productos.
3. Registrar una venta mediante `POST /api/sale`.
4. Registrar los detalles de esa venta mediante `POST /api/detail`.
5. Abrir `/` en el navegador y consultar el numero de venta para generar el ticket.
6. Registrar promociones, reglas y premios.
7. Registrar un usuario e iniciar sesion.
8. Usar el token JWT para registrar tickets, consultar puntos, consultar premios y guardar datos fiscales.

## Endpoints principales

Endpoints publicos definidos en `routes/api.php`:

- `POST /api/register`
- `POST /api/login`
- `POST /api/station`
- `POST /api/fuel`
- `POST /api/pump`
- `POST /api/gastype`
- `POST /api/operator`
- `POST /api/supply`
- `POST /api/product`
- `POST /api/group`
- `POST /api/sale`
- `GET /api/sale/{sale}`
- `POST /api/detail`
- `GET /api/detail/{sale}`
- `POST /api/promotion`
- `POST /api/rule`
- `POST /api/prize`
- `POST /api/win`
- `POST /api/finish`

Endpoints protegidos por middleware JWT:

- `GET /api/logout`
- `GET /api/get_user`
- `GET /api/show_user`
- `POST /api/update_user`
- `GET /api/get_promotion`
- `POST /api/ticket`
- `GET /api/point`
- `GET /api/win`
- `POST /api/taxes`
- `GET /api/get_taxes`
- `POST /api/update_taxes`

## Estructura

```text
app/
  Http/Controllers/   Controladores de API y logica de cada recurso.
  Http/Middleware/    Middleware, incluyendo validacion JWT.
  Models/             Modelos Eloquent del dominio.
  Rules/              Reglas de validacion personalizadas.
config/               Configuracion Laravel, base de datos, JWT, mail y servicios.
database/
  migrations/         Estructura de tablas.
  seeders/            Datos de ejemplo o carga inicial.
public/               Punto de entrada web y assets compilados.
resources/
  js/                 JavaScript fuente.
  sass/               Estilos fuente.
  views/              Vista web para generar tickets.
routes/               Rutas web y API.
tests/                Pruebas de funcionalidad.
```

## Seguridad

- No guardes contrasenas, tokens, claves API ni credenciales en el codigo.
- Usa `.env` para configuracion sensible.
- No subas `.env` al repositorio.
- Manten `.env.example` solo con valores ficticios.
- Genera `APP_KEY` y `JWT_SECRET` por entorno.
- Revisa las rutas publicas antes de usar el proyecto en produccion, porque varios endpoints de carga de catalogos no estan protegidos actualmente por JWT.

Si encuentras una vulnerabilidad, reportala de forma responsable al mantenedor del repositorio.

## Pruebas

El proyecto contiene pruebas en `tests/Feature`.

Comando habitual en Laravel:

```bash
php artisan test
```

Tambien puede ejecutarse PHPUnit directamente si el entorno esta configurado:

```bash
vendor/bin/phpunit
```

Algunas pruebas contienen cuerpos comentados, por lo que la cobertura real puede ser limitada.

## Estado del proyecto

El proyecto parece una version inicial funcional o prototipo avanzado. Tiene modelos, migraciones, controladores y rutas para el flujo principal, pero tambien conserva metodos vacios, pruebas comentadas y una interfaz web limitada al ticket de venta.

No hay evidencia suficiente para declararlo listo para produccion sin una revision adicional de seguridad, pruebas y permisos de rutas.

## Limitaciones actuales

- No existe un panel administrativo completo; la mayoria de operaciones se realizan por API.
- Varias rutas de creacion de catalogos y ventas son publicas en `routes/api.php`.
- No se observa recuperacion de contrasena implementada en las rutas actuales.
- Los metodos `index`, `edit`, `update` o `destroy` de varios controladores estan vacios.
- `DatabaseSeeder.php` no carga automaticamente los seeders existentes.
- Las pruebas automatizadas tienen casos comentados y cobertura limitada.
- La vista web se centra en consultar ventas y generar tickets; no cubre toda la administracion del sistema.

## Proximas mejoras

- Proteger endpoints administrativos con autenticacion y autorizacion.
- Agregar un panel administrativo para catalogos, promociones, reglas y premios.
- Completar pruebas automatizadas para el flujo de venta, ticket, puntos y premios.
- Conectar los seeders desde `DatabaseSeeder`.
- Documentar ejemplos de payload para cada endpoint.
- Agregar capturas reales de la vista de ticket.
- Implementar recuperacion de contrasena si el flujo de usuarios lo requiere.

## Contribuciones

1. Haz un fork del repositorio.
2. Crea una rama para tu cambio:

```bash
git checkout -b feature/nueva-funcionalidad
```

3. Realiza cambios pequenos y enfocados.
4. Ejecuta migraciones y pruebas cuando aplique:

```bash
php artisan migrate
php artisan test
```

5. Verifica que no agregaste `.env`, credenciales, dumps de base de datos ni archivos generados innecesarios.
6. Abre un Pull Request describiendo el problema resuelto y los cambios realizados.

## Licencia

Este proyecto todavia no incluye un archivo `LICENSE`. Antes de publicarlo o aceptar contribuciones externas, conviene definir una licencia explicita.
