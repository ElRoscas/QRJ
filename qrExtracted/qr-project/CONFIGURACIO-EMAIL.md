# Configuració del Correu Electrònic

## Situació Actual
📧 El sistema està configurat per guardar els correus al log (`MAIL_MAILER=log`)
📝 Els correus es guarden a: `storage/logs/laravel.log`

## Per enviar correus reals (Gmail, Mailtrap, etc.)

### Opció 1: Gmail (Producció)

Edita el fitxer `.env` i canvia:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=el_teu_correu@gmail.com
MAIL_PASSWORD=la_teva_contrasenya_aplicacio
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=el_teu_correu@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Important:** Per Gmail necessites crear una "Contrasenya d'aplicació":
1. Ves a https://myaccount.google.com/security
2. Activa la verificació en dos passos
3. Crea una "Contrasenya d'aplicació"
4. Utilitza aquesta contrasenya a `MAIL_PASSWORD`

---

### Opció 2: Mailtrap (Desenvolupament/Proves)

Mailtrap és perfecte per proves, captura tots els correus sense enviar-los realment.

1. Crea un compte gratuït a: https://mailtrap.io
2. Copia les credencials SMTP
3. Edita `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=les_teves_credencials
MAIL_PASSWORD=la_teva_contrasenya
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

### Opció 3: MailHog (Local)

Per proves locals sense registre:

1. Descarrega MailHog: https://github.com/mailhog/MailHog/releases
2. Executa `MailHog.exe`
3. Edita `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

4. Obre http://localhost:8025 per veure els correus

---

## Provar l'enviament

Un cop configuris el correu:

1. Neteja la cache:
```bash
php artisan config:clear
```

2. Ves a: http://localhost:8000/qr/create
3. Omple el formulari amb el teu correu
4. Hauries de rebre el QR per email!

---

## Debugging

Si hi ha errors:

1. Revisa els logs: `storage/logs/laravel.log`
2. Verifica les credencials al `.env`
3. Assegura't que `php artisan config:clear` s'ha executat

---

## Nota

Per defecte, els correus es guarden al log per seguretat.
Això et permet desenvolupar sense preocupar-te d'enviar correus reals.
