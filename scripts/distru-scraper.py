#!/usr/bin/env python3
"""
Skyworld Cannabis Product Scraper for Distru Menus
Extracts Skyworld products from SJR Horticulture menu
"""

import requests
from bs4 import BeautifulSoup
import json
import csv
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options

def setup_driver():
    """Setup Chrome driver with headless options"""
    chrome_options = Options()
    chrome_options.add_argument("--headless")
    chrome_options.add_argument("--no-sandbox")
    chrome_options.add_argument("--disable-dev-shm-usage")
    chrome_options.add_argument("--user-agent=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36")
    
    try:
        driver = webdriver.Chrome(options=chrome_options)
        return driver
    except Exception as e:
        print(f"Error setting up Chrome driver: {e}")
        print("Make sure you have ChromeDriver installed: brew install chromedriver")
        return None

def scrape_distru_menu(url):
    """Scrape Distru menu using Selenium for dynamic content"""
    driver = setup_driver()
    if not driver:
        return []
    
    try:
        print(f"Loading page: {url}")
        driver.get(url)
        
        # Wait for products to load
        wait = WebDriverWait(driver, 10)
        wait.until(EC.presence_of_element_located((By.CLASS_NAME, "menu-product-card")))
        
        # Give extra time for all products to load
        time.sleep(3)
        
        products = []
        product_cards = driver.find_elements(By.CLASS_NAME, "menu-product-card")
        
        print(f"Found {len(product_cards)} product cards")
        
        for card in product_cards:
            try:
                # Extract product info
                name_element = card.find_element(By.CLASS_NAME, "menu-product-card__name")
                product_name = name_element.text.strip()
                
                # Skip non-Skyworld products and Twic3 baked
                if not is_skyworld_product(product_name):
                    continue
                
                # Get strain type
                try:
                    type_element = card.find_element(By.CLASS_NAME, "menu-product-card__strain-type")
                    strain_type = type_element.text.strip()
                except:
                    strain_type = ""
                
                # Get THC/CBD info
                try:
                    potency_element = card.find_element(By.CLASS_NAME, "menu-product-card__potency")
                    potency = potency_element.text.strip()
                    thc, cbd = parse_potency(potency)
                except:
                    thc, cbd = "", ""
                
                # Get price
                try:
                    price_element = card.find_element(By.CLASS_NAME, "menu-product-card__price")
                    price = price_element.text.strip()
                except:
                    price = ""
                
                # Get package size from name or separate element
                package_size = extract_package_size(product_name)
                
                product_info = {
                    'name': clean_product_name(product_name),
                    'strain_type': strain_type,
                    'thc_percentage': thc,
                    'cbd_percentage': cbd,
                    'price': price,
                    'package_size': package_size,
                    'product_type': 'Flower',
                    'brand': 'Skyworld'
                }
                
                products.append(product_info)
                print(f"✓ Extracted: {product_info['name']}")
                
            except Exception as e:
                print(f"Error extracting product info: {e}")
                continue
        
        return products
        
    except Exception as e:
        print(f"Error scraping menu: {e}")
        return []
    
    finally:
        driver.quit()

def is_skyworld_product(product_name):
    """Check if product is a Skyworld product (not Twic3 baked)"""
    name_lower = product_name.lower()
    
    # Skip Twic3 baked products
    if 'twic3' in name_lower or 'baked' in name_lower:
        return False
    
    # Include Skyworld indicators
    skyworld_indicators = ['skyworld', 'sky world']
    for indicator in skyworld_indicators:
        if indicator in name_lower:
            return True
    
    # If no explicit brand, assume it might be Skyworld (you can adjust this logic)
    return True

def clean_product_name(name):
    """Clean up product name removing package sizes and brand prefixes"""
    # Remove common package size indicators
    import re
    name = re.sub(r'\b\d+\.?\d*g?\b', '', name)  # Remove weights
    name = re.sub(r'skyworld\s*', '', name, flags=re.IGNORECASE)  # Remove brand
    return name.strip()

def extract_package_size(name):
    """Extract package size from product name"""
    import re
    match = re.search(r'\b(\d+\.?\d*g?)\b', name.lower())
    return match.group(1) if match else ''

def parse_potency(potency_text):
    """Parse THC/CBD percentages from potency text"""
    import re
    thc_match = re.search(r'thc:\s*(\d+\.?\d*)%?', potency_text.lower())
    cbd_match = re.search(r'cbd:\s*(\d+\.?\d*)%?', potency_text.lower())
    
    thc = thc_match.group(1) if thc_match else ''
    cbd = cbd_match.group(1) if cbd_match else ''
    
    return thc, cbd

def save_to_csv(products, filename='skyworld_products.csv'):
    """Save products to CSV for WordPress import"""
    if not products:
        print("No products to save")
        return
    
    with open(filename, 'w', newline='', encoding='utf-8') as csvfile:
        fieldnames = ['name', 'strain_type', 'thc_percentage', 'cbd_percentage', 
                     'price', 'package_size', 'product_type', 'brand']
        writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
        
        writer.writeheader()
        for product in products:
            writer.writerow(product)
    
    print(f"✅ Saved {len(products)} Skyworld products to {filename}")

def main():
    url = "https://app.distru.com/menu/sjr-horticulture/menu?collection_id=d8cad54c-7e16-41e4-a40e-3fb9e2a49397&menu_page=collection"
    
    print("🌿 Skyworld Cannabis Product Scraper")
    print("=" * 40)
    
    products = scrape_distru_menu(url)
    
    if products:
        print(f"\n📊 Found {len(products)} Skyworld products:")
        for product in products:
            print(f"  • {product['name']} ({product['strain_type']}) - {product['thc_percentage']}% THC")
        
        save_to_csv(products)
        print(f"\n🚀 Ready to import into WordPress using our cannabis import system!")
    else:
        print("❌ No Skyworld products found")

if __name__ == "__main__":
    main()