# LaravelServices
* **This is still a work in progress.**

Laravel Services provides 2 Artisan commands allowing you to create ServiceProviders and Services through the Artisan CLI.

## INSTALLATION

```
composer require funkywaddle/laravel-services
```

## WHAT IT PROVIDES

It creates 2 directories in your Laravel `app/` directory. One is `app/Services` and the other is `app/ServiceProviders`.

The reason for the ServiceProviders directory (even though Laravel already has a Providers directory) is because this package also scans through the ServiceProviders directory and auto registers any ServiceProvider class it finds in there. If we were to do that with the Providers directory, the pre-written ServiceProviders provided by Laravel would cause some issues.

With that said, once you create a ServiceProvider in the ServiceProviders directory, you should NOT add it to the config/app.php config file. This package will handle that for you.

To create a ServiceProvider, you would run:

```
php artisan make:serviceprovider {name}
```

The Service command has a few extra options available.

```
php artisan make:service {name} {--provider} {--test}
```

The `--provider` option does not need any value. Just supplying the option itself will create the corresponding ServiceProvider for the Service being created.

The `--test` option will create a test for the Service being created.
