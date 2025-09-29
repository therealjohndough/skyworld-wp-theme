# 🧪 Test → Commit → Auto Deploy Workflow

## � Complete Testing & Deployment Pipeline

Your Skyworld theme now has a **professional 3-stage deployment process**:

**Stage 1: 🧪 LOCAL TESTING** → **Stage 2: 📝 COMMIT** → **Stage 3: 🚀 AUTO DEPLOY**

---

## Stage 1: 🧪 Local Testing (Before Commit)

### Run Tests Locally:
```bash
# Run comprehensive local tests 
./scripts/test-theme.sh
```

### What Gets Tested:
- ✅ **PHP Syntax** - All PHP files checked for errors
- ✅ **CSS Validation** - Balanced braces, syntax checking  
- ✅ **WordPress Compatibility** - Functions, coding standards
- ✅ **File Structure** - Required theme files present
- ✅ **MAMP Connectivity** - Local development server test

### Manual Testing Checklist:
- [ ] Theme loads in MAMP (http://localhost:8888/case_study_labs/)
- [ ] Front page displays correctly
- [ ] About page styling works
- [ ] Strain library functions properly
- [ ] Media kit page renders correctly
- [ ] Mobile responsive design works
- [ ] No PHP errors in debug log

---

## Stage 2: 📝 Commit Process

### Only commit if all tests pass:
```bash
# After tests pass ✅
git add -A
git commit -m "Feature: Your descriptive commit message"
git push origin dev/skyworld
```

---

## Stage 3: 🚀 Auto Deploy Pipeline

### GitHub Actions Pipeline:
1. **🔍 PHP Code Quality Tests**
   - Syntax validation for all PHP files
   - WordPress coding standards check
   - Deprecated function detection

2. **🌐 WordPress Environment Tests**
   - Full WordPress installation in CI
   - Theme installation and activation test
   - Functions.php compatibility check
   - WordPress core functionality test

3. **🎨 Frontend Asset Tests**
   - CSS validity testing
   - JavaScript syntax checking (if applicable)
   - Asset file structure verification

4. **🚧 Deploy to Staging** (Only if all tests pass)
   - Automatic deployment to staging environment
   - Staging site accessibility test
   - Cache warming

5. **🌍 Deploy to Production** (Manual approval required)
   - Production deployment after staging verification
   - Live site monitoring
   - Rollback capability

---

## Current Deployment Status
✅ **Complete Testing Pipeline** - 3-stage automated testing
✅ **WordPress Environment Testing** - Full WP installation in CI  
✅ **cPanel deployment configured** - Ready to activate
✅ **GitHub Actions workflows** - Comprehensive testing
✅ **Local testing script** - Run before commits

## Option 1: cPanel Auto-Deploy (RECOMMENDED)

### Your Current Setup:
- Target: `dev.skyworldcannabis.com`
- Path: `/home/sjradmin/dev.skyworldcannabis.com/wp-content/themes/skyworld-wp-child`
- Trigger: Every push to `dev/skyworld` branch

### To Activate:
1. **Log into your cPanel hosting dashboard**
2. **Find "Git Version Control" or "Repository Deployment"**
3. **Connect your GitHub repository**: `therealjohndough/skyworld-wp-theme`
4. **Set branch**: `dev/skyworld`
5. **Enable auto-deployment on push**

### Benefits:
- ✅ Instant deployment on git push
- ✅ Proper file permissions automatically set
- ✅ Complete theme replacement (no conflicts)
- ✅ Deployment logging and verification

---

## Option 2: GitHub Actions CI/CD (Professional)

Add this workflow to automatically deploy to multiple environments:

```yaml
# .github/workflows/deploy.yml
name: Deploy to Production

on:
  push:
    branches: [ dev/skyworld ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      
      - name: Deploy to cPanel via FTP
        uses: SamKirkland/FTP-Deploy-Action@4.3.3
        with:
          server: ${{ secrets.FTP_SERVER }}
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          local-dir: ./
          server-dir: /wp-content/themes/skyworld-wp-child/
```

---

## Option 3: Webhook Deployment

Set up a webhook endpoint on your server that pulls changes automatically:

```php
// webhook-deploy.php (place in your website root)
<?php
$secret = 'your-webhook-secret';
$payload = json_decode(file_get_contents('php://input'), true);

if (hash_hmac('sha256', file_get_contents('php://input'), $secret) === $_SERVER['HTTP_X_HUB_SIGNATURE_256']) {
    if ($payload['ref'] === 'refs/heads/dev/skyworld') {
        shell_exec('cd /path/to/theme && git pull origin dev/skyworld 2>&1');
        echo "Deployment successful!";
    }
}
?>
```

---

## Option 4: WP Engine Git Push (If using WP Engine)

WP Engine has built-in Git deployment:
1. **Connect repository** in WP Engine dashboard
2. **Set branch** to `dev/skyworld`
3. **Enable auto-deploy** on push

---

## Recommended Workflow

### For Development:
```bash
# Make changes locally
git add -A
git commit -m "Feature: Add new functionality"
git push origin dev/skyworld
# 🚀 Auto-deploys to dev.skyworldcannabis.com
```

### For Production:
```bash
# When ready for production
git checkout main
git merge dev/skyworld
git push origin main
# 🚀 Auto-deploys to production site
```

---

## Testing Your Setup

After configuring, test with a small change:

```bash
# Add a comment to your CSS
echo "/* Auto-deploy test */" >> assets/css/skyworld.css
git add -A
git commit -m "Test: Auto-deployment verification"
git push origin dev/skyworld
```

Then check your live site in 1-2 minutes to verify the change appeared.

---

## Security Best Practices

1. **Use environment variables** for sensitive data
2. **Restrict webhook IPs** to GitHub's ranges
3. **Use SSH keys** instead of passwords when possible
4. **Monitor deployment logs** for issues
5. **Set up staging environment** for testing

---

## Troubleshooting

### Common Issues:
- **Permission denied**: Check file permissions (755 for directories, 644 for files)
- **Deployment not triggering**: Verify webhook URL and secret
- **Files not updating**: Clear any caching (CloudFlare, hosting cache)
- **PHP errors**: Check error logs in cPanel

### Quick Fixes:
```bash
# Reset file permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Force pull latest changes
git reset --hard origin/dev/skyworld
```