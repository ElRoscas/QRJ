# 📧 Com Configurar Gmail per Enviar Correus

## Pas 1: Activar Verificació en 2 Passos

1. Ves a la teva compte de Google: https://myaccount.google.com/
2. Ves a **Seguretat** al menú lateral esquerre
3. Cerca **Verificació en 2 passos** i activa-la
4. Segueix els passos per activar-la (necessitaràs el teu telèfon)

## Pas 2: Generar Contrasenya d'Aplicació

1. Un cop activada la verificació en 2 passos, torna a **Seguretat**
2. Cerca **Contrasenyes d'aplicació** (App Passwords)
3. Selecciona:
   - **App:** Correu
   - **Dispositiu:** Ordinador Windows
4. Fes clic a **Generar**
5. Google et mostrarà una contrasenya de 16 caràcters (exemple: `abcd efgh ijkl mnop`)
6. **Copia aquesta contrasenya** (sense els espais)

## Pas 3: Configurar .env

Obre l'arxiu `.env` del projecte i actualitza:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=el_teu_correu@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_FROM_ADDRESS="el_teu_correu@gmail.com"
MAIL_FROM_NAME="Sistema QR"
```

**IMPORTANT:**
- `MAIL_USERNAME`: El teu correu de Gmail complet
- `MAIL_PASSWORD`: La contrasenya de 16 caràcters que has generat (sense espais)
- `MAIL_FROM_ADDRESS`: El mateix correu de Gmail

## Pas 4: Netejar Caché i Provar

Executa aquestes comandes al terminal:

```bash
cd "d:\DAM\Llubes PHP\laravel\qr-project"
php artisan config:clear
php artisan cache:clear
```

Ara ja pots provar d'enviar correus des de l'aplicació!

## 🧪 Alternativa: Mailtrap (per proves)

Si vols provar sense enviar correus reals, pots usar Mailtrap:

1. Registra't gratuïtament a https://mailtrap.io/
2. Crea un inbox
3. Copia les credencials SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=el_teu_username_mailtrap
MAIL_PASSWORD=la_teva_password_mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="Sistema QR"
```

Amb Mailtrap els correus no s'envien de veritat, només es capturen per poder-los veure.

## ⚠️ Problemes Comuns

### Error: "Invalid address"
- Revisa que `MAIL_FROM_ADDRESS` tingui el format correcte amb cometes dobles

### Error: "Authentication failed"
- Comprova que has copiat la contrasenya d'aplicació correctament (sense espais)
- Verifica que has activat la verificació en 2 passos

### Els correus no arriben
- Revisa la carpeta de SPAM/Correu no desitjat
- Comprova els logs: `storage/logs/laravel.log`
- Verifica que WAMP està executant-se

## 📝 Verificar Configuració

Pots provar la configuració amb aquesta comanda:

```bash
php artisan tinker
```

I després:

```php
Mail::raw('Prova de correu', function($message) {
    $message->to('el_teu_correu@gmail.com')->subject('Test');
});
```

Si retorna `null`, el correu s'ha enviat correctament!
