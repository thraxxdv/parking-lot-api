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

## Routes

`/api/v1/parking/space` - Retrieves a list of parking spaces

`/api/v1/parking/create` - Creates a parking space. Parameters:

-   `vehicle_type_id` - The ID for the type of vehicle. 1 = S, 2 = M, 3 = L

`/api/v1/parking/park` - Park vehicle. Parameters:

-   `gate` - The ID of the gate where the vehicle will enter
-   `vehicle_type_id` - The type of vehicle coming into the parking space
-   `timestamp` - A timestamp for when the vehicle has parked
-   `uuid` (optional) - The UUID for a returning vehicle.

`/api/v1/parking/unpark` - Unpark vehicle. Parameters:

-   `uuid` - UUID of the vehicle
-   `timestamp` - A timestamp for when the vehicle will leave the parking space

`/api/v1/gate/get` - Get all gates/entry points

`/api/v1/gate/create` - Create a new gate

-   `nearest_space` - The parking space where the gate should be nearest to

`/api/v1/gate/delete` - Delete a gate

-   `nearest_space` - The parking space where the gate is nearest to

`/api/v1/vehicle-type/get` - Get vehicle types
