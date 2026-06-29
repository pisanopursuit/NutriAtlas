<?php

require_once __DIR__ . '/../app/config/database.php';

set_time_limit(0);
ini_set('memory_limit', '512M');

$db = Database::connect('food_core');
$dataPath = __DIR__ . '/data/';

function cleanValue($value)
{
    $value = trim($value);

    if ($value === '') {
        return null;
    }

    return $value;
}

function importCsv($db, $filePath, $tableName, $columns, $label)
{
    if (!file_exists($filePath)) {
        echo "❌ Missing file: " . htmlspecialchars($filePath) . "<br>";
        return;
    }

    $handle = fopen($filePath, 'r');

    if (!$handle) {
        echo "❌ Could not open: " . htmlspecialchars($filePath) . "<br>";
        return;
    }

    $header = fgetcsv($handle);

    $placeholders = implode(',', array_fill(0, count($columns), '?'));
    $columnList = implode(',', $columns);

    $sql = "REPLACE INTO {$tableName} ({$columnList}) VALUES ({$placeholders})";
    $stmt = $db->prepare($sql);

    $count = 0;

    while (($row = fgetcsv($handle)) !== false) {
        $values = [];

        foreach ($columns as $index => $column) {
            $values[] = cleanValue($row[$index] ?? null);
        }

        $stmt->execute($values);
        $count++;
    }

    fclose($handle);

    echo "✅ Imported {$count} rows into {$label}.<br>";
}

echo "<h1>NutriAtlas Core Import</h1>";

importCsv(
    $db,
    $dataPath . 'food_category.csv',
    'food_category',
    ['id', 'description'],
    'food_category'
);

importCsv(
    $db,
    $dataPath . 'measure_unit.csv',
    'measure_unit',
    ['id', 'name'],
    'measure_unit'
);

importCsv(
    $db,
    $dataPath . 'nutrient.csv',
    'nutrient',
    ['id', 'name', 'unit_name', 'nutrient_number', 'sort_order'],
    'nutrient'
);

echo "<hr>";
echo "<h2>Core lookup import complete.</h2>";