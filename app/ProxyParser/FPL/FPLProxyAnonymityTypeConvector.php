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

namespace App\ProxyParser\FPL;

use Webmozart\Assert\Assert;
use App\ProxyParser\ProxyAnonymityType;

/**
 * Class FPLProxyAnonymityTypeConvector
 */
class FPLProxyAnonymityTypeConvector
{
    /**
     * @var array
     */
    public static $associations = [
        FPLProxyAnonymityType::ELITE_PROXY => ProxyAnonymityType::HIGH,
        FPLProxyAnonymityType::ANONYMOUS_PROXY => ProxyAnonymityType::LOW,
        FPLProxyAnonymityType::TRANSPARENT_PROXY => ProxyAnonymityType::NOT_PROTECTED,
    ];

    /**
     * @param string $type
     * @return string
     *
     * @throws \InvalidArgumentException When type is not exists or no associations found.
     */
    public function toBasicAnonymityType(string $type): string
    {
        FPLProxyAnonymityType::assertExists($type);
        Assert::keyExists(static::$associations, $type, 'No associations found for `%s` anonymity type');

        return static::$associations[$type];
    }
}
