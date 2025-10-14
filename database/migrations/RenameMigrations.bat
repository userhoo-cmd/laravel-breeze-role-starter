@echo off
cd /d "C:\Users\Admin\Desktop\laravel-pos-master\database\migrations"

:: Rename migration files sequentially
ren "2014_10_12_000000_create_users_table.php" "2025_10_05_000100_create_users_table.php"
ren "2014_10_12_100000_create_password_resets_table.php" "2025_10_05_000200_create_password_resets_table.php"
ren "2019_08_19_000000_create_failed_jobs_table.php" "2025_10_05_000300_create_failed_jobs_table.php"
ren "2019_12_14_000001_create_personal_access_tokens_table.php" "2025_10_05_000400_create_personal_access_tokens_table.php"
ren "2020_04_19_081616_create_products_table.php" "2025_10_05_000500_create_products_table.php"
ren "2020_04_22_181602_add_quantity_to_products_table.php" "2025_10_05_000600_add_quantity_to_products_table.php"
ren "2020_04_24_170630_create_customers_table.php" "2025_10_05_000700_create_customers_table.php"
ren "2020_04_27_054355_create_settings_table.php" "2025_10_05_000800_create_settings_table.php"
ren "2020_04_30_053758_create_user_cart_table.php" "2025_10_05_000900_create_user_cart_table.php"
ren "2020_05_04_165730_create_orders_table.php" "2025_10_05_001000_create_orders_table.php"
ren "2020_05_04_165749_create_order_items_table.php" "2025_10_05_001100_create_order_items_table.php"
ren "2020_05_04_165822_create_payments_table.php" "2025_10_05_001200_create_payments_table.php"
ren "2022_03_21_125336_change_price_column.php" "2025_10_05_001300_change_price_column.php"
ren "2024_07_12_044953_create_suppliers_table.php" "2025_10_05_001400_create_suppliers_table.php"
ren "2024_07_13_045228_create_purchase_cart_table.php" "2025_10_05_001500_create_purchase_cart_table.php"
ren "2024_08_17_033153_create_sessions_table.php" "2025_10_05_001600_create_sessions_table.php"

echo.
echo All migration files have been renamed successfully!
pause
