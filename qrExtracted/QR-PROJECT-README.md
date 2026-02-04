# Laravel QR Code Reader Project

Este proyecto implementa la lectura de códigos QR desde documentos PDF usando Laravel, siguiendo la guía de: https://oguzhankrcb.medium.com/reading-qr-codes-with-laravel-and-increasing-the-qr-reading-rate-with-image-processing-273970f3bd41

## ⚠️ REQUISITOS IMPORTANTES

### Extensiones PHP Requeridas:
- **Imagick** (ext-imagick) - REQUERIDA pero NO instalada actualmente
- **ZBar** - Herramienta para leer códigos QR

### Instalación de Dependencias del Sistema:

#### Windows:
1. **Instalar ImageMagick:**
   - Descargar de: https://imagemagick.org/script/download.php
   - Durante la instalación, marcar "Install development headers and libraries"

2. **Instalar la extensión Imagick para PHP:**
   - Descargar DLL desde: https://pecl.php.net/package/imagick
   - Copiar `php_imagick.dll` a la carpeta de extensiones de PHP
   - Agregar `extension=imagick` en `php.ini`
   - Reiniciar el servidor web

3. **Instalar ZBar:**
   - Descargar desde: https://zbar.sourceforge.net/download.html
   - Agregar al PATH del sistema

#### macOS (con Homebrew):
```bash
brew install pkg-config imagemagick
brew install zbar
/opt/homebrew/opt/php@8.1/bin/pecl install imagick
```

#### Linux (Ubuntu/Debian):
```bash
sudo apt-get install imagemagick libmagickwand-dev zbar-tools
sudo pecl install imagick
```

## 📦 Paquetes Instalados

- `simplesoftwareio/simple-qrcode` ~4 - Generación de códigos QR
- `laraveldaily/laravel-invoices` - Generación de facturas
- `tarfin-labs/zbar-php` - **NO SE PUDO INSTALAR** (requiere ext-imagick)

## 🏗️ Estructura del Proyecto

```
app/
├── Services/
│   ├── InvoiceService/
│   │   ├── InvoiceService.php
│   │   └── InvoiceServiceProvider.php
│   ├── ImageProcessingService/
│   │   ├── ImageProcessingService.php
│   │   └── ImageProcessingServiceProvider.php
│   └── Facades/
│       ├── InvoiceService.php
│       └── ImageProcessingService.php
├── Http/Controllers/
│   ├── InvoiceController.php
│   └── ImageProcessingController.php
```

## 🚀 Rutas Disponibles

1. **GET /get-invoice** - Genera y descarga una factura PDF con código QR
2. **GET /process-qr-code** - Lee el código QR de la factura almacenada

## 📝 Uso

### 1. Generar Factura con QR:
```
http://localhost:8000/get-invoice
```
Esto descargará un PDF con un código QR incrustado.

### 2. Leer el QR Code (requiere extensiones instaladas):
Primero, guarda la factura generada en `storage/app/public/invoice.pdf`, luego:
```
http://localhost:8000/process-qr-code
```

## ⚙️ Configuración

Los ServiceProviders están registrados en:
- `bootstrap/providers.php`

Los Facades están registrados en:
- `config/app.php` (sección 'aliases')

## 🔧 Próximos Pasos CRÍTICOS

1. **Instalar ext-imagick** en tu sistema PHP
2. **Instalar ZBar** en tu sistema
3. Ejecutar nuevamente:
   ```bash
   composer require tarfin-labs/zbar-php
   ```
4. Verificar que todo funcione accediendo a las rutas

## 📚 Funcionalidades

### InvoiceService
- Genera facturas PDF con códigos QR
- Usa el paquete SimpleSoftwareIO para crear QR codes
- Embebe el QR en la plantilla de factura

### ImageProcessingService
- Extrae códigos QR de documentos PDF
- Recorta la región del QR para mejor lectura
- Aplica procesamiento de imagen si la lectura inicial falla:
  - Aplana capas de imagen
  - Convierte a escala de grises
  - Aplica umbralización para mejorar contraste

## ⚠️ Notas Importantes

- **El proyecto NO funcionará completamente** hasta que instales Imagick y ZBar
- Las rutas de procesamiento de QR lanzarán errores sin estas extensiones
- La generación de facturas SÍ funcionará (solo usa SimpleSoftwareIO)
- Asegúrate de crear el directorio `storage/app/public` si no existe

## 🐛 Troubleshooting

Si obtienes errores de "Class not found" para Imagick o Zbar:
1. Verifica que las extensiones estén instaladas: `php -m | grep imagick`
2. Reinicia el servidor después de instalar extensiones
3. Verifica el php.ini correcto con `php --ini`

## 📄 Licencia

Este proyecto sigue las mismas licencias que Laravel y los paquetes utilizados.
