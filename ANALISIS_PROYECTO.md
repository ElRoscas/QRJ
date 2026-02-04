# Análisis del Proyecto QRJ - Laravel

## 📋 Resumen Ejecutivo

**QRJ** es un proyecto Laravel diseñado para gestionar eventos (Esdeveniments) con sistema de control de invitados mediante códigos QR. El proyecto integra autenticación de usuarios, control de permisos y gestión de eventos.

---

## 🏗️ Arquitectura General

### Stack Tecnológico
- **Framework**: Laravel 11+
- **Frontend**: Blade Templates + Livewire + Volt
- **Base de Datos**: MySQL/PostgreSQL
- **Autenticación**: Laravel Fortify
- **Build Tool**: Vite
- **Package Manager**: Composer (PHP), npm (JS)

---

## 🔐 Autenticación y Autorización

### Sistema de Autenticación
- **Método**: Laravel Fortify (autenticación integrada)
- **Autenticación de dos factores**: Habilitada
- **Campo primario de Usuario**: `Correu` (email)
- **Tabla de Usuarios**: `usuari`

### Sistema de Permisos
- **Tabla**: `permissos`
- **Código de Permisos**: String de 5 caracteres (ej: "11111" = Admin Total)
- **Estructura**:
  ```
  ID_Permissos -> ID único
  ID_Usuari -> Referencia a usuari.Correu
  PermCode -> Código de permisos (00000 a 11111)
  ```

### Roles Identificados
1. **Admin (PermCode = "11111")**
   - Acceso completo a todas las funcionalidades
   - Gestión de eventos
   - Control de usuarios
   - Lector QR

2. **Usuario Normal (sin permisos admin)**
   - Ver eventos (própios)
   - Ver menú de usuario
   - Funcionalidades limitadas

---

## 🗄️ Modelos de Datos

### 1. Usuario (usuari)
```php
- Correu (string, PK) - Email único
- Nom (string) - Nombre completo
- Contrasenya (string) - Contraseña hasheada
- Curs (string, nullable) - Curso/Nivel
- remember_token
- two_factor_secret
- two_factor_recovery_codes
- two_factor_confirmed_at
- timestamps (created_at, updated_at)
```

**Relaciones**:
- `hasMany(Permis)` - Un usuario puede tener múltiples permisos
- `hasMany(Esdeveniment)` - Un usuario crea múltiples eventos

### 2. Eventos (esdeveniments)
```php
- id (int, PK)
- ID_USER (string, FK) -> usuari.Correu
- Nom (string) - Nombre del evento
- Tipus (string) - Tipo de evento
- Nº_Invitats (int) - Número de invitados
- Nº_VIPS (int, nullable) - VIPs
- Descripcio (text, nullable) - Descripción
- Ubicacio (string) - Ubicación
- Data_Esdeveniment (date) - Fecha del evento
- Hora_Inici (time) - Hora de inicio
- Data_Limit_Confirmacio (date) - Fecha límite de confirmación
- timestamps (created_at, updated_at)
```

**Relaciones**:
- `belongsTo(User)` - Pertenece a un usuario

### 3. Permisos (permissos)
```php
- ID_Permissos (int, PK)
- ID_Usuari (string, FK) -> usuari.Correu
- PermCode (string, 5 chars) - Código de permisos
- timestamps (created_at, updated_at)
```

**Relaciones**:
- `belongsTo(User)` - Pertenece a un usuario

---

## 🛣️ Estructura de Rutas

### Rutas Públicas
```
GET  /                          -> Redirige según autenticación
GET  /login                     -> Formulario de login
POST /login                     -> Procesar login
POST /logout                    -> Cerrar sesión
GET  /register                  -> Formulario de registro
POST /register                  -> Procesar registro
GET  /registre                  -> Redirect a /register (compatibilidad)
```

### Rutas de Preview (sin autenticación - desarrollo)
```
GET /preview/menu-admin
GET /preview/menu-user
GET /preview/esdevenent
GET /preview/control-usuaris
GET /preview/info-usuaris
GET /preview/crear-esdeveniment
GET /preview/control-convidats
GET /preview/graduacio
```

### Rutas Protegidas - Usuario Normal (auth)
```
GET  /menu-user                        -> Vista menú usuario
GET  /esdeveniments                   -> Listar eventos
GET  /esdeveniments/llistar           -> Alias para listar
```

### Rutas Protegidas - Admin (auth + admin.perm)
```
GET  /menu-admin                       -> Menú administrador
GET  /admin/esdeveniments             -> Listar eventos (admin)
GET  /admin/esdeveniments/crear       -> Formulario crear evento
POST /admin/esdeveniments             -> Guardar evento
GET  /admin/esdeveniments/{id}/editar -> Formulario editar evento
PUT  /admin/esdeveniments/{id}        -> Actualizar evento
DELETE /admin/esdeveniments/{id}      -> Eliminar evento
GET  /lector-qr                        -> Control de acceso/Lector QR
GET  /dashboard                        -> Dashboard (verified)
GET  /settings/profile                 -> Editar perfil (Volt)
GET  /settings/password                -> Cambiar contraseña (Volt)
GET  /settings/appearance              -> Apariencia (Volt)
GET  /logout                           -> Logout rápido (testing)
```

---

## 🔄 Flujo de la Aplicación

### 1. Acceso Inicial
```
Usuario no autenticado
    ↓
GET / (index)
    ↓
¿Autenticado?
    ├─ NO → Mostrar vista 'welcome'
    └─ SÍ → ¿PermCode = '11111'?
        ├─ SÍ → Redirigir a /menu-admin
        └─ NO → Redirigir a /menu-user
```

### 2. Proceso de Login
```
Usuario visita GET /login
    ↓
Envía credenciales POST /login (LoginController)
    ↓
Valida contraseña contra usuari.Contrasenya
    ↓
¿Autenticado?
    ├─ NO → Vuelve a /login con error
    └─ SÍ → Sesión iniciada
        ↓
    Redirige según permisos (admin o user)
```

### 3. Proceso de Registro
```
Usuario visita GET /register
    ↓
Completa formulario CustomRegisterController
    ↓
POST /register (CustomRegisterController)
    ↓
Valida datos
    ↓
Crea usuario en tabla 'usuari'
    ↓
Asigna permisos por defecto (opcional)
    ↓
Redirige a login
```

### 4. Gestión de Eventos (Admin)
```
Admin accede a /admin/acontecimientos
    ↓
Middleware: auth + admin.perm
    ↓
EsdevenimentController@index
    ├─ Carga eventos: Esdeveniment::with('user')->orderBy('Data_Esdeveniment')
    └─ Pasa a vista 'esdeveniments'
    ↓
GET /admin/acontecimientos/crear
    ↓
EsdevenimentController@create
    └─ Muestra vista 'CrearEsdeveniments'
    ↓
POST /admin/acontecimientos (store)
    ├─ Valida datos
    ├─ Crea evento: Esdeveniment::create([...])
    │  └─ ID_USER = Auth::user()->Correu
    └─ Redirige a lista con mensaje 'success'
    ↓
Edición/Eliminación similar con edit(), update(), destroy()
```

### 5. Lector QR (Admin)
```
Admin accede a /lector-qr
    ↓
Middleware: auth + admin.perm
    ↓
GET /lector-qr
    └─ Muestra componente Livewire 'qr'
    ↓
Componente QR:
    ├─ Captura/escanea código QR
    ├─ Procesa datos del QR
    └─ Actualiza control de asistencia
```

---

## 📁 Estructura de Carpetas Clave

```
QRJ-Project/
├── app/
│   ├── Models/
│   │   ├── User.php              (Modelo Usuario - PK: Correu)
│   │   ├── Esdeveniment.php      (Modelo Eventos)
│   │   └── Permis.php            (Modelo Permisos)
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── EsdevenimentController.php  (CRUD Eventos)
│   │   │   └── Auth/
│   │   │       ├── LoginController.php
│   │   │       └── CustomRegisterController.php
│   │   │
│   │   └── Middleware/
│   │       ├── EnsureAdminPerm.php         (Verifica admin)
│   │       └── RedirectAfterLogin.php
│   │
│   ├── Livewire/
│   │   └── Actions/               (Acciones Livewire)
│   │
│   └── Providers/
│       ├── AppServiceProvider.php
│       ├── FortifyServiceProvider.php
│       └── VoltServiceProvider.php
│
├── config/
│   ├── auth.php                  (Configuración auth)
│   ├── fortify.php               (Configuración Fortify)
│   └── ...
│
├── database/
│   ├── migrations/
│   │   ├── *_create_usuari_table.php
│   │   ├── *_create_permissos_table.php
│   │   └── *_create_esdeveniments_table.php
│   │
│   └── seeders/
│       └── (Seeders para datos iniciales)
│
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php      (Página inicial pública)
│   │   ├── menu_admin.blade.php
│   │   ├── menu_user.blade.php
│   │   ├── encara_menu.blade.php
│   │   ├── control_usuaris.blade.php
│   │   ├── control_convidats.blade.php
│   │   ├── info_user.blade.php
│   │   ├── graduacio.blade.php
│   │   ├── CrearEsdeveniments.blade.php
│   │   ├── esdeveniments.blade.php
│   │   └── livewire/
│   │       ├── menu.blade.php
│   │       ├── qr.blade.php       (Lector QR)
│   │       └── ...
│   │
│   ├── css/                       (Estilos)
│   ├── js/                        (JavaScript)
│   │
├── routes/
│   ├── web.php                   (Rutas principales)
│   └── console.php
│
├── storage/                       (Logs, caché, uploads)
├── tests/                         (Pruebas unitarias/feature)
└── vendor/                        (Dependencias)
```

---

## 🔌 Middleware Principal

### `EnsureAdminPerm`
```php
// Ubicación: app/Http/Middleware/EnsureAdminPerm.php

Comprobaciones:
1. ¿Usuario autenticado? → NO: Redirige a /login
2. ¿PermCode = '11111'?
   ├─ SÍ → Continúa (next request)
   └─ NO → Redirige a /menu_user con mensaje
```

**Uso**:
```php
Route::middleware(['auth', 'admin.perm'])->group(function () {
    // Rutas solo para admin
});
```

---

## 📊 Dependencias Principales

### Composer (Backend)
- **laravel/framework** - Framework principal
- **laravel/fortify** - Autenticación
- **livewire/livewire** - Componentes interactivos
- **livewire/volt** - Componentes con sintaxis simplificada

### NPM (Frontend)
- **vite** - Build tool
- **@tailwindcss/forms** - Estilos formularios
- **axios** - HTTP client

---

## 🚀 Funcionalidades Principales

### 1. Autenticación
- ✅ Login/Logout
- ✅ Registro de usuarios
- ✅ Autenticación de 2 factores
- ✅ Recuperación de contraseña

### 2. Gestión de Eventos
- ✅ Crear eventos (Admin)
- ✅ Editar eventos (Admin)
- ✅ Eliminar eventos (Admin)
- ✅ Listar eventos
- ✅ Filtrar por fecha

### 3. Control de Invitados
- ✅ Lector de códigos QR
- ✅ Control de asistencia
- ✅ Gestión de invitados

### 4. Gestión de Usuarios
- ✅ Control de usuarios (Admin)
- ✅ Asignación de permisos
- ✅ Visualización de perfiles

### 5. Graduación
- ✅ Gestión de graduaciones
- ✅ Vista de graduación

---

## 🔑 Puntos Clave de Funcionamiento

### 1. Autenticación Personalizada
- Campo primario: **email (Correu)**, no ID numérico
- Validación: Compara `Contrasenya` hasheada

### 2. Sistema de Permisos
- Basado en tabla `permissos` (No Laravel Gates/Policies nativas)
- PermCode = "11111" = Admin total
- Flexible: permite agregar más códigos de permiso

### 3. Relaciones Clave
```
Usuario (1) ──→ (N) Permisos
Usuario (1) ──→ (N) Eventos
```

### 4. Protección de Rutas
```
Públicas: /login, /register, /
Autenticadas: /menu-user, /evenimente
Admin: /menu-admin, /admin/*, /lector-qr
```

---

## 📝 Datos de Ejemplo

### Admin Creado por Seeder
```
Email: admin@lasalle.cat
Password: admin123
PermCode: 11111 (Admin completo)
```

---

## 🔍 Archivos de Configuración Documentales

- **BASEDADES.md** - Documentación de la base de datos
- **CONFIGURACION_AUTH.md** - Configuración de autenticación
- **ESTRUCTURA.md** - Estructura del proyecto original (antes de Laravel)

---

## 🛠️ Flujo de Desarrollo Recomendado

1. **Para nuevas funcionalidades**:
   - Crear migraciones en `database/migrations/`
   - Crear modelos en `app/Models/`
   - Crear controladores en `app/Http/Controllers/`
   - Definir rutas en `routes/web.php`
   - Crear vistas en `resources/views/`

2. **Para proteger rutas**:
   - Usar middleware `auth` para rutas autenticadas
   - Usar middleware `admin.perm` para rutas admin
   - O crear nuevos middlewares personalizados

3. **Para controlar permisos granulares**:
   - Extender el sistema `permissos` actual
   - Analizar PermCode (ej: [Admin][User][Event][QR][etc])
   - Crear más middlewares específicos

---

## ⚠️ Notas Importantes

1. **Convención de Nombres**: El proyecto mezcla catalán e inglés en nombres de tablas y vistas
2. **Primary Key Personalizado**: Usuario usa email como PK, no ID numérico
3. **Timestamps**: Habilitados en usuarios y eventos
4. **Soft Deletes**: No configurados actualmente (borrados permanentes)
5. **Rutas de Preview**: Existen para desarrollo sin necesidad de autenticación

