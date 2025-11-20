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
  console.log(`Spanish: http://localhost:${PORT}/`);
  console.log(`Catalan: http://localhost:${PORT}/ca`);
});
