CREATE TABLE IF NOT EXISTS food (
    fdc_id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    data_type VARCHAR(100) NULL,
    description TEXT NULL,
    food_category_id BIGINT UNSIGNED NULL,
    publication_date DATE NULL,
    INDEX idx_food_category_id (food_category_id),
    FULLTEXT INDEX ft_food_description (description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS food_category (
    id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    code VARCHAR(50) NULL,
    description VARCHAR(255) NULL,
    INDEX idx_food_category_description (description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS nutrient (
    id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    name VARCHAR(255) NULL,
    unit_name VARCHAR(50) NULL,
    nutrient_nbr VARCHAR(50) NULL,
    rank_value INT NULL,
    INDEX idx_nutrient_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS measure_unit (
    id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    name VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS food_portion (
    id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    fdc_id BIGINT UNSIGNED NOT NULL,
    seq_num INT NULL,
    amount DECIMAL(12,4) NULL,
    measure_unit_id BIGINT UNSIGNED NULL,
    portion_description VARCHAR(255) NULL,
    modifier VARCHAR(255) NULL,
    gram_weight DECIMAL(12,4) NULL,
    data_points INT NULL,
    footnote TEXT NULL,
    min_year_acquired INT NULL,
    INDEX idx_food_portion_fdc_id (fdc_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
