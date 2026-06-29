<?php

require_once __DIR__ . '/../app/config/database.php';

set_time_limit(0);
ini_set('memory_limit', '512M');

$db = Database::connect('food_core');
$filePath = __DIR__ . '/data/food.csv';

function cleanValue($value) {
    $value = trim((string)$value);
    return $value === '' ? null : $value;
}

function fixDateValue($value) {
    $value = cleanValue($value);
    if ($value === null) return null;

    $date = DateTime::createFromFormat('m/d/Y', $value);
    if ($date) return $date->format('Y-m-d');

    $date = DateTime::createFromFormat('Y-m-d', $value);
    if ($date) return $date->format('Y-m-d');

    return null;
}

if (!file_exists($filePath)) {
    die("Missing food.csv");
}

$handle = fopen($filePath, 'r');
if (!$handle) {
    die("Could not open food.csv");
}

$header = fgetcsv($handle);
$headerMap = [];

foreach ($header as $index => $columnName) {
    $headerMap[trim($columnName)] = $index;
}

echo "<h1>Smart Import: food.csv</h1>";
echo "<pre>";
print_r($headerMap);
echo "</pre>";

$db->exec("ALTER TABLE food MODIFY food_category_id VARCHAR(255) NULL");
$db->exec("TRUNCATE TABLE food");

$stmt = $db->prepare("
    REPLACE INTO food (
        fdc_id,
        data_type,
        description,
        food_category_id,
        publication_date
    ) VALUES (
        :fdc_id,
        :data_type,
        :description,
        :food_category_id,
        :publication_date
    )
");

$count = 0;

while (($row = fgetcsv($handle)) !== false) {
    $stmt->execute([
        ':fdc_id'           => cleanValue($row[$headerMap['fdc_id']] ?? null),
        ':data_type'        => cleanValue($row[$headerMap['data_type']] ?? null),
        ':description'      => cleanValue($row[$headerMap['description']] ?? null),
        ':food_category_id' => cleanValue($row[$headerMap['food_category_id']] ?? null),
        ':publication_date' => fixDateValue($row[$headerMap['publication_date']] ?? null),
    ]);

    $count++;

    if ($count % 10000 === 0) {
        echo "Imported {$count} rows...<br>";
        flush();
    }
}

fclose($handle);

echo "<hr>";
echo "<h2>✅ Smart import complete. Imported {$count} rows into food.</h2>";