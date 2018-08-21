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

use Carbon\CarbonInterval;
use DateTime;
use DateTimeInterface;

/**
 * Class FPLProxyTransformer.
 */
class FPLProxyTransformer
{
    /**
     * @var FPLProxyAnonymityTypeConvector
     */
    private $anonymityTypeConvector;

    /**
     * FPLProxyTransformer constructor.
     *
     * @param FPLProxyAnonymityTypeConvector $anonymityTypeConvector
     */
    public function __construct(FPLProxyAnonymityTypeConvector $anonymityTypeConvector)
    {
        $this->anonymityTypeConvector = $anonymityTypeConvector;
    }

    /**
     * @param array $values
     *
     * @return FPLProxy
     */
    public function transform(array $values): FPLProxy
    {
        return FPLProxy::fromArray(
            $this->transformArray($values)
        );
    }

    /**
     * @param array $values
     *
     * @return array
     */
    protected function transformArray(array $values): array
    {
        return [
            'ipAddress'     => $this->transformIpAddress($values[0]),
            'port'          => (int) $values[1],
            'country'       => empty($values[2]) ? '--' : $values[2],
            'anonymityType' => $this->transformAnonymityType($values[4]),
            'lastUpdatedAt' => $this->transformLastUpdatedAt($values[7]),
        ];
    }

    /**
     * @param string $ip
     *
     * @return string
     */
    protected function transformIpAddress(string $ip): string
    {
        return ltrim($ip, '0'); // 05.197.183.222 -> 5.197.183.222
    }

    /**
     * @param string $type
     *
     * @throws \InvalidArgumentException When type is not exists in FPLProxyAnonymityType.
     *
     * @return string
     */
    protected function transformAnonymityType(string $type): string
    {
        return $this->anonymityTypeConvector->toBasicAnonymityType($type);
    }

    /**
     * @param string $lastUpdatedAt
     *
     * @return DateTimeInterface
     */
    protected function transformLastUpdatedAt(string $lastUpdatedAt): DateTimeInterface
    {
        return (new DateTime())->sub(CarbonInterval::fromString($lastUpdatedAt));
    }
}
