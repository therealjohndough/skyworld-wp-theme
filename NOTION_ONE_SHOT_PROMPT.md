# One-Shot Notion Cannabis Database Creation Prompt

## 🎯 **Agent Prompt for Complete Setup**

Copy and paste this entire prompt to an agent that can interact with Notion:

---

**PROMPT:**

Create a complete cannabis business database system in Notion with 3 interconnected databases for professional strain and inventory management. Set up the following:

**DATABASE 1: "🌿 Skyworld Strain Masters"**
Properties needed:
- Strain Name (Title - already exists)
- Type (Select: Indica, Sativa, Hybrid)
- Genetics (Text)
- Avg THC (Number, format as %)
- Avg CBD (Number, format as %)
- Avg CBG (Number, format as %)
- Avg THCV (Number, format as %)
- Avg Terp Total (Number, format as %)
- Dom Terp 1 (Text)
- Dom Terp 1 % (Number, format as %)
- Dom Terp 2 (Text)
- Dom Terp 2 % (Number, format as %)
- Dom Terp 3 (Text)
- Dom Terp 3 % (Number, format as %)
- Effects (Text)
- Nose (Text)
- Flavor (Text)
- Strain Photos (Files & media)
- Related Batches (Relation - to Product Batches DB)
- Total Batches (Rollup - count of related batches)
- Status (Select: Active, Discontinued, Coming Soon)
- Created (Created time)
- Updated (Last edited time)

**DATABASE 2: "📦 Skyworld Product Batches"**
Properties needed:
- Batch Number (Title - already exists)
- Strain (Relation - to Strain Masters DB, display "Strain Name")
- Product Type (Select: Flower, Pre-roll, Hash Hole)
- Status (Select: IN-STOCK, SOLD-OUT, COMING-SOON)
- Test Date (Date)
- Harvest Date (Date)
- Package Sizes (Multi-select: 1g, 3.5g, 7g, 14g, 28g)
- THC % (Number, format as %)
- CBD % (Number, format as %)
- CBG % (Number, format as %)
- THCV % (Number, format as %)
- Terp Total % (Number, format as %)
- Terp 1 Name (Text)
- Terp 1 % (Number, format as %)
- Terp 2 Name (Text)
- Terp 2 % (Number, format as %)
- Terp 3 Name (Text)
- Terp 3 % (Number, format as %)
- Lab Name (Text)
- COA Document (Relation - to COA Documents DB, display "COA ID")
- WordPress Status (Select: NOT-SYNCED, SYNCED, PUBLISHED)
- Price 1g (Number, format as $)
- Price 3.5g (Number, format as $)
- Price 7g (Number, format as $)
- Notes (Text)
- Created (Created time)
- Updated (Last edited time)

**DATABASE 3: "📋 Skyworld COA Documents"**
Properties needed:
- COA ID (Title - already exists)
- Related Batch (Relation - to Product Batches DB, display "Batch Number")
- PDF File (Files & media)
- Lab Name (Text)
- Test Date (Date)
- License Number (Text)
- Overall Status (Select: PASS, FAIL, PENDING)
- Pesticides (Select: PASS, FAIL, N/A)
- Heavy Metals (Select: PASS, FAIL, N/A)
- Microbials (Select: PASS, FAIL, N/A)
- Residual Solvents (Select: PASS, FAIL, N/A)
- Moisture % (Number, format as %)
- Total Cannabinoids % (Number, format as %)
- Total Terpenes % (Number, format as %)
- WordPress Status (Select: NOT-UPLOADED, UPLOADED, PUBLISHED)
- Notes (Text)
- Upload Date (Created time)
- Last Modified (Last edited time)

**RELATIONS TO SET UP:**
1. Strain Masters "Related Batches" ↔ Product Batches "Strain"
2. Product Batches "COA Document" ↔ COA Documents "Related Batch"

**SAMPLE DATA TO ADD:**

Strain Master Example:
- Strain Name: Wafflez
- Type: Indica
- Genetics: Apple Fritter x Stuff French Toast
- Avg THC: 28.5%
- Avg CBD: 0.7%
- Dom Terp 1: b-Caryophyllene
- Dom Terp 1 %: 0.76%
- Effects: Relaxing, Happy, Comforting
- Nose: Sweet pastry with subtle cinnamon and fruit undertones

Product Batch Example:
- Batch Number: SW031725-J35-WZ
- Strain: [Link to Wafflez]
- Product Type: Flower
- Status: IN-STOCK
- Test Date: 2025-03-17
- THC %: 27.27%
- CBD %: 0.15%
- CBG %: 0.98%
- Terp Total %: 2.52%
- Price 3.5g: $45.00

COA Document Example:
- COA ID: COA-SW031725-J35-WZ
- Related Batch: [Link to SW031725-J35-WZ]
- Lab Name: Testing Laboratory LLC
- Test Date: 2025-03-17
- Overall Status: PASS
- WordPress Status: NOT-UPLOADED

**VIEWS TO CREATE:**

For Strain Masters:
- Gallery View: "Strain Library" (grouped by Type, show Strain Photos)
- Table View: "Active Strains" (filter: Status = Active)

For Product Batches:
- Board View: "Inventory Status" (grouped by Status)
- Table View: "Current Stock" (filter: Status = IN-STOCK)
- Table View: "Need COA" (filter: COA Document is empty)

For COA Documents:
- Table View: "Upload Progress" (filter: WordPress Status ≠ PUBLISHED)
- Board View: "Test Results" (grouped by Overall Status)

Create this complete system with all properties, relations, sample data, and views. This will be used for professional cannabis business management with WordPress integration for COA displays and inventory management.

---

**Use this prompt with any Notion automation agent or assistant that can create databases!** 🚀