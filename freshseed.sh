php artisan migrate:fresh --seed --path=database/migrations/tenant
php artisan module:migrate VehicleTracker
php artisan module:seed VehicleTracker
php artisan module:migrate LiveTracking
php artisan module:seed LiveTracking
