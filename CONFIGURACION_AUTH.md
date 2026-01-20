# Configuración de Autenticación - Sistema QRJ

## Cambios Realizados

Se ha configurado Laravel para trabajar con las tablas personalizadas de la base de datos:

### 1. Modelo User (`app/Models/User.php`)
- Configurado para usar la tabla `usuari` en lugar de `users`
- La clave primaria es `Correu` (email)
- Los campos son: `Nom`, `Correu`, `Contrasenya`, `Curs`
- Se añadieron accessors para mantener compatibilidad con Laravel (name, email, password)
- Relación con la tabla `permissos` configurada

### 2. Modelo Permis (`app/Models/Permis.php`)
- Creado para gestionar la tabla `permissos`
- Campos: `ID_Permissos`, `ID_Usuari`, `PermCode`
- Relación con User configurada

### 3. CreateNewUser (`app/Actions/Fortify/CreateNewUser.php`)
- Actualizado para crear registros en la tabla `usuari`
- Mapea los campos del formulario a los campos de la BD:
  - `name` → `Nom`
  - `email` → `Correu`
  - `password` → `Contrasenya`

## Configuración Requerida en .env

Asegúrate de tener configurado en tu archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=orles
DB_USERNAME=root
DB_PASSWORD=

# Si necesitas usar un charset específico:
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

## Estructura de la Base de Datos

### Tabla: `usuari`
```sql
- Correu (varchar(100)) - PRIMARY KEY
- Nom (varchar(255))
- Contrasenya (varchar(255)) - Se hashea automáticamente
- Curs (varchar(255), NULL permitido)
```

### Tabla: `permissos`
```sql
- ID_Permissos (int, AUTO_INCREMENT) - PRIMARY KEY
- ID_Usuari (varchar(100)) - FOREIGN KEY → usuari.Correu
- PermCode (varchar(5))
```

### Tabla: `sessions` (requerida por Laravel)
Si no existe, créala con:
```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id VARCHAR(100) NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);
```

## Funcionamiento

### Registro de Usuarios
1. El usuario completa el formulario en `/register` ([register.blade.php](c:\Users\usuari\Documents\GitHub\QRJ\QRJ-Project\resources\views\livewire\auth\register.blade.php))
2. Los datos se envían a `CreateNewUser`
3. Se valida que el email sea único en la tabla `usuari`
4. Se crea el registro con la contraseña hasheada automáticamente
5. El usuario queda autenticado

### Login de Usuarios
1. El usuario completa el formulario en `/login` ([login.blade.php](c:\Users\usuari\Documents\GitHub\QRJ\QRJ-Project\resources\views\livewire\auth\login.blade.php))
2. Laravel Fortify busca el usuario por el campo `Correu`
3. Verifica la contraseña contra `Contrasenya` (hasheada)
4. Si es correcto, inicia la sesión

### Funcionalidad "Recorda'm"
**NOTA:** Actualmente desactivada porque la tabla `usuari` no tiene columna `remember_token`.

Si quieres activarla:
```sql
ALTER TABLE usuari ADD COLUMN remember_token VARCHAR(100) NULL;
```

Y en [User.php](c:\Users\usuari\Documents\GitHub\QRJ\QRJ-Project\app\Models\User.php), cambiar:
```php
public function getRememberTokenName()
{
    return 'remember_token'; // En lugar de null
}
```

## Gestión de Permisos

Para asignar permisos a un usuario:

```php
use App\Models\User;
use App\Models\Permis;

// Obtener usuario
$user = User::where('Correu', 'usuario@example.com')->first();

// Crear permiso
Permis::create([
    'ID_Usuari' => $user->Correu,
    'PermCode' => 'ADMIN'
]);

// Obtener permisos de un usuario
$permisos = $user->permissos;
```

## Testing

Para probar la autenticación:

1. **Crear un usuario manualmente en phpMyAdmin:**
```sql
INSERT INTO usuari (Correu, Nom, Contrasenya) 
VALUES ('test@example.com', 'Usuario Test', '$2y$12$...');
```
Para generar el hash de la contraseña, ejecuta en terminal:
```bash
php artisan tinker
Hash::make('tu_contraseña')
```

2. **Probar el registro:**
- Ve a `http://localhost/register`
- Completa el formulario
- Verifica que se cree el registro en la tabla `usuari`

3. **Probar el login:**
- Ve a `http://localhost/login`
- Usa las credenciales creadas
- Deberías ser redirigido a `/menu-admin`

## Comandos Útiles

```bash
# Limpiar caché de configuración
php artisan config:clear

# Limpiar caché de rutas
php artisan route:clear

# Ver todas las rutas
php artisan route:list

# Probar conexión a BD en tinker
php artisan tinker
DB::connection()->getPdo()
```

## Solución de Problemas

### Error: "SQLSTATE[42S02]: Base table or view not found: 'users'"
Laravel todavía busca la tabla `users`. Verifica que:
- El modelo User esté correctamente configurado con `protected $table = 'usuari';`
- Hayas limpiado la caché: `php artisan config:clear`

### Error: "Column not found: 'email'"
El sistema está buscando la columna 'email' en lugar de 'Correu'.
- Verifica que los métodos `getAuthIdentifierName()` y `getAuthPassword()` estén en el modelo User

### Error: "These credentials do not match our records"
- Verifica que la contraseña esté hasheada en la BD
- Asegúrate de que el email sea correcto
- Verifica que `protected function casts()` tenga `'Contrasenya' => 'hashed'`

## Próximos Pasos Recomendados

1. **Crear middleware para verificar permisos:**
   - Verificar el `PermCode` de un usuario antes de permitir acceso a rutas admin

2. **Añadir campo Curs al formulario de registro** (si es necesario):
   - Añadir select con los cursos disponibles

3. **Implementar recuperación de contraseña:**
   - Requiere configurar la tabla `password_reset_tokens` y servicio de email
