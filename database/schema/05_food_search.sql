CREATE TABLE IF NOT EXISTS food_search_index (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fdc_id BIGINT UNSIGNED NOT NULL,
    food_name TEXT NULL,
    brand_owner VARCHAR(255) NULL,
    brand_name VARCHAR(255) NULL,
    gtin_upc VARCHAR(50) NULL,
    category VARCHAR(255) NULL,
    data_type VARCHAR(100) NULL,
    source_database VARCHAR(100) NOT NULL DEFAULT 'food_core',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_fdc_id (fdc_id),
    INDEX idx_gtin_upc (gtin_upc),
    INDEX idx_brand_owner (brand_owner),
    INDEX idx_brand_name (brand_name),
    FULLTEXT INDEX ft_food_search (food_name, brand_owner, brand_name, category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
