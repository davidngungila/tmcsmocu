# Fix 419 Page Expired Error

The 419 error is a CSRF token issue. Here are the solutions:

## Solution 1: Clear All Caches (Try this first)

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

## Solution 2: Check Session Configuration

The default session driver is 'database'. Make sure:

1. The sessions table exists (it should from the default Laravel migration)
2. Or change to 'file' driver in `.env`:

```env
SESSION_DRIVER=file
```

Then clear config:
```bash
php artisan config:clear
```

## Solution 3: Ensure APP_KEY is Set

```bash
php artisan key:generate
```

## Solution 4: Check Browser Cookies

- Clear browser cookies for `127.0.0.1:8002`
- Try in incognito/private mode
- Make sure cookies are enabled

## Solution 5: Verify Session Storage is Writable

If using 'file' driver, ensure `storage/framework/sessions` is writable:

```bash
# Windows (PowerShell)
icacls storage\framework\sessions /grant Users:F /T
```

## Solution 6: Check APP_URL in .env

Make sure APP_URL matches your actual URL:

```env
APP_URL=http://127.0.0.1:8002
```

Then:
```bash
php artisan config:clear
```

## Quick Fix (Recommended for Development)

Add to `.env`:
```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

Then:
```bash
php artisan config:clear
php artisan cache:clear
```

Restart your server and try again.

