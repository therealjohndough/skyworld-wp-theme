#!/bin/bash

# 🧪 Skyworld Theme Local Testing Script
# Run this before committing to ensure your changes work properly

echo "🌿 === SKYWORLD THEME LOCAL TESTING ==="
echo "📅 Started: $(date)"
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Test counters
TESTS_PASSED=0
TESTS_FAILED=0

# Function to run a test
run_test() {
    local test_name="$1"
    local test_command="$2"
    
    echo -n "🔍 Testing $test_name... "
    
    if eval "$test_command" >/dev/null 2>&1; then
        echo -e "${GREEN}✅ PASSED${NC}"
        ((TESTS_PASSED++))
        return 0
    else
        echo -e "${RED}❌ FAILED${NC}"
        ((TESTS_FAILED++))
        return 1
    fi
}

# Function to run a test with output
run_test_verbose() {
    local test_name="$1"
    local test_command="$2"
    
    echo "🔍 Testing $test_name..."
    
    if eval "$test_command"; then
        echo -e "${GREEN}✅ PASSED${NC}"
        echo ""
        ((TESTS_PASSED++))
        return 0
    else
        echo -e "${RED}❌ FAILED${NC}"
        echo ""
        ((TESTS_FAILED++))
        return 1
    fi
}

echo "1. 🔍 PHP SYNTAX TESTS"
echo "======================"

# Test PHP syntax for all PHP files
for php_file in $(find . -name "*.php" -not -path "./.git/*" -not -path "./vendor/*"); do
    run_test "PHP syntax: $(basename $php_file)" "php -l '$php_file'"
done

echo ""
echo "2. 🎨 CSS VALIDATION TESTS"
echo "=========================="

# Test CSS files for basic syntax
for css_file in $(find assets -name "*.css" 2>/dev/null); do
    if [ -f "$css_file" ]; then
        # Check for balanced braces
        open_braces=$(grep -c '{' "$css_file")
        close_braces=$(grep -c '}' "$css_file")
        
        if [ "$open_braces" -eq "$close_braces" ]; then
            run_test "CSS syntax: $(basename $css_file)" "true"
        else
            run_test "CSS syntax: $(basename $css_file)" "false"
            echo -e "${YELLOW}   ⚠️  Mismatched braces: $open_braces opening, $close_braces closing${NC}"
        fi
    fi
done

echo ""
echo "3. 🌐 WORDPRESS COMPATIBILITY TESTS"
echo "===================================="

# Check for WordPress functions
run_test_verbose "WordPress functions usage" "
    echo 'Checking for proper WordPress function usage...'
    
    # Check for direct database queries (should use WP functions)
    if grep -r 'mysql_\|mysqli_' --include='*.php' . >/dev/null 2>&1; then
        echo '⚠️  Warning: Found direct database queries - consider using WP functions'
    fi
    
    # Check for unescaped output
    if grep -r 'echo \$[^;]*;' --include='*.php' . >/dev/null 2>&1; then
        echo '⚠️  Warning: Found potentially unescaped output - use esc_html(), esc_attr(), etc.'
    fi
    
    # Check for WordPress function usage
    if grep -r 'wp_enqueue_script\|wp_enqueue_style\|get_template_part\|the_content' --include='*.php' . >/dev/null 2>&1; then
        echo '✅ Using WordPress functions properly'
        return 0
    else
        echo '⚠️  Limited WordPress function usage detected'
        return 0
    fi
"

# Test functions.php loads without fatal errors
if [ -f "functions.php" ]; then
    run_test_verbose "functions.php loads without fatal errors" "
        php -d display_errors=1 -r \"
        error_reporting(E_ALL);
        define('ABSPATH', __DIR__ . '/');
        define('WP_DEBUG', true);
        
        // Mock WordPress functions to prevent undefined function errors
        if (!function_exists('add_action')) {
            function add_action(\\\$hook, \\\$function, \\\$priority = 10, \\\$accepted_args = 1) { return true; }
        }
        if (!function_exists('add_filter')) {
            function add_filter(\\\$hook, \\\$function, \\\$priority = 10, \\\$accepted_args = 1) { return true; }
        }
        if (!function_exists('wp_enqueue_style')) {
            function wp_enqueue_style(\\\$handle, \\\$src = '', \\\$deps = array(), \\\$ver = false, \\\$media = 'all') { return true; }
        }
        if (!function_exists('wp_enqueue_script')) {
            function wp_enqueue_script(\\\$handle, \\\$src = '', \\\$deps = array(), \\\$ver = false, \\\$in_footer = false) { return true; }
        }
        if (!function_exists('get_template_directory_uri')) {
            function get_template_directory_uri() { return 'http://example.com/wp-content/themes/skyworld'; }
        }
        if (!function_exists('get_stylesheet_directory_uri')) {
            function get_stylesheet_directory_uri() { return 'http://example.com/wp-content/themes/skyworld-wp-child'; }
        }
        if (!function_exists('remove_theme_support')) {
            function remove_theme_support(\\\$feature) { return true; }
        }
        if (!function_exists('add_theme_support')) {
            function add_theme_support(\\\$feature, \\\$args = null) { return true; }
        }
        if (!function_exists('wp_head')) {
            function wp_head() { return true; }
        }
        if (!function_exists('wp_footer')) {
            function wp_footer() { return true; }
        }
        if (!function_exists('register_nav_menus')) {
            function register_nav_menus(\\\$locations = array()) { return true; }
        }
        
        // Try to include functions.php
        ob_start();
        try {
            include 'functions.php';
            echo 'Functions.php loaded successfully';
        } catch (Exception \\\$e) {
            echo 'Error loading functions.php: ' . \\\$e->getMessage();
            exit(1);
        }
        ob_end_clean();
        \"
    "
fi

echo ""
echo "4. 📁 FILE STRUCTURE TESTS"
echo "=========================="

# Check for required WordPress theme files
run_test "style.css exists" "[ -f 'style.css' ]"
run_test "index.php exists" "[ -f 'index.php' ]"
run_test "functions.php exists" "[ -f 'functions.php' ]"

# Check for theme assets
run_test "assets directory exists" "[ -d 'assets' ]"
run_test "CSS assets exist" "[ -f 'assets/css/skyworld.css' ]"

echo ""
echo "5. 🔧 LOCAL MAMP CONNECTIVITY TEST"
echo "=================================="

# Test MAMP connection
run_test_verbose "MAMP server connectivity" "
    echo 'Testing MAMP server at localhost:8888...'
    
    if curl -f http://localhost:8888/case_study_labs/ >/dev/null 2>&1; then
        echo '✅ MAMP server is running and accessible'
        return 0
    else
        echo '⚠️  MAMP server not accessible - make sure MAMP is running'
        echo '   Start MAMP and navigate to http://localhost:8888/case_study_labs/'
        return 1
    fi
"

echo ""
echo "📊 === TEST SUMMARY ==="
echo "======================="
echo -e "Tests passed: ${GREEN}$TESTS_PASSED${NC}"
echo -e "Tests failed: ${RED}$TESTS_FAILED${NC}"
echo "Total tests: $((TESTS_PASSED + TESTS_FAILED))"

if [ $TESTS_FAILED -eq 0 ]; then
    echo ""
    echo -e "${GREEN}🎉 ALL TESTS PASSED!${NC}"
    echo -e "${GREEN}✅ Your theme is ready to commit and deploy${NC}"
    echo ""
    echo "Next steps:"
    echo "1. git add -A"
    echo "2. git commit -m 'Your commit message'"
    echo "3. git push origin dev/skyworld"
    echo "4. 🚀 Auto-deployment will start!"
    exit 0
else
    echo ""
    echo -e "${RED}❌ SOME TESTS FAILED${NC}"
    echo -e "${YELLOW}⚠️  Please fix the issues above before committing${NC}"
    echo ""
    echo "Need help? Check the WordPress Codex or ask for assistance."
    exit 1
fi