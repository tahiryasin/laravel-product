# Product Module
A simple "Product" module for Backend Developer- Skill Assessment Test.

## Installation
1. Download the zip folder from the github repository.
2. Create a directory named `modules/Product` at application root
3. Unzip the downloaded folder and copy contents inside  `modules/Product` directory 
4. Now open `config/app.php` and register module service provider.
```sh
'providers' => [
        ...
        /*
         * Package Service Providers...
         */

        \Modules\Product\Providers\ProductServiceProvider::class,
]
```
5. Now open composer.json and go to `autoload psr-4`.
```sh
    "autoload": {
        "psr-4": {
            ...
            "Modules\\Product\\": "modules/Product/"
        }
    }
```
6. Set application environment variable `MAIL_MAILER=log`
7. Now open the command prompt and run<br>
`php artisan config:cache`<br>
`composer dump-autoload`<br>
`php artisan migrate`


## Testing

Download the postman collection from email attachment and test the APIs.
