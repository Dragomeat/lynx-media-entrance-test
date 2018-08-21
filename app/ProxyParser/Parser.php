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

use Traversable;

/**
 * Class Parser.
 */
class Parser
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * Parser constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return Proxy[]|Traversable
     */
    public function parse(): Traversable
    {
        foreach ($this->manager->getProviders() as $provider) {
            yield from $provider->all();
        }
    }
}
