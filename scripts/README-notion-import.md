# Notion Batch Importer for Skyworld Cannabis

This script uploads product batch data from CSV to Notion database with PDF links, matching batch numbers to COA PDF files.

## Features

- ✅ **CSV to Notion Import**: Reads batch metadata from `notion-product-batches-real.csv`
- ✅ **PDF Linking**: Automatically links COA PDF files to batch records
- ✅ **GitHub Integration**: Creates GitHub raw URLs for PDF access
- ✅ **Error Handling**: Comprehensive error handling and validation
- ✅ **Field Mapping**: Intelligent mapping of CSV columns to Notion properties
- ✅ **Progress Tracking**: Detailed logging and import statistics

## Prerequisites

1. **Python Dependencies**:
   ```bash
   pip install -r requirements.txt
   ```

2. **Notion Integration**:
   - Create a Notion integration at https://www.notion.so/my-integrations
   - Get your integration token
   - Share your database with the integration
   - Get your database ID from the URL

3. **Data Files**:
   - `notion-product-batches-real.csv` - Product batch metadata
   - `COAs/` directory with PDF files named by batch number

## Configuration

Set environment variables or edit the script configuration:

```bash
export NOTION_TOKEN="secret_your_token_here"
export NOTION_DATABASE_ID="your_database_id_here"
```

Or edit these variables in the script:
```python
NOTION_TOKEN = "your_notion_integration_token"
DATABASE_ID = "your_database_id"
```

## File Structure

```
skyworld-wp-theme/
├── scripts/
│   ├── notion_batch_importer.py          # Main import script
│   ├── notion-product-batches-real.csv   # Batch metadata
│   ├── requirements.txt                  # Python dependencies
│   └── README-notion-import.md           # This file
└── COAs/
    ├── SW3725J-WZ.pdf                    # COA PDF files
    ├── SW031725-PRE1-SCP.pdf
    └── SW3725J-SP.pdf
```

## Usage

1. **Prepare Data**:
   ```bash
   cd scripts/
   # Ensure CSV file exists
   ls -la notion-product-batches-real.csv
   # Ensure PDF files exist
   ls -la ../COAs/
   ```

2. **Run Import**:
   ```bash
   python notion_batch_importer.py
   ```

3. **Monitor Progress**:
   ```
   🌿 Skyworld Notion Batch Importer
   ========================================
   📊 Loading CSV: ./notion-product-batches-real.csv
      Found 33 batch records
   🔗 Connecting to Notion...
      ✅ Connected to database: Product Batches
   📁 Found 3 PDF files in ./COAs/
   
   🔍 Processing: SW3725J-WZ.pdf
      Batch number: SW3725J-WZ
      ✅ Found metadata for strain: Skyworld Wafflez
      ✅ Uploaded SW3725J-WZ to Notion
   ```

## CSV Column Mapping

The script automatically maps CSV columns to Notion properties:

| CSV Column | Notion Property | Type |
|------------|----------------|------|
| Batch Number | Name (Title) | Title |
| Strain Name | Strain Name | Rich Text |
| Product Type | Product Type | Rich Text |
| THC % | THC % | Number |
| CBD % | CBD % | Number |
| CBG % | CBG % | Number |
| THCV % | THCV % | Number |
| Terp Total % | Terpene Total % | Number |
| Terp 1 Name | Terpene 1 | Rich Text |
| Terp 1 % | Terpene 1 % | Number |
| Notes | Effects | Rich Text |
| Test Date | Season/Date | Rich Text |
| Package Sizes | Package Sizes | Rich Text |

## PDF File Naming

PDF files should be named with the batch number:
- ✅ `SW3725J-WZ.pdf`
- ✅ `SW031725-PRE1-SCP.pdf`
- ✅ `SW3725J-SP.pdf`

Complex filenames are supported:
- ✅ `SW3725J-WZ - SJR Lab - Skyworld Wafflez.pdf` → Batch: `SW3725J-WZ`

## GitHub PDF URLs

PDFs are linked using GitHub raw URLs:
```
https://github.com/therealjohndough/skyworld-wp-theme/raw/main/COAs/SW3725J-WZ.pdf
```

## Error Handling

The script handles common issues:

- **Missing CSV**: Creates template if file not found
- **Missing PDFs**: Creates COAs directory if missing
- **Invalid Notion Token**: Validates connection before import
- **Batch Mismatches**: Logs skipped files with missing metadata
- **API Errors**: Continues processing other files on individual failures

## Troubleshooting

### Common Issues

1. **"Metadata not found"**:
   - Check batch number extraction from PDF filename
   - Verify CSV contains matching 'Batch/Lot #' values
   - Check CSV encoding (should be UTF-8)

2. **"Failed to connect to database"**:
   - Verify NOTION_TOKEN is correct
   - Ensure database is shared with integration
   - Check DATABASE_ID format

3. **"Permission denied"**:
   - Share Notion database with your integration
   - Grant "Insert content" permission

### Debug Mode

For detailed debugging, edit the script:
```python
# Add at the top for verbose logging
import logging
logging.basicConfig(level=logging.DEBUG)
```

## Import Results

After successful import, your Notion database will contain:
- **Product batch records** with all metadata
- **PDF links** pointing to GitHub raw files
- **Searchable properties** for strain name, batch number, etc.
- **Structured data** ready for WordPress integration

## Next Steps

1. **Manual Relations**: Link batches to strain masters in Notion
2. **WordPress Integration**: Export Notion data for WordPress import
3. **COA Viewer**: Use PDF links in WordPress COA viewer
4. **Data Sync**: Set up regular imports for new batches

## Support

For issues or questions:
1. Check the import summary for error details
2. Verify CSV column headers match expected format
3. Ensure PDF files are properly named with batch numbers
4. Test with a small subset of data first