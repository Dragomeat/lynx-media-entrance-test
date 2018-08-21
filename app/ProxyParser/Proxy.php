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

use DateTimeInterface;

/**
 * Interface Proxy
 */
interface Proxy
{
    /**
     * @return string
     */
    public function getIpAddress(): string;

    /**
     * @return int
     */
    public function getPort(): int;

    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return string
     */
    public function getCountry(): string;

    /**
     * @return string
     */
    public function getAnonymityType(): string;

    /**
     * @return DateTimeInterface
     */
    public function getLastUpdatedAt(): DateTimeInterface;

    /**
     * @return array
     */
    public function toArray(): array;
}
