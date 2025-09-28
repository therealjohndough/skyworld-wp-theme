# Skyworld Cannabis WordPress Theme

⚠️ **IMPORTANT: This is a WordPress theme repository, not a Next.js project!**

If you're seeing this on Vercel, please visit the actual WordPress site: **[https://dev.skyworldcannabis.com](https://dev.skyworldcannabis.com)**

---

A comprehensive WordPress child theme for Skyworld Cannabis featuring advanced strain library, store locator, COA management, age verification, and wholesale integration.

## 🚀 Features

### ✅ Completed Features

#### 1. Age Gate System
- **Location**: `assets/js/age-gate.js`, `assets/css/age-gate.css`
- **Functionality**: 21+ verification modal with cookie persistence
- **Status**: ✅ Complete and fully functional

#### 2. Store Locator
- **Location**: `page-store-locator.php`, `assets/js/store-locator.js`, `assets/css/store-locator.css`
- **Functionality**: Interactive Google Maps with dispensary locations, search, and directions
- **Features**: Location detection, detail modals, responsive design
- **Status**: ✅ Complete with Google Maps integration

#### 3. Certificate of Analysis (COA) System
- **Location**: `page-coa.php`, `assets/js/coa.js`, `assets/css/coa.css`
- **Functionality**: Lab results management with search and filtering
- **Features**: Cannabinoid profiles, terpene data, batch tracking
- **Status**: ✅ Complete with advanced filtering

#### 4. Gravity Forms + Brevo Integration
- **Location**: `inc/gravity-forms-integration.php`
- **Functionality**: Email marketing automation with form submissions
- **Features**: Contact sync, list management, honeypot protection
- **Status**: ✅ Complete with error handling

#### 5. Strain Library Hub System
- **Location**: `archive-strain.php`, `single-strain.php`, `assets/css/strain-library.css`
- **Functionality**: Comprehensive genetics database with interactive features
- **Features**:
  - Advanced filtering (THC range, flowering time, growing difficulty)
  - Strain comparison modal
  - Educational sidebar
  - Detailed strain profiles
  - Related products integration
  - Terpene and effect taxonomies
  - **Image Type Distinction**: Flower/plant photos for strains vs packaging photos for products
- **Status**: ✅ Complete hub & spoke implementation

#### 6. Wholesale Page
- **Location**: `page-wholesale.php`
- **Functionality**: B2B partnership application with Gravity Forms integration
- **Features**: Requirements display, benefits showcase, contact integration
- **Status**: ✅ Complete with comprehensive styling

#### 7. Enhanced Taxonomy Structure
- **Custom Post Types**: `strain`, `sky_product`
- **Taxonomies**: 
  - `strain_type` (Indica, Sativa, Hybrid)
  - `effects` (Relaxing, Energizing, Creative, etc.)
  - `terpenes` (Myrcene, Limonene, Pinene, etc.)
  - `flavors` (Citrus, Berry, Pine, etc.)
  - `growing_difficulty` (Beginner, Intermediate, Expert)
  - `medical_benefit` (Pain Relief, Anxiety, Insomnia, etc.)
- **Status**: ✅ Complete with 6 comprehensive taxonomies

## 🏗️ Architecture

### File Structure
```
skyworld-wp-child/
├── README.md                           # Project documentation
├── style.css                          # Child theme styles
├── functions.php                       # Core functionality
├── front-page.php                      # Homepage template
├── page-about.php                      # About page
├── page-careers.php                    # Careers page
├── page-sitemap.php                    # Sitemap page
├── page-wholesale.php                  # Wholesale application page ✅
├── page-store-locator.php              # Store locator with Google Maps ✅
├── page-coa.php                        # Certificate of Analysis system ✅
├── archive-sky_product.php             # Product archive
├── single-sky_product.php              # Single product template
├── archive-strain.php                  # Strain library hub ✅
├── single-strain.php                   # Individual strain details ✅
├── inc/
│   ├── acf-fields.php                  # Advanced Custom Fields setup
│   ├── importer.php                    # Data import functionality
│   └── gravity-forms-integration.php   # Brevo email integration ✅
├── assets/
│   ├── css/
│   │   ├── skyworld.css                # Main theme styles
│   │   ├── age-gate.css                # Age verification styles ✅
│   │   ├── store-locator.css           # Store locator styles ✅
│   │   ├── coa.css                     # COA system styles ✅
│   │   └── strain-library.css          # Strain library styles ✅
│   └── js/
│       ├── skyworld.js                 # Main theme scripts
│       ├── age-gate.js                 # Age verification logic ✅
│       ├── store-locator.js            # Google Maps integration ✅
│       └── coa.js                      # COA functionality ✅
└── acf-json/
    ├── group_product_fields.json       # Product field definitions
    └── group_strain_fields.json        # Strain field definitions
```

### Integration Points

#### Gravity Forms Integration
- **Form IDs**: 
  - Form #1: General Contact/COA Requests
  - Form #2: Wholesale Applications
- **Brevo Integration**: Automatic contact creation and list management
- **Features**: Form validation, spam protection, email notifications

#### Google Maps API
- **Usage**: Store locator functionality
- **Features**: Interactive maps, location search, directions
- **Configuration**: Replace `YOUR_API_KEY` in `functions.php`

#### Custom Post Types & Fields
- **Strains**: Comprehensive genetics database
- **Products**: Inventory management with strain relationships
- **Meta Fields**: THC/CBD content, terpenes, growing info, lab results

## 🎯 Hub & Spoke Model Implementation

### Strain Library as Educational Hub
The strain library serves as the central educational hub with:

1. **Interactive Strain Browser** (`archive-strain.php`)
   - Advanced filtering system
   - Search and sort functionality
   - Comparison tools
   - Educational sidebar

2. **Detailed Strain Profiles** (`single-strain.php`)
   - Comprehensive strain information
   - Lab results and cannabinoid profiles
   - Growing information
   - Related products integration
   - Similar strain suggestions

3. **Educational Components**
   - Terpene education
   - Effect descriptions
   - Growing difficulty explanations
   - Medical benefit information

### Spoke Integrations
- **Product Pages**: Link to strain information
- **COA System**: Strain-specific lab results
- **Store Locator**: Find products by strain
- **Wholesale**: Feature strain library in B2B materials

## 🔧 Setup Instructions

### Prerequisites
- WordPress 5.0+
- Gravity Forms plugin
- Advanced Custom Fields plugin (optional but recommended)

### Installation
1. Upload child theme to `/wp-content/themes/skyworld-wp-child/`
2. Activate the child theme
3. Install and configure required plugins:
   - Gravity Forms
   - Advanced Custom Fields (optional)

### Configuration

#### 1. Google Maps API
```php
// In functions.php, replace YOUR_API_KEY with actual Google Maps API key
wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=YOUR_ACTUAL_API_KEY&libraries=places'
```

#### 2. Brevo Integration
Configure in `inc/gravity-forms-integration.php`:
```php
// Add your Brevo API credentials
$api_key = 'your_brevo_api_key';
$list_id = 'your_brevo_list_id';
```

#### 3. Gravity Forms Setup
- Create forms with IDs 1 and 2
- Configure form notifications
- Set up Brevo integration hooks

#### 4. Custom Post Types
The theme automatically registers:
- `strain` post type with taxonomies
- `sky_product` post type
- All necessary taxonomy terms

### Content Setup

#### 1. Create Pages
Use the included page templates:
- Store Locator (use `page-store-locator.php` template)
- COA (use `page-coa.php` template)
- Wholesale (use `page-wholesale.php` template)

#### 2. Add Strain Library Content
1. Navigate to Strains → Add New
2. Add strain information using custom fields
3. Assign appropriate taxonomies (strain type, effects, terpenes, etc.)
4. Upload featured images

#### 3. Configure Store Locations
Add dispensary data to the store locator system (modify `store-locator.js` with actual locations)

## 🎨 Customization

### Styling
- Main styles: `assets/css/skyworld.css`
- Component-specific styles in individual CSS files
- Dark mode support included
- Responsive design for all components

### JavaScript Functionality
- Modular JavaScript architecture
- jQuery-based interactions
- AJAX integration for dynamic content
- Google Maps API integration

### Custom Fields
Extend functionality by adding fields through:
- ACF JSON files in `acf-json/`
- Custom field registration in `functions.php`

## 🚀 Performance Features

- **Conditional Loading**: Styles and scripts load only where needed
- **Optimized Images**: Proper image sizing and lazy loading support
- **Caching Friendly**: Compatible with WordPress caching plugins
- **SEO Optimized**: Schema markup and semantic HTML structure

## 🔐 Security Features

- **Age Verification**: COPPA compliance with cookie-based verification
- **Form Protection**: Honeypot and nonce protection
- **Data Validation**: Sanitized inputs and outputs
- **HTTPS Ready**: Secure asset loading

## 📱 Mobile Responsive

All components are fully responsive:
- Mobile-first design approach
- Touch-friendly interfaces
- Optimized layouts for all screen sizes
- Progressive enhancement

## 🎯 Business Features

### For Dispensaries (B2B)
- Wholesale application system
- Strain library for education
- Product catalog integration
- Contact management

### For Consumers (B2C)  
- Interactive strain discovery
- Store locator for purchases
- Educational content
- Lab result transparency

## 🆕 Recent Updates

### Version 1.0.0 - Complete Implementation
- ✅ Added comprehensive strain library hub system
- ✅ Implemented single strain template with detailed profiles
- ✅ Created wholesale page with Gravity Forms integration
- ✅ Added strain library CSS with responsive design
- ✅ Enhanced taxonomy structure with 6 comprehensive categories
- ✅ Completed hub & spoke model for educational engagement
- ✅ Integrated all systems with consistent styling and functionality

## 🚀 Future Enhancements

### Potential Additions
- **User Accounts**: Customer portal and favorites
- **E-commerce**: WooCommerce integration for direct sales
- **Reviews System**: Strain and product reviews
- **Blog Integration**: Cannabis education content
- **Multi-language**: Internationalization support
- **Advanced Analytics**: User engagement tracking
- **Mobile App**: Progressive Web App features

### API Integrations
- **Inventory Management**: Real-time product availability
- **Lab Testing**: Automated COA updates
- **Compliance**: State reporting integration
- **Payment Processing**: B2B payment gateway

## 📄 License

This child theme is proprietary software developed specifically for Skyworld Cannabis. All rights reserved.

## 🤝 Support

For technical support and customization requests, please contact the development team.

---

**Skyworld Cannabis** - Premium Indoor Flower for New York Dispensaries  
*Indigenous-owned cultivator committed to quality, compliance, and community.*