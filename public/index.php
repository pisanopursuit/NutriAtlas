<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>NutriAtlas</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<main class="container hero">
    <h1>NutriAtlas</h1>
    <p>A searchable nutrition app built from USDA FoodData Central CSV files.</p>

    <form action="search.php" method="get" class="search-form">
        <input type="search" name="q" placeholder="Search foods..." required>
        <button type="submit">Search</button>
    </form>

    <p class="note">First build step: connect the six databases, then import USDA CSV data.</p>
</main>
</body>
</html>
