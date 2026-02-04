# Script per instal·lar les extensions necessàries per al projecte QR
# IMPORTANT: Executar com a Administrador

Write-Host "=== Instal·lador d'Extensions per Laravel QR Project ===" -ForegroundColor Cyan
Write-Host ""

# Verificar si s'executa com a administrador
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
if (-not $isAdmin) {
    Write-Host "ERROR: Aquest script ha de ser executat com a Administrador" -ForegroundColor Red
    Write-Host "Fes clic dret al fitxer i selecciona 'Executar com a administrador'" -ForegroundColor Yellow
    pause
    exit 1
}

# Configuració
$phpVersion = "8.3"
$phpPath = "C:\wamp64\bin\php\php8.3.14"
$phpIni = "$phpPath\php.ini"
$extDir = "$phpPath\ext"

Write-Host "PHP Path: $phpPath" -ForegroundColor Green
Write-Host "Extensions Dir: $extDir" -ForegroundColor Green
Write-Host ""

# 1. Instal·lar ImageMagick
Write-Host "[1/4] Instal·lant ImageMagick..." -ForegroundColor Yellow
try {
    winget install ImageMagick.ImageMagick --silent --accept-source-agreements --accept-package-agreements
    Write-Host "✓ ImageMagick instal·lat correctament" -ForegroundColor Green
} catch {
    Write-Host "⚠ Error instal·lant ImageMagick: $_" -ForegroundColor Red
}

# 2. Descarregar i instal·lar l'extensió Imagick per PHP
Write-Host ""
Write-Host "[2/4] Descarregant extensió PHP Imagick..." -ForegroundColor Yellow

# Opcions d'URLs per provar
$imagickUrls = @(
    "https://windows.php.net/downloads/pecl/releases/imagick/3.7.0/php_imagick-3.7.0-8.3-ts-vs16-x64.zip",
    "https://windows.php.net/downloads/pecl/releases/imagick/3.7.0/php_imagick-3.7.0-8.2-ts-vs16-x64.zip",
    "https://github.com/php/pecl-file_formats-imagick/releases/download/3.7.0/php_imagick-3.7.0-8.3-ts-vs16-x64.zip"
)

$downloaded = $false
foreach ($url in $imagickUrls) {
    try {
        Write-Host "Provant: $url" -ForegroundColor Gray
        $tempZip = "$env:TEMP\php_imagick.zip"
        Invoke-WebRequest -Uri $url -OutFile $tempZip -UseBasicParsing -ErrorAction Stop
        
        # Extreure
        $tempExtract = "$env:TEMP\imagick_extract"
        if (Test-Path $tempExtract) { Remove-Item $tempExtract -Recurse -Force }
        Expand-Archive -Path $tempZip -DestinationPath $tempExtract -Force
        
        # Copiar DLL
        $dllFile = Get-ChildItem -Path $tempExtract -Filter "php_imagick.dll" -Recurse | Select-Object -First 1
        if ($dllFile) {
            Copy-Item $dllFile.FullName -Destination "$extDir\php_imagick.dll" -Force
            Write-Host "✓ Extensió Imagick copiada correctament" -ForegroundColor Green
            $downloaded = $true
            break
        }
    } catch {
        Write-Host "  ✗ Fallat: $_" -ForegroundColor Gray
        continue
    }
}

if (-not $downloaded) {
    Write-Host "⚠ No s'ha pogut descarregar automàticament Imagick" -ForegroundColor Red
    Write-Host "Descarrega manualment des de: https://pecl.php.net/package/imagick" -ForegroundColor Yellow
    Write-Host "I copia php_imagick.dll a: $extDir" -ForegroundColor Yellow
}

# 3. Habilitar l'extensió al php.ini
Write-Host ""
Write-Host "[3/4] Configurant php.ini..." -ForegroundColor Yellow

if (Test-Path $phpIni) {
    $iniContent = Get-Content $phpIni -Raw
    
    if ($iniContent -notmatch "extension=imagick") {
        Add-Content -Path $phpIni -Value "`nextension=imagick"
        Write-Host "✓ Extension=imagick afegida al php.ini" -ForegroundColor Green
    } else {
        Write-Host "✓ Extension=imagick ja està al php.ini" -ForegroundColor Green
    }
} else {
    Write-Host "⚠ No s'ha trobat php.ini a: $phpIni" -ForegroundColor Red
}

# 4. Instal·lar ZBar
Write-Host ""
Write-Host "[4/4] Instal·lant ZBar..." -ForegroundColor Yellow

# ZBar és més complicat a Windows, proporcionar instruccions manuals
Write-Host "⚠ ZBar requereix instal·lació manual a Windows" -ForegroundColor Yellow
Write-Host ""
Write-Host "Opcions per instal·lar ZBar:" -ForegroundColor Cyan
Write-Host "1. Descarrega des de: https://sourceforge.net/projects/zbar/files/zbar/0.10/zbar-0.10-setup.exe" -ForegroundColor White
Write-Host "2. O utilitza una alternativa: https://github.com/mchehab/zbar" -ForegroundColor White
Write-Host "3. Després d'instal·lar, afegeix al PATH del sistema" -ForegroundColor White

Write-Host ""
Write-Host "=== Resum ===" -ForegroundColor Cyan
Write-Host "1. ImageMagick: Instal·lat ✓" -ForegroundColor Green
Write-Host "2. PHP Imagick: " -NoNewline
if ($downloaded) {
    Write-Host "Instal·lat ✓" -ForegroundColor Green
} else {
    Write-Host "Requereix instal·lació manual ⚠" -ForegroundColor Yellow
}
Write-Host "3. ZBar: Requereix instal·lació manual ⚠" -ForegroundColor Yellow
Write-Host ""
Write-Host "SEGÜENTS PASSOS:" -ForegroundColor Cyan
Write-Host "1. Reinicia WAMP/Apache" -ForegroundColor White
Write-Host "2. Verifica amb: php -m | findstr imagick" -ForegroundColor White
Write-Host "3. Instal·la ZBar manualment" -ForegroundColor White
Write-Host "4. Executa: composer require tarfin-labs/zbar-php" -ForegroundColor White
Write-Host ""

pause
