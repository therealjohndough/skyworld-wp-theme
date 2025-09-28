#!/usr/bin/env python3
"""
Notion Product Batch Importer for Skyworld Cannabis

Uploads product batch data from CSV to Notion database with PDF links.
Matches batch numbers to PDF files in the COAs directory.

Requirements:
- pandas
- notion-client 
- requests

Usage:
1. Configure NOTION_TOKEN and DATABASE_ID
2. Place CSV file: notion-product-batches-real.csv  
3. Place PDF files in COAs/ directory
4. Run: python notion_batch_importer.py
"""

import os
import sys
import pandas as pd
from notion_client import Client
import requests
from typing import Dict, Any, Optional

# CONFIGURATION
NOTION_TOKEN = os.getenv("NOTION_TOKEN", "your_notion_integration_token")
DATABASE_ID = os.getenv("NOTION_DATABASE_ID", "your_database_id")
REPO_PDF_DIR = "./COAs/"  # Path to PDF files
CSV_PATH = "./notion-product-batches-real.csv"
GITHUB_PDF_BASE_URL = "https://github.com/therealjohndough/skyworld-wp-theme/raw/main/COAs/"

def validate_config() -> bool:
    """Validate configuration before running"""
    if NOTION_TOKEN == "your_notion_integration_token":
        print("❌ Error: Please set NOTION_TOKEN environment variable or update the script")
        return False
    
    if DATABASE_ID == "your_database_id":
        print("❌ Error: Please set NOTION_DATABASE_ID environment variable or update the script")
        return False
    
    if not os.path.exists(CSV_PATH):
        print(f"❌ Error: CSV file not found: {CSV_PATH}")
        return False
    
    if not os.path.exists(REPO_PDF_DIR):
        print(f"❌ Error: PDF directory not found: {REPO_PDF_DIR}")
        print(f"   Creating directory: {REPO_PDF_DIR}")
        os.makedirs(REPO_PDF_DIR, exist_ok=True)
    
    return True

def normalize_column_names(df: pd.DataFrame) -> pd.DataFrame:
    """Normalize CSV column names to match expected format"""
    # Create mapping for common column variations
    column_mapping = {
        'batch number': 'Batch/Lot #',
        'batch_number': 'Batch/Lot #',
        'batch/lot #': 'Batch/Lot #',
        'strain name': 'strain_name',
        'strain_name': 'strain_name', 
        'product type': 'Product Type',
        'product_type': 'Product Type',
        'thc %': 'thc',
        'thc_percent': 'thc',
        'cbd %': 'cbd',
        'cbg %': 'cbg',
        'thcv %': 'thcv',
        'terp total %': 'terp_total',
        'terp 1 name': 'terp_1',
        'terp 1 %': 'terp_1_percentage',
        'terp 2 name': 'terp_2', 
        'terp 2 %': 'terp_2_percentage',
        'terp 3 name': 'terp_3',
        'terp 3 %': 'terp_3 percentage',
        'test date': 'season',
        'package sizes': 'package_sizes',
        'notes': 'effects'
    }
    
    # Store original columns for batch number detection
    original_columns = df.columns.tolist()
    
    # Normalize column names
    df.columns = [col.lower().strip() for col in df.columns]
    df = df.rename(columns=column_mapping)
    
    # Special handling for batch number column - keep original if it already works
    for orig_col in original_columns:
        if 'batch' in orig_col.lower() and ('number' in orig_col.lower() or '#' in orig_col):
            # Map this to our standard batch column
            df = df.rename(columns={orig_col.lower().strip(): 'Batch/Lot #'})
            break
    
    return df

def create_notion_properties(meta_row: Dict[str, Any], batch_number: str, pdf_url: str) -> Dict[str, Any]:
    """Create Notion page properties from CSV metadata"""
    properties = {
        "Name": {"title": [{"text": {"content": batch_number}}]},
        "PDF Link": {"url": pdf_url},
    }
    
    # Map CSV fields to Notion properties
    field_mapping = [
        ("strain_name", "Strain Name"),
        ("type", "Type"), 
        ("Product Type", "Product Type"),
        ("genetics", "Genetics"),
        ("thc", "THC %"),
        ("cbg", "CBG %"),
        ("cbd", "CBD %"),
        ("thcv", "THCV %"),
        ("terp_total", "Terpene Total %"),
        ("terp_1", "Terpene 1"),
        ("terp_1_percentage", "Terpene 1 %"),
        ("terp_2", "Terpene 2"),
        ("terp_2_percentage", "Terpene 2 %"), 
        ("terp_3", "Terpene 3"),
        ("terp_3 percentage", "Terpene 3 %"),
        ("effects", "Effects"),
        ("nose", "Nose/Aroma"),
        ("flavor", "Flavor"),
        ("season", "Season/Date"),
        ("package_sizes", "Package Sizes"),
        ("@image", "Image URL"),
        ("Batch/Lot #", "Batch Number")
    ]
    
    for csv_field, notion_field in field_mapping:
        if csv_field in meta_row and pd.notna(meta_row[csv_field]) and str(meta_row[csv_field]).strip():
            value = str(meta_row[csv_field]).strip()
            
            # Handle special cases
            if csv_field == "@image" and value:
                properties[notion_field] = {"url": value}
            elif csv_field in ["thc", "cbd", "cbg", "thcv", "terp_total", "terp_1_percentage", "terp_2_percentage", "terp_3 percentage"]:
                # Handle percentage fields
                properties[notion_field] = {"number": float(value.replace('%', '')) if value.replace('%', '').replace('.', '').isdigit() else 0}
            else:
                # Default to rich text
                properties[notion_field] = {"rich_text": [{"text": {"content": value}}]}
    
    return properties

def main():
    """Main import function"""
    print("🌿 Skyworld Notion Batch Importer")
    print("=" * 40)
    
    # Validate configuration
    if not validate_config():
        return False
    
    try:
        # 1. Load batch metadata from CSV
        print(f"📊 Loading CSV: {CSV_PATH}")
        df = pd.read_csv(CSV_PATH, dtype=str)
        df = normalize_column_names(df)
        print(f"   Found {len(df)} batch records")
        
        # 2. Initialize Notion client
        print("🔗 Connecting to Notion...")
        notion = Client(auth=NOTION_TOKEN)
        
        # Test connection
        try:
            database = notion.databases.retrieve(DATABASE_ID)
            print(f"   ✅ Connected to database: {database['title'][0]['text']['content']}")
        except Exception as e:
            print(f"   ❌ Failed to connect to database: {e}")
            return False
        
        # 3. Scan PDF directory
        pdf_files = []
        if os.path.exists(REPO_PDF_DIR):
            pdf_files = [f for f in os.listdir(REPO_PDF_DIR) if f.lower().endswith('.pdf')]
        
        print(f"📁 Found {len(pdf_files)} PDF files in {REPO_PDF_DIR}")
        
        # 4. Process each PDF file
        uploaded_count = 0
        skipped_count = 0
        error_count = 0
        
        for filename in pdf_files:
            try:
                print(f"\n🔍 Processing: {filename}")
                
                # Extract batch number from filename 
                batch_number = filename.split('.')[0]  
                # Handle more complex filename patterns if needed
                if ' - ' in batch_number:
                    batch_number = batch_number.split(' - ')[0]
                
                print(f"   Batch number: {batch_number}")
                
                # 5. Find metadata row
                meta = df[df['Batch/Lot #'] == batch_number]
                if meta.empty:
                    print(f"   ⚠️  Metadata not found for {batch_number}")
                    skipped_count += 1
                    continue
                
                meta_row = meta.iloc[0].to_dict()
                print(f"   ✅ Found metadata for strain: {meta_row.get('strain_name', 'Unknown')}")
                
                # 6. Prepare Notion page properties
                pdf_url = GITHUB_PDF_BASE_URL + filename
                properties = create_notion_properties(meta_row, batch_number, pdf_url)
                
                # 7. Create page in Notion
                try:
                    page = notion.pages.create(
                        parent={"database_id": DATABASE_ID},
                        properties=properties
                    )
                    print(f"   ✅ Uploaded {batch_number} to Notion")
                    uploaded_count += 1
                    
                except Exception as e:
                    print(f"   ❌ Failed to create Notion page: {e}")
                    error_count += 1
                    
            except Exception as e:
                print(f"   ❌ Error processing {filename}: {e}")
                error_count += 1
        
        # Summary
        print(f"\n📈 Import Summary")
        print(f"   ✅ Uploaded: {uploaded_count}")
        print(f"   ⚠️  Skipped: {skipped_count}")
        print(f"   ❌ Errors: {error_count}")
        print(f"   📁 Total PDFs: {len(pdf_files)}")
        
        print("\n🎉 Import complete!")
        
        if skipped_count > 0:
            print(f"\n💡 Tips for skipped files:")
            print("   • Check batch number extraction from PDF filename")
            print("   • Ensure CSV contains matching 'Batch/Lot #' values") 
            print("   • Verify CSV file encoding and format")
        
        return True
        
    except Exception as e:
        print(f"❌ Critical error: {e}")
        return False

if __name__ == "__main__":
    success = main()
    sys.exit(0 if success else 1)