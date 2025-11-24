const express = require('express');
const path = require('path');
const nodemailer = require('nodemailer');
const multer = require('multer');
const axios = require('axios');
require('dotenv').config();
const app = express();

// Configure multer for form data
const upload = multer();

// Load translations
const translations = {
  es: require('./translations/es.json'),
  ca: require('./translations/ca.json')
};

// Configure nodemailer transporter
const transporter = nodemailer.createTransport({
  host: process.env.SMTP_HOST,
  port: process.env.SMTP_PORT,
  secure: process.env.SMTP_PORT == 465,
  auth: {
    user: process.env.SMTP_USER,
    pass: process.env.SMTP_PASSWORD
  }
});

// Cloudflare Turnstile verification function
async function verifyTurnstileToken(token) {
  try {
    const response = await axios.post(
      'https://challenges.cloudflare.com/turnstile/v0/siteverify',
      {
        secret: process.env.TURNSTILE_SECRET_KEY,
        response: token
      },
      {
        headers: {
          'Content-Type': 'application/json'
        }
      }
    );

    return response.data.success;
  } catch (error) {
    console.error('Turnstile verification error:', error);
    return false;
  }
}

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

// Catalan version (default)
app.get('/', (req, res) => {
  res.render('index', {
    t: translations.ca,
    lang: 'ca',
    alternateLang: 'es',
    alternateLangName: 'Español'
  });
});

// Catalan version (with /ca prefix for consistency with privacy policy)
app.get('/ca', (req, res) => {
  res.render('index', {
    t: translations.ca,
    lang: 'ca',
    alternateLang: 'es',
    alternateLangName: 'Español'
  });
});

// Spanish version
app.get('/es', (req, res) => {
  res.render('index', {
    t: translations.es,
    lang: 'es',
    alternateLang: 'ca',
    alternateLangName: 'Català'
  });
});

// Catalan Privacy Policy
app.get('/ca/politica-de-privacitat', (req, res) => {
  res.render('privacy-policy', {
    t: translations.ca,
    lang: 'ca',
    alternateLang: 'es',
    alternateLangName: 'Español'
  });
});

// Spanish Privacy Policy
app.get('/es/politica-de-privacidad', (req, res) => {
  res.render('privacy-policy', {
    t: translations.es,
    lang: 'es',
    alternateLang: 'ca',
    alternateLangName: 'Català'
  });
});

// Contact form handler - Catalan
app.post('/', upload.none(), async (req, res) => {
  try {
    const { nombre, email, telefono, mensaje, 'cf-turnstile-response': turnstileToken } = req.body;

    // Validate CAPTCHA
    if (!turnstileToken) {
      return res.status(400).json({
        success: false,
        message: translations.ca.contacto.form.captchaRequired || 'CAPTCHA verification required'
      });
    }

    const isCaptchaValid = await verifyTurnstileToken(turnstileToken);
    if (!isCaptchaValid) {
      return res.status(400).json({
        success: false,
        message: translations.ca.contacto.form.captchaFailed || 'CAPTCHA verification failed'
      });
    }

    // Validate required fields
    if (!nombre || !email || !mensaje) {
      return res.status(400).json({
        success: false,
        message: translations.ca.contacto.form.error || 'Please fill in all required fields'
      });
    }

    // Render email template
    const emailHtml = await new Promise((resolve, reject) => {
      const data = {
        name: nombre,
        email: email,
        phone: telefono,
        message: mensaje,
        isSpanish: false
      };
      res.app.render('email-template', data, (err, html) => {
        if (err) reject(err);
        else resolve(html);
      });
    });

    // Send email
    await transporter.sendMail({
      from: `Web fisioterapiavilassar <${process.env.SMTP_FROM_EMAIL}>`,
      to: `${process.env.RECIPIENT_EMAIL}, axl@fisioterapiavilassar.com`,
      replyTo: email,
      subject: `${translations.ca.contacto.form.emailSubject} ${nombre}`,
      html: emailHtml
    });

    res.json({
      success: true,
      message: translations.ca.contacto.form.success || 'Message sent successfully'
    });
  } catch (error) {
    console.error('Email error:', error);
    res.status(500).json({
      success: false,
      message: translations.ca.contacto.form.errorServer || 'Error sending message'
    });
  }
});

// Contact form handler - Spanish
app.post('/es', upload.none(), async (req, res) => {
  try {
    const { nombre, email, telefono, mensaje, 'cf-turnstile-response': turnstileToken } = req.body;

    // Validate CAPTCHA
    if (!turnstileToken) {
      return res.status(400).json({
        success: false,
        message: translations.es.contacto.form.captchaRequired || 'CAPTCHA verification required'
      });
    }

    const isCaptchaValid = await verifyTurnstileToken(turnstileToken);
    if (!isCaptchaValid) {
      return res.status(400).json({
        success: false,
        message: translations.es.contacto.form.captchaFailed || 'CAPTCHA verification failed'
      });
    }

    // Validate required fields
    if (!nombre || !email || !mensaje) {
      return res.status(400).json({
        success: false,
        message: translations.es.contacto.form.error || 'Please fill in all required fields'
      });
    }

    // Render email template
    const emailHtml = await new Promise((resolve, reject) => {
      const data = {
        name: nombre,
        email: email,
        phone: telefono,
        message: mensaje,
        isSpanish: true
      };
      res.app.render('email-template', data, (err, html) => {
        if (err) reject(err);
        else resolve(html);
      });
    });

    // Send email
    await transporter.sendMail({
      from: `Web fisioterapiavilassar <${process.env.SMTP_FROM_EMAIL}>`,
      to: `${process.env.RECIPIENT_EMAIL}, axl@fisioterapiavilassar.com`,
      replyTo: email,
      subject: `${translations.es.contacto.form.emailSubject} ${nombre}`,
      html: emailHtml
    });

    res.json({
      success: true,
      message: translations.es.contacto.form.success || 'Message sent successfully'
    });
  } catch (error) {
    console.error('Email error:', error);
    res.status(500).json({
      success: false,
      message: translations.es.contacto.form.errorServer || 'Error sending message'
    });
  }
});

// 404 handler
app.use((req, res) => {
  res.status(404).send('Page not found');
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
  console.log(`Catalan (default): http://localhost:${PORT}/`);
  console.log(`Spanish: http://localhost:${PORT}/es`);
});
