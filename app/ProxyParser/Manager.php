<?php
/**
 *  This file is part of the lynx-media-entrance-test package.
 *
 *  (c) Artem Prosvetov <dragomeat@dragomeat.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\ProxyParser;

use App\ProxyParser\FPL\FPLDataProvider;
use Illuminate\Contracts\Container\Container;

/**
 * Class Manager.
 */
class Manager
{
    /**
     * @var array
     */
    private static $defaultProviders = [
        FPLDataProvider::class,
    ];

    /**
     * @var DataProvider[]
     */
    private $providers;

    /**
     * Manager constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        foreach (static::$defaultProviders as $provider) {
            $this->add($container->make($provider));
        }
    }

    /**
     * @param DataProvider $provider
     *
     * @return Manager
     */
    public function add(DataProvider $provider): self
    {
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * @return DataProvider[]
     */
    public function getProviders(): array
    {
        return $this->providers;
    }
}
