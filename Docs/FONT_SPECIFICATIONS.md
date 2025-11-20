# Font Specifications & Guidelines

## Overview

This document outlines the standard font specifications for the fisioterapiavilassar.com website. These guidelines ensure consistency across all pages and sections using **Inter** from Google Fonts as the primary typeface, with system font fallbacks for optimal performance and reliability.

**Primary Font:** Inter (Google Fonts)
**Fallback Chain:** System fonts + web-safe alternatives
**Loading:** Optimized with `preconnect` and `font-display: swap`

---

## Primary Font Stack

### Default Body & UI Font

**Purpose:** Used for body text, UI elements, headers, and general content across the site.

```css
font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
```

**Font Selection Logic:**
- **Primary:** Inter (Google Fonts) - Modern, geometric, web-optimized
- **Fallback (if Google Fonts unavailable):** System font stack (SF Pro/Segoe UI)
- **Final Fallback:** Helvetica, Arial, generic sans-serif

**Characteristics:**
- Modern, clean, geometric aesthetic
- Excellent readability on all screen sizes
- Professional appearance
- Specifically designed for web use
- Variable font with full range: weights 100-900

**Google Fonts Import (in HTML head):**
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
```

---

## Monospace Font Stack

### Code & Technical Content

**Purpose:** Used for code blocks, technical snippets, and pre-formatted text.

```css
font-family: "SF Mono", Menlo, Monaco, "Courier New", monospace;
```

**Font Selection Logic (by OS):**
- **macOS/iOS:** SF Mono - Native monospace font
- **Windows/Linux:** Menlo or Monaco
- **Fallback:** Courier New, generic monospace

**Usage Examples:**
- Code snippets
- Command line examples
- Data displays
- Technical documentation

---

## Font Weight & Styling Recommendations

### For Primary Font Stack

| Use Case | Weight | CSS | Notes |
|----------|--------|-----|-------|
| Body Text | 400 (Regular) | `font-weight: 400;` | Default, standard readability |
| Emphasis/Strong | 600-700 (Semibold/Bold) | `font-weight: 600;` or `font-weight: 700;` | Use sparingly for emphasis |
| Headings (H1-H6) | 600-700 | `font-weight: 600;` | Depends on heading level |
| Light Text | 300 (Light) | `font-weight: 300;` | Secondary, decorative content |

### Font Size Guidelines

| Element | Size | Weight | Line Height | Example |
|---------|------|--------|-------------|---------|
| H1 (Page Title) | 32-48px | 700 | 1.2-1.3 | Main headings |
| H2 (Section Title) | 24-32px | 700 | 1.3-1.4 | Section headings |
| H3 (Subsection) | 20-24px | 600 | 1.4-1.5 | Subsection headings |
| H4 & Below | 16-20px | 600 | 1.5 | Minor headings |
| Body Text | 14-16px | 400 | 1.5-1.6 | Paragraph text |
| Small Text | 12-14px | 400 | 1.5 | Captions, labels |
| Code Blocks | 13-14px | 400 | 1.5 | Pre-formatted text |

---

## Color & Contrast

While fonts are specified separately from colors, ensure adequate contrast ratios:

- **Body text on light background:** Use dark color (#333, #000, etc.)
- **Body text on dark background:** Use light color (#f0f0f0, #fff, etc.)
- **WCAG AA compliance:** Minimum 4.5:1 contrast ratio for normal text, 3:1 for large text

---

## Implementation Examples

### Basic HTML Setup

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Root font stack */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.6;
        }

        /* Monospace for code */
        code, pre {
            font-family: "SF Mono", Menlo, Monaco, "Courier New", monospace;
            font-size: 14px;
        }

        /* Headings */
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
        }

        h2 {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.3;
        }

        h3 {
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1.4;
        }

        h4, h5, h6 {
            font-size: 1.25rem;
            font-weight: 600;
            line-height: 1.5;
        }

        /* Strong/Bold emphasis */
        strong, b {
            font-weight: 700;
        }

        /* Light text */
        .light-text {
            font-weight: 300;
        }
    </style>
</head>
<body>
    <!-- Your content here -->
</body>
</html>
```

### CSS Font Face Setup (Optional Web Fonts)

If you need to extend beyond system fonts in the future, use this pattern:

```css
/* Example: Adding a custom display font */
@font-face {
    font-family: 'CustomFont';
    src: url('/fonts/custom-font.woff2') format('woff2'),
         url('/fonts/custom-font.woff') format('woff');
    font-weight: normal;
    font-style: normal;
    font-display: swap; /* Fallback to system font while loading */
}

/* Use custom font for specific elements */
.display-heading {
    font-family: 'CustomFont', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}
```

---

## Section-Specific Font Guidance

### Header/Navigation
- **Font:** Primary font stack
- **Weight:** 500-600
- **Size:** 14-18px
- **Note:** Keep readable and not too heavy

### Hero Section
- **Font:** Primary font stack
- **Weight:** 700 (bold)
- **Size:** 32-48px (depending on device)
- **Note:** Should be visually prominent

### Body Content
- **Font:** Primary font stack
- **Weight:** 400
- **Size:** 16px
- **Line Height:** 1.6 (important for readability)

### Call-to-Action (CTA) Buttons
- **Font:** Primary font stack
- **Weight:** 600
- **Size:** 14-16px
- **Note:** Slightly heavier for emphasis

### Footer
- **Font:** Primary font stack
- **Weight:** 400-500
- **Size:** 12-14px
- **Note:** Can be slightly smaller than body

### Code/Technical Elements
- **Font:** Monospace font stack
- **Weight:** 400
- **Size:** 13-14px
- **Note:** Use `<code>` and `<pre>` tags

---

## Migration from Wix Fonts

### Fonts Being Replaced

| Wix Font | Replacement | Rationale |
|----------|-------------|-----------|
| Madefor | Inter (Google Fonts) | Modern, geometric, web-optimized alternative with similar aesthetic |
| HelveticaNeueW01/W02/W10 (various weights) | Inter (multiple weights) | Cleaner, more modern appearance with better web compatibility |
| Monaco/Menlo (monospace) | "SF Mono"/Menlo/Monaco with fallbacks | Same monospace feel, system-optimized |

### Benefits of Migration

✅ **Modern Aesthetic:** Inter is specifically designed for contemporary web use
✅ **Consistency:** Renders identically across all browsers and OS
✅ **Performance:** Optimized Google Font with preconnect for faster loading
✅ **Accessibility:** Professional typeface designed for readability
✅ **Reliability:** No font availability issues - always loads correctly
✅ **Professional Fallbacks:** System fonts provide instant display if CDN unavailable

---

## Checklist for New Page Creation

- [ ] Apply primary font stack to `<body>` tag
- [ ] Use monospace stack for `<code>` and `<pre>` elements
- [ ] Define font weights and sizes for all heading levels (H1-H6)
- [ ] Ensure minimum 16px font size for body text on mobile
- [ ] Verify line height is at least 1.5 for body text
- [ ] Test heading readability on all screen sizes
- [ ] Verify color contrast meets WCAG AA standards
- [ ] Test on different browsers (Chrome, Firefox, Safari, Edge)
- [ ] Test on different operating systems (macOS, Windows, iOS, Android)

---

## Browser & OS Compatibility

The recommended font stacks are compatible with:

- ✅ macOS 10.11+
- ✅ iOS 9+
- ✅ Windows Vista+
- ✅ Android 4.4+
- ✅ All modern browsers (Chrome, Firefox, Safari, Edge)

---

## Additional Resources

- [WCAG 2.1 Text Spacing Guidelines](https://www.w3.org/WAI/WCAG21/Understanding/text-spacing.html)
- [System Font Stacks](https://systemfontstack.com/)
- [Web Typography Best Practices](https://www.smashingmagazine.com/2015/02/using-system-ui-fonts-practical-guide/)
- [Font Loading Strategy - font-display property](https://developer.mozilla.org/en-US/docs/Web/CSS/@font-face/font-display)

---

## Questions or Updates?

If you encounter any issues with font rendering or need to add new font specifications, please update this document and notify the development team.

**Last Updated:** November 19, 2025
**Version:** 1.0
