# drupal-memory-kernel
Provides a DrupalKernel that uses an in-memory SQLite database

## Usage


```php
$kernel = MemoryKernelFactory::get(
    environment: 'testing',
    autoloader: require __DIR__ . '/../vendor/autoload.php',
    modules: [
        'user' => 0,
        'serialization' => 0,
    ],
);
```

Now you can interact with the Drupal kernel and its service container!
