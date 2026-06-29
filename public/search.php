<?php
$q = trim($_GET['q'] ?? '');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Search | NutriAtlas</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<main class="container">
    <h1>Search</h1>
    <form action="search.php" method="get" class="search-form">
        <input type="search" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Search foods..." required>
        <button type="submit">Search</button>
    </form>

    <?php if ($q): ?>
        <p>Search results will appear here after the USDA import and search index are built.</p>
    <?php endif; ?>
</main>
</body>
</html>
