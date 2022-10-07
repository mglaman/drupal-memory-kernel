<?php

declare(strict_types=1);

namespace mglaman\DrupalMemoryKernel\Tests;

use mglaman\DrupalMemoryKernel\MemoryKernelFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class DrupalMemoryKernelTest extends TestCase
{
    /**
     * @covers \mglaman\DrupalMemoryKernel\MemoryKernelFactory::get
     * @covers \mglaman\DrupalMemoryKernel\DrupalMemoryKernel::getCachedContainerDefinition
     */
    public function testConstructor(): void
    {
        $sut = MemoryKernelFactory::get(
            'testing',
            require __DIR__ . '/../vendor/autoload.php',
            [],
        );
        self::assertEquals(
            realpath(__DIR__ . '/../vendor/drupal'),
            realpath($sut->getAppRoot())
        );
        self::assertTrue(\Drupal::hasContainer());
    }

    public function testHandle(): void
    {
        // @todo fix this!
        $this->expectException(\LogicException::class);
        $this->expectErrorMessage(
            'Site path cannot be changed after calling boot()'
        );
        $sut = MemoryKernelFactory::get(
            'testing',
            require __DIR__ . '/../vendor/autoload.php',
            []
        );
        $response = $sut->handle(Request::create('/'));
        self::assertEquals(200, $response->getStatusCode());
    }
}
