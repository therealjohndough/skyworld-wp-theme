# Skyworld Cannabis Notion Template - Ready to Duplicate

## 🚀 **One-Click Setup**

### **Method 1: Duplicate This Template**
[Notion Template Link - Coming Soon]
*(I'll provide the shareable template link once created)*

### **Method 2: Manual Setup (Copy/Paste)**

---

## 📊 **Database 1 Creation Script**

### **Create "🌿 Skyworld Strain Masters"**

Copy this into a new Notion database page:

```
Database Name: 🌿 Skyworld Strain Masters

Properties to Add:
1. Strain Name (Title) - Already exists
2. Genetics (Text)
3. Type (Select)
   Options: Indica, Sativa, Hybrid
4. Avg THC (Number - Format as Percentage)
5. Avg CBD (Number - Format as Percentage)
6. Avg CBG (Number - Format as Percentage)  
7. Avg THCV (Number - Format as Percentage)
8. Avg Terp Total (Number - Format as Percentage)
9. Dom Terp 1 (Text)
10. Dom Terp 1 % (Number - Format as Percentage)
11. Dom Terp 2 (Text)
12. Dom Terp 2 % (Number - Format as Percentage)
13. Dom Terp 3 (Text)
14. Dom Terp 3 % (Number - Format as Percentage)
15. Effects (Text)
16. Nose (Text)
17. Flavor (Text)
18. Strain Photos (Files & media)
19. Related Batches (Relation - Connect to Product Batches)
20. Total Batches (Rollup - Count related batches)
21. Last Updated (Last edited time)
22. Created Date (Created time)
```

---

## 📦 **Database 2 Creation Script**

### **Create "📦 Skyworld Product Batches"**

```
Database Name: 📦 Skyworld Product Batches

Properties to Add:
1. Batch Number (Title) - Already exists
2. Strain (Relation - Connect to Strain Masters)
3. Test Date (Date)
4. Harvest Date (Date)
5. Product Type (Select)
   Options: Flower, Pre-roll, Hash Hole
6. Package Sizes (Multi-select)
   Options: 1g, 3.5g, 7g, 14g, 28g
7. Status (Select)
   Options: IN-STOCK, SOLD-OUT, COMING-SOON
8. THC % (Number - Format as Percentage)
9. CBD % (Number - Format as Percentage)
10. CBG % (Number - Format as Percentage)
11. THCV % (Number - Format as Percentage)
12. Terp Total % (Number - Format as Percentage)
13. Terp 1 Name (Text)
14. Terp 1 % (Number - Format as Percentage)
15. Terp 2 Name (Text)
16. Terp 2 % (Number - Format as Percentage)
17. Terp 3 Name (Text)
18. Terp 3 % (Number - Format as Percentage)
19. COA Document (Relation - Connect to COA Documents)
20. Lab Name (Text)
21. WordPress Status (Select)
    Options: NOT-SYNCED, SYNCED, PUBLISHED
22. Price 1g (Number - Format as Dollar)
23. Price 3.5g (Number - Format as Dollar)
24. Price 7g (Number - Format as Dollar)
25. Created Date (Created time)
26. Last Updated (Last edited time)
```

---

## 📋 **Database 3 Creation Script**

### **Create "📋 Skyworld COA Documents"**

```
Database Name: 📋 Skyworld COA Documents

Properties to Add:
1. COA ID (Title) - Already exists
2. Related Batch (Relation - Connect to Product Batches)
3. PDF File (Files & media)
4. Lab Name (Text)
5. Test Date (Date)
6. License Number (Text)
7. Overall Status (Select)
   Options: PASS, FAIL, PENDING
8. Pesticides (Select)
   Options: PASS, FAIL, N/A
9. Heavy Metals (Select)
   Options: PASS, FAIL, N/A
10. Microbials (Select)
    Options: PASS, FAIL, N/A
11. Residual Solvents (Select)
    Options: PASS, FAIL, N/A
12. Moisture % (Number - Format as Percentage)
13. Total Cannabinoids % (Number - Format as Percentage)
14. Total Terpenes % (Number - Format as Percentage)
15. WordPress Status (Select)
    Options: NOT-UPLOADED, UPLOADED, PUBLISHED
16. Upload Date (Created time)
17. Last Modified (Last edited time)
18. Notes (Text - Long text)
```

---

## 🔗 **Relation Setup Instructions**

### **After Creating All 3 Databases:**

1. **Go to Strain Masters Database**
   - Edit "Related Batches" property
   - Select "Product Batches" as the target database
   - Choose "Batch Number" as the display property

2. **Go to Product Batches Database**
   - Edit "Strain" property  
   - Select "Strain Masters" as the target database
   - Choose "Strain Name" as the display property
   
   - Edit "COA Document" property
   - Select "COA Documents" as the target database  
   - Choose "COA ID" as the display property

3. **Go to COA Documents Database**
   - Edit "Related Batch" property
   - Select "Product Batches" as the target database
   - Choose "Batch Number" as the display property

---

## 📊 **Template Views to Create**

### **Strain Masters Views:**

**Gallery View - "Strain Library"**
```
- Layout: Gallery
- Card Preview: Strain Photos
- Card Size: Medium
- Group by: Type
- Sort by: Strain Name (A to Z)
```

**Table View - "Complete Data"**
```
- Show all properties
- Sort by: Total Batches (High to Low)
- Filter: Total Batches > 0
```

### **Product Batches Views:**

**Board View - "Inventory Status"**
```
- Group by: Status
- Card Properties: Strain, THC %, Package Sizes
- Sort by: Test Date (New to Old)
```

**Table View - "Current Inventory"**
```
- Filter: Status = IN-STOCK
- Show: Batch Number, Strain, THC %, CBD %, Status, Package Sizes
- Sort by: Test Date (New to Old)
```

**Table View - "Need COA Upload"**
```
- Filter: COA Document is empty
- Show: Batch Number, Strain, Test Date, WordPress Status
- Sort by: Test Date (Old to New)
```

### **COA Documents Views:**

**Table View - "Upload Progress"**
```
- Show: COA ID, Related Batch, PDF File, WordPress Status
- Sort by: Upload Date (New to Old)
- Filter: WordPress Status ≠ PUBLISHED
```

**Board View - "Test Results"**
```
- Group by: Overall Status
- Card Properties: Related Batch, Lab Name, Test Date
```

---

## 📝 **Sample Data Templates**

### **Strain Master Template:**
```
🌿 Strain Name: Wafflez
🧬 Genetics: Apple Fritter x Stuff French Toast  
🔄 Type: Indica
📈 Avg THC: 28.5%
📈 Avg CBD: 0.7%
📈 Avg CBG: 1.2%
🍃 Avg Terp Total: 2.3%
🏷️ Dom Terp 1: b-Caryophyllene
📊 Dom Terp 1 %: 0.76%
🏷️ Dom Terp 2: Limonene  
📊 Dom Terp 2 %: 0.61%
🏷️ Dom Terp 3: b-Myrcene
📊 Dom Terp 3 %: 0.27%
😊 Effects: Relaxing, Happy, Comforting
👃 Nose: Sweet pastry with subtle cinnamon and fruit undertones
👅 Flavor: Warm, buttery dessert notes with hints of apple and spice
```

### **Product Batch Template:**
```
📋 Batch Number: SW031725-J35-WZ
🌿 Strain: [Link to Wafflez]
📅 Test Date: 2025-03-17
🏷️ Product Type: Flower
📦 Package Sizes: 1g, 3.5g, 7g
🔄 Status: IN-STOCK
📈 THC %: 27.27%
📈 CBD %: 0.15%
📈 CBG %: 0.98%
🍃 Terp Total %: 2.52%
🏷️ Terp 1 Name: b-Caryophyllene
📊 Terp 1 %: 0.76%
🏷️ Terp 2 Name: Limonene
📊 Terp 2 %: 0.61%
🏷️ Terp 3 Name: b-Myrcene
📊 Terp 3 %: 0.26%
🧪 Lab Name: Testing Laboratory LLC
📄 WordPress Status: NOT-SYNCED
💰 Price 1g: $15.00
💰 Price 3.5g: $45.00
💰 Price 7g: $85.00
```

### **COA Document Template:**
```
📄 COA ID: COA-SW031725-J35-WZ
📋 Related Batch: [Link to SW031725-J35-WZ]
📁 PDF File: [Upload COA PDF here]
🧪 Lab Name: Testing Laboratory LLC
📅 Test Date: 2025-03-17
🔢 License Number: C8-0000013-LIC
✅ Overall Status: PASS
🦠 Pesticides: PASS
⚖️ Heavy Metals: PASS
🔬 Microbials: PASS
🧪 Residual Solvents: PASS
💧 Moisture %: 8.2%
📊 Total Cannabinoids %: 28.4%
📊 Total Terpenes %: 2.52%
📈 WordPress Status: NOT-UPLOADED
```

---

## 🎯 **Quick Start Checklist**

- [ ] Create 3 databases with properties above
- [ ] Set up relations between databases  
- [ ] Create recommended views
- [ ] Add sample data using templates
- [ ] Upload first COA PDF to test
- [ ] Link batch to strain master
- [ ] Export first CSV for WordPress testing

**This template structure will make your cannabis data management professional and efficient!** 🌿

---

## 💡 **Pro Tips for Setup**

1. **Start small** - Create 2-3 strain records first
2. **Test relations** - Make sure linking works between databases
3. **Upload one COA** - Verify file storage works
4. **Export test CSV** - Confirm WordPress import compatibility
5. **Build templates** - Save time with consistent data entry

**Ready to revolutionize your cannabis data management?** 🚀