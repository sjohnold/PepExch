# PepExch Production Deployment Checklist

This document outlines the steps required to transition the PepExch Barter Platform from local development to a production environment.

## Phase 1: Environment Configuration

- [ ] **App Environment**: Ensure `APP_ENV=production` and `APP_DEBUG=false` in `.env`.
- [ ] **Security Keys**: Generate a fresh app key using `php artisan key:generate --force`.
- [ ] **URL Configuration**: Update `APP_URL` to the production domain (e.g., `https://pepexch.com`).
- [ ] **Database**: Configure production PostgreSQL/MySQL credentials. Ensure SSL is enabled for remote connections.

## Phase 2: Dependency Management

- [ ] **Composer**: Run `composer install --no-dev --optimize-autoloader`.
- [ ] **NPM**: Run `npm install` and `npm run build` to generate production assets (Vite/Inertia).
- [ ] **Caching**: Execute production optimization commands:
  - `php artisan config:cache`
  - `php artisan route:cache`
  - `php artisan view:cache`

## Phase 3: Database & Migrations

- [ ] **Backup**: Take a snapshot of the current database state.
- [ ] **Migrations**: Run `php artisan migrate --force` to ensure the schema is up to date.
- [ ] **Seeders**: If necessary, run specific production seeders (e.g., Roles/Permissions).

## Phase 4: Storage & Filesystem

- [ ] **Storage Link**: Ensure the public storage link exists: `php artisan storage:link`.
- [ ] **Permissions**: Verify that `storage/` and `bootstrap/cache/` are writable by the web server (e.g., `www-data`).
- [ ] **S3/Cloud**: If using external storage for images, verify AWS/DigitalOcean credentials.

## Phase 5: Infrastructure & Services

- [ ] **Queue Worker**: Setup a process monitor (like Supervisor) to run `php artisan queue:work`.
- [ ] **Scheduler**: Add the Laravel scheduler to the server's crontab:
  `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
- [ ] **Redis/Memcached**: Ensure the caching service is running and secured.

## Phase 6: Security Hardening

- [ ] **SSL/TLS**: Ensure an SSL certificate is installed (Let's Encrypt/Cloudflare).
- [ ] **Security Headers**: Verify the `SecurityHeaders` middleware is active (X-Frame-Options, HSTS, etc.).
- [ ] **Permissions**: Disable directory listing in the web server configuration (Nginx/Apache).
- [ ] **Firewall**: Ensure only ports 80, 443, and 22 are open to public traffic.

## Phase 7: Verification

- [ ] **Dashboard**: Verify the admin dashboard loads with barter metrics.
- [ ] **Offers**: Test creating a barter offer and performing a status transition.
- [ ] **Notifications**: Confirm that system emails/notifications are being dispatched correctly.
- [ ] **Logs**: Monitor `storage/logs/laravel.log` for any runtime errors.

---

**Last Updated**: May 2026
**Status**: Ready for Staging

