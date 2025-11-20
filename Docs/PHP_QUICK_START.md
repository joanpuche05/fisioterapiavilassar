# PHP Quick Start Guide

## Installation Status ✅

**Version:** PHP 8.4.14
**Location:** `/opt/homebrew/opt/php/bin/php`
**Status:** Successfully installed via Homebrew

---

## Running Your Local Development Server

### Start the PHP Built-in Server

Navigate to your project directory and run:

```bash
cd /Users/joanpuche/Documents/Code/fisioterapiavilassar.com
php -S localhost:4321 router.php
```

Then visit in your browser:
- **Catalan (default):** http://localhost:4321/
- **Spanish:** http://localhost:4321/es

### Stop the Server

Press `Ctrl+C` in the terminal

---

## Common PHP Commands

```bash
# Check PHP version
php --version

# Display PHP information and installed extensions
php -i

# Run a PHP file directly
php filename.php

# Check if a specific extension is enabled
php -m | grep extension_name

# Lint (check for syntax errors) a PHP file
php -l filename.php
```

---

## PHP Configuration

**PHP Configuration File Location:**
```
/opt/homebrew/etc/php/8.4/php.ini
```

Edit this file if you need to change PHP settings like:
- Memory limits
- Upload file sizes
- Execution time limits
- Enabled extensions

---

## Important Note: URL Rewriting

**`.htaccess` URL rewriting will NOT work with PHP's built-in server** (it only works on Apache with `mod_rewrite` enabled).

### For Local Development:

When using `php -S localhost:4321 router.php`, the `router.php` script simulates `.htaccess` behavior:
- `http://localhost:4321/` → Catalan version (default)
- `http://localhost:4321/es` → Spanish version (rewritten internally)

If you run without `router.php`, you must access URLs directly:
- `http://localhost:4321/es?lang=es`

### For Production Hosting:

`.htaccess` URL rewriting will work on your shared hosting provider (if they have Apache with `mod_rewrite` enabled), so:
- `http://fisioterapiavilassar.com/` → Catalan version
- `http://fisioterapiavilassar.com/es` → Spanish version

---

## Testing Your Bilingual Implementation

### Phase A Implementation Checklist

Once you've created all the files from the PHP_LANGUAGE_IMPLEMENTATION_PLAN.md:

1. **Start the server:**
   ```bash
   php -S localhost:4321
   ```

2. **Test Catalan version:**
   - Open http://localhost:4321/
   - Verify Catalan content displays
   - Check form labels are in Catalan
   - Click language switcher → should attempt to navigate to Spanish

3. **Test Spanish version:**
   - Manually edit `index.php` to set `$lang = 'es'` temporarily
   - Reload page
   - Verify Spanish content displays
   - Verify language switcher shows Catalan option

4. **Test with different browsers:**
   - Chrome
   - Firefox
   - Safari
   - Mobile browser

5. **Check console for errors:**
   - Open browser DevTools (F12)
   - Check Console tab for any JavaScript errors
   - Check Network tab to ensure all assets load

---

## Setting Up PHP as a Service (Optional)

If you want PHP to run in the background automatically:

```bash
# Start PHP FPM service
brew services start php

# Stop PHP FPM service
brew services stop php

# Restart PHP FPM service
brew services restart php

# View running services
brew services list
```

**Note:** For development, the simple `php -S localhost:4321` approach is usually enough. You only need the service if you want PHP running permanently.

---

## Troubleshooting

### PHP command not found
If `php` command is not found, ensure Homebrew's PHP is in your PATH:

```bash
which php
# Should show: /opt/homebrew/bin/php

# If not, add to ~/.zshrc:
export PATH="/opt/homebrew/bin:$PATH"
```

### Port 4321 already in use
If port 4321 is already in use:

```bash
# Use a different port
php -S localhost:8000

# Or find and kill the process using 4321
lsof -i :4321
kill -9 <PID>
```

### JSON parsing errors in translations
Make sure your JSON files are valid:

```bash
# Check JSON syntax
php -r "json_decode(file_get_contents('translations/ca.json')); echo json_last_error_msg();"
php -r "json_decode(file_get_contents('translations/es.json')); echo json_last_error_msg();"
```

### Files not loading (CSS, images, etc.)
- Verify all files are in the correct directories
- Check file permissions: `ls -la`
- Verify paths in `includes/template.php` match your directory structure

---

## Next Steps

1. **Create the file structure:**
   ```bash
   mkdir -p includes translations
   ```

2. **Create all required files** following the PHP_LANGUAGE_IMPLEMENTATION_PLAN.md:
   - `.htaccess`
   - `index.php`
   - `includes/functions.php`
   - `includes/template.php`
   - `translations/ca.json`
   - `translations/es.json`

3. **Start the development server:**
   ```bash
   php -S localhost:4321
   ```

4. **Test and iterate:**
   - Visit http://localhost:4321/
   - Verify everything works
   - Make adjustments as needed

5. **Deploy to production** when ready using FTP/SFTP to your hosting provider

---

## Documentation References

- **PHP Implementation Plan:** `PHP_LANGUAGE_IMPLEMENTATION_PLAN.md`
- **Project Guidelines:** `CLAUDE.md`
- **Font Specifications:** `FONT_SPECIFICATIONS.md`

---

**Last Updated:** 2025-11-20
**PHP Version:** 8.4.14
**Status:** Ready for development
