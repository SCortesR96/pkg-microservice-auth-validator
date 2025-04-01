# MicroServiceAuthValidatorPackage

Este paquete proporciona middleware para la validación de tokens JWT y permisos en microservicios desarrollados en Laravel.

## Instalación

Puedes instalar este paquete a través de Composer ejecutando el siguiente comando:

```sh
composer require mydevzone/microservice-auth-validator
```

Si estás utilizando este paquete en un entorno de desarrollo local sin publicación en Packagist, asegúrate de agregarlo en el `composer.json` de tu proyecto:

```json
"repositories": [
    {
        "type": "path",
        "url": "../Packages/MyDevZone/MicroServiceAuthValidatorPackage"
    }
]
```

Luego, ejecuta:

```sh
composer require mydevzone/microservice-auth-validator:dev-main
```

## Configuración

Después de instalar el paquete, Laravel detectará automáticamente el `JwtAuthServiceProvider`. Sin embargo, si necesitas registrarlo manualmente, agrégalo en `config/app.php` dentro de la sección `providers`:

```php
'providers' => [
    MyDevZone\Providers\JwtAuthServiceProvider::class,
],
```

### Publicación de Configuración (Opcional)

Si deseas modificar la configuración del paquete, puedes publicarla con:

```sh
php artisan vendor:publish --tag=microservice-auth-validator-config
```

Esto creará un archivo en `config/microservice-auth.php` donde puedes ajustar los valores según tus necesidades.

## Uso

### Middleware JWT

Este middleware verifica que el token JWT sea válido antes de procesar la solicitud. Para aplicarlo en tus rutas, agrégalo en el archivo `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    'jwt.auth' => \MyDevZone\Middleware\JwtMiddleware::class,
];
```

Luego, úsalo en tus rutas:

```php
Route::get('/protected-route', [ProtectedController::class, 'index'])
    ->middleware('jwt.auth');
```

### Middleware de Permisos

Este middleware valida si el usuario tiene el permiso requerido para acceder a una ruta específica. Se agrega de la siguiente manera:

```php
protected $routeMiddleware = [
    'permission' => \MyDevZone\Middleware\PermissionMiddleware::class,
];
```

Para proteger rutas con permisos específicos:

```php
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('permission:admin-access');
```

## Métodos Disponibles en los Traits

Este paquete incluye traits reutilizables para manejar tokens y permisos:

- `DecodeToken.php`: Decodifica y obtiene información del token JWT.
- `ValidatePermission.php`: Valida los permisos de un usuario.

Ejemplo de uso en un controlador:

```php
use MyDevZone\Traits\DecodeToken;

class ExampleController extends Controller {
    use DecodeToken;

    public function index(Request $request) {
        $tokenData = $this->decode($request->header('Authorization'));
        return response()->json($tokenData);
    }
}
```

## Requerimientos

- PHP 8.2+
- Laravel 11+
- `firebase/php-jwt` para la validación de tokens JWT

## Licencia

Este paquete es de código abierto y se distribuye bajo la licencia MIT.

---

> Desarrollado por [My Dev Zone](https://github.com/MyDevZone).

