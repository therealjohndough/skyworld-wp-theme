<?php
/**
 * Archive template for Strain Library
 * This is the main hub for exploring cannabis genetics
 */

get_header();
?>

<div class="strain-library-container">
    <!-- Hero Section -->
    <div class="strain-library-hero">
        <div class="hero-content">
            <h1 class="hero-title">STRAIN LIBRARY</h1>
            <p class="hero-subtitle">Explore the genetic diversity of premium cannabis. Discover the science, artistry, and passion behind each strain in our carefully curated collection.</p>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number" id="total-strains"><?php echo wp_count_posts('strain')->publish; ?></span>
                <span class="stat-label">Unique Strains</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo get_terms('terpene', array('hide_empty' => true, 'fields' => 'count')); ?></span>
                <span class="stat-label">Terpene Profiles</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo get_terms('effects', array('hide_empty' => true, 'fields' => 'count')); ?></span>
                <span class="stat-label">Effect Categories</span>
            </div>
        </div>
    </div>

    <!-- Interactive Controls -->
    <div class="strain-controls">
        <!-- Search Bar -->
        <div class="strain-search">
            <input type="text" id="strain-search-input" placeholder="Search strains by name, effects, or terpenes..." />
            <button id="strain-search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <!-- Filter Toggles -->
        <div class="filter-toggles">
            <button class="filter-toggle active" data-view="grid">
                <i class="fas fa-th"></i> Grid View
            </button>
            <button class="filter-toggle" data-view="list">
                <i class="fas fa-list"></i> List View
            </button>
            <button class="filter-toggle" data-view="family">
                <i class="fas fa-project-diagram"></i> Family Tree
            </button>
        </div>

        <!-- Advanced Filters -->
        <div class="advanced-filters">
            <button class="filters-toggle" id="toggle-filters">
                <i class="fas fa-sliders-h"></i> Filters
                <span class="filter-count" id="active-filter-count">0</span>
            </button>
        </div>
    </div>

    <!-- Filter Panel (Hidden by default) -->
    <div class="filter-panel" id="filter-panel">
        <div class="filter-grid">
            <!-- Strain Type Filter -->
            <div class="filter-group">
                <h4>Strain Type</h4>
                <div class="filter-options">
                    <?php
                    $strain_types = get_terms('strain_type', array('hide_empty' => true));
                    foreach ($strain_types as $type) {
                        echo '<label class="filter-checkbox">';
                        echo '<input type="checkbox" name="strain_type" value="' . $type->slug . '" />';
                        echo '<span>' . $type->name . '</span>';
                        echo '<small>(' . $type->count . ')</small>';
                        echo '</label>';
                    }
                    ?>
                </div>
            </div>

            <!-- Effects Filter -->
            <div class="filter-group">
                <h4>Primary Effects</h4>
                <div class="filter-options">
                    <?php
                    $effects = get_terms('effects', array('hide_empty' => true, 'parent' => 0, 'number' => 8));
                    foreach ($effects as $effect) {
                        echo '<label class="filter-checkbox">';
                        echo '<input type="checkbox" name="effects" value="' . $effect->slug . '" />';
                        echo '<span>' . $effect->name . '</span>';
                        echo '<small>(' . $effect->count . ')</small>';
                        echo '</label>';
                    }
                    ?>
                </div>
            </div>

            <!-- Terpenes Filter -->
            <div class="filter-group">
                <h4>Dominant Terpenes</h4>
                <div class="filter-options">
                    <?php
                    $terpenes = get_terms('terpene', array('hide_empty' => true, 'number' => 8));
                    foreach ($terpenes as $terpene) {
                        echo '<label class="filter-checkbox">';
                        echo '<input type="checkbox" name="terpene" value="' . $terpene->slug . '" />';
                        echo '<span>' . $terpene->name . '</span>';
                        echo '<small>(' . $terpene->count . ')</small>';
                        echo '</label>';
                    }
                    ?>
                </div>
            </div>

            <!-- THC Range -->
            <div class="filter-group">
                <h4>THC Range</h4>
                <div class="range-filter">
                    <input type="range" id="thc-min" min="0" max="40" value="0" />
                    <input type="range" id="thc-max" min="0" max="40" value="40" />
                    <div class="range-display">
                        <span id="thc-range-display">0% - 40%</span>
                    </div>
                </div>
            </div>

            <!-- Flowering Time -->
            <div class="filter-group">
                <h4>Flowering Time (weeks)</h4>
                <div class="range-filter">
                    <input type="range" id="flowering-min" min="6" max="16" value="6" />
                    <input type="range" id="flowering-max" min="6" max="16" value="16" />
                    <div class="range-display">
                        <span id="flowering-range-display">6 - 16 weeks</span>
                    </div>
                </div>
            </div>

            <!-- Growing Difficulty -->
            <div class="filter-group">
                <h4>Growing Difficulty</h4>
                <div class="filter-options">
                    <?php
                    $difficulties = get_terms('growing_difficulty', array('hide_empty' => true));
                    foreach ($difficulties as $difficulty) {
                        echo '<label class="filter-checkbox">';
                        echo '<input type="checkbox" name="growing_difficulty" value="' . $difficulty->slug . '" />';
                        echo '<span>' . $difficulty->name . '</span>';
                        echo '<small>(' . $difficulty->count . ')</small>';
                        echo '</label>';
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="filter-actions">
            <button id="apply-filters" class="btn btn-primary">Apply Filters</button>
            <button id="clear-filters" class="btn btn-outline">Clear All</button>
        </div>
    </div>

    <!-- Sort Options -->
    <div class="sort-options">
        <label for="sort-strains">Sort by:</label>
        <select id="sort-strains">
            <option value="name">Strain Name (A-Z)</option>
            <option value="name-desc">Strain Name (Z-A)</option>
            <option value="thc-high">THC % (High to Low)</option>
            <option value="thc-low">THC % (Low to High)</option>
            <option value="popularity">Most Popular</option>
            <option value="newest">Recently Added</option>
        </select>
    </div>

    <!-- Results Container -->
    <div class="strain-results">
        <div class="results-meta">
            <span id="results-count">Loading strains...</span>
            <div class="view-options">
                <button class="compare-btn" id="compare-strains" disabled>
                    <i class="fas fa-balance-scale"></i> Compare Selected
                </button>
            </div>
        </div>

        <!-- Strain Grid -->
        <div class="strain-grid" id="strain-grid">
            <!-- Strains will be populated via AJAX -->
        </div>

        <!-- Loading State -->
        <div class="loading-state" id="loading-state">
            <div class="loading-spinner"></div>
            <p>Loading strain library...</p>
        </div>

        <!-- No Results -->
        <div class="no-results" id="no-results" style="display: none;">
            <div class="no-results-icon">
                <i class="fas fa-search-minus"></i>
            </div>
            <h3>No strains found</h3>
            <p>Try adjusting your filters or search terms to find what you're looking for.</p>
            <button class="btn btn-primary" onclick="clearAllFilters()">Clear Filters</button>
        </div>
    </div>

    <!-- Pagination -->
    <div class="strain-pagination" id="strain-pagination">
        <!-- Pagination will be populated via JavaScript -->
    </div>
</div>

<!-- Strain Comparison Modal -->
<div class="strain-compare-modal" id="strain-compare-modal" style="display: none;">
    <div class="compare-modal-content">
        <div class="compare-modal-header">
            <h3>Strain Comparison</h3>
            <button class="compare-modal-close">&times;</button>
        </div>
        <div class="compare-modal-body" id="compare-modal-body">
            <!-- Comparison content will be populated via JavaScript -->
        </div>
    </div>
</div>

<!-- Education Sidebar -->
<div class="education-sidebar" id="education-sidebar">
    <button class="education-toggle" id="education-toggle">
        <i class="fas fa-graduation-cap"></i>
        <span>Learn</span>
    </button>
    
    <div class="education-content">
        <h4>Cannabis Education</h4>
        
        <div class="education-section">
            <h5>Understanding Terpenes</h5>
            <p>Terpenes are aromatic compounds that influence flavor, aroma, and effects. Learn how different terpenes create unique experiences.</p>
            <a href="#" class="education-link">Read More →</a>
        </div>
        
        <div class="education-section">
            <h5>Indica vs Sativa</h5>
            <p>Discover the differences between indica and sativa strains, and how hybrids combine the best of both worlds.</p>
            <a href="#" class="education-link">Read More →</a>
        </div>
        
        <div class="education-section">
            <h5>Growing Basics</h5>
            <p>Interested in cultivation? Learn about growing conditions, flowering times, and difficulty levels.</p>
            <a href="#" class="education-link">Read More →</a>
        </div>
    </div>
</div>

<script>
// Strain Library JavaScript
(function() {
    'use strict';

    class StrainLibrary {
        constructor() {
            this.strains = [];
            this.filteredStrains = [];
            this.currentPage = 1;
            this.strainsPerPage = 12;
            this.activeFilters = {};
            this.selectedStrains = new Set();
            this.currentView = 'grid';
            
            this.init();
        }

        init() {
            this.bindEvents();
            this.loadStrains();
        }

        bindEvents() {
            // Search functionality
            document.getElementById('strain-search-btn').addEventListener('click', () => this.searchStrains());
            document.getElementById('strain-search-input').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.searchStrains();
            });

            // Filter toggles
            document.getElementById('toggle-filters').addEventListener('click', () => this.toggleFilterPanel());
            document.getElementById('apply-filters').addEventListener('click', () => this.applyFilters());
            document.getElementById('clear-filters').addEventListener('click', () => this.clearAllFilters());

            // View toggles
            document.querySelectorAll('.filter-toggle').forEach(btn => {
                btn.addEventListener('click', (e) => this.changeView(e.target.dataset.view));
            });

            // Sort functionality
            document.getElementById('sort-strains').addEventListener('change', (e) => this.sortStrains(e.target.value));

            // Range sliders
            this.setupRangeSliders();

            // Compare functionality
            document.getElementById('compare-strains').addEventListener('click', () => this.openComparisonModal());

            // Education sidebar
            document.getElementById('education-toggle').addEventListener('click', () => this.toggleEducationSidebar());

            // Modal close
            document.querySelector('.compare-modal-close').addEventListener('click', () => this.closeComparisonModal());
        }

        async loadStrains() {
            try {
                this.showLoading();
                
                // In production, this would be an AJAX call to a WordPress REST endpoint
                // For now, we'll simulate the data structure
                const response = await fetch('/wp-json/skyworld/v1/strains');
                this.strains = await response.json();
                
                this.filteredStrains = [...this.strains];
                this.renderStrains();
                this.updateResultsCount();
                this.hideLoading();
            } catch (error) {
                console.error('Error loading strains:', error);
                this.hideLoading();
                this.showNoResults();
            }
        }

        searchStrains() {
            const query = document.getElementById('strain-search-input').value.toLowerCase().trim();
            
            if (!query) {
                this.filteredStrains = [...this.strains];
            } else {
                this.filteredStrains = this.strains.filter(strain => 
                    strain.name.toLowerCase().includes(query) ||
                    strain.description.toLowerCase().includes(query) ||
                    strain.effects.some(effect => effect.toLowerCase().includes(query)) ||
                    strain.terpenes.some(terpene => terpene.toLowerCase().includes(query))
                );
            }
            
            this.currentPage = 1;
            this.renderStrains();
            this.updateResultsCount();
        }

        toggleFilterPanel() {
            const panel = document.getElementById('filter-panel');
            panel.classList.toggle('active');
        }

        applyFilters() {
            // Apply all active filters
            this.filteredStrains = this.strains.filter(strain => {
                return this.passesAllFilters(strain);
            });
            
            this.currentPage = 1;
            this.renderStrains();
            this.updateResultsCount();
            this.toggleFilterPanel(); // Close filter panel
            this.updateActiveFilterCount();
        }

        passesAllFilters(strain) {
            // Implement filter logic based on activeFilters
            // This would check strain_type, effects, terpenes, THC range, etc.
            return true; // Simplified for now
        }

        clearAllFilters() {
            // Reset all filter inputs
            document.querySelectorAll('.filter-panel input').forEach(input => {
                if (input.type === 'checkbox') {
                    input.checked = false;
                } else if (input.type === 'range') {
                    input.value = input.getAttribute('min') || input.getAttribute('max');
                }
            });
            
            this.activeFilters = {};
            this.filteredStrains = [...this.strains];
            this.currentPage = 1;
            this.renderStrains();
            this.updateResultsCount();
            this.updateActiveFilterCount();
        }

        changeView(view) {
            this.currentView = view;
            
            // Update active toggle
            document.querySelectorAll('.filter-toggle').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`[data-view="${view}"]`).classList.add('active');
            
            // Update grid layout
            const grid = document.getElementById('strain-grid');
            grid.className = `strain-grid strain-${view}`;
            
            this.renderStrains();
        }

        sortStrains(sortBy) {
            switch (sortBy) {
                case 'name':
                    this.filteredStrains.sort((a, b) => a.name.localeCompare(b.name));
                    break;
                case 'name-desc':
                    this.filteredStrains.sort((a, b) => b.name.localeCompare(a.name));
                    break;
                case 'thc-high':
                    this.filteredStrains.sort((a, b) => b.thc_percentage - a.thc_percentage);
                    break;
                case 'thc-low':
                    this.filteredStrains.sort((a, b) => a.thc_percentage - b.thc_percentage);
                    break;
                case 'newest':
                    this.filteredStrains.sort((a, b) => new Date(b.date_added) - new Date(a.date_added));
                    break;
            }
            
            this.renderStrains();
        }

        renderStrains() {
            const grid = document.getElementById('strain-grid');
            const startIndex = (this.currentPage - 1) * this.strainsPerPage;
            const endIndex = startIndex + this.strainsPerPage;
            const pageStrains = this.filteredStrains.slice(startIndex, endIndex);

            if (pageStrains.length === 0) {
                this.showNoResults();
                return;
            }

            let html = '';
            pageStrains.forEach(strain => {
                html += this.createStrainCard(strain);
            });

            grid.innerHTML = html;
            this.bindStrainCardEvents();
            this.renderPagination();
        }

        createStrainCard(strain) {
            const isSelected = this.selectedStrains.has(strain.id);
            
            return `
                <div class="strain-card ${isSelected ? 'selected' : ''}" data-strain-id="${strain.id}">
                    <div class="strain-card-header">
                        <div class="strain-image">
                            <img src="${strain.featured_image || '/wp-content/uploads/placeholder-strain.jpg'}" alt="${strain.name} cannabis flower" />
                            <div class="image-overlay">
                                <span class="image-type-badge">Cannabis Flower</span>
                            </div>
                            <div class="strain-type-badge ${strain.strain_type.toLowerCase()}">${strain.strain_type}</div>
                        </div>
                        <div class="compare-checkbox">
                            <input type="checkbox" ${isSelected ? 'checked' : ''} />
                        </div>
                    </div>
                    
                    <div class="strain-card-content">
                        <h3 class="strain-name">${strain.name}</h3>
                        <p class="strain-genetics">${strain.genetics || 'Unknown genetics'}</p>
                        
                        <div class="strain-stats">
                            <div class="stat">
                                <label>THC</label>
                                <span class="thc-value">${strain.thc_percentage}%</span>
                            </div>
                            <div class="stat">
                                <label>CBD</label>
                                <span>${strain.cbd_percentage || '< 1'}%</span>
                            </div>
                            <div class="stat">
                                <label>Flowering</label>
                                <span>${strain.flowering_time || 'N/A'} weeks</span>
                            </div>
                        </div>
                        
                        <div class="strain-terpenes">
                            <label>Primary Terpenes:</label>
                            <div class="terpene-tags">
                                ${strain.terpenes.slice(0, 3).map(terpene => 
                                    `<span class="terpene-tag">${terpene}</span>`
                                ).join('')}
                            </div>
                        </div>
                        
                        <div class="strain-effects">
                            <label>Effects:</label>
                            <div class="effect-tags">
                                ${strain.effects.slice(0, 3).map(effect => 
                                    `<span class="effect-tag">${effect}</span>`
                                ).join('')}
                            </div>
                        </div>
                    </div>
                    
                    <div class="strain-card-footer">
                        <button class="btn btn-outline strain-details-btn">
                            View Details
                        </button>
                        <button class="btn btn-primary strain-products-btn">
                            View Products
                        </button>
                    </div>
                </div>
            `;
        }

        bindStrainCardEvents() {
            // Bind events to newly rendered strain cards
            document.querySelectorAll('.strain-card').forEach(card => {
                const strainId = card.dataset.strainId;
                
                // Compare checkbox
                const checkbox = card.querySelector('.compare-checkbox input');
                checkbox.addEventListener('change', (e) => {
                    if (e.target.checked) {
                        this.selectedStrains.add(strainId);
                        card.classList.add('selected');
                    } else {
                        this.selectedStrains.delete(strainId);
                        card.classList.remove('selected');
                    }
                    this.updateCompareButton();
                });

                // Details button
                card.querySelector('.strain-details-btn').addEventListener('click', () => {
                    window.location.href = `/strains/${this.getStrainSlug(strainId)}/`;
                });

                // Products button
                card.querySelector('.strain-products-btn').addEventListener('click', () => {
                    window.location.href = `/products/?strain=${strainId}`;
                });
            });
        }

        updateCompareButton() {
            const compareBtn = document.getElementById('compare-strains');
            const count = this.selectedStrains.size;
            
            if (count >= 2) {
                compareBtn.disabled = false;
                compareBtn.innerHTML = `<i class="fas fa-balance-scale"></i> Compare ${count} Strains`;
            } else {
                compareBtn.disabled = true;
                compareBtn.innerHTML = '<i class="fas fa-balance-scale"></i> Compare Selected';
            }
        }

        openComparisonModal() {
            if (this.selectedStrains.size < 2) return;
            
            // Populate comparison modal
            const modal = document.getElementById('strain-compare-modal');
            const modalBody = document.getElementById('compare-modal-body');
            
            // Create comparison table
            const selectedStrainData = Array.from(this.selectedStrains).map(id => 
                this.strains.find(strain => strain.id === id)
            );
            
            modalBody.innerHTML = this.createComparisonTable(selectedStrainData);
            modal.style.display = 'flex';
        }

        closeComparisonModal() {
            document.getElementById('strain-compare-modal').style.display = 'none';
        }

        createComparisonTable(strains) {
            // Create detailed comparison table
            return `
                <div class="comparison-table">
                    <div class="comparison-header">
                        ${strains.map(strain => `
                            <div class="comparison-strain">
                                <img src="${strain.featured_image}" alt="${strain.name}" />
                                <h4>${strain.name}</h4>
                                <span class="strain-type">${strain.strain_type}</span>
                            </div>
                        `).join('')}
                    </div>
                    
                    <div class="comparison-rows">
                        <div class="comparison-row">
                            <div class="comparison-label">THC %</div>
                            ${strains.map(strain => `<div class="comparison-value">${strain.thc_percentage}%</div>`).join('')}
                        </div>
                        <div class="comparison-row">
                            <div class="comparison-label">CBD %</div>
                            ${strains.map(strain => `<div class="comparison-value">${strain.cbd_percentage || '< 1'}%</div>`).join('')}
                        </div>
                        <div class="comparison-row">
                            <div class="comparison-label">Flowering Time</div>
                            ${strains.map(strain => `<div class="comparison-value">${strain.flowering_time || 'N/A'} weeks</div>`).join('')}
                        </div>
                        <!-- Add more comparison rows as needed -->
                    </div>
                </div>
            `;
        }

        setupRangeSliders() {
            // THC Range sliders
            const thcMin = document.getElementById('thc-min');
            const thcMax = document.getElementById('thc-max');
            const thcDisplay = document.getElementById('thc-range-display');

            [thcMin, thcMax].forEach(slider => {
                slider.addEventListener('input', () => {
                    const minVal = parseInt(thcMin.value);
                    const maxVal = parseInt(thcMax.value);
                    
                    if (minVal >= maxVal) {
                        if (slider === thcMin) {
                            thcMax.value = minVal + 1;
                        } else {
                            thcMin.value = maxVal - 1;
                        }
                    }
                    
                    thcDisplay.textContent = `${thcMin.value}% - ${thcMax.value}%`;
                });
            });

            // Flowering time sliders
            const flowerMin = document.getElementById('flowering-min');
            const flowerMax = document.getElementById('flowering-max');
            const flowerDisplay = document.getElementById('flowering-range-display');

            [flowerMin, flowerMax].forEach(slider => {
                slider.addEventListener('input', () => {
                    const minVal = parseInt(flowerMin.value);
                    const maxVal = parseInt(flowerMax.value);
                    
                    if (minVal >= maxVal) {
                        if (slider === flowerMin) {
                            flowerMax.value = minVal + 1;
                        } else {
                            flowerMin.value = maxVal - 1;
                        }
                    }
                    
                    flowerDisplay.textContent = `${flowerMin.value} - ${flowerMax.value} weeks`;
                });
            });
        }

        toggleEducationSidebar() {
            const sidebar = document.getElementById('education-sidebar');
            sidebar.classList.toggle('active');
        }

        updateResultsCount() {
            const count = this.filteredStrains.length;
            const total = this.strains.length;
            document.getElementById('results-count').textContent = 
                `Showing ${count} of ${total} strains`;
        }

        updateActiveFilterCount() {
            const count = Object.keys(this.activeFilters).length;
            const countElement = document.getElementById('active-filter-count');
            countElement.textContent = count;
            countElement.style.display = count > 0 ? 'inline' : 'none';
        }

        showLoading() {
            document.getElementById('loading-state').style.display = 'block';
            document.getElementById('strain-grid').style.display = 'none';
            document.getElementById('no-results').style.display = 'none';
        }

        hideLoading() {
            document.getElementById('loading-state').style.display = 'none';
            document.getElementById('strain-grid').style.display = 'grid';
        }

        showNoResults() {
            document.getElementById('no-results').style.display = 'block';
            document.getElementById('strain-grid').style.display = 'none';
        }

        renderPagination() {
            const totalPages = Math.ceil(this.filteredStrains.length / this.strainsPerPage);
            const pagination = document.getElementById('strain-pagination');
            
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }

            let html = '<div class="pagination-controls">';
            
            // Previous button
            if (this.currentPage > 1) {
                html += `<button class="page-btn" onclick="strainLibrary.changePage(${this.currentPage - 1})">← Previous</button>`;
            }
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === this.currentPage) {
                    html += `<span class="page-current">${i}</span>`;
                } else {
                    html += `<button class="page-btn" onclick="strainLibrary.changePage(${i})">${i}</button>`;
                }
            }
            
            // Next button
            if (this.currentPage < totalPages) {
                html += `<button class="page-btn" onclick="strainLibrary.changePage(${this.currentPage + 1})">Next →</button>`;
            }
            
            html += '</div>';
            pagination.innerHTML = html;
        }

        changePage(page) {
            this.currentPage = page;
            this.renderStrains();
            
            // Scroll to top of results
            document.querySelector('.strain-results').scrollIntoView({ 
                behavior: 'smooth' 
            });
        }

        getStrainSlug(strainId) {
            const strain = this.strains.find(s => s.id === strainId);
            return strain ? strain.slug : strainId;
        }
    }

    // Initialize strain library when page loads
    let strainLibrary;
    document.addEventListener('DOMContentLoaded', function() {
        strainLibrary = new StrainLibrary();
        window.strainLibrary = strainLibrary; // Make globally accessible
    });

})();
</script>

<?php get_footer(); ?>