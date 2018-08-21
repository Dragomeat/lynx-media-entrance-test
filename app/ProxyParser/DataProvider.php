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
 * Interface DataProvider.
 */
interface DataProvider
{
    /**
     * @return Proxy[]|Traversable
     */
    public function all(): Traversable;

    /**
     * @param int $page
     *
     * @return Proxy[]|Traversable
     */
    public function byPage(int $page = 1): Traversable;
}
