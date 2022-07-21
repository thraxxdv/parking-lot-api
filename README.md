## Parking Lot API

API built with the PHP Laravel Framework that does the following:

-   Create parking spaces for S, M and L vehicles
-   Create and delete gates to the parking spaces
-   Park and unpark vehicles
-   Generate fee based on how long a vehicle is parked and what type of parking space is occupied, taking into account returning vehicles within an hour

This build utilizes Laravel's built in broadcast channels to give realtime updates to parking spaces and gates

## Installation

1. Run `composer install` and wait until finished
2. Run `php artisan serve` and visit the development server URL indicated
3. In another terminal, run `php artisan websockets:serve`

Refer to `routes/api.php` for the API endpoints
