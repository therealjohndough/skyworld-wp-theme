# 🚀 FINAL: Import Your Real Cannabis Data to Notion

## ✅ Ready to Import - Real Data Templates

Your **actual cannabis inventory data** is now ready for Notion import! All templates are based on your real COA files and batch naming system.

## 📋 Import Order (CRITICAL)

**Import in this exact order to maintain relations:**

### 1. **Strain Masters FIRST** ⭐
```
File: scripts/notion-strain-masters-real.csv
Records: 16 strains
Action: Notion Database → "..." → "Merge with CSV"
```

### 2. **Product Batches SECOND** ⭐⭐
```
File: scripts/notion-product-batches-real.csv  
Records: 33 batches
Action: Notion Database → "..." → "Merge with CSV"
```

### 3. **COA Documents LAST** ⭐⭐⭐
```
File: scripts/notion-coa-documents-real.csv
Records: 33 COAs
Action: Notion Database → "..." → "Merge with CSV"
```

## 🎯 Column Mapping Guide

### Strain Masters Import
```
CSV Column → Notion Property
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Strain Name → Strain Name (Title)
Type → Type
Genetics → Genetics  
Avg THC → Avg THC (format as %)
Avg CBD → Avg CBD (format as %)
...continue with all columns
SKIP: Related Batches (link manually after)
```

### Product Batches Import  
```
CSV Column → Notion Property
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Batch Number → Batch Number (Title)
Product Type → Product Type
Status → Status
Test Date → Test Date
Package Sizes → Package Sizes
...continue with all columns  
SKIP: Strain (relation - link manually)
SKIP: COA Document (relation - link manually)
```

### COA Documents Import
```  
CSV Column → Notion Property
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
COA ID → COA ID (Title)
Lab Name → Lab Name
Test Date → Test Date
Overall Status → Overall Status
...continue with all columns
SKIP: Related Batch (relation - link manually)
```

## 🔗 Manual Relation Linking Required

After importing, **manually link these relations:**

### Link Batches to Strains
```
Example Links:
SW3725J-WZ → Skyworld Wafflez
SW051925-PRE05X2-GG → Garlic Gravity  
SW063025-J35-MS → Melted Strawberries
SW051925-HH-SCPXPR → Sherb Cream Pie
```

### Link COAs to Batches  
```
Example Links:
2502RLI0135-0492 → SW3725J-WZ
2507RLI0610-2236 → SW051925-PRE05X2-GG
2507RLI0668-2521 → SW063025-J35-MS
2508RLI0713-2651 → SW051925-HH-SCPXPR
```

## 📊 Your Complete Cannabis Data

After import, you'll have:

### 🌿 **16 Strain Profiles**
- Skyworld Wafflez, Sherb Cream Pie, Stay Puft
- Garlic Gravity, Melted Strawberries, Triple Burger
- Peanut Butter Gelato, White Apple Runtz, Superboof
- Complete cannabinoid & terpene data

### 📦 **33 Product Batches**
- **21 Flower batches** (3.5g jars)
- **10 Pre-roll batches** (0.5g, 1g, 2pk, 6pk)
- **2 Hash Hole batches** (premium 1g)

### 📋 **33 COA Documents**  
- Real COA IDs matching your PDF filenames
- SJR Horticulture lab results
- Complete safety test data

## 🎯 Upload COA PDFs

After database import, upload your actual COA PDF files:
1. **In COA Documents database** → open each COA record
2. **Click "PDF File" field** → upload corresponding PDF
3. **Match COA ID to filename** (e.g., COA ID `2502RLI0135-0492` → upload `2502RLI0135-0492 - SJR Horticulture - Skyworld Wafflez 3.5g.pdf`)

## 🚀 WordPress Integration Ready

Once Notion is populated:
1. **Export data from Notion** (CSV format)  
2. **Import to WordPress** using your cannabis importer
3. **Upload COAs to Asset Manager**
4. **Test COA Viewer** on your live site

## ✅ Your Professional Cannabis Ecosystem

**Backend**: Notion database with team collaboration  
**Frontend**: WordPress with professional COA displays  
**Integration**: Seamless data flow between systems  
**Live Site**: dev.skyworldcannabis.com

---

## 🎯 Ready to Launch!

**Start with Step 1**: Import `notion-strain-masters-real.csv` to your Strain Masters database in Notion.

Your complete cannabis business management system awaits! 🌿🚀