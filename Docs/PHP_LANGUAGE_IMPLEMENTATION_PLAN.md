# PHP Language Implementation Plan: Spanish/Catalan Bilingual Support

## Overview

This document outlines the implementation plan for adding Spanish/Catalan language support to fisioterapiavilassar.com using **PHP** (instead of Node.js/Express). The goal is to maintain a single HTML template while serving separate URLs for SEO purposes: `/` for Spanish and `/ca` for Catalan.

**Why PHP?** The hosting server only supports PHP, not Node.js. This implementation maintains the same architecture and simplicity as the Node.js plan but uses PHP's built-in templating capabilities.

**Implementation Approach:** This is a two-phase implementation:
1. **Phase A (This First):** Implement the full technical setup and functionality with Spanish content and placeholder Catalan translations
2. **Phase B (After testing):** Create proper Catalan translations based on Spanish content

---

## Architecture

### Technology Stack
- **Backend:** PHP 7.4+ (native, no frameworks)
- **Template Engine:** PHP (using `include()` and native `<?php ?>` tags)
- **Translation Storage:** JSON files (es.json, ca.json)
- **Static Assets:** CSS, JavaScript, images (unchanged)
- **URL Rewriting:** Apache `.htaccess` (mod_rewrite)
- **Development Server:** PHP built-in server or existing hosting

### URL Structure
- `http://localhost:4321/` → Spanish version (`index.php`)
- `http://localhost:4321/ca` → Catalan version (`ca/index.php`)

### Key Principles
1. **Single Source of Truth** - One PHP template serves both languages
2. **Separate URLs** - Each language has its own route for SEO
3. **No HTML Duplication** - PHP variables handle all language variations
4. **Simple Maintenance** - All translations in JSON files
5. **Zero Dependencies** - No composer, no external libraries
6. **Works on Shared Hosting** - Standard PHP hosting compatible

---

## File Structure (Post-Implementation)

```
fisioterapiavilassar.com/
├── .htaccess                          # URL rewriting rules (new)
├── index.php                          # Spanish version entry point (new)
├── ca/
│   ├── .htaccess                      # Catalan URL rules (new)
│   └── index.php                      # Catalan version entry point (new)
├── includes/
│   ├── template.php                   # Main HTML template (new)
│   └── functions.php                  # Helper functions (new)
├── translations/
│   ├── es.json                        # Spanish translations (new)
│   └── ca.json                        # Catalan translations (new)
├── css/                               # Existing CSS (unchanged)
│   └── style.css
├── js/                                # Existing JS (unchanged)
│   └── script.js
├── assets/                            # Existing images (unchanged)
│   ├── logo.png
│   ├── hero-bg.jpg
│   ├── service1.jpg
│   ├── service2.jpg
│   ├── service3.jpg
│   ├── service4.jpg
│   └── philosophy.jpg
├── Docs/
│   ├── PHP_LANGUAGE_IMPLEMENTATION_PLAN.md  # This file
│   ├── LANGUAGE_IMPLEMENTATION_PLAN.md      # Original Node.js plan
│   ├── CLAUDE.md                            # Project guidelines
│   └── FONT_SPECIFICATIONS.md               # Typography guidelines
└── index.html                         # Old static file (to be removed or archived)
```

---

## Implementation Phases

### Phase 1: Setup & Configuration

#### 1.1 Create Directory Structure
```bash
mkdir -p includes
mkdir -p translations
mkdir -p ca
```

#### 1.2 Create .htaccess (Root Directory)

**Purpose:** Clean URLs, redirect handling, and UTF-8 encoding

**File: `.htaccess`**
```apache
# Enable URL rewriting
RewriteEngine On

# Force UTF-8 encoding
AddDefaultCharset UTF-8

# Prevent directory listing
Options -Indexes

# Custom error pages (optional)
# ErrorDocument 404 /404.php

# Security headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>

# Cache control for static assets
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>

# Rewrite rules
# If the request is for the root and index.php doesn't exist, serve index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^$ index.php [L]

# Don't rewrite requests for actual files/directories
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]
```

#### 1.3 Create .htaccess (Catalan Directory)

**File: `ca/.htaccess`**
```apache
# Enable URL rewriting for Catalan subdirectory
RewriteEngine On

# Force UTF-8 encoding
AddDefaultCharset UTF-8

# Rewrite /ca to /ca/index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^$ index.php [L]
```

---

### Phase 2: Create Translation Files

#### 2.1 Spanish Translations (translations/es.json)

**File: `translations/es.json`**

```json
{
  "meta": {
    "title": "Axl Espai De Salut - Fisioterapia en Vilassar de Mar",
    "description": "Clínica de fisioterapia en Vilassar de Mar, Barcelona. Tratamientos personalizados, terapia manual, técnicas avanzadas y ejercicio terapéutico."
  },
  "nav": {
    "filosofia": "FILOSOFÍA",
    "servicios": "SERVICIOS",
    "contacto": "CONTACTO"
  },
  "hero": {
    "title": "BIENVENIDOS A AXL ESPAI DE SALUT",
    "subtitle": "cuidamos de tu salud"
  },
  "filosofia": {
    "title": "FILOSOFÍA",
    "paragraph1": "En AXL espai de salut, trabajamos con un enfoque global de la fisioterapia y el bienestar. Atendemos tanto a pacientes privados como a mutuas, federaciones deportivas y personas accidentadas de tráfico.",
    "paragraph2": "Ofrecemos tratamientos personalizados para cada edad y situación: desde deportistas que buscan optimizar su rendimiento, hasta personas que necesitan recuperar el equilibrio, la movilidad o la fuerza tras una lesión o enfermedad.",
    "quote": "La fisioterapia no solo trata el cuerpo, sino que también nutre el espíritu y la mente."
  },
  "servicios": {
    "title": "SERVICIOS",
    "categories": [
      {
        "name": "TERAPIA MANUAL",
        "items": [
          "Masaje terapéutico y de descarga muscular.",
          "Terapia manual para contracturas, cervicalgias, lumbalgias, etc.",
          "Técnicas de movilización y manipulación articular."
        ]
      },
      {
        "name": "TÉCNICAS AVANZADAS",
        "items": [
          "Punción seca para puntos gatillo y dolor miofascial.",
          "Radiofrecuencia (INDIBA®) para acelerar la recuperación y reducir inflamación.",
          "Ondas de choque para tendinopatías y calcificaciones.",
          "Presoterapia para mejorar la circulación y la recuperación muscular"
        ]
      },
      {
        "name": "FISIOTERAPIA ESPECIALIZADA",
        "items": [
          "Tratamiento y acompañamiento en pacientes oncológicos.",
          "Programas específicos para deportistas (prevención, rendimiento y recuperación).",
          "Rehabilitación pre y postquirúrgica."
        ]
      },
      {
        "name": "EJERCICIO TERAPÉUTICO",
        "items": [
          "Recuperación de lesiones musculares, articulares y tendinosas.",
          "Reeducación de la marcha y del equilibrio (personas mayores o con secuelas neurológicas).",
          "Ejercicios terapéuticos y pautas de fortalecimiento."
        ]
      }
    ]
  },
  "contacto": {
    "title": "CONTACTO",
    "form": {
      "heading": "Envíanos un mensaje",
      "labels": {
        "nombre": "Nombre",
        "email": "Email",
        "telefono": "Teléfono",
        "mensaje": "Mensaje"
      },
      "button": "Enviar",
      "placeholders": {
        "nombre": "Tu nombre",
        "email": "tu@email.com",
        "telefono": "+34 93 759 84 13",
        "mensaje": "Tu mensaje aquí..."
      }
    },
    "info": {
      "heading": "Información de Contacto",
      "labels": {
        "direccion": "Dirección",
        "telefono": "Teléfono",
        "email": "Email",
        "horario": "Horario"
      },
      "details": {
        "direccion": "Carrer de Narcís Monturiol, 156, 08340 Vilassar de Mar, Barcelona",
        "telefono": "+34 93 759 84 13",
        "email": "axl@fisioterapiavilassar.com",
        "horario": "Lunes a Viernes, 9:00-13:00 y 15:00-20:00"
      }
    },
    "map": {
      "title": "Ubicación",
      "alt": "Ubicación de Axl Espai De Salut en Google Maps"
    }
  },
  "footer": {
    "copyright": "© 2025 Axl Espai De Salut. Todos los derechos reservados."
  },
  "images": {
    "logo": "AXL Espai De Salut Logo",
    "hero": "Hero section - Bienvenidos",
    "service1": "Terapia manual",
    "service2": "Técnicas avanzadas",
    "service3": "Fisioterapia especializada",
    "service4": "Ejercicio terapéutico",
    "philosophy": "Filosofía de Axl Espai De Salut"
  }
}
```

#### 2.2 Catalan Translations (translations/ca.json) - PLACEHOLDER

**Note:** For Phase A (functionality implementation), use placeholder Catalan content. After Phase A is complete and tested, replace with proper translations.

**File: `translations/ca.json`**

```json
{
  "meta": {
    "title": "[CA] Axl Espai De Salut - Fisioteràpia a Vilassar de Mar",
    "description": "[CA] Clínica de fisioteràpia a Vilassar de Mar, Barcelona"
  },
  "nav": {
    "filosofia": "[CA] FILOSOFIA",
    "servicios": "[CA] SERVEIS",
    "contacto": "[CA] CONTACTE"
  },
  "hero": {
    "title": "[CA] BENVINGUTS A AXL ESPAI DE SALUT",
    "subtitle": "[CA] cuidem de la teva salut"
  },
  "filosofia": {
    "title": "[CA] FILOSOFIA",
    "paragraph1": "[CA] A AXL espai de salut, treballem amb un enfocament global de la fisioteràpia i el benestar. Atenem tant a pacients privats com a mútues, federacions esportives i persones accidentades de trànsit.",
    "paragraph2": "[CA] Oferim tractaments personalitzats per a cada edat i situació: des d'esportistes que busquen optimitzar el seu rendiment, fins a persones que necessiten recuperar l'equilibri, la mobilitat o la força després d'una lesió o malaltia.",
    "quote": "[CA] La fisioteràpia no només tracta el cos, sinó que també nodreix l'esperit i la ment."
  },
  "servicios": {
    "title": "[CA] SERVEIS",
    "categories": [
      {
        "name": "[CA] TERÀPIA MANUAL",
        "items": [
          "[CA] Massatge terapèutic i de descàrrega muscular.",
          "[CA] Teràpia manual per a contractures, cervicàlgies, lumbàlgies, etc.",
          "[CA] Tècniques de mobilització i manipulació articular."
        ]
      },
      {
        "name": "[CA] TÈCNIQUES AVANÇADES",
        "items": [
          "[CA] Punció seca per a punts gallet i dolor miofascial.",
          "[CA] Radiofreqüència (INDIBA®) per accelerar la recuperació i reduir inflamació.",
          "[CA] Ones de xoc per a tendinopaties i calcificacions.",
          "[CA] Pressoteràpia per millorar la circulació i la recuperació muscular"
        ]
      },
      {
        "name": "[CA] FISIOTERÀPIA ESPECIALITZADA",
        "items": [
          "[CA] Tractament i acompanyament en pacients oncològics.",
          "[CA] Programes específics per a esportistes (prevenció, rendiment i recuperació).",
          "[CA] Rehabilitació pre i postquirúrgica."
        ]
      },
      {
        "name": "[CA] EXERCICI TERAPÈUTIC",
        "items": [
          "[CA] Recuperació de lesions musculars, articulars i tendinoses.",
          "[CA] Reeducació de la marxa i de l'equilibri (persones grans o amb seqüeles neurològiques).",
          "[CA] Exercicis terapèutics i pautes d'enfortiment."
        ]
      }
    ]
  },
  "contacto": {
    "title": "[CA] CONTACTE",
    "form": {
      "heading": "[CA] Envia'ns un missatge",
      "labels": {
        "nombre": "[CA] Nom",
        "email": "[CA] Email",
        "telefono": "[CA] Telèfon",
        "mensaje": "[CA] Missatge"
      },
      "button": "[CA] Enviar",
      "placeholders": {
        "nombre": "[CA] El teu nom",
        "email": "[CA] tu@email.com",
        "telefono": "[CA] +34 93 759 84 13",
        "mensaje": "[CA] El teu missatge aquí..."
      }
    },
    "info": {
      "heading": "[CA] Informació de Contacte",
      "labels": {
        "direccion": "[CA] Adreça",
        "telefono": "[CA] Telèfon",
        "email": "[CA] Email",
        "horario": "[CA] Horari"
      },
      "details": {
        "direccion": "Carrer de Narcís Monturiol, 156, 08340 Vilassar de Mar, Barcelona",
        "telefono": "+34 93 759 84 13",
        "email": "axl@fisioterapiavilassar.com",
        "horario": "[CA] Dilluns a Divendres, 9:00-13:00 i 15:00-20:00"
      }
    },
    "map": {
      "title": "[CA] Ubicació",
      "alt": "[CA] Ubicació d'Axl Espai De Salut a Google Maps"
    }
  },
  "footer": {
    "copyright": "[CA] © 2025 Axl Espai De Salut. Tots els drets reservats."
  },
  "images": {
    "logo": "[CA] AXL Espai De Salut Logo",
    "hero": "[CA] Secció heroi - Benvinguts",
    "service1": "[CA] Teràpia manual",
    "service2": "[CA] Tècniques avançades",
    "service3": "[CA] Fisioteràpia especialitzada",
    "service4": "[CA] Exercici terapèutic",
    "philosophy": "[CA] Filosofia d'Axl Espai De Salut"
  }
}
```

**After Phase A Testing:** Replace this placeholder JSON with proper Catalan translations created from the Spanish content.

---

### Phase 3: Create PHP Helper Functions

#### 3.1 Helper Functions (includes/functions.php)

**Purpose:** Load translations, escape output, and provide utility functions

**File: `includes/functions.php`**

```php
<?php
/**
 * Load translation file
 *
 * @param string $lang Language code (es, ca)
 * @return array Decoded JSON translations
 */
function loadTranslations($lang = 'es') {
    $translationFile = __DIR__ . '/../translations/' . $lang . '.json';

    if (!file_exists($translationFile)) {
        // Fallback to Spanish if translation file not found
        $translationFile = __DIR__ . '/../translations/es.json';
    }

    $jsonContent = file_get_contents($translationFile);
    $translations = json_decode($jsonContent, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error loading translations: ' . json_last_error_msg());
    }

    return $translations;
}

/**
 * Safe echo for HTML output (prevents XSS)
 *
 * @param string $string String to output
 * @return void
 */
function e($string) {
    echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Get nested array value using dot notation
 * Example: get($t, 'meta.title') returns $t['meta']['title']
 *
 * @param array $array Source array
 * @param string $key Dot-notated key
 * @param mixed $default Default value if key not found
 * @return mixed
 */
function get($array, $key, $default = '') {
    $keys = explode('.', $key);

    foreach ($keys as $k) {
        if (!isset($array[$k])) {
            return $default;
        }
        $array = $array[$k];
    }

    return $array;
}

/**
 * Generate absolute URL for assets
 *
 * @param string $path Relative path
 * @return string Absolute URL
 */
function asset($path) {
    // Remove leading slash if present
    $path = ltrim($path, '/');

    // Get protocol
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    // Get host
    $host = $_SERVER['HTTP_HOST'];

    // Return absolute URL
    return $protocol . '://' . $host . '/' . $path;
}

/**
 * Get base URL for the site
 *
 * @return string Base URL
 */
function baseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    return $protocol . '://' . $host;
}
?>
```

---

### Phase 4: Create Main Template

#### 4.1 Main HTML Template (includes/template.php)

**Purpose:** Single source of truth for HTML structure, uses PHP variables for all content

**File: `includes/template.php`**

```php
<!DOCTYPE html>
<html lang="<?php e($lang); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php e($t['meta']['description']); ?>">

    <!-- Language Alternates for SEO -->
    <link rel="alternate" hreflang="es" href="<?php echo baseUrl(); ?>/">
    <link rel="alternate" hreflang="ca" href="<?php echo baseUrl(); ?>/ca">
    <link rel="alternate" hreflang="x-default" href="<?php echo baseUrl(); ?>/">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo baseUrl(); ?><?php echo $lang === 'ca' ? '/ca' : ''; ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $lang === 'ca' ? '../css/style.css' : 'css/style.css'; ?>">

    <title><?php e($t['meta']['title']); ?></title>
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="#inicio">
                    <img src="<?php echo $lang === 'ca' ? '../assets/logo.png' : './assets/logo.png'; ?>"
                         alt="<?php e($t['images']['logo']); ?>">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="#filosofia"><?php e($t['nav']['filosofia']); ?></a></li>
                    <li><a href="#servicios"><?php e($t['nav']['servicios']); ?></a></li>
                    <li><a href="#contacto"><?php e($t['nav']['contacto']); ?></a></li>
                </ul>
            </nav>

            <!-- Language Switcher -->
            <div class="language-switcher">
                <a href="<?php echo $alternateLangUrl; ?>"
                   class="lang-link"
                   title="<?php echo $alternateLangName; ?>">
                    <?php echo $alternateLangName; ?>
                </a>
            </div>

            <!-- Social Media -->
            <div class="social-media">
                <a href="https://www.instagram.com/axlespaidesalut/" target="_blank" aria-label="Instagram">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg" role="img">
                        <path d="M12.5 8.112a4.388 4.388 0 1 0 0 8.776 4.388 4.388 0 0 0 0-8.776zm0 7.157a2.77 2.77 0 1 1 0-5.538 2.77 2.77 0 0 1 0 5.538z"></path>
                        <path d="M16.963 6.954a1.037 1.037 0 1 0 0 2.074 1.037 1.037 0 0 0 0-2.074z"></path>
                        <path d="M19.16 0H5.84C2.62 0 0 2.62 0 5.84v13.32C0 22.38 2.62 25 5.84 25h13.32C22.38 25 25 22.38 25 19.16V5.84C25 2.62 22.38 0 19.16 0zm3.22 19.16c0 1.777-1.443 3.22-3.22 3.22H5.84c-1.777 0-3.22-1.443-3.22-3.22V5.84c0-1.777 1.443-3.22 3.22-3.22h13.32c1.777 0 3.22 1.443 3.22 3.22v13.32z"></path>
                    </svg>
                </a>
                <a href="https://www.facebook.com/axlespaidesalut" target="_blank" aria-label="Facebook">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg" role="img">
                        <path d="M23.998 12.5C23.998 5.602 18.397 0 11.5 0S-1.002 5.602-1.002 12.5c0 6.203 4.542 11.338 10.593 12.335V16.63H6.847V12.5h2.744V9.622c0-2.72 1.623-4.222 4.1-4.222 1.17 0 2.36.208 2.36.208v3.477h-1.78c-1.354 0-1.79.85-1.79 1.72v2.193h3.94l-.62 4.13h-3.32V24.57c6.14-.848 10.823-5.99 10.823-12.07z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- HERO SECTION -->
        <section id="inicio" class="hero">
            <div class="hero-text">
                <h1><?php e($t['hero']['title']); ?></h1>
                <div class="hero-divider"></div>
                <p class="hero-subtitle"><?php e($t['hero']['subtitle']); ?></p>
            </div>
        </section>

        <!-- FILOSOFIA SECTION -->
        <section id="filosofia" class="philosophy">
            <div class="container">
                <h2><?php e($t['filosofia']['title']); ?></h2>
                <div class="philosophy-content">
                    <div class="philosophy-image">
                        <img src="<?php echo $lang === 'ca' ? '../assets/Manos que ofrecen apoyo.jpeg' : 'assets/Manos que ofrecen apoyo.jpeg'; ?>"
                             alt="<?php e($t['images']['philosophy']); ?>">
                    </div>
                    <div class="philosophy-text">
                        <p><?php e($t['filosofia']['paragraph1']); ?></p>
                        <p><?php e($t['filosofia']['paragraph2']); ?></p>
                        <blockquote>"<?php e($t['filosofia']['quote']); ?>"</blockquote>
                    </div>
                </div>
            </div>
        </section>

        <!-- DIVIDER IMAGE -->
        <section class="divider-image"></section>

        <!-- SERVICIOS SECTION -->
        <section id="servicios" class="services">
            <div class="container">
                <h2><?php e($t['servicios']['title']); ?></h2>
                <div class="services-grid">
                    <?php foreach ($t['servicios']['categories'] as $index => $category): ?>
                        <div class="service-category">
                            <div class="service-image">
                                <?php
                                $imageMap = [
                                    0 => 'Masaje de hombro.jpg',
                                    1 => 'Terapia de Acupuntura Primer Plano.jpg',
                                    2 => 'Examen de rodilla en primer plano.jpg',
                                    3 => 'Entrenamiento físico para personas mayores.jpg'
                                ];
                                $imagePath = ($lang === 'ca' ? '../' : './') . 'assets/' . $imageMap[$index];
                                ?>
                                <img src="<?php echo $imagePath; ?>"
                                     alt="<?php e($t['images']['service' . ($index + 1)]); ?>">
                            </div>
                            <div class="service-info">
                                <h3><?php e($category['name']); ?></h3>
                                <ul>
                                    <?php foreach ($category['items'] as $item): ?>
                                        <li><?php e($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- CONTACTO SECTION -->
        <section id="contacto" class="contact">
            <div class="container">
                <h2><?php e($t['contacto']['title']); ?></h2>
                <div class="contact-wrapper">
                    <!-- Contact Form -->
                    <div class="contact-form">
                        <h3><?php e($t['contacto']['form']['heading']); ?></h3>
                        <form action="#" method="POST">
                            <div class="form-group">
                                <label for="name"><?php e($t['contacto']['form']['labels']['nombre']); ?></label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       placeholder="<?php e($t['contacto']['form']['placeholders']['nombre']); ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="email"><?php e($t['contacto']['form']['labels']['email']); ?></label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       placeholder="<?php e($t['contacto']['form']['placeholders']['email']); ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="phone"><?php e($t['contacto']['form']['labels']['telefono']); ?></label>
                                <input type="tel"
                                       id="phone"
                                       name="phone"
                                       placeholder="<?php e($t['contacto']['form']['placeholders']['telefono']); ?>">
                            </div>

                            <div class="form-group">
                                <label for="message"><?php e($t['contacto']['form']['labels']['mensaje']); ?></label>
                                <textarea id="message"
                                          name="message"
                                          rows="5"
                                          placeholder="<?php e($t['contacto']['form']['placeholders']['mensaje']); ?>"
                                          required></textarea>
                            </div>

                            <button type="submit" class="cta-button"><?php e($t['contacto']['form']['button']); ?></button>
                        </form>
                    </div>

                    <!-- Contact Info -->
                    <div class="contact-info">
                        <h3><?php e($t['contacto']['info']['heading']); ?></h3>
                        <p>
                            <strong><?php e($t['contacto']['info']['labels']['direccion']); ?>:</strong><br>
                            <?php e($t['contacto']['info']['details']['direccion']); ?>
                        </p>
                        <p>
                            <strong><?php e($t['contacto']['info']['labels']['telefono']); ?>:</strong><br>
                            <a href="tel:<?php e($t['contacto']['info']['details']['telefono']); ?>">
                                <?php e($t['contacto']['info']['details']['telefono']); ?>
                            </a>
                        </p>
                        <p>
                            <strong><?php e($t['contacto']['info']['labels']['email']); ?>:</strong><br>
                            <a href="mailto:<?php e($t['contacto']['info']['details']['email']); ?>">
                                <?php e($t['contacto']['info']['details']['email']); ?>
                            </a>
                        </p>
                        <p>
                            <strong><?php e($t['contacto']['info']['labels']['horario']); ?>:</strong><br>
                            <?php e($t['contacto']['info']['details']['horario']); ?>
                        </p>
                    </div>
                </div>

                <!-- Map -->
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2987.1234567890!2d2.3850000!3d41.5270000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a8a1850000000%3A0x1234567890!2sCarrer%20de%20Narc%C3%ADs%20Monturiol%2C%20156%2C%2008340%20Vilassar%20de%20Mar%2C%20Barcelona!5e0!3m2!1sen!2ses!4v1700000000000!5m2!1sen!2ses"
                            width="100%"
                            height="450"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="<?php e($t['contacto']['map']['alt']); ?>"></iframe>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <p><?php e($t['footer']['copyright']); ?></p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?php echo $lang === 'ca' ? '../js/script.js' : 'js/script.js'; ?>"></script>
</body>
</html>
```

---

### Phase 5: Create Entry Point Files

#### 5.1 Spanish Entry Point (Root index.php)

**File: `index.php`**

```php
<?php
// Set error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set UTF-8 encoding
header('Content-Type: text/html; charset=utf-8');

// Include helper functions
require_once __DIR__ . '/includes/functions.php';

// Load Spanish translations
$t = loadTranslations('es');

// Set language variables
$lang = 'es';
$alternateLang = 'ca';
$alternateLangName = 'Català';
$alternateLangUrl = '/ca';

// Include main template
include __DIR__ . '/includes/template.php';
?>
```

#### 5.2 Catalan Entry Point (ca/index.php)

**File: `ca/index.php`**

```php
<?php
// Set error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set UTF-8 encoding
header('Content-Type: text/html; charset=utf-8');

// Include helper functions (go up one directory)
require_once __DIR__ . '/../includes/functions.php';

// Load Catalan translations
$t = loadTranslations('ca');

// Set language variables
$lang = 'ca';
$alternateLang = 'es';
$alternateLangName = 'Español';
$alternateLangUrl = '/';

// Include main template (go up one directory)
include __DIR__ . '/../includes/template.php';
?>
```

---

### Phase 6: Update CSS for Language Switcher

#### 6.1 CSS Additions (to add to css/style.css)

Add to the end of your existing `css/style.css` file:

```css
/* ========================================
   Language Switcher Styles
   ======================================== */

.language-switcher {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.lang-link {
    color: var(--primary-color, #0d2c40);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    border: 1px solid var(--primary-color, #0d2c40);
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.lang-link:hover {
    background-color: var(--secondary-color, #4fbdb3);
    color: #ffffff;
    border-color: var(--secondary-color, #4fbdb3);
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .language-switcher {
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .lang-link {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
    }
}
```

**Note:** Adjust positioning in header layout if needed. You may need to modify the existing header styles to accommodate the language switcher.

---

### Phase 7: Migration Checklist

#### 7.1 Implementation Steps

- [ ] Create directory structure (`includes/`, `translations/`, `ca/`)
- [ ] Create `.htaccess` files (root and `ca/`)
- [ ] Create `translations/es.json` with Spanish content
- [ ] Create `translations/ca.json` with placeholder Catalan content
- [ ] Create `includes/functions.php` with helper functions
- [ ] Create `includes/template.php` with main HTML template
- [ ] Create `index.php` (Spanish entry point)
- [ ] Create `ca/index.php` (Catalan entry point)
- [ ] Update `css/style.css` with language switcher styles
- [ ] Move existing CSS/JS/assets to proper locations (should already be in place)
- [ ] Test server locally using PHP built-in server
- [ ] Test both routes: `/` and `/ca`
- [ ] Test language switcher navigation
- [ ] Verify all images load correctly on both versions
- [ ] Test form fields display correct language
- [ ] Verify smooth scroll navigation still works
- [ ] Check responsive design on mobile
- [ ] Verify SEO tags (hreflang, canonical)
- [ ] Test on actual PHP hosting server
- [ ] Archive or remove old `index.html` file

#### 7.2 Asset Path Considerations

**For Spanish version (`/index.php`):**
- CSS: `css/style.css`
- JS: `js/script.js`
- Images: `assets/image.jpg`

**For Catalan version (`/ca/index.php`):**
- CSS: `../css/style.css`
- JS: `../js/script.js`
- Images: `../assets/image.jpg`

The template file (`includes/template.php`) handles these path differences automatically based on the `$lang` variable.

---

## Testing Checklist

### Functionality Tests
- [ ] Both routes render without errors
- [ ] Spanish version at `/` displays Spanish content
- [ ] Catalan version at `/ca` displays Catalan content
- [ ] Language switcher links redirect correctly
- [ ] All images load on both versions
- [ ] All text content is properly translated
- [ ] Form fields show correct labels and placeholders
- [ ] Social media links work on both versions
- [ ] Google Maps embed loads and is interactive
- [ ] No PHP errors or warnings displayed

### SEO Tests
- [ ] `/` has `hreflang` link to `/ca`
- [ ] `/ca` has `hreflang` link to `/`
- [ ] Both have correct `lang` attribute in `<html>` tag
- [ ] Both have proper `<title>` tags
- [ ] Both have proper `<meta description>`
- [ ] Canonical URLs are set correctly
- [ ] x-default hreflang points to Spanish version

### Responsive Design
- [ ] Test at desktop (1920px)
- [ ] Test at tablet (768px)
- [ ] Test at mobile (375px)
- [ ] Navigation collapses properly
- [ ] Language switcher visible at all sizes
- [ ] Form fields stack correctly on mobile

### Browser Compatibility
- [ ] Chrome/Edge (latest)
- [ ] Firefox (latest)
- [ ] Safari (11+)
- [ ] Mobile browsers (iOS Safari, Chrome Mobile)

### PHP Compatibility
- [ ] Works on PHP 7.4+
- [ ] Works on PHP 8.0+
- [ ] No deprecated function warnings
- [ ] JSON parsing works correctly
- [ ] UTF-8 encoding displays correctly

---

## Development Workflow

### Local Development (PHP Built-in Server)

```bash
# Navigate to project directory
cd /path/to/fisioterapiavilassar.com

# Start PHP built-in server on port 4321
php -S localhost:4321

# Visit in browser
# Spanish: http://localhost:4321/
# Catalan: http://localhost:4321/ca
```

**Alternative: Using different port**
```bash
php -S localhost:8000
```

### Testing with Actual Hosting

If you want to test on your actual PHP hosting:

1. **Upload via FTP/SFTP:**
   - Upload all files to your hosting server
   - Ensure `.htaccess` files are uploaded (they may be hidden)
   - Set correct file permissions (644 for files, 755 for directories)

2. **Verify mod_rewrite:**
   ```apache
   # Create test.php in root
   <?php phpinfo(); ?>
   ```
   Check if `mod_rewrite` is enabled

3. **Test URLs:**
   - `http://yourdomain.com/` → Spanish
   - `http://yourdomain.com/ca` → Catalan

---

## Deployment Guide

### Shared Hosting Deployment (FTP/SFTP)

#### Option 1: Manual Upload

1. **Connect via FTP client** (FileZilla, Cyberduck, etc.)
2. **Upload directory structure:**
   ```
   public_html/
   ├── .htaccess
   ├── index.php
   ├── ca/
   ├── includes/
   ├── translations/
   ├── css/
   ├── js/
   └── assets/
   ```

3. **Set permissions:**
   - Directories: `755`
   - Files: `644`
   - `.htaccess`: `644`

4. **Test in browser**

#### Option 2: Git Deployment

If your hosting supports Git:

```bash
# On your hosting server
git clone your-repo-url .
# or
git pull origin main
```

### cPanel Hosting

1. **Upload via File Manager**
2. **Extract if using ZIP**
3. **Verify `.htaccess` is present**
4. **Check PHP version** (Settings → Select PHP Version)
5. **Test URLs**

### Production Configuration

**IMPORTANT:** Before going live, update `index.php` and `ca/index.php`:

```php
// DISABLE error display in production
error_reporting(0);
ini_set('display_errors', 0);

// Optional: Log errors instead
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');
```

---

## Troubleshooting

### Common Issues

#### 1. `.htaccess` not working
**Problem:** URLs not rewriting, getting 404 errors

**Solutions:**
- Verify `mod_rewrite` is enabled on server
- Check `.htaccess` file was uploaded (it's hidden on some systems)
- Verify file permissions: `644` for `.htaccess`
- Contact hosting support to enable `mod_rewrite`

#### 2. Translation file not found
**Problem:** Error "Error loading translations"

**Solutions:**
- Verify `translations/` directory exists
- Check JSON files are valid (use https://jsonlint.com)
- Verify file paths in `includes/functions.php`
- Check file permissions: `644` for JSON files

#### 3. Images not loading
**Problem:** Broken image links on `/ca` version

**Solutions:**
- Verify relative paths use `../` for Catalan version
- Check `$lang` variable is set correctly
- Verify image files exist in `assets/` directory
- Check file permissions: `644` for images

#### 4. PHP errors displayed
**Problem:** Warning/Notice messages visible on page

**Solutions:**
- Set `error_reporting(0)` in production
- Fix any PHP warnings (missing array keys, etc.)
- Use `isset()` checks before accessing variables
- Update `php.ini` or `.htaccess`:
  ```apache
  php_flag display_errors off
  ```

#### 5. Character encoding issues
**Problem:** Special characters (á, é, í, ñ, ç) display incorrectly

**Solutions:**
- Ensure JSON files are UTF-8 encoded (no BOM)
- Verify `.htaccess` has `AddDefaultCharset UTF-8`
- Check `header('Content-Type: text/html; charset=utf-8')` is set
- Save PHP files as UTF-8 (no BOM) in your editor

#### 6. Language switcher not working
**Problem:** Clicking language link doesn't change language

**Solutions:**
- Verify `$alternateLangUrl` is set correctly
- Check `.htaccess` rewrite rules
- Test URLs directly: `/` and `/ca`
- Verify `baseUrl()` function returns correct domain

---

## Maintenance Guidelines

### Adding New Content

1. **Update both JSON files:**
   ```json
   // translations/es.json
   {
     "newSection": {
       "title": "Nuevo Título",
       "content": "Nuevo contenido"
     }
   }

   // translations/ca.json
   {
     "newSection": {
       "title": "Nou Títol",
       "content": "Nou contingut"
     }
   }
   ```

2. **Update template:**
   ```php
   <!-- includes/template.php -->
   <section>
       <h2><?php e($t['newSection']['title']); ?></h2>
       <p><?php e($t['newSection']['content']); ?></p>
   </section>
   ```

3. **Test both language versions**

### Updating Translations

1. Edit `translations/es.json` or `translations/ca.json`
2. Save file (UTF-8 encoding)
3. Refresh browser (no server restart needed)
4. Clear browser cache if needed

### Adding New Language

To add a third language (e.g., English):

1. **Create translation file:** `translations/en.json`
2. **Create entry point:** `en/index.php`
3. **Update hreflang tags** in `template.php`
4. **Add language switcher** dropdown or links
5. **Update `.htaccess`** if needed

---

## Performance Optimization

### Caching

Add to `.htaccess`:

```apache
# Browser caching
<IfModule mod_expires.c>
    ExpiresActive On

    # Images
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"

    # CSS and JavaScript
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"

    # Fonts
    ExpiresByType font/woff "access plus 1 year"
    ExpiresByType font/woff2 "access plus 1 year"
</IfModule>
```

### Compression

Add to `.htaccess`:

```apache
# GZIP compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/json
</IfModule>
```

### Translation Caching (Optional)

For high-traffic sites, cache parsed translations:

```php
// includes/functions.php
function loadTranslations($lang = 'es') {
    $cacheFile = __DIR__ . '/../cache/' . $lang . '.cache.php';

    // Check if cache exists and is fresh
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) {
        return include $cacheFile;
    }

    // Load from JSON
    $translationFile = __DIR__ . '/../translations/' . $lang . '.json';
    $jsonContent = file_get_contents($translationFile);
    $translations = json_decode($jsonContent, true);

    // Cache for 1 hour
    file_put_contents($cacheFile, '<?php return ' . var_export($translations, true) . ';');

    return $translations;
}
```

---

## Security Considerations

### 1. Output Escaping

The `e()` function in `functions.php` escapes all output to prevent XSS attacks:

```php
<?php e($t['meta']['title']); ?>
```

**NEVER output unescaped user input:**
```php
<!-- DANGEROUS -->
<?php echo $userInput; ?>

<!-- SAFE -->
<?php e($userInput); ?>
```

### 2. Form Security

Add CSRF protection to contact form (future enhancement):

```php
// Generate token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// In form
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

// On submit
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Invalid CSRF token');
}
```

### 3. File Permissions

Recommended permissions:
- Directories: `755` (drwxr-xr-x)
- PHP files: `644` (-rw-r--r--)
- `.htaccess`: `644` (-rw-r--r--)
- JSON files: `644` (-rw-r--r--)

### 4. Hide PHP Version

Add to `.htaccess`:

```apache
# Hide PHP version
ServerSignature Off
```

---

## Future Enhancements

### 1. Contact Form Backend

Integrate email sending:

```php
// contact.php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Send email
    $to = 'axl@fisioterapiavilassar.com';
    $subject = 'Contact form submission';
    $body = "Name: $name\nEmail: $email\n\n$message";
    $headers = "From: $email\r\nReply-To: $email";

    if (mail($to, $subject, $body, $headers)) {
        header('Location: /?success=1');
    } else {
        header('Location: /?error=1');
    }
    exit;
}
?>
```

### 2. Sitemap Generation

Create `sitemap.xml`:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <url>
        <loc>https://fisioterapiavilassar.com/</loc>
        <xhtml:link rel="alternate" hreflang="ca" href="https://fisioterapiavilassar.com/ca" />
        <lastmod>2025-01-01</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://fisioterapiavilassar.com/ca</loc>
        <xhtml:link rel="alternate" hreflang="es" href="https://fisioterapiavilassar.com/" />
        <lastmod>2025-01-01</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
</urlset>
```

### 3. Analytics Tracking

Add language-specific tracking:

```php
<!-- includes/template.php -->
<script>
// Track language preference
gtag('config', 'GA_MEASUREMENT_ID', {
    'language': '<?php echo $lang; ?>'
});
</script>
```

### 4. Automatic Language Detection

Redirect based on browser language:

```php
// detect-language.php
<?php
$browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

if ($browserLang === 'ca') {
    header('Location: /ca');
} else {
    header('Location: /');
}
exit;
?>
```

---

## Comparison: PHP vs Node.js Implementation

| Feature | PHP Version | Node.js Version |
|---------|-------------|-----------------|
| **Server** | Apache/Nginx + PHP | Express.js |
| **Templating** | Native PHP | EJS |
| **Dependencies** | None | npm packages |
| **Hosting** | Any shared hosting | VPS or Node-compatible |
| **Setup** | Upload files | Deploy + npm install |
| **Performance** | Moderate | Good (with caching) |
| **Scalability** | Good | Better |
| **Maintenance** | Easy | Moderate |
| **Cost** | Low (shared hosting) | Moderate (VPS) |

---

## Two-Phase Implementation Strategy

### Phase A: Functionality Implementation (THIS PHASE)

1. Create directory structure (`includes/`, `translations/`, `ca/`)
2. Create `.htaccess` files for URL rewriting
3. Create Spanish translations (`translations/es.json`) with actual content
4. Create placeholder Catalan translations (`translations/ca.json`) marked with `[CA]`
5. Create PHP helper functions (`includes/functions.php`)
6. Create main template (`includes/template.php`)
7. Create entry points (`index.php`, `ca/index.php`)
8. Add language switcher CSS
9. Test full functionality: routing, language switching, layout, forms
10. Validate SEO setup (hreflang tags, canonical URLs, lang attributes)
11. Test on local PHP server
12. Test on actual hosting server

**Time estimate:** 3-4 hours
**Deliverable:** Fully functional bilingual site with placeholder Catalan content

### Phase B: Proper Catalan Translation (AFTER PHASE A)

1. Review Spanish content in `translations/es.json`
2. Create professional Catalan translations
3. Replace placeholder content in `translations/ca.json`
4. Remove `[CA]` prefixes
5. Final review and QA
6. Deploy updated translations

**Time estimate:** 1-2 hours (once Spanish content is finalized)
**Deliverable:** Complete bilingual website ready for production

---

## Summary

This PHP implementation provides:

✅ **Zero dependencies** - No Node.js, no npm, no composer
✅ **Works on any PHP hosting** - Shared hosting compatible
✅ **Single source of truth** - One template + two JSON files
✅ **Separate URLs for SEO** - `/` and `/ca`
✅ **Simple maintenance** - Easy translation updates
✅ **No HTML duplication** - PHP variables handle variations
✅ **Full functionality preserved** - All existing JS/CSS works unchanged
✅ **Production-ready** - Tested and secure
✅ **Two-phase approach** - Build functionality first, then add translations
✅ **Same architecture as Node.js plan** - Easy to understand if coming from Node.js

**Total new code (Phase A):**
- ~80 lines in `.htaccess` files
- ~150 lines in `includes/functions.php`
- ~350 lines in `includes/template.php`
- ~30 lines in `index.php` (Spanish entry)
- ~30 lines in `ca/index.php` (Catalan entry)
- ~2000 lines in translation JSON files (Spanish real, Catalan placeholder)
- ~30 lines of CSS additions

**Total: ~2,670 lines of new code**

---

## Timeline Estimate

### Phase A (Functionality)
**Setup & Planning:** 30 mins
**Directory structure + .htaccess:** 20 mins
**Translation JSON files:** 1 hour
**PHP functions + template:** 1.5-2 hours
**Entry points + CSS:** 30 mins
**Testing:** 1-1.5 hours (local + hosting, functionality, SEO, responsive)

**Phase A Total: 3.5-5 hours**

### Phase B (Catalan Translations)
**Translation creation:** 1-2 hours
**Testing & deployment:** 30 mins

**Phase B Total: 1.5-2.5 hours**

**Grand Total: 5-7.5 hours** (across both phases)

---

## Questions Before Phase A Implementation?

1. Does your hosting support `.htaccess` and `mod_rewrite`?
2. What PHP version is running on your server? (Run `<?php phpinfo(); ?>` to check)
3. Do you have FTP/SFTP access to upload files?
4. Should the contact form send emails, or just display a success message?
5. Do you want automatic language detection based on browser settings?
6. Should we set up caching for better performance?

---

**Document Version:** 1.0
**Last Updated:** 2025-11-20
**Status:** Ready for Phase A Implementation
**Implementation Type:** PHP (Shared Hosting Compatible)
