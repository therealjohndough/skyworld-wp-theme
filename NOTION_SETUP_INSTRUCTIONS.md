# Notion Database Setup Instructions

## 🚀 **Quick Setup Guide**

### **Step 1: Create Database 1 - Strain Masters**

1. **Create new database** in Notion
2. **Rename it to:** "🌿 Skyworld Strain Masters"
3. **Add these properties:**

```
Strain Name (Title) - already exists
Genetics - Text
Type - Select: Indica, Sativa, Hybrid
Avg THC - Number (show as %)
Avg CBD - Number (show as %)  
Avg CBG - Number (show as %)
Avg THCV - Number (show as %)
Avg Terp Total - Number (show as %)
Dom Terp 1 - Text
Dom Terp 1 % - Number (show as %)
Dom Terp 2 - Text
Dom Terp 2 % - Number (show as %)
Dom Terp 3 - Text  
Dom Terp 3 % - Number (show as %)
Effects - Text
Nose - Text
Flavor - Text
Strain Photos - Files & media
Related Batches - Relation (will connect after creating batches DB)
Total Batches - Rollup (count related batches)
```

### **Step 2: Create Database 2 - Product Batches**

1. **Create new database**
2. **Rename to:** "📦 Skyworld Product Batches"  
3. **Add these properties:**

```
Batch Number (Title) - already exists
Strain - Relation (to Strain Masters DB)
Test Date - Date
Harvest Date - Date
Product Type - Select: Flower, Pre-roll, Hash Hole
Package Sizes - Multi-select: 1g, 3.5g, 7g, 14g, 28g
Current Status - Select: IN-STOCK, SOLD-OUT, COMING-SOON
THC % - Number (show as %)
CBD % - Number (show as %)
CBG % - Number (show as %)
THCV % - Number (show as %)
Terp Total % - Number (show as %)
Terp 1 Name - Text
Terp 1 % - Number (show as %)
Terp 2 Name - Text
Terp 2 % - Number (show as %)
Terp 3 Name - Text
Terp 3 % - Number (show as %)
COA File - Relation (to COA DB - create this next)
Lab Name - Text
WordPress Status - Select: NOT-SYNCED, SYNCED, PUBLISHED
```

### **Step 3: Create Database 3 - COA Documents**

1. **Create new database**
2. **Rename to:** "📋 Skyworld COA Documents"
3. **Add these properties:**

```
COA ID (Title) - already exists  
Related Batch - Relation (to Product Batches DB)
PDF File - Files & media
Lab Name - Text
Test Date - Date
License Number - Text
Overall Status - Select: PASS, FAIL, PENDING
Pesticides - Select: PASS, FAIL, N/A
Heavy Metals - Select: PASS, FAIL, N/A
Microbials - Select: PASS, FAIL, N/A
Residual Solvents - Select: PASS, FAIL, N/A
Moisture % - Number (show as %)
Total Cannabinoids % - Number (show as %)
Total Terpenes % - Number (show as %)
WordPress Status - Select: NOT-UPLOADED, UPLOADED, PUBLISHED
```

### **Step 4: Connect the Relations**

1. **Go back to Strain Masters DB**
2. **Edit "Related Batches" property** → Select "Product Batches" as target
3. **Go to Product Batches DB**  
4. **Edit "Strain" property** → Select "Strain Masters" as target
5. **Edit "COA File" property** → Select "COA Documents" as target

---

## 📊 **Sample Data Entry**

### **Strain Master Example:**
```
Strain Name: Wafflez
Genetics: Apple Fritter x Stuff French Toast
Type: Indica
Avg THC: 28.5%
Avg CBD: 0.7%
Dom Terp 1: b-Caryophyllene (0.76%)
Dom Terp 2: Limonene (0.60%) 
Dom Terp 3: b-Myrcene (0.27%)
Effects: Relaxing, Happy, Comforting
Nose: Sweet pastry with subtle cinnamon and fruit undertones
Flavor: Warm, buttery dessert notes with hints of apple and spice
```

### **Batch Example:**
```
Batch Number: SW031725-J35-WZ
Strain: [Link to Wafflez]
Test Date: March 17, 2025
Product Type: Flower
Package Sizes: 1g, 3.5g, 7g
Current Status: IN-STOCK
THC %: 27.27%
CBD %: 0.15%
CBG %: 0.98%
Terp Total %: 2.52%
Terp 1 Name: b-Caryophyllene (0.76%)
Terp 2 Name: Limonene (0.61%)
Terp 3 Name: b-Myrcene (0.26%)
```

### **COA Example:**
```
COA ID: COA-SW031725-J35-WZ
Related Batch: [Link to SW031725-J35-WZ]
PDF File: [Upload COA PDF]
Lab Name: Testing Laboratory LLC
Test Date: March 17, 2025
Overall Status: PASS
Pesticides: PASS
Heavy Metals: PASS
Microbials: PASS
WordPress Status: NOT-UPLOADED
```

---

## 🔄 **Workflow Process**

### **Data Entry Workflow:**
1. **Upload COA PDF** to COA Documents DB
2. **Create batch record** with specific test results
3. **Link batch to strain master** (creates relation)
4. **Strain averages update** automatically via rollup
5. **Export to CSV** when ready for WordPress

### **WordPress Sync:**
1. **Export batches** as CSV for product import
2. **Export strains** as CSV for strain library
3. **Upload COA PDFs** to WordPress Asset Manager
4. **Link batch numbers** to COA displays
5. **Update sync status** in Notion

---

## 🎯 **Views to Create**

### **Strain Masters:**
- **Gallery View** - Visual strain library
- **Active Strains** - Filter: Related Batches > 0
- **By Type** - Group by Indica/Sativa/Hybrid

### **Product Batches:**
- **Current Inventory** - Filter: Status = IN-STOCK
- **Need COA Upload** - Filter: COA File is empty
- **Ready for WordPress** - Filter: WordPress Status = NOT-SYNCED

### **COA Documents:**
- **Upload Progress** - Track PDF uploads
- **Test Results** - Quick overview of pass/fail
- **WordPress Sync** - Track publication status

**Ready to set this up? This will make managing your cannabis data so much easier!** 🌿