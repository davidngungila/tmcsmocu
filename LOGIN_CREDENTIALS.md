# Login Credentials

After running the database seeders, you can use the following credentials to log in:

## Test Users

### 1. Priest (Full Access)
- **Email:** `priest@church.com`
- **Password:** `password123`
- **Role:** Priest / Church Father
- **Access:** Full access to all features

### 2. Church Leader (Limited Admin)
- **Email:** `leader@church.com`
- **Password:** `password123`
- **Role:** Church Leadership Team
- **Access:** View reports, manage events, view parishioners

### 3. Secretary (Secretary)
- **Email:** `secretary@church.com`
- **Password:** `password123`
- **Role:** Church Secretary
- **Access:** Create parishioners, create events, create SMS

### 4. Treasurer (Treasurer)
- **Email:** `treasurer@church.com`
- **Password:** `password123`
- **Role:** Church Treasurer
- **Access:** Manage finance, view reports, approve SMS

### 5. System Admin
- **Email:** `admin@church.com`
- **Password:** `admin123`
- **Role:** System Administrator
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

All test users have the default password: **`password123`** (except admin: `admin123`)

⚠️ **Important:** Change these passwords in production!

## System Changes Made

✅ **Translated to English:**
- Participant types: `regular_member`, `youth`, `choir`, `guest`, `minister`, `usher`, `media`, `security`, `protocol`
- Event types: `regular_mass`, `special_mass`, `wedding_mass`, `funeral_mass`, `confirmation_mass`, etc.
- Role names: `Priest`, `Church Leader`, `Secretary`, `Treasurer`, `System Admin`

✅ **Sample Users Created:**
- Father John Smith (Priest)
- Michael Johnson (Church Leader)  
- Sarah Williams (Secretary)
- David Brown (Treasurer)
- System Administrator

