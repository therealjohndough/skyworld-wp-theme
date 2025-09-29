#!/usr/bin/env python3
"""
Simple Distru Product Extractor
Manual data entry helper for Skyworld products
"""

def create_skyworld_template():
    """Create a template CSV for manual data entry"""
    import csv
    
    # Sample Skyworld products (you'll replace with actual data from browser)
    sample_products = [
        {
            'name': 'Example Strain Name',
            'description': 'High-quality cannabis flower with exceptional potency and flavor',
            'strain_type': 'Hybrid',  # Indica, Sativa, or Hybrid
            'thc_percentage': '25.5',
            'cbd_percentage': '0.8',
            'terpenes': 'Myrcene, Limonene, Caryophyllene',
            'effects': 'Relaxed, Happy, Euphoric',
            'product_type': 'Flower',
            'package_size': '3.5g',
            'price': '$45.00',
            'image_url': '',
            'genetics': 'Parent Strain A x Parent Strain B'
        }
    ]
    
    filename = 'skyworld_products_template.csv'
    
    with open(filename, 'w', newline='', encoding='utf-8') as csvfile:
        fieldnames = ['name', 'description', 'strain_type', 'thc_percentage', 
                     'cbd_percentage', 'terpenes', 'effects', 'product_type', 
                     'package_size', 'price', 'image_url', 'genetics']
        writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
        
        writer.writeheader()
        for product in sample_products:
            writer.writerow(product)
    
    print(f"✅ Created template: {filename}")
    print("\n📝 Instructions:")
    print("1. Open the template CSV file")
    print("2. Replace the sample data with actual Skyworld products from the browser")
    print("3. Add one row per product variation (different package sizes = separate rows)")
    print("4. Use our WordPress import system to upload the completed CSV")
    
    return filename

def extract_from_browser_copy():
    """Help extract data from browser copy-paste"""
    print("🌿 Skyworld Product Data Extractor")
    print("=" * 40)
    print("\nIf you can copy product data from the browser, paste it here:")
    print("(Press Enter twice when done, or type 'template' for CSV template)\n")
    
    lines = []
    while True:
        try:
            line = input()
            if line.lower() == 'template':
                create_skyworld_template()
                return
            if line == '' and len(lines) > 0:
                break
            lines.append(line)
        except KeyboardInterrupt:
            break
    
    if not lines:
        create_skyworld_template()
        return
    
    # Process the pasted data
    print(f"\n📊 Processing {len(lines)} lines of data...")
    
    # You can add parsing logic here based on the format of copied data
    products = []
    
    for line in lines:
        if 'skyworld' in line.lower() and 'twic3' not in line.lower():
            print(f"  • Found potential Skyworld product: {line[:50]}...")
    
    print("\n💡 For best results, use the CSV template method:")
    create_skyworld_template()

if __name__ == "__main__":
    extract_from_browser_copy()