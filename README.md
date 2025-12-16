# LMS Prototype

## Project structure
- `public/` – web root containing all front-facing pages, admin UI, borrower pages, shared themes, and static assets.
- `include/` – PHP bootstrap, configuration, and shared classes that sit outside the web root.
- `contact_log.txt` / `admin_messages.txt` – message logs stored alongside the project but outside the web root.
- `db_onlinelibrary.sql` – sample database schema and data.

## Running locally
- Point your web server or PHP built-in server to the `public/` directory (e.g., `php -S localhost:8000 -t public`).
