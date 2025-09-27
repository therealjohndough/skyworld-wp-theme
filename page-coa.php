<?php
/**
 * Template Name: COA - Lab Results
 */

get_header();
?>

<div class="coa-container">
    <div class="coa-header">
        <h1>QUALITY CHECK</h1>
        <p>At Skyworld, we believe in complete transparency about our products. Every batch of our New York cannabis flower undergoes comprehensive third-party laboratory testing to ensure quality, potency, and safety.</p>
    </div>

    <div class="coa-search-filter">
        <div class="search-container">
            <input type="text" id="coa-search" placeholder="Search by strain name or batch number..." />
            <button id="coa-search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>
        
        <div class="filter-container">
            <select id="product-type-filter">
                <option value="">All Product Types</option>
                <option value="flower">Flower</option>
                <option value="pre-roll">Pre-Roll</option>
                <option value="concentrate">Concentrate</option>
            </select>
            
            <select id="sort-filter">
                <option value="name">Sort by Name</option>
                <option value="date">Sort by Date</option>
                <option value="thc">Sort by THC %</option>
            </select>
        </div>
    </div>

    <div class="coa-grid" id="coa-grid">
        <!-- COA items will be populated here -->
    </div>

    <div class="coa-loading" id="coa-loading" style="display: none;">
        <div class="loading-spinner"></div>
        <p>Loading lab results...</p>
    </div>
</div>

<!-- COA Detail Modal -->
<div id="coa-modal" class="coa-modal" style="display: none;">
    <div class="coa-modal-content">
        <div class="coa-modal-header">
            <h3 id="modal-strain-name"></h3>
            <button class="coa-modal-close">&times;</button>
        </div>
        <div class="coa-modal-body">
            <div class="coa-details">
                <div class="coa-info-grid">
                    <div class="coa-info-item">
                        <label>Product Type:</label>
                        <span id="modal-product-type"></span>
                    </div>
                    <div class="coa-info-item">
                        <label>Batch Number:</label>
                        <span id="modal-batch-number"></span>
                    </div>
                    <div class="coa-info-item">
                        <label>Test Date:</label>
                        <span id="modal-test-date"></span>
                    </div>
                    <div class="coa-info-item">
                        <label>Lab:</label>
                        <span id="modal-lab-name"></span>
                    </div>
                </div>
                
                <div class="cannabinoid-results">
                    <h4>Cannabinoid Profile</h4>
                    <div class="cannabinoid-grid" id="modal-cannabinoids">
                        <!-- Cannabinoid data will be populated here -->
                    </div>
                </div>
                
                <div class="terpene-results">
                    <h4>Terpene Profile</h4>
                    <div class="terpene-grid" id="modal-terpenes">
                        <!-- Terpene data will be populated here -->
                    </div>
                </div>
                
                <div class="safety-results">
                    <h4>Safety Testing</h4>
                    <div class="safety-grid" id="modal-safety">
                        <!-- Safety test data will be populated here -->
                    </div>
                </div>
            </div>
            
            <div class="coa-actions">
                <a id="modal-download-btn" href="#" target="_blank" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download PDF
                </a>
                <button id="modal-share-btn" class="btn btn-secondary">
                    <i class="fas fa-share"></i> Share COA
                </button>
            </div>
        </div>
    </div>
</div>

<!-- FAQs Section -->
<div class="faqs-section">
    <div class="faqs-container">
        <h2>FAQs</h2>
        
        <div class="faq-item">
            <h3>Is Your Flower Grown Indoors?</h3>
            <p>When we say indoor flower, we mean legitimate indoor flower. This isn't greenhouse tree trying to pass the vibe check. Our growth chambers are meticulously controlled environments where every plant receives the perfect amount of light, nutrients, and care – we are obsessed with the details.</p>
        </div>
        
        <div class="faq-item">
            <h3>What Is A COA?</h3>
            <p>A Certificate of Analysis is a document that confirms a product has been tested by an accredited third-party laboratory and meets quality and safety standards.</p>
        </div>
        
        <div class="faq-item">
            <h3>Why Are COAs Important?</h3>
            <p>COAs ensure our products are safe, consistent, and comply with New York State cannabis regulations. They allow you to verify exactly what's in your cannabis flower.</p>
        </div>
        
        <div class="faq-item">
            <h3>How Do I Find My Batch Number?</h3>
            <p>If you're having trouble locating your product's test results, please contact our customer support at quality@skyworldcannabis.com with your batch number.</p>
        </div>
        
        <div class="faq-item">
            <h3>What Lab Do You Use?</h3>
            <p>All testing is performed by DRS Testing, an ISO-accredited laboratory licensed by the New York State Office of Cannabis Management.</p>
        </div>
    </div>
</div>

<script>
// COA Page JavaScript
(function() {
    'use strict';

    // Sample COA data (replace with actual API data)
    const COA_DATA = [
        {
            id: 1,
            strain: "41 G's",
            productType: "flower",
            batchNumber: "SW3725J-41G",
            testDate: "2025-03-17",
            labName: "DRS Testing",
            pdfUrl: "https://drive.google.com/file/d/1dpDWP8kpdGUbE7VpxV9OwQaAryExMzyX/view",
            cannabinoids: {
                thc: 31.92,
                thca: 35.42,
                cbd: 0.12,
                cbda: 0.08,
                cbg: 0.45,
                cbga: 1.00,
                cbn: 0.15
            },
            terpenes: {
                "β-Caryophyllene": 0.85,
                "β-Myrcene": 0.67,
                "Limonene": 0.54,
                "Linalool": 0.13
            },
            safetyTests: {
                pesticides: "Pass",
                heavyMetals: "Pass",
                microbials: "Pass",
                residualSolvents: "Pass"
            }
        },
        {
            id: 2,
            strain: "Charmz",
            productType: "flower",
            batchNumber: "SW031725-J35-CHZ",
            testDate: "2025-03-15",
            labName: "DRS Testing",
            pdfUrl: "https://drive.google.com/file/d/1X2OWHQnTSg11EYQaVPtIuuGce-dWvwOr/view",
            cannabinoids: {
                thc: 30.78,
                thca: 34.12,
                cbd: 0.08,
                cbda: 0.05,
                cbg: 0.38,
                cbga: 2.00,
                cbn: 0.22
            },
            terpenes: {
                "Limonene": 0.72,
                "β-Caryophyllene": 0.58,
                "β-Myrcene": 0.33
            },
            safetyTests: {
                pesticides: "Pass",
                heavyMetals: "Pass",
                microbials: "Pass",
                residualSolvents: "Pass"
            }
        },
        {
            id: 3,
            strain: "Dirt N Worms",
            productType: "flower",
            batchNumber: "SW031725-J35-DNW",
            testDate: "2025-03-14",
            labName: "DRS Testing",
            pdfUrl: "https://drive.google.com/file/d/1YqwjOCgogKSEDChQR-Z-veIGUWsZWHCX/view",
            cannabinoids: {
                thc: 23.83,
                thca: 26.45,
                cbd: 0.15,
                cbda: 0.12,
                cbg: 0.52,
                cbga: 2.00,
                cbn: 0.18
            },
            terpenes: {
                "Limonene": 0.68,
                "β-Caryophyllene": 0.45,
                "α-Pinene": 0.27
            },
            safetyTests: {
                pesticides: "Pass",
                heavyMetals: "Pass",
                microbials: "Pass",
                residualSolvents: "Pass"
            }
        },
        {
            id: 4,
            strain: "Garlic Gravity",
            productType: "pre-roll",
            batchNumber: "SW040725-PRE05X6-GG",
            testDate: "2025-04-05",
            labName: "DRS Testing",
            pdfUrl: "https://drive.google.com/file/d/10VBpBMIvBx3of14y03qjnXKxV9vhBCIH/view",
            cannabinoids: {
                thc: 28.45,
                thca: 31.67,
                cbd: 0.09,
                cbda: 0.06,
                cbg: 0.41,
                cbga: 1.85,
                cbn: 0.28
            },
            terpenes: {
                "β-Myrcene": 0.89,
                "β-Caryophyllene": 0.71,
                "Limonene": 0.43,
                "Linalool": 0.19
            },
            safetyTests: {
                pesticides: "Pass",
                heavyMetals: "Pass",
                microbials: "Pass",
                residualSolvents: "Pass"
            }
        }
    ];

    class COAManager {
        constructor() {
            this.coaData = COA_DATA;
            this.filteredData = [...this.coaData];
            this.init();
        }

        init() {
            this.bindEvents();
            this.renderCOAGrid();
        }

        bindEvents() {
            // Search functionality
            document.getElementById('coa-search').addEventListener('input', () => this.filterCOAs());
            document.getElementById('coa-search-btn').addEventListener('click', () => this.filterCOAs());
            
            // Filter functionality
            document.getElementById('product-type-filter').addEventListener('change', () => this.filterCOAs());
            document.getElementById('sort-filter').addEventListener('change', () => this.sortCOAs());
            
            // Modal close
            document.querySelector('.coa-modal-close').addEventListener('click', () => this.closeModal());
            document.getElementById('coa-modal').addEventListener('click', (e) => {
                if (e.target.id === 'coa-modal') this.closeModal();
            });
            
            // Share functionality
            document.getElementById('modal-share-btn').addEventListener('click', () => this.shareCOA());
        }

        filterCOAs() {
            const searchTerm = document.getElementById('coa-search').value.toLowerCase().trim();
            const productTypeFilter = document.getElementById('product-type-filter').value;
            
            this.filteredData = this.coaData.filter(coa => {
                const matchesSearch = !searchTerm || 
                    coa.strain.toLowerCase().includes(searchTerm) ||
                    coa.batchNumber.toLowerCase().includes(searchTerm);
                    
                const matchesType = !productTypeFilter || coa.productType === productTypeFilter;
                
                return matchesSearch && matchesType;
            });
            
            this.renderCOAGrid();
        }

        sortCOAs() {
            const sortBy = document.getElementById('sort-filter').value;
            
            this.filteredData.sort((a, b) => {
                switch (sortBy) {
                    case 'name':
                        return a.strain.localeCompare(b.strain);
                    case 'date':
                        return new Date(b.testDate) - new Date(a.testDate);
                    case 'thc':
                        return b.cannabinoids.thc - a.cannabinoids.thc;
                    default:
                        return 0;
                }
            });
            
            this.renderCOAGrid();
        }

        renderCOAGrid() {
            const grid = document.getElementById('coa-grid');
            grid.innerHTML = '';

            if (this.filteredData.length === 0) {
                grid.innerHTML = '<div class="no-results"><p>No lab results found matching your criteria.</p></div>';
                return;
            }

            this.filteredData.forEach(coa => {
                const coaCard = this.createCOACard(coa);
                grid.appendChild(coaCard);
            });
        }

        createCOACard(coa) {
            const card = document.createElement('div');
            card.className = 'coa-card';
            
            const totalTerpenes = Object.values(coa.terpenes).reduce((sum, val) => sum + val, 0);
            const primaryTerpenes = Object.entries(coa.terpenes)
                .sort(([,a], [,b]) => b - a)
                .slice(0, 3)
                .map(([name]) => name)
                .join(', ');

            card.innerHTML = `
                <div class="coa-card-header">
                    <h3>${coa.strain}</h3>
                    <span class="product-type-badge">${coa.productType}</span>
                </div>
                
                <div class="coa-stats">
                    <div class="stat-item">
                        <label>THC</label>
                        <span class="thc-value">${coa.cannabinoids.thc}%</span>
                    </div>
                    <div class="stat-item">
                        <label>Total Terpenes</label>
                        <span>${totalTerpenes.toFixed(2)}%</span>
                    </div>
                </div>
                
                <div class="coa-terpenes">
                    <label>Primary Terpenes:</label>
                    <p>${primaryTerpenes}</p>
                </div>
                
                <div class="coa-batch">
                    <label>Batch:</label>
                    <span>${coa.batchNumber}</span>
                </div>
                
                <div class="coa-date">
                    <label>Test Date:</label>
                    <span>${this.formatDate(coa.testDate)}</span>
                </div>
                
                <div class="coa-actions">
                    <button class="btn btn-outline" onclick="coaManager.showCOADetails(${coa.id})">
                        View Details
                    </button>
                    <a href="${coa.pdfUrl}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-download"></i> View COA
                    </a>
                </div>
            `;

            return card;
        }

        showCOADetails(coaId) {
            const coa = this.coaData.find(c => c.id === coaId);
            if (!coa) return;

            // Populate modal with COA data
            document.getElementById('modal-strain-name').textContent = coa.strain;
            document.getElementById('modal-product-type').textContent = coa.productType.charAt(0).toUpperCase() + coa.productType.slice(1);
            document.getElementById('modal-batch-number').textContent = coa.batchNumber;
            document.getElementById('modal-test-date').textContent = this.formatDate(coa.testDate);
            document.getElementById('modal-lab-name').textContent = coa.labName;
            
            // Populate cannabinoids
            const cannabinoidGrid = document.getElementById('modal-cannabinoids');
            cannabinoidGrid.innerHTML = '';
            Object.entries(coa.cannabinoids).forEach(([name, value]) => {
                const item = document.createElement('div');
                item.className = 'result-item';
                item.innerHTML = `
                    <span class="result-name">${name.toUpperCase()}</span>
                    <span class="result-value">${value}%</span>
                `;
                cannabinoidGrid.appendChild(item);
            });
            
            // Populate terpenes
            const terpeneGrid = document.getElementById('modal-terpenes');
            terpeneGrid.innerHTML = '';
            Object.entries(coa.terpenes).forEach(([name, value]) => {
                const item = document.createElement('div');
                item.className = 'result-item';
                item.innerHTML = `
                    <span class="result-name">${name}</span>
                    <span class="result-value">${value}%</span>
                `;
                terpeneGrid.appendChild(item);
            });
            
            // Populate safety tests
            const safetyGrid = document.getElementById('modal-safety');
            safetyGrid.innerHTML = '';
            Object.entries(coa.safetyTests).forEach(([test, result]) => {
                const item = document.createElement('div');
                item.className = 'result-item';
                item.innerHTML = `
                    <span class="result-name">${this.formatTestName(test)}</span>
                    <span class="result-value pass">${result}</span>
                `;
                safetyGrid.appendChild(item);
            });
            
            // Set download link
            document.getElementById('modal-download-btn').href = coa.pdfUrl;
            
            // Store current COA for sharing
            this.currentCOA = coa;
            
            // Show modal
            document.getElementById('coa-modal').style.display = 'flex';
        }

        closeModal() {
            document.getElementById('coa-modal').style.display = 'none';
        }

        shareCOA() {
            if (!this.currentCOA) return;
            
            const shareText = `Check out the lab results for ${this.currentCOA.strain} by Skyworld Cannabis - THC: ${this.currentCOA.cannabinoids.thc}%`;
            const shareUrl = window.location.href;
            
            if (navigator.share) {
                navigator.share({
                    title: `${this.currentCOA.strain} - Lab Results`,
                    text: shareText,
                    url: shareUrl
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(`${shareText} - ${shareUrl}`).then(() => {
                    alert('COA link copied to clipboard!');
                }).catch(() => {
                    // Final fallback: show share URL
                    prompt('Copy this link to share:', shareUrl);
                });
            }
        }

        formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }

        formatTestName(testName) {
            return testName.replace(/([A-Z])/g, ' $1').replace(/^./, str => str.toUpperCase());
        }
    }

    // Initialize COA manager when page loads
    let coaManager;
    document.addEventListener('DOMContentLoaded', function() {
        coaManager = new COAManager();
        window.coaManager = coaManager; // Make globally accessible
    });

})();
</script>

<?php get_footer(); ?>