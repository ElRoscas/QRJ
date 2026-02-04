# 📧 Com Enviar Correus REALS amb Resend

## 🚀 Passos (5 minuts):

### **Pas 1: Registra't a Resend**

1. Ves a: **https://resend.com/signup**
2. Registra't gratuïtament (amb GitHub o email)
3. Confirma el teu email

### **Pas 2: Crea una API Key**

1. Un cop dins, vés a **"API Keys"** al menú lateral
2. Fes clic a **"Create API Key"**
3. Dona-li un nom (exemple: "Laravel QR System")
4. Selecciona permisos: **"Sending access"**
5. Fes clic a **"Create"**
6. **COPIA la API Key** (comença per `re_...`)
   - ⚠️ Només es mostra un cop! Guarda-la bé

### **Pas 3: Configura l'API Key al .env**

Obre el fitxer `.env` i cerca:

```env
RESEND_API_KEY=re_123456789_TU_API_KEY_AQUI
```

Canvia-ho per la teva API Key real:

```env
RESEND_API_KEY=re_abc123def456...
```

### **Pas 4: (Opcional) Verifica el teu domini**

Per defecte, Resend envia correus des de `onboarding@resend.dev`. 

Si vols usar el TEU domini (exemple: `noreply@elteudomiini.com`):

1. Vés a **"Domains"** a Resend
2. Afegeix el teu domini
3. Configura els registres DNS que et demana
4. Un cop verificat, canvia al `.env`:

```env
MAIL_FROM_ADDRESS="noreply@elteudomiini.com"
```

**Si NO tens domini propi, deixa-ho així:**
```env
MAIL_FROM_ADDRESS="onboarding@resend.dev"
```

### **Pas 5: Neteja la caché i prova**

```bash
php artisan config:clear
```

Ara vés a http://localhost:8000/qr/create i prova d'enviar un QR al teu correu!

## ✅ Avantatges de Resend:

- ✨ **Gratuït**: 3.000 correus/mes (100/dia)
- 🚀 **Ràpid**: Els correus arriben en segons
- 📊 **Seguiment**: Pots veure si els correus s'han obert
- 🔒 **Segur**: No cal Gmail ni contrasenyes d'aplicació
- 💯 **Fiable**: No va a SPAM

## 🧪 Proves:

Un cop configurat, prova:

1. Ves a http://localhost:8000/qr/create
2. Omple el formulari
3. Posa el TEU correu a "Enviar per correu"
4. Fes clic a "Generar QR"
5. **Revisa la safata d'entrada** (hauria d'arribar en 5-10 segons)

## ⚠️ Problemes Comuns:

### "API key no vàlida"
- Comprova que has copiat la API key completa
- Verifica que no té espais al principi/final
- Executa `php artisan config:clear`

### "Els correus no arriben"
- Revisa la carpeta de SPAM
- Comprova que has posat bé el correu destinatari
- Verifica els logs a Resend Dashboard → "Logs"

### "Invalid from address"
- Si NO has verificat un domini, deixa: `MAIL_FROM_ADDRESS="onboarding@resend.dev"`
- Si has verificat un domini, usa: `MAIL_FROM_ADDRESS="tuemail@tudomini.com"`

## 📊 Veure els correus enviats:

Ves a https://resend.com/emails i veuràs tots els correus enviats, si s'han obert, etc.

---

**Això és tot! Ara els correus s'enviaran de VERITAT.** 🎉
