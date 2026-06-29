<?php
require_once __DIR__ . '/../../app/config/database.php';

$databases = [
    'food_core',
    'food_branded',
    'food_nutrients_1',
    'food_nutrients_2',
    'food_search',
    'food_app',
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>NutriAtlas Database Test</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
<main class="container">
    <h1>NutriAtlas Database Test</h1>
    <p>This page checks whether PHP can connect to each database.</p>

    <table>
        <thead>
            <tr>
                <th>Database</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($databases as $database): ?>
            <tr>
                <td><?php echo htmlspecialchars($database); ?></td>
                <td>
                    <?php
                    try {
                        Database::connect($database);
                        echo '<span class="ok">OK</span>';
                    } catch (Throwable $e) {
                        echo '<span class="bad">FAILED</span><br><small>' . htmlspecialchars($e->getMessage()) . '</small>';
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>
