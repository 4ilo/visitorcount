A simple visitor counter with graph for Laravel

## Installation

    composer require ovde/visitorcount

For Laravel < 5.5 add the service provider of the package. To do this open your `config/app.php` file.

Add a new line to the `providers` array:

	Ovde\Visitorcount\VisitorCountServiceProvider::class,
	

Publish the assets:

    php artisan vendor:publish --tag=public --force
    
Migrate your database:

    php artisan migrate
    
## Usage

The folowing views are available to use:

    @include("visitorcount::graph")
    @include("visitorcount::stats")
    
Register the `countVisit` middleware on the routes you want to count visits.

    Route::get("/")->middleware("countVisit");