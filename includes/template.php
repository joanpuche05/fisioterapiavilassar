<!DOCTYPE html>
<html lang="<?php e($lang); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php e($t['meta']['description']); ?>">

    <!-- Language Alternates for SEO -->
    <link rel="alternate" hreflang="ca" href="<?php echo baseUrl(); ?>/">
    <link rel="alternate" hreflang="es" href="<?php echo baseUrl(); ?>/es">
    <link rel="alternate" hreflang="x-default" href="<?php echo baseUrl(); ?>/">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo baseUrl(); ?><?php echo $lang === 'es' ? '/es' : ''; ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">

    <title><?php e($t['meta']['title']); ?></title>
</head>

<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="#inicio">
                    <img src="<?php echo asset('assets/logo.png'); ?>" alt="<?php e($t['images']['logo']); ?>">
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
                <?php if ($lang === 'ca'): ?>
                    <a href="/es" class="lang-link" title="Español">Español</a>
                <?php else: ?>
                    <a href="/" class="lang-link" title="Català">Català</a>
                <?php endif; ?>
            </div>

            <!-- Social Media -->
            <div class="social-media">
                <a href="https://www.instagram.com/axlespaidesalut/" target="_blank" aria-label="Instagram">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg" role="img">
                        <path
                            d="M12.5 8.112a4.388 4.388 0 1 0 0 8.776 4.388 4.388 0 0 0 0-8.776zm0 7.157a2.77 2.77 0 1 1 0-5.538 2.77 2.77 0 0 1 0 5.538z">
                        </path>
                        <path d="M16.963 6.954a1.037 1.037 0 1 0 0 2.074 1.037 1.037 0 0 0 0-2.074z"></path>
                        <path
                            d="M19.16 0H5.84C2.62 0 0 2.62 0 5.84v13.32C0 22.38 2.62 25 5.84 25h13.32C22.38 25 25 22.38 25 19.16V5.84C25 2.62 22.38 0 19.16 0zm3.22 19.16c0 1.777-1.443 3.22-3.22 3.22H5.84c-1.777 0-3.22-1.443-3.22-3.22V5.84c0-1.777 1.443-3.22 3.22-3.22h13.32c1.777 0 3.22 1.443 3.22 3.22v13.32z">
                        </path>
                    </svg>
                </a>
                <a href="https://www.facebook.com/axlespaidesalut" target="_blank" aria-label="Facebook">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg" role="img">
                        <path
                            d="M23.998 12.5C23.998 5.602 18.397 0 11.5 0S-1.002 5.602-1.002 12.5c0 6.203 4.542 11.338 10.593 12.335V16.63H6.847V12.5h2.744V9.622c0-2.72 1.623-4.222 4.1-4.222 1.17 0 2.36.208 2.36.208v3.477h-1.78c-1.354 0-1.79.85-1.79 1.72v2.193h3.94l-.62 4.13h-3.32V24.57c6.14-.848 10.823-5.99 10.823-12.07z">
                        </path>
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
                        <img src="<?php echo asset('assets/Manos que ofrecen apoyo.jpeg'); ?>"
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
                                ?>
                                <img src="<?php echo asset('assets/' . $imageMap[$index]); ?>"
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
                                <input type="text" id="name" name="name"
                                    placeholder="<?php e($t['contacto']['form']['placeholders']['nombre']); ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="email"><?php e($t['contacto']['form']['labels']['email']); ?></label>
                                <input type="email" id="email" name="email"
                                    placeholder="<?php e($t['contacto']['form']['placeholders']['email']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="phone"><?php e($t['contacto']['form']['labels']['telefono']); ?></label>
                                <input type="tel" id="phone" name="phone"
                                    placeholder="<?php e($t['contacto']['form']['placeholders']['telefono']); ?>">
                            </div>

                            <div class="form-group">
                                <label for="message"><?php e($t['contacto']['form']['labels']['mensaje']); ?></label>
                                <textarea id="message" name="message" rows="5"
                                    placeholder="<?php e($t['contacto']['form']['placeholders']['mensaje']); ?>"
                                    required></textarea>
                            </div>

                            <button type="submit"
                                class="cta-button"><?php e($t['contacto']['form']['button']); ?></button>
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
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2987.1234567890!2d2.3850000!3d41.5270000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a8a1850000000%3A0x1234567890!2sCarrer%20de%20Narc%C3%ADs%20Monturiol%2C%20156%2C%2008340%20Vilassar%20de%20Mar%2C%20Barcelona!5e0!3m2!1sen!2ses!4v1700000000000!5m2!1sen!2ses"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
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
    <script src="<?php echo asset('js/script.js'); ?>"></script>
</body>

</html>