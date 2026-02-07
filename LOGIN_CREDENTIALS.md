# Login Credentials

After running the database seeders, you can use the following credentials to log in:

## Test Users

### 1. Padri (Full Access)
- **Email:** `padri@example.com`
- **Password:** `password`
- **Role:** Padri / Baba wa Kanisa
- **Access:** Full access to all features

### 2. Viongozi (Limited Admin)
- **Email:** `viongozi@example.com`
- **Password:** `password`
- **Role:** Viongozi wa Chaptance
- **Access:** View reports, manage events, view parishioners

### 3. Katibu (Secretary)
- **Email:** `katibu@example.com`
- **Password:** `password`
- **Role:** Katibu
- **Access:** Create parishioners, create events, create SMS

### 4. Mweka Hazina (Treasurer)
- **Email:** `hazina@example.com`
- **Password:** `password`
- **Role:** Mweka Hazina
- **Access:** Manage finance, view reports, approve SMS

### 5. System Admin
- **Email:** `admin@example.com`
- **Password:** `password`
- **Role:** System Admin
- **Access:** Full system access

## How to Seed the Database

Run the following commands:

```bash
# Run migrations first
php artisan migrate

# Run seeders to create roles and users
php artisan db:seed
```

Or run everything at once:

```bash
php artisan migrate --seed
```

## Default Password

All test users have the default password: **`password`**

⚠️ **Important:** Change these passwords in production!

