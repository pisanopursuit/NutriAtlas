<?php

require_once __DIR__ . '/../app/config/database.php';

$db = Database::connect('food_core');

$count = $db->query("SELECT COUNT(*) AS total FROM food")->fetch();

echo "<h1>Food Table Count</h1>";
echo "<p>Total rows imported: <strong>" . number_format($count['total']) . "</strong></p>";