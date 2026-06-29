<?php

require_once __DIR__ . '/../app/config/database.php';

$db = Database::connect('food_core');

$search = trim($_GET['q'] ?? '');
$results = [];

if ($search !== '') {
    $stmt = $db->prepare("
        SELECT 
            fdc_id,
            data_type,
            description,
            food_category_id,
            publication_date
        FROM food
        WHERE description LIKE :search
        ORDER BY description ASC
        LIMIT 50
    ");

    $stmt->execute([
        ':search' => '%' . $search . '%'
    ]);

    $results = $stmt->fetchAll();
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>NutriAtlas Food Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            background: #f7f7f7;
            color: #222;
        }

        h1 {
            margin-bottom: 10px;
        }

        form {
            margin: 25px 0;
            display: flex;
            gap: 10px;
        }

        input[type="text"] {
            flex: 1;
            padding: 12px;
            font-size: 16px;
        }

        button {
            padding: 12px 18px;
            font-size: 16px;
            cursor: pointer;
        }

        .result {
            background: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        .meta {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<h1>NutriAtlas Food Search</h1>
<p>Search the imported USDA food table.</p>

<form method="get">
    <input 
        type="text" 
        name="q" 
        value="<?php echo htmlspecialchars($search); ?>" 
        placeholder="Search foods, example: apple"
    >
    <button type="submit">Search</button>
</form>

<?php if ($search !== ''): ?>

    <h2>Results for "<?php echo htmlspecialchars($search); ?>"</h2>

    <?php if (empty($results)): ?>

        <p>No results found.</p>

    <?php else: ?>

        <?php foreach ($results as $food): ?>
            <div class="result">
                <strong><?php echo htmlspecialchars($food['description']); ?></strong>
                <div class="meta">
                    FDC ID: <?php echo htmlspecialchars($food['fdc_id']); ?> |
                    Type: <?php echo htmlspecialchars($food['data_type']); ?> |
                    Category: <?php echo htmlspecialchars($food['food_category_id'] ?? ''); ?> |
                    Published: <?php echo htmlspecialchars($food['publication_date'] ?? ''); ?>
                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>

<?php endif; ?>

</body>
</html>