# NutriAtlas Next Steps

## Step 1
Upload the starter kit to your server.

## Step 2
Edit:

`app/config/db-config.php`

Add the real credentials for your six databases.

## Step 3
Open:

`public/admin/db-test.php`

All six databases should say OK.

## Step 4
Create the database tables using the SQL files in:

`database/schema/`

Run each file against the matching database:

- `01_food_core.sql` -> food_core
- `02_food_branded.sql` -> food_branded
- `03_food_nutrients_1.sql` -> food_nutrients_1
- `04_food_nutrients_2.sql` -> food_nutrients_2
- `05_food_search.sql` -> food_search
- `06_food_app.sql` -> food_app

## Step 5
After tables are created, build the first importer for `food.csv`.
