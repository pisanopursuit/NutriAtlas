CREATE TABLE IF NOT EXISTS food_nutrient (
    id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    fdc_id BIGINT UNSIGNED NOT NULL,
    nutrient_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(18,6) NULL,
    data_points INT NULL,
    derivation_id BIGINT UNSIGNED NULL,
    min DECIMAL(18,6) NULL,
    max DECIMAL(18,6) NULL,
    median DECIMAL(18,6) NULL,
    footnote TEXT NULL,
    min_year_acquired INT NULL,
    INDEX idx_fdc_id (fdc_id),
    INDEX idx_nutrient_id (nutrient_id),
    INDEX idx_fdc_nutrient (fdc_id, nutrient_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
