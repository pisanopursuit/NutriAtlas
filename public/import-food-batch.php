<?php

require_once __DIR__ . '/../app/config/database.php';

set_time_limit(0);
ini_set('memory_limit', '512M');

$db = Database::connect('food_core');
$filePath = __DIR__ . '/data/food.csv';

$batchSize = 50000;
$start = isset($_GET['start']) ? (int) $_GET['start'] : 0;

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

if ($start === 0) {
    $db->exec("ALTER TABLE food MODIFY food_category_id VARCHAR(255) NULL");
    $db->exec("TRUNCATE TABLE food");
}

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

$currentRow = 0;
$importedThisRun = 0;

while (($row = fgetcsv($handle)) !== false) {

    if ($currentRow < $start) {
        $currentRow++;
        continue;
    }

    if ($importedThisRun >= $batchSize) {
        break;
    }

    $stmt->execute([
        ':fdc_id'           => cleanValue($row[$headerMap['fdc_id']] ?? null),
        ':data_type'        => cleanValue($row[$headerMap['data_type']] ?? null),
        ':description'      => cleanValue($row[$headerMap['description']] ?? null),
        ':food_category_id' => cleanValue($row[$headerMap['food_category_id']] ?? null),
        ':publication_date' => fixDateValue($row[$headerMap['publication_date']] ?? null),
    ]);

    $currentRow++;
    $importedThisRun++;
}

fclose($handle);

$nextStart = $start + $importedThisRun;

echo "<h1>NutriAtlas Batch Import: food.csv</h1>";
echo "<p>Started at row: <strong>" . number_format($start) . "</strong></p>";
echo "<p>Imported this run: <strong>" . number_format($importedThisRun) . "</strong></p>";
echo "<p>Next start row: <strong>" . number_format($nextStart) . "</strong></p>";

if ($importedThisRun < $batchSize) {
    echo "<hr><h2>✅ food.csv import complete.</h2>";
} else {
    echo "<hr>";
    echo '<p><a href="import-food-batch.php?start=' . $nextStart . '">Continue next batch</a></p>';
}