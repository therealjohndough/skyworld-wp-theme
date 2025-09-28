# Skyworld Product Extraction Guide

## What You Need to Do:

1. **Open the CSV file**: `skyworld_products_extract.csv`
2. **Go to the Distru browser page** with all the flower products
3. **Find each Skyworld product** (ignore Twic3 baked)
4. **Replace the placeholder data** with real information

## Data Collection Checklist:

### For Each Product, Get:
- ✅ **Actual strain name** (replace "Skyworld Flower Strain 1" etc.)
- ✅ **Strain type** (Indica/Sativa/Hybrid)  
- ✅ **THC percentage** (just the number, like 25.5)
- ✅ **CBD percentage** (just the number, like 0.8)
- ✅ **Package size** (1g for pre-rolls, 3.5g for flower, etc.)
- ✅ **Price** (format: $XX.00)

### Product Categories:
- **9 Flower products** → `product_type` = "Flower"
- **10 Regular pre-rolls** → `product_type` = "Pre-roll" 
- **2 Hash holes** → `product_type` = "Hash Hole"

## Quick Tips:
- Keep strain names clean (no package sizes in name)
- THC/CBD as numbers only (no % symbol)
- Leave empty fields blank (don't put "N/A")
- Each row = one product variation

## When Done:
1. Save the CSV file
2. Go to WordPress Admin → Products → Import Data  
3. Upload your completed CSV
4. Watch the magic happen! ✨

---
**Current Status**: Template ready with 21 product slots
**Next Step**: Fill in real data from Distru browser page