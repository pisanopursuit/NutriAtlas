<?php

require_once __DIR__ . '/../app/config/database.php';

try {

    $db = Database::connect('food_core');

    // -------------------------------------------------------
    // FOOD TABLE
    // -------------------------------------------------------

    $db->exec("
        CREATE TABLE IF NOT EXISTS food (
            fdc_id BIGINT PRIMARY KEY,
            data_type VARCHAR(50),
            description VARCHAR(500),
            food_category_id VARCHAR(255) NULL,
            publication_date DATE NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    echo "✅ food table created.<br>";

    // -------------------------------------------------------
    // FOOD CATEGORY TABLE
    // -------------------------------------------------------

    $db->exec("
        CREATE TABLE IF NOT EXISTS food_category (
            id BIGINT PRIMARY KEY,
            description VARCHAR(255)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    echo "✅ food_category table created.<br>";

    // -------------------------------------------------------
    // MEASURE UNIT TABLE
    // -------------------------------------------------------

    $db->exec("
        CREATE TABLE IF NOT EXISTS measure_unit (
            id BIGINT PRIMARY KEY,
            name VARCHAR(100)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    echo "✅ measure_unit table created.<br>";

    // -------------------------------------------------------
    // FOOD PORTION TABLE
    // -------------------------------------------------------

    $db->exec("
        CREATE TABLE IF NOT EXISTS food_portion (
            id BIGINT PRIMARY KEY,
            fdc_id BIGINT,
            sequence_number INT,
            amount DECIMAL(10,4),
            measure_unit_id BIGINT,
            modifier VARCHAR(255),
            gram_weight DECIMAL(10,4)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    echo "✅ food_portion table created.<br>";

    // -------------------------------------------------------
    // NUTRIENT TABLE
    // -------------------------------------------------------

    $db->exec("
        CREATE TABLE IF NOT EXISTS nutrient (
            id BIGINT PRIMARY KEY,
            name VARCHAR(255),
            unit_name VARCHAR(50),
            nutrient_number VARCHAR(20),
            sort_order INT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    echo "✅ nutrient table created.<br>";

    echo "<hr>";
    echo "<h2>🎉 food_core database initialized successfully.</h2>";

} catch (PDOException $e) {

    die("Database Error: " . $e->getMessage());

} catch (Exception $e) {

    die("Error: " . $e->getMessage());

}