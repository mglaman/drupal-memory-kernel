<?php

declare(strict_types=1);

namespace mglaman\DrupalMemoryKernel;

use Drupal\Core\DrupalKernel;

final class DrupalMemoryKernel extends DrupalKernel
{
    /**
     * {@inheritdoc}
     */
    protected $sitePath = __DIR__;

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>|null
     */
    public function getCachedContainerDefinition(): array | null
    {
        return null;
    }
}
