# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**fisioterapiavilassar.com** is a bilingual website for Axl Espai De Salut, a physiotherapy clinic in Vilassar de Mar, Barcelona. The site is built with Node.js/Express backend, EJS templating, and vanilla CSS/JavaScript. It supports Spanish (default at `/`) and Catalan (at `/ca`) with separate URL routes for SEO purposes. It's a single-page website with sections for: hero, services, philosophy, and contact.

## Architecture

### File Structure
- **server.js** - Express.js server that handles routing and template rendering
- **views/index.ejs** - Single EJS template serving both language versions with variable interpolation
- **translations/es.json** - Spanish translations and content
- **translations/ca.json** - Catalan translations and content (Phase A: placeholders, Phase B: proper translations)
- **public/css/style.css** - All styling using CSS variables for colors and typography
- **public/js/script.js** - Smooth scroll behavior for navigation links
- **public/assets/** - Image files (JPG, JPEG format) for service cards and philosophy section
- **package.json** - Node.js dependencies (Express, EJS)
- **FONT_SPECIFICATIONS.md** - Complete typography guidelines and font specifications

### Language Implementation

The site uses a **two-phase approach** for bilingual support:

**Phase A (Completed):** Functional implementation with Spanish content and placeholder Catalan (marked with `[CA]` prefix)
**Phase B (Pending):** Replace placeholder Catalan translations with proper translations

Key implementation details:
- Single EJS template (`views/index.ejs`) handles both languages via template variables
- Language-specific content loaded from JSON files (`translations/es.json`, `translations/ca.json`)
- Server passes appropriate translation object to template based on route (`/` for Spanish, `/ca` for Catalan)
- SEO-friendly with hreflang tags, canonical URLs, and language attributes

### Design System (CSS Variables)

The site uses CSS custom properties defined in `:root`:

**Colors:**
- `--primary-color: #0d2c40` (Dark blue/teal for headers, text)
- `--secondary-color: #4fbdb3` (Light teal for accents, hover states, CTAs)
- `--text-color: #333` (Body text)
- `--background-color: #ffffff` (Main background)
- `--light-gray-color: #f4f4f4` (Section backgrounds)

**Typography:**
- `--font-family-default` - Inter (Google Fonts) with system fallbacks
- `--font-family-monospace` - SF Mono with fallbacks
- Container width: `1100px`

### Page Sections

1. **Header** - Fixed navigation with logo and social media links (Instagram, Facebook)
2. **Hero** - Full-screen background image with dark overlay and main heading
3. **Services** - 4 service categories with alternating image/text layout
4. **Philosophy** - Text content with supporting image
5. **Contact** - Form on left, contact info + map embed on right
6. **Footer** - Copyright text

### Responsive Design

Mobile breakpoint: `768px` (max-width)
- Header becomes vertical stack
- Service cards switch to single column
- Philosophy and contact sections stack vertically
- Hero padding adjusted for taller mobile header
- Font sizes reduced on mobile

## Development Workflow

### Running the Server

The development server runs on **port 4321** using:
```bash
npm start
```

Or for development with auto-reload (requires nodemon):
```bash
npm install -g nodemon
nodemon server.js
```

The site will be accessible at:
- Spanish: `http://localhost:4321/`
- Catalan: `http://localhost:4321/ca`

### Chrome DevTools Validation

**For every change request, use Chrome DevTools MCP to validate the changes** unless explicitly told otherwise. This includes:
- Taking snapshots to verify DOM changes
- Taking screenshots to validate visual appearance
- Using the Network tab to check resource loading (fonts, images)
- Using the Console to verify JavaScript functionality
- Testing responsive design at different breakpoints
- Checking accessibility and element visibility

This ensures that modifications work as expected in the browser before considering them complete.

## Development Notes

### Font Implementation

The site uses Inter from Google Fonts (weights 100-900) with system font fallbacks. See **FONT_SPECIFICATIONS.md** for complete typography guidelines, sizing recommendations, and implementation details.

### Smooth Scroll Navigation

The `js/script.js` file provides smooth scrolling for navigation links. It prevents default click behavior and uses `window.scrollTo()` with a 80px top offset (account for fixed header height).

### CTA Button Styling

The `.cta-button` class is used for the "Enviar" (Send) button in the contact form. It uses the secondary color with a darker hover state.

### Image Handling

- All images are in `assets/` folder
- Image paths in HTML use relative paths (e.g., `./assets/image.jpg`)
- CSS uses relative paths for hero background (e.g., `../assets/image.jpg`)
- Images use `object-fit: cover` in service cards for consistent sizing

### Social Media Links

External links in header are:
- Instagram: `https://www.instagram.com/axlespaidesalut/`
- Facebook: `https://www.facebook.com/axlespaidesalut`

### Contact Form

The form has fields for:
- Name (required)
- Email (required)
- Phone (optional)
- Message (required, textarea)

Form action is currently set to `#` (needs backend integration or service setup).

### Map Embed

Embedded Google Map iframe pointing to the clinic's physical location. The iframe has `referrerpolicy="no-referrer-when-downgrade"` for privacy.

## Common Development Tasks

### Updating Contact Information

Contact details are stored in translation JSON files for both languages:

**Spanish** (`translations/es.json`):
- Address: Carrer de Narcís Monturiol, 156, 08340 Vilassar de Mar, Barcelona
- Phone: +34 93 759 84 13
- Email: axl@fisioterapiavilassar.com
- Hours: Lunes a Viernes, 9:00-13:00 y 15:00-20:00

**Catalan** (`translations/ca.json`):
- Update the same fields with Catalan translations

To update contact information:
1. Edit the `contacto.info.details` object in both JSON files
2. Restart the server with `npm start`
3. Changes are reflected immediately on both language versions

### Adding or Modifying Services

Services are dynamically rendered from translation JSON files. To modify services:

1. Edit `translations/es.json` - update `servicios.categories` array:
```json
{
  "servicios": {
    "categories": [
      {
        "name": "SERVICE TITLE",
        "items": [
          "Service item 1",
          "Service item 2",
          "Service item 3"
        ]
      }
    ]
  }
}
```

2. Update the same structure in `translations/ca.json` with Catalan translations
3. Restart server - changes are reflected on both language versions

The EJS template automatically renders each service category with its image and items list.

### Changing Colors

Update the CSS variables in `style.css`:
```css
:root {
    --primary-color: [new color];
    --secondary-color: [new color];
    /* ... */
}
```

All usages throughout the site will automatically update.

### Modifying Hero Section

The hero background image is set via CSS:
```css
.hero {
    background: url('../assets/image.jpg') no-repeat center center/cover;
}
```

The hero has a `::before` pseudo-element creating a dark overlay (20% black).

## Testing & Validation

### Manual Testing Checklist

- [ ] Smooth scroll navigation works on all sections
- [ ] Hover states on links and buttons function correctly
- [ ] Responsive layout works on mobile (test at 768px and below)
- [ ] All images load and display correctly
- [ ] Hero section background image displays with overlay
- [ ] Form inputs are properly styled and functional
- [ ] Social media icons appear and link to correct profiles
- [ ] Map embed loads and is interactive
- [ ] External links open in new tabs where specified
- [ ] Text contrast meets accessibility standards
- [ ] Font loads from Google Fonts (check network tab)

### Browser Compatibility

The site targets all modern browsers with CSS Grid/Flexbox support:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (11+)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Considerations

- Google Fonts uses `preconnect` for optimization
- Single CSS file (7.8KB) with CSS variables
- Minimal JavaScript (661 bytes) for smooth scroll
- Hero background image uses efficient compression
- Service images are JPG format (smaller than PNG for photos)

## Language Implementation - Phase B (Catalan Translations)

**Status:** Phase A complete. Phase B pending.

### Phase B Tasks (For proper Catalan translation):
1. Extract final Spanish content from `translations/es.json`
2. Create professional Catalan translations
3. Replace `[CA]` placeholder content in `translations/ca.json`
4. Final QA testing on both language versions
5. Deploy updated translations

See `Docs/LANGUAGE_IMPLEMENTATION_PLAN.md` for complete implementation details.

## Future Enhancement Ideas

- Backend integration for contact form (currently no action endpoint)
- Service booking system
- Staff profiles/testimonials section
- Blog or news section
- Automatic language detection based on browser Accept-Language header
- Dark mode variant (CSS variables support this well)
- Analytics tracking per language
- Sitemap generation for both language versions
- RSS feed support
