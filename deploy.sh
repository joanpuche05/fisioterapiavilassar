#!/bin/bash

# Deployment script for fisioterapiavilassar.com
# Usage: ./deploy.sh

set -e  # Exit on any error

echo "🚀 Starting deployment..."

# Store current commit for potential rollback
CURRENT_COMMIT=$(git rev-parse HEAD)
echo "📝 Current commit: $CURRENT_COMMIT"

# Pull latest changes from main branch
echo "📥 Pulling latest changes from main..."
git pull origin main

# Check if package.json changed
NEW_COMMIT=$(git rev-parse HEAD)
if git diff --name-only $CURRENT_COMMIT $NEW_COMMIT | grep -q "package.json"; then
    echo "📦 package.json changed, installing dependencies..."
    npm install --production
else
    echo "✅ No dependency changes detected"
fi

# Restart application with PM2
echo "🔄 Restarting application..."
if pm2 list | grep -q "fisioterapiavilassar"; then
    pm2 restart fisioterapiavilassar
    echo "✅ Application restarted"
else
    pm2 start server.js --name fisioterapiavilassar
    echo "✅ Application started"
fi

# Show PM2 status
pm2 list

echo "✨ Deployment complete!"
echo ""
echo "Useful commands:"
echo "  pm2 logs fisioterapiavilassar  - View logs"
echo "  pm2 status                      - Check status"
echo "  pm2 restart fisioterapiavilassar - Restart app"
echo "  git reset --hard $CURRENT_COMMIT - Rollback to previous version"
