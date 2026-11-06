# YTX Tools Hub — Installation Guide

## Requirements

- PHP 8.x recommended (PHP 7.4+ may work with a compatible `str_contains` polyfill)
- MySQL 5.7+ or MariaDB 10.x
- Apache/Nginx hosting

## 1. Upload files

Upload the project files to your hosting public folder (`public_html`, `htdocs`, or equivalent).

## 2. Create and import the database

Create a MySQL/MariaDB database and user, grant all privileges, then import:

```text
database/ytx_tools.sql
```

The snapshot removes the previous placeholder tools and seeds six local YTX utilities: JSON Formatter, Base64 Encoder, URL Encoder, UUID Generator, Color Converter and Password Generator.

## 3. Configure the database

Open `includes/config.php` and update `DB_HOST`, `DB_USER`, `DB_PASS` and `DB_NAME` with your hosting credentials.

## 4. Admin panel

Open `/admin/` after upload. The default development login is `admin` / `admin123`; change it immediately from **Change Password**.

## Admin features

- Add, edit, activate, deactivate and delete tools.
- Every tool uses an internal page path and opens in the YTX viewer; external redirects are blocked.
- Upload tool icons directly from the admin form; image URLs are not required.
- Upload the site logo, favicon and fallback banner directly from Site Settings.
- Upload banner artwork directly from Sliding Banners; banner links remain optional CTA links.
- Configure site name, tagline, footer, menu, colors, animations and maintenance mode.

## Privacy

The included utility tools run in the visitor's browser. Text, JSON, URLs and generated passwords are not submitted to a third-party tool site.

## Security

Change the default admin password, use HTTPS in production, keep database credentials private, verify the upload folder is writable, and remove public database dumps after deployment.
