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

use App\ProxyParser\ProxyAnonymityType;
use Webmozart\Assert\Assert;

/**
 * Class FPLProxyAnonymityTypeConvector.
 */
class FPLProxyAnonymityTypeConvector
{
    /**
     * @var array
     */
    public static $associations = [
        FPLProxyAnonymityType::ELITE_PROXY       => ProxyAnonymityType::HIGH,
        FPLProxyAnonymityType::ANONYMOUS_PROXY   => ProxyAnonymityType::LOW,
        FPLProxyAnonymityType::TRANSPARENT_PROXY => ProxyAnonymityType::NOT_PROTECTED,
    ];

    /**
     * @param string $type
     *
     * @throws \InvalidArgumentException When type is not exists or no associations found.
     *
     * @return string
     */
    public function toBasicAnonymityType(string $type): string
    {
        FPLProxyAnonymityType::assertExists($type);
        Assert::keyExists(static::$associations, $type, 'No associations found for `%s` anonymity type');

        return static::$associations[$type];
    }
}
