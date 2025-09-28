# Skyworld Notion Setup - Step by Step

## 🚀 **10-Minute Setup Guide**

### **Before You Start:**
- Have your Notion workspace ready
- Keep this guide open for reference
- Prepare your flower archive data for copying

---

## **STEP 1: Create Database 1 - Strain Masters**

1. **Open Notion** → Create new page
2. **Type:** `/database` → Select "Database - Full Page"
3. **Title:** 🌿 Skyworld Strain Masters
4. **Add Properties** (click + next to existing columns):

```
✅ Strain Name (Title) - Already exists

🔄 Type
   - Property Type: Select
   - Options: Indica, Sativa, Hybrid

🧬 Genetics
   - Property Type: Text

📈 Avg THC
   - Property Type: Number
   - Format: Percent

📈 Avg CBD
   - Property Type: Number  
   - Format: Percent

📈 Avg CBG
   - Property Type: Number
   - Format: Percent

🍃 Avg Terp Total
   - Property Type: Number
   - Format: Percent

🏷️ Dom Terp 1
   - Property Type: Text

📊 Dom Terp 1 %
   - Property Type: Number
   - Format: Percent

🏷️ Dom Terp 2
   - Property Type: Text

📊 Dom Terp 2 %
   - Property Type: Number
   - Format: Percent

🏷️ Dom Terp 3
   - Property Type: Text

📊 Dom Terp 3 %
   - Property Type: Number
   - Format: Percent

😊 Effects
   - Property Type: Text

👃 Nose
   - Property Type: Text

👅 Flavor
   - Property Type: Text

📸 Strain Photos
   - Property Type: Files & media

🔗 Related Batches
   - Property Type: Relation
   - (We'll connect this after creating the Batches database)

📈 Total Batches
   - Property Type: Rollup
   - (We'll configure this after relations are set)
```

**✅ Database 1 Complete!**

---

## **STEP 2: Create Database 2 - Product Batches**

1. **Create another new page** → Database - Full Page
2. **Title:** 📦 Skyworld Product Batches
3. **Add Properties:**

```
✅ Batch Number (Title) - Already exists

🌿 Strain
   - Property Type: Relation
   - (We'll connect this to Strain Masters next)

🏷️ Product Type
   - Property Type: Select
   - Options: Flower, Pre-roll, Hash Hole

🔄 Status
   - Property Type: Select
   - Options: IN-STOCK, SOLD-OUT, COMING-SOON

📅 Test Date
   - Property Type: Date

📅 Harvest Date
   - Property Type: Date

📦 Package Sizes
   - Property Type: Multi-select
   - Options: 1g, 3.5g, 7g, 14g, 28g

📈 THC %
   - Property Type: Number
   - Format: Percent

📈 CBD %
   - Property Type: Number
   - Format: Percent

📈 CBG %
   - Property Type: Number
   - Format: Percent

🍃 Terp Total %
   - Property Type: Number
   - Format: Percent

🏷️ Terp 1 Name
   - Property Type: Text

📊 Terp 1 %
   - Property Type: Number
   - Format: Percent

🏷️ Terp 2 Name
   - Property Type: Text

📊 Terp 2 %
   - Property Type: Number
   - Format: Percent

🏷️ Terp 3 Name
   - Property Type: Text

📊 Terp 3 %
   - Property Type: Number
   - Format: Percent

🧪 Lab Name
   - Property Type: Text

📋 COA Document
   - Property Type: Relation
   - (We'll connect this to COA database next)

📄 WordPress Status
   - Property Type: Select
   - Options: NOT-SYNCED, SYNCED, PUBLISHED

💰 Price 1g
   - Property Type: Number
   - Format: Dollar

💰 Price 3.5g
   - Property Type: Number
   - Format: Dollar

💰 Price 7g
   - Property Type: Number
   - Format: Dollar
```

**✅ Database 2 Complete!**

---

## **STEP 3: Create Database 3 - COA Documents**

1. **Create third new page** → Database - Full Page
2. **Title:** 📋 Skyworld COA Documents  
3. **Add Properties:**

```
✅ COA ID (Title) - Already exists

📋 Related Batch
   - Property Type: Relation
   - (We'll connect this to Product Batches)

📁 PDF File
   - Property Type: Files & media

🧪 Lab Name
   - Property Type: Text

📅 Test Date
   - Property Type: Date

🔢 License Number
   - Property Type: Text

✅ Overall Status
   - Property Type: Select
   - Options: PASS, FAIL, PENDING

🦠 Pesticides
   - Property Type: Select
   - Options: PASS, FAIL, N/A

⚖️ Heavy Metals
   - Property Type: Select
   - Options: PASS, FAIL, N/A

🔬 Microbials
   - Property Type: Select
   - Options: PASS, FAIL, N/A

🧪 Residual Solvents
   - Property Type: Select
   - Options: PASS, FAIL, N/A

💧 Moisture %
   - Property Type: Number
   - Format: Percent

📊 Total Cannabinoids %
   - Property Type: Number
   - Format: Percent

📊 Total Terpenes %
   - Property Type: Number
   - Format: Percent

📈 WordPress Status
   - Property Type: Select
   - Options: NOT-UPLOADED, UPLOADED, PUBLISHED
```

**✅ Database 3 Complete!**

---

## **STEP 4: Connect the Relations** ⭐ IMPORTANT!

### **Connect Strain Masters ↔ Product Batches:**

1. **Go to Strain Masters database**
2. **Click on "Related Batches" column header** → Edit property
3. **Select "Product Batches" database**
4. **For display property, choose "Batch Number"**
5. **Click Done**

6. **Go to Product Batches database**
7. **Click on "Strain" column header** → Edit property
8. **Select "Strain Masters" database**
9. **For display property, choose "Strain Name"**
10. **Click Done**

### **Connect Product Batches ↔ COA Documents:**

1. **In Product Batches database**
2. **Click "COA Document" column header** → Edit property
3. **Select "COA Documents" database**
4. **For display property, choose "COA ID"**
5. **Click Done**

6. **Go to COA Documents database**
7. **Click "Related Batch" column header** → Edit property
8. **Select "Product Batches" database**
9. **For display property, choose "Batch Number"**
10. **Click Done**

**✅ All Relations Connected!**

---

## **STEP 5: Test with Sample Data**

### **Add Your First Strain:**
1. **Go to Strain Masters database**
2. **Click "New" to add a row**
3. **Fill in sample data:**
   ```
   Strain Name: Wafflez
   Type: Indica
   Genetics: Apple Fritter x Stuff French Toast
   Avg THC: 28.5%
   Dom Terp 1: b-Caryophyllene
   Dom Terp 1 %: 0.76%
   Effects: Relaxing, Happy, Comforting
   Nose: Sweet pastry with cinnamon
   ```

### **Add Your First Batch:**
1. **Go to Product Batches database**
2. **Click "New" to add a row**
3. **Fill in sample data:**
   ```
   Batch Number: SW031725-J35-WZ
   Strain: [Select "Wafflez" from dropdown]
   Product Type: Flower
   Status: IN-STOCK
   THC %: 27.27%
   Price 3.5g: $45.00
   ```

### **Add Your First COA:**
1. **Go to COA Documents database**
2. **Click "New" to add a row**
3. **Fill in sample data:**
   ```
   COA ID: COA-SW031725-J35-WZ
   Related Batch: [Select "SW031725-J35-WZ" from dropdown]
   Lab Name: Testing Laboratory LLC
   Overall Status: PASS
   ```

**🎉 SUCCESS! Your databases are now connected and working!**

---

## **STEP 6: Import Your Real Data**

Now you can:
1. **Copy your flower archive data** into the Product Batches database
2. **Upload your COA PDFs** to the COA Documents database
3. **Create strain master records** for each unique strain
4. **Link everything together** using the relations

---

## **Pro Tips:**

✅ **Start with 3-4 strains** to test the system
✅ **Upload one COA PDF** to verify file storage works
✅ **Test the relations** by linking batches to strains
✅ **Export a CSV** to test WordPress compatibility
✅ **Create views** for easier data management

**Your professional cannabis database is now ready! This will sync perfectly with your WordPress system.** 🌿🚀