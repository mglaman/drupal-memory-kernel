<?php

namespace mglaman\DrupalMemoryKernel;

use Composer\Autoload\ClassLoader;
use Drupal\Core\Config\MemoryStorage;
use Drupal\Core\Database\Database;
use Drupal\Core\Site\Settings;

final class MemoryKernelFactory
{
    /**
     * @param array<string, int> $modules
     */
    public static function get(
        string $environment,
        ClassLoader $autoloader,
        array $modules,
    ): DrupalMemoryKernel {
        // The system module is always required.
        $modules['system'] = 0;

        // Drupal 9.4 moved database drivers into their own modules.
        // @link https://www.drupal.org/node/3129492
        $modules['sqlite'] = 0;
        Database::addConnectionInfo('default', 'default', [
          'driver' => 'sqlite',
          'database' => ':memory:',
        ]);

        new Settings([
          'bootstrap_config_storage' => static function () use ($modules) {
              $memoryStorage = new MemoryStorage();
              $memoryStorage->write('core.extension', [
                'module' => $modules,
                'profile' => 'minimal',
              ]);
              return $memoryStorage;
          },
          'cache' => [
            'default' => 'cache.backend.memory',
          ],
        ]);

        $kernel = new DrupalMemoryKernel(
            $environment,
            $autoloader,
            // No need to dump container to cache.
            false,
        );
        chdir($kernel->getAppRoot());
        $kernel::bootEnvironment();
        $kernel->boot();
        return $kernel;
    }
}
