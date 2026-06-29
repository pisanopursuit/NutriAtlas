<?php

require_once __DIR__ . '/../app/config/database.php';

set_time_limit(0);
ini_set('memory_limit', '512M');

$db = Database::connect('food_core');
$filePath = __DIR__ . '/data/food.csv';

function cleanValue($value)
{
    $value = trim((string)$value);
    return $value === '' ? null : $value;
}

function fixDateValue($value)
{
    $value = cleanValue($value);

    if ($value === null) {
        return null;
    }

    $date = DateTime::createFromFormat('m/d/Y', $value);

    if (!$date) {
        return null;
    }

    return $date->format('Y-m-d');
}

if (!file_exists($filePath)) {
    die("Missing file: " . htmlspecialchars($filePath));
}

$handle = fopen($filePath, 'r');

if (!$handle) {
    die("Could not open food.csv");
}

$header = fgetcsv($handle);

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

echo "<h1>Importing food.csv</h1>";

while (($row = fgetcsv($handle)) !== false) {
    $stmt->execute([
        ':fdc_id'           => cleanValue($row[0] ?? null),
        ':data_type'        => cleanValue($row[1] ?? null),
        ':description'      => cleanValue($row[2] ?? null),
        ':food_category_id' => cleanValue($row[3] ?? null),
        ':publication_date' => fixDateValue($row[4] ?? null),
    ]);

    $count++;

    if ($count % 10000 === 0) {
        echo "Imported {$count} rows...<br>";
        flush();
    }
}

fclose($handle);

echo "<hr>";
echo "<h2>✅ Imported {$count} rows into food.</h2>";