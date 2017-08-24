A simple visitor counter with graph for Laravel

## Installation

Clone the package in a `packages/ovde` directory.

Add to your composer.json file:

    "repositories": [
        {
            "type": "path",
            "url": "packages/ovde/visitorcount"
        }
    ],
    "require": {
        ...
        "ovde/visitorcount": "dev-master"
    },

Now all you have to do is add the service provider of the package. To do this open your `config/app.php` file.

Add a new line to the `providers` array:

	Ovde\Visitorcount\VisitorCountServiceProvider::class,
	

Publish the assets:

    php artisan vendor:publish --tag=public --force
    
Migrate your database:

    php artisan migrate
    
## Usage

The folowing views are available to use:

    "visitorcount::graph"
    "visitorcount::stats"
    
Register the `countVisit` middleware on the routes you want to count visits.

    Route::get("/")->middleware("countVisit");