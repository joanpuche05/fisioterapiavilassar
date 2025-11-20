# Language Implementation Plan: Spanish/Catalan Bilingual Support

## Overview

This document outlines the implementation plan for adding Spanish/Catalan language support to fisioterapiavilassar.com using Express.js and EJS templating. The goal is to maintain a single HTML template while serving separate URLs for SEO purposes: `/` for Spanish and `/ca` for Catalan.

**Implementation Approach:** This is a two-phase implementation:
1. **Phase A (This First):** Implement the full technical setup and functionality with Spanish content and placeholder Catalan translations
2. **Phase B (After testing):** Create proper Catalan translations based on Spanish content

---

## Architecture

### Technology Stack
- **Backend:** Node.js + Express.js
- **Template Engine:** EJS (Embedded JavaScript templating)
- **Translation Storage:** JSON files (es.json, ca.json)
- **Static Assets:** CSS, JavaScript, images (unchanged)
- **Development Server:** Current setup (port 4321)

### URL Structure
- `http://localhost:4321/` → Spanish version
- `http://localhost:4321/ca` → Catalan version

### Key Principles
1. **Single Source of Truth** - One EJS template serves both languages
2. **Separate URLs** - Each language has its own route for SEO
3. **No HTML Duplication** - Template variables handle all language variations
4. **Simple Maintenance** - All translations in JSON files
5. **Progressive Enhancement** - Server-rendered HTML works without JavaScript

---

## File Structure (Post-Implementation)

```
fisioterapiavilassar.com/
├── server.js                          # Express server (new)
├── package.json                       # Node dependencies (new)
├── package-lock.json                  # Dependency lock file (new)
├── views/
│   └── index.ejs                      # Single EJS template (new)
├── translations/
│   ├── es.json                        # Spanish translations (new)
│   └── ca.json                        # Catalan translations (new)
├── public/                            # Static assets (existing, unchanged)
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── assets/
│       ├── hero-bg.jpg
│       ├── service1.jpg
│       ├── service2.jpg
│       ├── service3.jpg
│       ├── service4.jpg
│       └── philosophy.jpg
├── LANGUAGE_IMPLEMENTATION_PLAN.md    # This file
├── CLAUDE.md                          # Existing project guidelines
├── FONT_SPECIFICATIONS.md             # Existing typography guidelines
└── index.html                         # Old static file (to be removed)
```

---

## Implementation Phases

### Phase 1: Setup & Dependencies

#### 1.1 Initialize Node Project
```bash
npm init -y
npm install express ejs
```

#### 1.2 Create package.json Configuration
Key additions to `package.json`:
```json
{
  "name": "fisioterapiavilassar",
  "version": "1.0.0",
  "description": "Bilingual website for Axl Espai De Salut",
  "main": "server.js",
  "scripts": {
    "start": "node server.js",
    "dev": "node server.js"
  },
  "keywords": ["fisioterapia", "vilassar", "health", "wellness"],
  "author": "",
  "license": "ISC",
  "dependencies": {
    "express": "^4.18.2",
    "ejs": "^3.1.9"
  }
}
```

#### 1.3 Directory Structure
Create the following directories:
- `mkdir views`
- `mkdir translations`
- `mkdir public` (if not exists)
- Ensure `public/css`, `public/js`, `public/assets` exist

---

### Phase 2: Create Translation Files

#### 2.1 Spanish Translations (translations/es.json)

```json
{
  "meta": {
    "title": "Axl Espai De Salut - Fisioterapia en Vilassar de Mar",
    "description": "Clínica de fisioterapia en Vilassar de Mar, Barcelona"
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
    "paragraph1": "En Axl Espai De Salut creemos que la salud es un estado de bienestar físico, mental y social. Nuestro equipo de profesionales altamente cualificados se compromete a proporcionar un tratamiento personalizado y de calidad a cada uno de nuestros pacientes.",
    "paragraph2": "Utilizamos técnicas y metodologías más avanzadas para garantizar resultados óptimos. Nos enfocamos en el bienestar integral del paciente, considerando no solo los síntomas, sino también las causas subyacentes de la lesión o enfermedad.",
    "quote": "La fisioterapia no solo trata el cuerpo, sino que también nutre el espíritu y la mente."
  },
  "servicios": {
    "title": "SERVICIOS",
    "categories": [
      {
        "name": "TERAPIA MANUAL",
        "items": [
          "Masaje terapéutico y relajante",
          "Técnicas de movilización articular",
          "Tratamiento de puntos gatillo"
        ]
      },
      {
        "name": "TÉCNICAS AVANZADAS",
        "items": [
          "Electroterapia y magnetoterapia",
          "Ultrasonido y diatermia",
          "Punción seca y acupuntura"
        ]
      },
      {
        "name": "FISIOTERAPIA ESPECIALIZADA",
        "items": [
          "Rehabilitación post-quirúrgica",
          "Tratamiento de lesiones deportivas",
          "Fisioterapia neurológica"
        ]
      },
      {
        "name": "EJERCICIO TERAPÉUTICO",
        "items": [
          "Programas de fortalecimiento muscular",
          "Reeducación postural",
          "Entrenamiento propioceptivo"
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
        "direccion": "Carrer Sant Jaume, 33, 08340 Vilassar de Mar, Barcelona",
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

```json
{
  "meta": {
    "title": "[CA] Axl Espai De Salut - Fisioterapia a Vilassar de Mar",
    "description": "[CA] Clínica de fisioterapia a Vilassar de Mar, Barcelona"
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
    "paragraph1": "[CA] Placeholder paragraph 1 - Will be replaced with proper Catalan translation",
    "paragraph2": "[CA] Placeholder paragraph 2 - Will be replaced with proper Catalan translation",
    "quote": "[CA] Placeholder quote - Will be replaced with proper Catalan translation"
  },
  "servicios": {
    "title": "[CA] SERVEIS",
    "categories": [
      {
        "name": "[CA] TERÀPIA MANUAL",
        "items": [
          "[CA] Service item 1",
          "[CA] Service item 2",
          "[CA] Service item 3"
        ]
      },
      {
        "name": "[CA] TÈCNIQUES AVANÇADES",
        "items": [
          "[CA] Service item 1",
          "[CA] Service item 2",
          "[CA] Service item 3"
        ]
      },
      {
        "name": "[CA] FISIOTERAPIA ESPECIALITZADA",
        "items": [
          "[CA] Service item 1",
          "[CA] Service item 2",
          "[CA] Service item 3"
        ]
      },
      {
        "name": "[CA] EXERCICI TERAPÈUTIC",
        "items": [
          "[CA] Service item 1",
          "[CA] Service item 2",
          "[CA] Service item 3"
        ]
      }
    ]
  },
  "contacto": {
    "title": "[CA] CONTACTE",
    "form": {
      "heading": "[CA] Envíanos un missatge",
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
        "direccion": "Carrer Sant Jaume, 33, 08340 Vilassar de Mar, Barcelona",
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
    "hero": "[CA] Secció heroi - Benvinguts",
    "service1": "[CA] Teràpia manual",
    "service2": "[CA] Tècniques avançades",
    "service3": "[CA] Fisioterapia especialitzada",
    "service4": "[CA] Exercici terapèutic",
    "philosophy": "[CA] Filosofia d'Axl Espai De Salut"
  }
}
```

**After Phase A Testing:** Replace this placeholder JSON with proper Catalan translations created from the Spanish content.

---

### Phase 3: Create Express Server

#### 3.1 Server Implementation (server.js)

```javascript
const express = require('express');
const path = require('path');
const app = express();

// Load translations
const translations = {
  es: require('./translations/es.json'),
  ca: require('./translations/ca.json')
};

// Configuration
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Serve static files
app.use('/css', express.static(path.join(__dirname, 'public/css')));
app.use('/js', express.static(path.join(__dirname, 'public/js')));
app.use('/assets', express.static(path.join(__dirname, 'public/assets')));

// Middleware for parsing forms (for future contact form functionality)
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// Routes

// Spanish version (default)
app.get('/', (req, res) => {
  res.render('index', {
    t: translations.es,
    lang: 'es',
    alternateLang: 'ca',
    alternateLangName: 'Català'
  });
});

// Catalan version
app.get('/ca', (req, res) => {
  res.render('index', {
    t: translations.ca,
    lang: 'ca',
    alternateLang: 'es',
    alternateLangName: 'Español'
  });
});

// Language detection and redirect (optional: redirects based on browser language)
// Uncomment this for automatic language detection
/*
app.get('/detect-language', (req, res) => {
  const acceptLanguage = req.get('Accept-Language') || '';
  const prefersCatalan = acceptLanguage.includes('ca');

  if (prefersCatalan) {
    res.redirect('/ca');
  } else {
    res.redirect('/');
  }
});
*/

// 404 handler
app.use((req, res) => {
  res.status(404).render('404', {
    lang: 'es'
  });
});

// Error handler
app.use((err, req, res, next) => {
  console.error(err.stack);
  res.status(500).send('Something went wrong!');
});

// Server startup
const PORT = process.env.PORT || 4321;
app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
  console.log(`Spanish: http://localhost:${PORT}/`);
  console.log(`Catalan: http://localhost:${PORT}/ca`);
});
```

---

### Phase 4: Create EJS Template

#### 4.1 Main Template (views/index.ejs)

```ejs
<!DOCTYPE html>
<html lang="<%= lang %>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<%= t.meta.description %>">

    <!-- Language Alternates for SEO -->
    <link rel="alternate" hreflang="<%= alternateLang %>"
          href="http://fisioterapiavilassar.com<%= alternateLang === 'ca' ? '/ca' : '' %>">
    <link rel="alternate" hreflang="x-default"
          href="http://fisioterapiavilassar.com/">

    <!-- Canonical URL -->
    <link rel="canonical" href="http://fisioterapiavilassar.com<%= lang === 'ca' ? '/ca' : '' %>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/css/style.css">

    <title><%= t.meta.title %></title>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h2>Axl Espai De Salut</h2>
                </div>

                <nav class="nav">
                    <a href="#filosofia"><%= t.nav.filosofia %></a>
                    <a href="#servicios"><%= t.nav.servicios %></a>
                    <a href="#contacto"><%= t.nav.contacto %></a>
                </nav>

                <!-- Language Switcher -->
                <div class="language-switcher">
                    <a href="/<%= alternateLang === 'ca' ? 'ca' : '' %>"
                       class="lang-link"
                       title="Switch to <%= alternateLangName %>">
                        <%= alternateLangName %>
                    </a>
                </div>

                <!-- Social Icons -->
                <div class="social-icons">
                    <a href="https://www.instagram.com/axlespaidesalut/"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="Instagram">
                        <i class="icon-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/axlespaidesalut"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="Facebook">
                        <i class="icon-facebook"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="inicio" class="hero">
        <div class="hero-content">
            <h1 class="hero-title"><%= t.hero.title %></h1>
            <p class="hero-subtitle"><%= t.hero.subtitle %></p>
        </div>
    </section>

    <!-- FILOSOFIA SECTION -->
    <section id="filosofia" class="filosofia">
        <div class="container">
            <h2><%= t.filosofia.title %></h2>
            <div class="filosofia-content">
                <div class="filosofia-text">
                    <p><%= t.filosofia.paragraph1 %></p>
                    <p><%= t.filosofia.paragraph2 %></p>
                    <blockquote>
                        <p><%= t.filosofia.quote %></p>
                    </blockquote>
                </div>
                <div class="filosofia-image">
                    <img src="/assets/philosophy.jpg"
                         alt="<%= t.images.philosophy %>">
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICIOS SECTION -->
    <section id="servicios" class="servicios">
        <div class="container">
            <h2><%= t.servicios.title %></h2>
            <div class="services-grid">
                <% t.servicios.categories.forEach((category, index) => { %>
                    <div class="service-category">
                        <div class="service-image">
                            <img src="/assets/service<%= index + 1 %>.jpg"
                                 alt="<%= t.images['service' + (index + 1)] %>">
                        </div>
                        <div class="service-info">
                            <h3><%= category.name %></h3>
                            <ul>
                                <% category.items.forEach(item => { %>
                                    <li><%= item %></li>
                                <% }); %>
                            </ul>
                        </div>
                    </div>
                <% }); %>
            </div>
        </div>
    </section>

    <!-- CONTACTO SECTION -->
    <section id="contacto" class="contacto">
        <div class="container">
            <h2><%= t.contacto.title %></h2>
            <div class="contacto-content">
                <!-- Contact Form -->
                <div class="contacto-form">
                    <h3><%= t.contacto.form.heading %></h3>
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="nombre"><%= t.contacto.form.labels.nombre %></label>
                            <input type="text"
                                   id="nombre"
                                   name="nombre"
                                   placeholder="<%= t.contacto.form.placeholders.nombre %>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="email"><%= t.contacto.form.labels.email %></label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   placeholder="<%= t.contacto.form.placeholders.email %>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="telefono"><%= t.contacto.form.labels.telefono %></label>
                            <input type="tel"
                                   id="telefono"
                                   name="telefono"
                                   placeholder="<%= t.contacto.form.placeholders.telefono %>">
                        </div>

                        <div class="form-group">
                            <label for="mensaje"><%= t.contacto.form.labels.mensaje %></label>
                            <textarea id="mensaje"
                                      name="mensaje"
                                      placeholder="<%= t.contacto.form.placeholders.mensaje %>"
                                      required></textarea>
                        </div>

                        <button type="submit" class="cta-button"><%= t.contacto.form.button %></button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="contacto-info">
                    <h3><%= t.contacto.info.heading %></h3>
                    <div class="info-item">
                        <strong><%= t.contacto.info.labels.direccion %></strong>
                        <p><%= t.contacto.info.details.direccion %></p>
                    </div>
                    <div class="info-item">
                        <strong><%= t.contacto.info.labels.telefono %></strong>
                        <p><a href="tel:<%= t.contacto.info.details.telefono %>"><%= t.contacto.info.details.telefono %></a></p>
                    </div>
                    <div class="info-item">
                        <strong><%= t.contacto.info.labels.email %></strong>
                        <p><a href="mailto:<%= t.contacto.info.details.email %>"><%= t.contacto.info.details.email %></a></p>
                    </div>
                    <div class="info-item">
                        <strong><%= t.contacto.info.labels.horario %></strong>
                        <p><%= t.contacto.info.details.horario %></p>
                    </div>

                    <!-- Map Embed -->
                    <div class="map-embed">
                        <h3><%= t.contacto.map.title %></h3>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2985.2156456789!2d2.3657!3d41.4876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z41LCsNC80LDQvNC70L7Qv9C60L7Qt9C-!5e0!3m2!1sen!2ses!4v1234567890"
                                width="100%"
                                height="300"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="<%= t.contacto.map.alt %>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p><%= t.footer.copyright %></p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/js/script.js"></script>
</body>
</html>
```

---

### Phase 5: Update CSS for Language Switcher

#### 5.1 CSS Additions (to add to public/css/style.css)

```css
/* Language Switcher Styles */
.language-switcher {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.lang-link {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.lang-link:hover {
    background-color: var(--light-gray-color);
    color: var(--secondary-color);
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .language-switcher {
        gap: 0.5rem;
    }

    .lang-link {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
    }
}
```

---

### Phase 6: Update JavaScript

#### 6.1 JavaScript Updates (public/js/script.js)

The existing script.js should continue to work as-is. No major changes are required since the server handles routing. If adding language-aware analytics, add this:

```javascript
// Get current language from HTML lang attribute
const currentLang = document.documentElement.lang;

// You can use this for analytics or other language-specific functionality
console.log('Current language:', currentLang);

// Rest of existing script.js code...
```

---

### Phase 7: Migration Checklist

#### 7.1 From Static to Server-Based

- [ ] Install dependencies: `npm install express ejs`
- [ ] Create `server.js` with proper configuration
- [ ] Create `views/` directory and `index.ejs` template
- [ ] Create `translations/` directory with `es.json` and `ca.json`
- [ ] Move CSS, JS, and images to `public/` directory
- [ ] Update all asset paths in EJS template (use `/css`, `/js`, `/assets`)
- [ ] Test server locally: `npm start`
- [ ] Test both routes: `/` and `/ca`
- [ ] Test language switcher navigation
- [ ] Verify all images load correctly
- [ ] Test form fields and buttons display correct language
- [ ] Verify smooth scroll navigation still works
- [ ] Check responsive design on mobile
- [ ] Verify SEO tags (hreflang, canonical)

#### 7.2 Asset Path Changes

| Old Path | New Path |
|----------|----------|
| `./assets/image.jpg` | `/assets/image.jpg` |
| `../assets/image.jpg` | `/assets/image.jpg` |
| `./css/style.css` | `/css/style.css` |
| `./js/script.js` | `/js/script.js` |

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

### SEO Tests
- [ ] `/` has `hreflang` link to `/ca`
- [ ] `/ca` has `hreflang` link to `/`
- [ ] Both have correct `lang` attribute
- [ ] Both have proper `<title>` tags
- [ ] Both have proper `<meta description>`
- [ ] Canonical URLs are set correctly

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
- [ ] Mobile browsers

---

## Deployment Options

### Option 1: Heroku (Recommended for Simplicity)
```bash
# Install Heroku CLI
# Login: heroku login
# Create app: heroku create app-name
# Deploy: git push heroku main
```

**Heroku Configuration:**
- Add `Procfile`:
  ```
  web: node server.js
  ```

### Option 2: Railway.app
- Connect GitHub repository
- Railway auto-detects Node.js
- Automatic deployments on git push

### Option 3: DigitalOcean App Platform
- Connect GitHub repository
- Configure to run `npm start`
- Add environment variables if needed

### Option 4: Self-Hosted VPS with PM2
```bash
# Install PM2 globally
npm install -g pm2

# Start app with PM2
pm2 start server.js --name "fisioterapia"

# Save PM2 process list
pm2 save

# Start on system reboot
pm2 startup
```

### Option 5: Static Pre-rendering (for Static Hosting)
Add a build script to generate static files:
```javascript
// build.js
const fs = require('fs');
const path = require('path');
const ejs = require('ejs');

const translations = {
  es: require('./translations/es.json'),
  ca: require('./translations/ca.json')
};

// Render Spanish version
const esHtml = ejs.render(
  fs.readFileSync('views/index.ejs', 'utf8'),
  { t: translations.es, lang: 'es', alternateLang: 'ca', alternateLangName: 'Català' }
);
fs.writeFileSync('dist/index.html', esHtml);

// Render Catalan version
const caHtml = ejs.render(
  fs.readFileSync('views/index.ejs', 'utf8'),
  { t: translations.ca, lang: 'ca', alternateLang: 'es', alternateLangName: 'Español' }
);
fs.mkdirSync('dist/ca', { recursive: true });
fs.writeFileSync('dist/ca/index.html', caHtml);

// Copy static assets
// ... (copy css, js, assets directories)

console.log('Build complete!');
```

Add to `package.json`:
```json
{
  "scripts": {
    "build": "node build.js",
    "start": "node server.js"
  }
}
```

---

## Maintenance Guidelines

### Adding New Content
1. Update both `es.json` and `ca.json` with new translations
2. Update `views/index.ejs` to use the new translation keys (use `<%= t.section.key %>`)
3. Test on both `/` and `/ca` routes
4. Deploy changes

### Updating Translations
1. Edit `translations/es.json` or `translations/ca.json`
2. Restart server: `npm start`
3. Changes are reflected immediately (no page rebuilding needed)

### Adding New Routes
```javascript
// In server.js
app.get('/new-page', (req, res) => {
  res.render('new-page', {
    t: translations.es,
    lang: 'es',
    alternateLang: 'ca',
    alternateLangName: 'Català'
  });
});
```

### Future Enhancements
1. **Contact Form Backend** - Integrate email service (SendGrid, Nodemailer)
2. **Sitemap** - Auto-generate `sitemap.xml` with both language versions
3. **RSS Feed** - Add blog section with multi-language feeds
4. **Analytics** - Track visits by language
5. **Caching** - Implement response caching for better performance
6. **Compression** - Add gzip compression middleware

---

## Development Workflow

### Local Development
```bash
# Install dependencies (one-time)
npm install

# Start development server
npm start

# Visit in browser
# Spanish: http://localhost:4321/
# Catalan: http://localhost:4321/ca
```

### Production Deployment (Example: Heroku)
```bash
# Build and push to Heroku
git push heroku main

# Check logs
heroku logs --tail

# Environment variables (if needed)
heroku config:set NODE_ENV=production
```

---

## Troubleshooting

### Port Already in Use
```bash
# Kill process using port 4321
lsof -ti:4321 | xargs kill -9

# Or use different port
PORT=3000 npm start
```

### Module Not Found Error
```bash
# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install
```

### Template Not Rendering
- Ensure `views/index.ejs` exists in correct location
- Check for typos in `res.render('index', ...)`
- Verify EJS is installed: `npm list ejs`

### Static Files Not Loading
- Ensure files are in `public/` directory
- Check Express static configuration in `server.js`
- Verify asset paths start with `/` in template

### Translations Not Updating
- Restart server after editing JSON files
- Check JSON syntax (use online JSON validator)
- Verify key names match between template and JSON

---

## Two-Phase Implementation Strategy

### Phase A: Functionality Implementation (THIS PHASE)
1. Setup Node.js/Express environment
2. Create EJS template structure
3. Implement Spanish translations (actual content)
4. Implement placeholder Catalan translations (marked with `[CA]` prefix)
5. Test full functionality: routing, language switching, layout, forms
6. Validate SEO setup (hreflang tags, canonical URLs, lang attributes)

**Time estimate:** 4-5 hours
**Deliverable:** Fully functional bilingual site with placeholder Catalan content

### Phase B: Proper Catalan Translation (AFTER PHASE A)
1. Extract Spanish content from es.json
2. Create professional Catalan translations
3. Replace placeholder content in ca.json
4. Final review and QA
5. Deploy updated translations

**Time estimate:** 1-2 hours (once Spanish content is finalized)
**Deliverable:** Complete bilingual website ready for production

---

## Summary

This implementation provides:

✅ **Single source of truth** - One EJS template + two JSON translation files
✅ **Separate URLs for SEO** - `/` and `/ca`
✅ **Simple maintenance** - Easy translation updates
✅ **No HTML duplication** - Template-based rendering
✅ **Full functionality preserved** - All existing JS/CSS works unchanged
✅ **Production-ready** - Multiple deployment options
✅ **Scalable** - Easy to add more languages
✅ **Two-phase approach** - Build functionality first, then add proper translations

**Total new code (Phase A):**
- ~100 lines in server.js
- ~400 lines in index.ejs
- ~2000 lines in translation JSON files (Spanish real, Catalan placeholder)
- ~30 lines of CSS additions

---

## Timeline Estimate

### Phase A (Functionality)
**Setup & Planning:** 30 mins
**Implementation:** 3-4 hours (setup, template, placeholder translations)
**Testing:** 1-2 hours (functionality, SEO, responsive, browser compatibility)

**Phase A Total: 4.5-6.5 hours**

### Phase B (Catalan Translations)
**Translation creation:** 1-2 hours
**Testing & deployment:** 30 mins

**Phase B Total: 1.5-2.5 hours**

**Grand Total: 6-9 hours** (across both phases)

---

## Questions Before Phase A Implementation?

1. Do you want automatic language detection based on browser settings?
2. Should the contact form have backend integration (email submission)?
3. What's your preferred hosting platform for deployment?
4. Do you need analytics tracking per language?
5. Should we set up the build/pre-rendering script now, or keep it dynamic for development?

---

**Document Version:** 2.0 (Updated for two-phase approach)
**Last Updated:** 2025-11-19
**Status:** Ready for Phase A Implementation
