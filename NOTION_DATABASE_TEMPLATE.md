# Skyworld Cannabis Notion Database Template

## 🎯 **Overview**
This Notion setup matches your WordPress structure perfectly, making it easy to manage cannabis data and sync to your website.

---

## 📊 **Database 1: Strain Master Records**

### **Properties Setup:**
```
🌿 Strain Name (Title) - Text
🧬 Genetics - Text
🔄 Type - Select (Indica, Sativa, Hybrid)
📈 Average THC - Number (%)
📈 Average CBD - Number (%)  
📈 Average CBG - Number (%)
📈 Average THCV - Number (%)
🍃 Average Terp Total - Number (%)
🏷️ Dominant Terpene 1 - Text
📊 Dom Terp 1 % - Number
🏷️ Dominant Terpene 2 - Text  
📊 Dom Terp 2 % - Number
🏷️ Dominant Terpene 3 - Text
📊 Dom Terp 3 % - Number
😊 Effects - Text
👃 Nose/Aroma - Text
👅 Flavor - Text
📸 Strain Images - Files & Media
🔗 Related Batches - Relation (to Batches DB)
📈 Total Batches - Rollup (count of related batches)
```

### **Template for New Strains:**
```
Strain Name: [Enter strain name]
Genetics: [Parent 1] x [Parent 2]
Type: [Select: Indica/Sativa/Hybrid]

Average Cannabinoids:
- THC: [Average across all batches]
- CBD: [Average across all batches] 
- CBG: [Average across all batches]

Top 3 Terpenes:
1. [Name]: [Average %]
2. [Name]: [Average %]  
3. [Name]: [Average %]

Effects: [Common effects across batches]
Nose: [Typical aroma profile]
Flavor: [Typical flavor notes]
```

---

## 📦 **Database 2: Product Batches**

### **Properties Setup:**
```
📋 Batch Number (Title) - Text
🌿 Strain - Relation (to Strain Master DB)
📅 Test Date - Date
📅 Harvest Date - Date  
🏷️ Product Type - Select (Flower, Pre-roll, Hash Hole)
📦 Package Sizes - Multi-select (1g, 3.5g, 7g, 14g, 28g)
💰 Prices - Text (JSON format: {"1g": "$15", "3.5g": "$45"})
🔄 Status - Select (IN-STOCK, SOLD-OUT, COMING-SOON)
📈 THC % - Number
📈 CBD % - Number
📈 CBG % - Number  
📈 THCV % - Number
🍃 Terp Total % - Number
🏷️ Terp 1 Name - Text
📊 Terp 1 % - Number
🏷️ Terp 2 Name - Text
📊 Terp 2 % - Number
🏷️ Terp 3 Name - Text
📊 Terp 3 % - Number
📋 COA File - Relation (to COA DB)
🧪 Lab Name - Text
📄 COA Status - Select (UPLOADED, LINKED, PUBLISHED)
```

### **Batch Template:**
```
Batch #: SW[DATE]-[LOCATION]-[STRAIN-CODE]
Strain: [Link to strain master record]
Test Date: [Lab test completion date]
Product Type: [Flower/Pre-roll/Hash Hole]

Specific Test Results:
- THC: [Exact % for this batch]
- CBD: [Exact % for this batch]
- Total Terpenes: [Exact % for this batch]

Top Terpenes This Batch:
1. [Name]: [%]
2. [Name]: [%]
3. [Name]: [%]

Status: [IN-STOCK/SOLD-OUT]
COA: [Link to COA record]
```

---

## 📋 **Database 3: COA Documents**

### **Properties Setup:**
```
📄 COA ID (Title) - Text
📋 Related Batch - Relation (to Batches DB)
📁 PDF File - Files & Media
🧪 Lab Name - Text
📅 Test Date - Date
🔢 License Number - Text
✅ Test Status - Select (PASS, FAIL, PENDING)
🦠 Pesticides - Select (PASS, FAIL, N/A)
⚖️ Heavy Metals - Select (PASS, FAIL, N/A)
🔬 Microbials - Select (PASS, FAIL, N/A)
🧪 Residual Solvents - Select (PASS, FAIL, N/A)
💧 Moisture Content - Number (%)
📊 Total Cannabinoids - Number (%)
📊 Total Terpenes - Number (%)
📈 WordPress Status - Select (NOT-SYNCED, SYNCED, PUBLISHED)
```

---

## 🔄 **Notion → WordPress Sync Process**

### **Step 1: Data Entry in Notion**
1. **Upload COA PDFs** to COA Database
2. **Extract key data** from PDFs into structured fields
3. **Create batch records** with specific test results
4. **Link batches to strain masters** for averages

### **Step 2: Export for WordPress**
1. **Export batches** as CSV with all cannabinoid/terpene data
2. **Export strains** as separate CSV with averages
3. **Use WordPress import system** we built

### **Step 3: COA Integration**
1. **Upload COA PDFs** to WordPress Asset Manager
2. **Link batch numbers** to COA files
3. **Add COA shortcodes** to product pages
4. **Users see professional displays** instead of raw PDFs

---

## 📊 **Notion Views to Create**

### **Strain Master Views:**
- **Gallery View** - Visual strain library with photos
- **Table View** - Full data comparison
- **Indica/Sativa/Hybrid** - Filtered by type

### **Batch Views:**
- **IN-STOCK Products** - Current inventory
- **By Strain** - All batches grouped by strain  
- **Recent Batches** - Newest test results first
- **COA Status** - Track which need COA uploads

### **COA Views:**
- **Upload Status** - Track PDF upload progress
- **Lab Results** - Quick test result overview
- **WordPress Sync** - Track what's published

---

## 🚀 **Getting Started Steps**

1. **Create the 3 databases** in Notion with properties above
2. **Set up relations** between databases
3. **Create templates** for consistent data entry
4. **Start with your flower archive** - enter existing data
5. **Upload COA PDFs** and link to batches
6. **Export to CSV** when ready for WordPress

---

## 💡 **Pro Tips**

### **Data Management:**
- **Use consistent naming** for batch numbers
- **Template everything** for faster data entry
- **Link all related records** for automatic calculations
- **Track sync status** to WordPress

### **Team Workflow:**
- **Assign COA upload** to specific team members
- **Review process** before WordPress sync
- **Version control** for data changes

---

## 🎯 **READY-TO-USE NOTION TEMPLATE**

### **One-Click Duplicate Link:**
**[Skyworld Cannabis Database Template →](https://www.notion.so/templates)**
*(Template will be available once published to Notion Template Gallery)*

### **Manual Setup Instructions:**

#### **Database 1: 🌿 Strain Masters**
```
1. Create new database in Notion
2. Title: "🌿 Skyworld Strain Masters"
3. Add these properties:

Name: Strain Name (Title) - Already exists
Type: Select - Options: Indica, Sativa, Hybrid
Genetics: Text
Avg THC: Number (Format as %)
Avg CBD: Number (Format as %)
Avg CBG: Number (Format as %)
Avg THCV: Number (Format as %)
Avg Terp Total: Number (Format as %)
Dom Terp 1: Text
Dom Terp 1 %: Number (Format as %)
Dom Terp 2: Text
Dom Terp 2 %: Number (Format as %)
Dom Terp 3: Text
Dom Terp 3 %: Number (Format as %)
Effects: Text
Nose: Text
Flavor: Text
Strain Photos: Files & media
Related Batches: Relation (to be connected)
Total Batches: Rollup (Count)
Status: Select - Options: Active, Discontinued, Coming Soon
Created: Created time
Updated: Last edited time
```

#### **Database 2: 📦 Product Batches**
```
1. Create new database in Notion
2. Title: "📦 Skyworld Product Batches"
3. Add these properties:

Name: Batch Number (Title) - Already exists
Strain: Relation (to Strain Masters)
Product Type: Select - Options: Flower, Pre-roll, Hash Hole
Status: Select - Options: IN-STOCK, SOLD-OUT, COMING-SOON
Test Date: Date
Harvest Date: Date
Package Sizes: Multi-select - Options: 1g, 3.5g, 7g, 14g, 28g
THC %: Number (Format as %)
CBD %: Number (Format as %)
CBG %: Number (Format as %)
THCV %: Number (Format as %)
Terp Total %: Number (Format as %)
Terp 1 Name: Text
Terp 1 %: Number (Format as %)
Terp 2 Name: Text
Terp 2 %: Number (Format as %)
Terp 3 Name: Text
Terp 3 %: Number (Format as %)
Lab Name: Text
COA Document: Relation (to COA Documents)
WordPress Status: Select - Options: NOT-SYNCED, SYNCED, PUBLISHED
Price 1g: Number (Format as $)
Price 3.5g: Number (Format as $)
Price 7g: Number (Format as $)
Notes: Text
Created: Created time
Updated: Last edited time
```

#### **Database 3: 📋 COA Documents**
```
1. Create new database in Notion
2. Title: "📋 Skyworld COA Documents"
3. Add these properties:

Name: COA ID (Title) - Already exists
Related Batch: Relation (to Product Batches)
PDF File: Files & media
Lab Name: Text
Test Date: Date
License Number: Text
Overall Status: Select - Options: PASS, FAIL, PENDING
Pesticides: Select - Options: PASS, FAIL, N/A
Heavy Metals: Select - Options: PASS, FAIL, N/A
Microbials: Select - Options: PASS, FAIL, N/A
Residual Solvents: Select - Options: PASS, FAIL, N/A
Moisture %: Number (Format as %)
Total Cannabinoids %: Number (Format as %)
Total Terpenes %: Number (Format as %)
WordPress Status: Select - Options: NOT-UPLOADED, UPLOADED, PUBLISHED
Notes: Text
Upload Date: Created time
Last Modified: Last edited time
```

### **Relation Setup (After Creating All 3):**
1. **Strain Masters** → Edit "Related Batches" → Connect to "Product Batches"
2. **Product Batches** → Edit "Strain" → Connect to "Strain Masters"
3. **Product Batches** → Edit "COA Document" → Connect to "COA Documents"
4. **COA Documents** → Edit "Related Batch" → Connect to "Product Batches"

### **Sample Data to Add:**
```
STRAIN MASTER EXAMPLE:
🌿 Strain Name: Wafflez
Type: Indica
Genetics: Apple Fritter x Stuff French Toast
Avg THC: 28.5%
Dom Terp 1: b-Caryophyllene (0.76%)
Effects: Relaxing, Happy, Comforting
Nose: Sweet pastry with subtle cinnamon

BATCH EXAMPLE:
📦 Batch Number: SW031725-J35-WZ
Strain: [Link to Wafflez]
Product Type: Flower
Status: IN-STOCK
THC %: 27.27%
Terp Total %: 2.52%
Price 3.5g: $45.00

COA EXAMPLE:
📋 COA ID: COA-SW031725-J35-WZ
Related Batch: [Link to SW031725-J35-WZ]
Lab Name: Testing Laboratory LLC
Overall Status: PASS
PDF File: [Upload COA here]
```

**Ready to revolutionize your cannabis data management! This template will sync perfectly with your WordPress system.** �