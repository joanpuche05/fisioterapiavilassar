# Fisioterapia Vilassar

A bilingual website for Axl Espai De Salut, a physiotherapy clinic in Vilassar de Mar, Barcelona. The site supports both Catalan (default) and Spanish with separate URL routes for SEO optimization.

## Table of Contents

- [Overview](#overview)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Features](#features)
- [Local Development Setup](#local-development-setup)
- [Environment Configuration](#environment-configuration)
- [Deployment](#deployment)
- [Deployment Workflow](#deployment-workflow)
- [Useful Commands](#useful-commands)
- [Maintenance](#maintenance)

## Overview

This is a single-page website built with Node.js/Express and EJS templating. It features:
- Bilingual support (Catalan and Spanish)
- Contact form with email functionality
- Responsive design
- HTTPS with SSL certificate
- Production deployment with PM2 process manager

**Live Site:** https://aws.fisioterapiavilassar.com

## Technology Stack

- **Backend:** Node.js with Express 5.x
- **Template Engine:** EJS
- **Styling:** Vanilla CSS with CSS variables
- **JavaScript:** Vanilla JS (smooth scroll navigation)
- **Email:** Nodemailer with SMTP
- **Process Manager:** PM2 (production)
- **Web Server:** Nginx (reverse proxy)
- **SSL:** Let's Encrypt (Certbot)

## Project Structure

```
fisioterapiavilassar/
├── public/
│   ├── css/
│   │   └── style.css           # All styling with CSS variables
│   ├── js/
│   │   └── script.js           # Smooth scroll functionality
│   └── assets/                 # Images (JPG/JPEG format)
├── translations/
│   ├── es.json                 # Spanish translations
│   └── ca.json                 # Catalan translations
├── views/
│   ├── index.ejs               # Main template (serves both languages)
│   └── email-template.ejs      # Email template for contact form
├── .env                        # Environment variables (not in git)
├── .env.example                # Environment variables template
├── server.js                   # Express server and routes
├── package.json                # Dependencies and scripts
└── README.md                   # This file
```

## Features

### Sections
1. **Header** - Fixed navigation with logo and language switcher
2. **Hero** - Full-screen background image with main heading
3. **Services** - 4 service categories with alternating image/text layout
4. **Philosophy** - Text content with supporting image
5. **Contact** - Form with SMTP email integration + contact info + map embed
6. **Footer** - Copyright text

### Bilingual Implementation
- **Catalan (default):** `https://aws.fisioterapiavilassar.com/`
- **Spanish:** `https://aws.fisioterapiavilassar.com/es`
- Single EJS template with translation variables
- Language-specific content loaded from JSON files
- SEO-friendly with hreflang tags and canonical URLs

### Responsive Design
- Mobile breakpoint: 768px
- Single column layout on mobile
- Adjusted typography and spacing

## Local Development Setup

### Prerequisites
- Node.js (v18+)
- npm

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/joanpuche05/fisioterapiavilassar.git
   cd fisioterapiavilassar
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Configure environment variables**
   ```bash
   cp .env.example .env
   ```
   Edit `.env` with your SMTP credentials (see [Environment Configuration](#environment-configuration))

4. **Start the development server**
   ```bash
   npm start
   ```

5. **Open in browser**
   - Catalan: http://localhost:4321/
   - Spanish: http://localhost:4321/es

## Environment Configuration

Create a `.env` file in the project root with the following variables:

```env
# Email Configuration
SMTP_HOST=your-smtp-host.com
SMTP_PORT=587
SMTP_USER=your-email@example.com
SMTP_PASSWORD=your-app-password
SMTP_FROM_EMAIL=noreply@example.com
RECIPIENT_EMAIL=recipient@example.com
```

### Email Setup Notes
- The contact form uses SMTP to send emails
- Recommended providers: Gmail (with App Password), SendGrid, AWS SES
- For Gmail: Enable 2FA and create an App Password
- The form will still work without SMTP configured (will log to console)

## Deployment

The project is deployed on AWS EC2 with the following setup:

### Server Architecture
- **Server:** AWS EC2 instance
- **OS:** Amazon Linux 2023
- **Node.js:** v18.20.8
- **Process Manager:** PM2 (keeps app running, auto-restart)
- **Web Server:** Nginx (reverse proxy on port 80/443)
- **SSL:** Let's Encrypt certificate (auto-renewal)
- **Domain:** aws.fisioterapiavilassar.com

### Initial Server Setup (One-Time)

This setup was already completed for the production server, but here's the process for reference:

1. **Install dependencies**
   ```bash
   # Node.js and npm should already be installed
   npm install -g pm2
   ```

2. **Clone and setup project**
   ```bash
   cd /home/ec2-user/app
   git clone https://github.com/joanpuche05/fisioterapiavilassar.git
   cd fisioterapiavilassar
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with production SMTP credentials
   nano .env
   ```

4. **Start with PM2**
   ```bash
   pm2 start server.js --name fisioterapiavilassar
   pm2 save
   pm2 startup
   # Run the command that PM2 outputs
   ```

5. **Configure Nginx**

   Create `/etc/nginx/conf.d/aws.fisioterapiavilassar.com.conf`:
   ```nginx
   server {
       listen 80;
       listen [::]:80;
       server_name aws.fisioterapiavilassar.com;

       location / {
           proxy_pass http://localhost:4321;
           proxy_http_version 1.1;
           proxy_set_header Upgrade $http_upgrade;
           proxy_set_header Connection 'upgrade';
           proxy_set_header Host $host;
           proxy_set_header X-Real-IP $remote_addr;
           proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
           proxy_set_header X-Forwarded-Proto $scheme;
           proxy_cache_bypass $http_upgrade;
       }

       access_log /var/log/nginx/aws.fisioterapiavilassar.com.access.log;
       error_log /var/log/nginx/aws.fisioterapiavilassar.com.error.log;
   }
   ```

   ```bash
   sudo nginx -t
   sudo systemctl reload nginx
   ```

6. **Setup SSL certificate**
   ```bash
   sudo certbot --nginx -d aws.fisioterapiavilassar.com
   ```

## Deployment Workflow

### Deploying Changes to Production

When you push changes to the GitHub repository, follow these steps to deploy to the server:

1. **SSH into the server**
   ```bash
   ssh ec2-user@<server-ip>
   ```

2. **Navigate to project directory**
   ```bash
   cd /home/ec2-user/app/fisioterapiavilassar
   ```

3. **Pull the latest changes**
   ```bash
   git pull
   ```

4. **Install any new dependencies** (if package.json changed)
   ```bash
   npm install
   ```

5. **Restart the application**
   ```bash
   pm2 restart fisioterapiavilassar
   ```

6. **Verify deployment**
   ```bash
   pm2 status
   pm2 logs fisioterapiavilassar --lines 20
   ```

7. **Test the site**
   Visit https://aws.fisioterapiavilassar.com to verify changes

### Quick Deployment Script

You can create a deployment script for convenience:

```bash
#!/bin/bash
# deploy.sh
cd /home/ec2-user/app/fisioterapiavilassar
git pull
npm install
pm2 restart fisioterapiavilassar
pm2 status
```

Make it executable and run:
```bash
chmod +x deploy.sh
./deploy.sh
```

## Useful Commands

### Development
```bash
npm start                  # Start development server
npm run dev               # Start development server (alternative)
```

### PM2 Process Management
```bash
pm2 status                          # Check application status
pm2 logs fisioterapiavilassar       # View live logs
pm2 logs fisioterapiavilassar --lines 50  # View last 50 log lines
pm2 restart fisioterapiavilassar    # Restart application
pm2 stop fisioterapiavilassar       # Stop application
pm2 start fisioterapiavilassar      # Start application
pm2 monit                           # Monitor CPU/memory usage
pm2 save                            # Save current process list
```

### Nginx
```bash
sudo nginx -t                 # Test configuration
sudo systemctl reload nginx   # Reload configuration
sudo systemctl restart nginx  # Restart Nginx
sudo systemctl status nginx   # Check Nginx status
```

### SSL Certificate
```bash
sudo certbot certificates                # Check certificate status
sudo certbot renew --dry-run            # Test renewal process
sudo systemctl status certbot-renew.timer  # Check auto-renewal timer
```

### Git
```bash
git status                    # Check working tree status
git pull                      # Pull latest changes
git log --oneline -10         # View last 10 commits
```

## Maintenance

### Log Files
- **Application logs:** `~/.pm2/logs/`
- **Nginx access logs:** `/var/log/nginx/aws.fisioterapiavilassar.com.access.log`
- **Nginx error logs:** `/var/log/nginx/aws.fisioterapiavilassar.com.error.log`

### SSL Certificate Renewal
- Certificates auto-renew via systemd timer
- Expires: Check with `sudo certbot certificates`
- Manual renewal: `sudo certbot renew`

### Backup Recommendations
- Database: Not applicable (static content)
- `.env` file: Backup SMTP credentials securely
- Images: `/public/assets/` directory

### Monitoring
```bash
# Check if application is running
pm2 status

# Monitor resource usage
pm2 monit

# Check server resources
htop
df -h        # Disk usage
free -h      # Memory usage
```

## Troubleshooting

### Application won't start
```bash
# Check logs for errors
pm2 logs fisioterapiavilassar

# Check if port 4321 is available
sudo netstat -tlnp | grep 4321

# Restart PM2 daemon
pm2 kill
pm2 start server.js --name fisioterapiavilassar
```

### Site not accessible
```bash
# Check Nginx status
sudo systemctl status nginx

# Check Nginx error logs
sudo tail -f /var/log/nginx/aws.fisioterapiavilassar.com.error.log

# Verify DNS
nslookup aws.fisioterapiavilassar.com
```

### Contact form not sending emails
1. Check `.env` file has correct SMTP credentials
2. Check application logs: `pm2 logs fisioterapiavilassar`
3. Verify SMTP settings with your email provider
4. Check for firewall blocking SMTP ports (587, 465)

## Contributing

1. Create a feature branch
2. Make your changes
3. Test locally
4. Commit with clear messages
5. Push to GitHub
6. Deploy to production following [Deployment Workflow](#deployment-workflow)

## License

ISC

## Contact

For questions or support, contact the development team.

---

**Last Updated:** November 2025
