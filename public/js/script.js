document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('header nav a');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80, // 80px offset for fixed header
                    behavior: 'smooth'
                });
            }
        });
    });

    // Contact form submission handler
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactFormSubmit);
    }

    // Initialize parallax effect
    updateParallax();
});

// Handle contact form submission
async function handleContactFormSubmit(e) {
    e.preventDefault();

    const form = e.target;
    const formMessage = document.getElementById('formMessage');
    const submitBtn = document.getElementById('submitBtn');
    const originalBtnText = submitBtn.textContent;

    // Show loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Enviando...';
    formMessage.style.display = 'none';

    try {
        const formData = new FormData(form);
        const response = await fetch(window.location.pathname, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            // Show success message
            formMessage.className = 'form-message success';
            formMessage.textContent = result.message;
            formMessage.style.display = 'block';

            // Reset form
            form.reset();

            // Hide success message after 5 seconds
            setTimeout(() => {
                formMessage.style.display = 'none';
            }, 5000);
        } else {
            // Show error message
            formMessage.className = 'form-message error';
            formMessage.textContent = result.message;
            formMessage.style.display = 'block';
        }
    } catch (error) {
        console.error('Form submission error:', error);
        formMessage.className = 'form-message error';
        formMessage.textContent = 'Error al enviar el mensaje. Por favor, intenta de nuevo.';
        formMessage.style.display = 'block';
    } finally {
        // Restore button state
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
    }
}

// Parallax scrolling effect for hero section
function updateParallax() {
    const hero = document.querySelector('.hero');
    if (hero) {
        const scrollPosition = window.pageYOffset;
        hero.style.backgroundPosition = `center ${scrollPosition * 0.5}px`;
    }
}

window.addEventListener('scroll', updateParallax);
