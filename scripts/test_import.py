#!/usr/bin/env python3
"""
Test script for Notion Batch Importer

Tests CSV loading and PDF file matching without requiring Notion credentials.
"""

import os
import sys
import pandas as pd

def test_csv_loading():
    """Test CSV file loading and column normalization"""
    CSV_PATH = "./notion-product-batches-real.csv"
    
    print("🧪 Testing CSV Loading")
    print("=" * 30)
    
    if not os.path.exists(CSV_PATH):
        print(f"❌ CSV file not found: {CSV_PATH}")
        return False
    
    try:
        # Load CSV
        df = pd.read_csv(CSV_PATH, dtype=str)
        print(f"✅ Loaded CSV: {len(df)} rows, {len(df.columns)} columns")
        
        # Show columns
        print(f"\n📊 CSV Columns ({len(df.columns)}):")
        for i, col in enumerate(df.columns, 1):
            print(f"   {i:2d}. {col}")
        
        # Show first few batch numbers
        batch_col = None
        for col in df.columns:
            if 'batch' in col.lower() and ('number' in col.lower() or '#' in col or 'lot' in col.lower()):
                batch_col = col
                break
        
        if batch_col:
            print(f"\n📝 Sample Batch Numbers (from '{batch_col}'):")
            batches = df[batch_col].dropna().head(5)
            for batch in batches:
                print(f"   • {batch}")
        else:
            print("\n⚠️  Could not identify batch number column")
            print("   Expected columns containing 'batch', 'lot', or '#'")
        
        return True
        
    except Exception as e:
        print(f"❌ Error loading CSV: {e}")
        return False

def test_pdf_matching():
    """Test PDF file discovery and batch number extraction"""
    PDF_DIR = "../COAs/"
    
    print(f"\n🧪 Testing PDF Matching")
    print("=" * 30)
    
    if not os.path.exists(PDF_DIR):
        print(f"❌ PDF directory not found: {PDF_DIR}")
        return False
    
    pdf_files = [f for f in os.listdir(PDF_DIR) if f.lower().endswith('.pdf')]
    print(f"✅ Found {len(pdf_files)} PDF files in {PDF_DIR}")
    
    if pdf_files:
        print(f"\n📁 PDF Files and Extracted Batch Numbers:")
        for filename in pdf_files:
            # Extract batch number (same logic as main script)
            batch_number = filename.split('.')[0]
            if ' - ' in batch_number:
                batch_number = batch_number.split(' - ')[0]
            print(f"   • {filename} → Batch: {batch_number}")
    else:
        print("\n💡 No PDF files found. Add some sample PDFs to test matching.")
    
    return len(pdf_files) > 0

def test_integration():
    """Test CSV-PDF integration"""
    print(f"\n🧪 Testing CSV-PDF Integration")
    print("=" * 30)
    
    CSV_PATH = "./notion-product-batches-real.csv"
    PDF_DIR = "../COAs/"
    
    if not os.path.exists(CSV_PATH) or not os.path.exists(PDF_DIR):
        print("❌ Missing files for integration test")
        return False
    
    try:
        # Load CSV
        df = pd.read_csv(CSV_PATH, dtype=str)
        
        # Find batch column
        batch_col = None
        for col in df.columns:
            if 'batch' in col.lower() and ('number' in col.lower() or '#' in col or 'lot' in col.lower()):
                batch_col = col
                break
        
        if not batch_col:
            print("❌ Could not find batch number column")
            return False
        
        # Get PDF files
        pdf_files = [f for f in os.listdir(PDF_DIR) if f.lower().endswith('.pdf')]
        
        # Test matching
        matches = 0
        for filename in pdf_files:
            batch_number = filename.split('.')[0]
            if ' - ' in batch_number:
                batch_number = batch_number.split(' - ')[0]
            
            # Check if batch exists in CSV
            meta = df[df[batch_col] == batch_number]
            if not meta.empty:
                strain_name = meta.iloc[0].get('Strain Name', 'Unknown')
                print(f"   ✅ Match: {batch_number} → {strain_name}")
                matches += 1
            else:
                print(f"   ⚠️  No CSV data: {batch_number}")
        
        print(f"\n📈 Integration Results:")
        print(f"   • PDF files: {len(pdf_files)}")
        print(f"   • CSV matches: {matches}")
        print(f"   • Match rate: {matches/len(pdf_files)*100:.1f}%" if pdf_files else "   • No PDFs to match")
        
        return matches > 0
        
    except Exception as e:
        print(f"❌ Integration test error: {e}")
        return False

def main():
    """Run all tests"""
    print("🌿 Skyworld Notion Import - Test Suite")
    print("=" * 40)
    
    tests = [
        ("CSV Loading", test_csv_loading),
        ("PDF Matching", test_pdf_matching),
        ("Integration", test_integration)
    ]
    
    passed = 0
    for test_name, test_func in tests:
        try:
            if test_func():
                passed += 1
                print(f"✅ {test_name}: PASSED")
            else:
                print(f"❌ {test_name}: FAILED")
        except Exception as e:
            print(f"❌ {test_name}: ERROR - {e}")
    
    print(f"\n📊 Test Summary: {passed}/{len(tests)} passed")
    
    if passed == len(tests):
        print("🎉 All tests passed! Ready for Notion import.")
    else:
        print("⚠️  Some tests failed. Check configuration and files.")
    
    return passed == len(tests)

if __name__ == "__main__":
    success = main()
    sys.exit(0 if success else 1)