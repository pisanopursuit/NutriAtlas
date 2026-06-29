<?php

require_once __DIR__ . '/../app/config/database.php';

$databases = [
    'food_core',
    'food_branded',
    'food_nutrients_1',
    'food_nutrients_2',
    'food_search',
    'food_app'
];

echo '<h1>NutriAtlas Database Test</h1>';

foreach ($databases as $db) {
    try {
        $conn = Database::connect($db);
        echo '<p style="color:green;">✅ Connected to ' . htmlspecialchars($db) . '</p>';
    } catch (Exception $e) {
        echo '<p style="color:red;">❌ Failed: ' . htmlspecialchars($db) . '</p>';
        echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    }
}