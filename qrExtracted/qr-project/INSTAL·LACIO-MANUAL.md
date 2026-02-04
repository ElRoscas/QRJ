# Guia d'Instal·lació Manual - Extensions QR Project

## Situació Actual
✅ ImageMagick instal·lat (via winget)
❌ Extensió PHP Imagick - NO instal·lada
❌ ZBar - NO instal·lat

## Opció 1: Script Automàtic (Recomanat)

1. Fes clic dret a `install-extensions.ps1`
2. Selecciona **"Executar amb PowerShell com a administrador"**
3. Segueix les instruccions que apareguin

## Opció 2: Instal·lació Manual Completa

### Pas 1: Instal·lar l'extensió PHP Imagick

**⚠️ PROBLEMA: No hi ha versió precompilada per PHP 8.3**

La versió més recent disponible és per PHP 8.1: `php_imagick-3.7.0-8.1-ts-vs16-x64.zip`

**Opcions:**

**A) Utilitzar alternativa PHP pura (RECOMANAT - JA INSTAL·LAT):**
- Ja tens `khanamiryan/qrcode-detector-decoder` instal·lat
- No requereix Imagick ni ZBar
- Veure més avall "Opció 4: Utilitzar implementació PHP pura"

**B) Esperar versió per PHP 8.3:**
- Estar pendent de: https://windows.php.net/downloads/pecl/releases/imagick/
- Pot trigar setmanes o mesos

**C) Baixar a PHP 8.1 (NO recomanat):**
- Hauries de canviar la versió de PHP a WAMP
- Descarrega: `php_imagick-3.7.0-8.1-ts-vs16-x64.zip`
- Després segueix els passos normals

**Mètode B - Si no trobes la versió exacta:**
```powershell
# Des de PowerShell com a administrador
cd C:\wamp64\bin\php\php8.3.14
.\php.exe -r "echo phpinfo();" | Select-String "Thread Safety"
# Si diu "enabled" necessites TS, si diu "disabled" necessites NTS
```

### Pas 2: Verificar Imagick

```powershell
php -m | findstr imagick
```

Si apareix "imagick", està instal·lat correctament ✓

### Pas 3: Instal·lar ZBar

**Windows - Opció Senzilla:**
1. Descarrega: https://sourceforge.net/projects/zbar/files/zbar/0.10/zbar-0.10-setup.exe
2. Executa l'instal·lador
3. Afegeix al PATH:
   - Botó Windows > "Variables d'entorn"
   - Edita "Path" del sistema
   - Afegeix: `C:\Program Files (x86)\ZBar\bin`
4. Reinicia el terminal

**Verificar ZBar:**
```powershell
zbarimg --version
```

### Pas 4: Instal·lar paquet PHP

Un cop Imagick i ZBar estiguin instal·lats:

```bash
cd "d:\DAM\Llubes PHP\laravel\qr-project"
composer require tarfin-labs/zbar-php
```

## Opció 3: Treballar sense processat d'imatge (simplificat)

Si només vols generar factures amb QR (sense llegir-los):

### Simplificar ImageProcessingService:

Comenta o elimina les referències a Imagick i ZBar. El servei `InvoiceService` ja funciona i generarà PDFs amb QR codes.

### Què funcionarà:
✅ Generar factures amb QR code (`/get-invoice`)
❌ Llegir QR codes des de PDFs (`/process-qr-code`)

---

## Opció 4: Utilitzar implementació PHP pura (✅ RECOMANAT per PHP 8.3)

### Ja tens instal·lat:
✅ `khanamiryan/qrcode-detector-decoder` - Llegeix QR amb PHP pur (sense Imagick/ZBar)

### Avantatges:
- ✅ NO requereix extensions del sistema
- ✅ Funciona amb PHP 8.3
- ✅ Més fàcil de configurar

### Desavantatges:
- ⚠️ Només llegeix imatges PNG/JPG directament
- ⚠️ Menys precís que ZBar amb PDFs complexos
- ⚠️ No fa processament avançat d'imatge

### Com utilitzar-lo:

Ja tens `ImageProcessingServiceAlternative.php` creat. Per activar-lo:

1. Edita `app/Http/Controllers/ImageProcessingController.php`:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Zxing\QrReader;

class ImageProcessingController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            // Primer necessites extreure el QR com a imatge
            // Per simplicitat, assumim que tens una imatge PNG
            $imagePath = storage_path('app/public/qr-code.png');
            
            $qrcode = new QrReader($imagePath);
            $text = $qrcode->text();
            
            return response()->json([
                'code' => $text,
                'method' => 'PHP Pure (Zxing)'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
```

### Limitacions:
- Cal convertir el PDF a imatge primer (pots fer-ho amb altres eines)
- O guardar el QR directament com a PNG quan el generes

## Verificació Final

```powershell
# 1. Verifica PHP extensions
php -m

# 2. Hauries de veure:
# - imagick
# - Altres extensions...

# 3. Verifica ZBar
zbarimg --version

# 4. Prova Laravel
cd "d:\DAM\Llubes PHP\laravel\qr-project"
php artisan serve

# 5. Ves a: http://localhost:8000/get-invoice
```

## Solució de Problemes

### Error: "Class 'Imagick' not found"
- L'extensió no està carregada
- Verifica que `extension=imagick` estigui al php.ini
- Reinicia Apache/WAMP

### Error: "ZbarError"
- ZBar no està instal·lat o no està al PATH
- Verifica: `zbarimg --version` al terminal

### La DLL no és vàlida
- Has descarregat la versió incorrecta (TS vs NTS, x64 vs x86)
- Comprova: `php -v` i busca "Thread Safety"

### "Unable to find vcruntime140.dll"
- Instal·la Visual C++ Redistributable:
  https://aka.ms/vs/17/release/vc_redist.x64.exe

## Contacte i Recursos

- **PECL Imagick**: https://pecl.php.net/package/imagick
- **ZBar**: https://zbar.sourceforge.net/
- **PHP Windows**: https://windows.php.net/downloads/pecl/

---

**Nota**: Un cop tot estigui instal·lat, el projecte funcionarà completament seguint l'article de Medium.
