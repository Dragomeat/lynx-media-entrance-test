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
use DateTimeInterface;
use App\ProxyParser\Proxy;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * Class FPLProxy
 */
class FPLProxy implements Proxy
{
    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $anonymityType;

    /**
     * @var DateTimeInterface
     */
    private $lastUpdatedAt;

    /**
     * @param array $values
     * @return static
     */
    public static function fromArray(array $values): FPLProxy
    {
        foreach (['ipAddress', 'port', 'country', 'anonymityType', 'lastUpdatedAt'] as $property) {
            Assert::keyExists($values, $property);
            Assert::notEmpty($values[$property]);
        }

        return new FPLProxy($values['ipAddress'], $values['port'], $values['country'], $values['anonymityType'], $values['lastUpdatedAt']);
    }

    /**
     * HideMyProxy constructor.
     * @param string $ipAddress
     * @param int $port
     * @param string $country
     * @param string $anonymityType
     * @param DateTimeInterface $lastUpdatedAt
     *
     * @throws InvalidArgumentException When any values are not valid.
     */
    public function __construct(string $ipAddress, int $port, string $country, string $anonymityType, DateTimeInterface $lastUpdatedAt)
    {
        $this->setIpAddress($ipAddress);
        $this->setPort($port);
        $this->setCountry($country);
        $this->setAnonymityType($anonymityType);
        $this->setLastUpdatedAt($lastUpdatedAt);
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return void
     *
     * @throws InvalidArgumentException When ip address is not valid.
     */
    private function setIpAddress(string $ipAddress): void
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            throw new InvalidArgumentException(
                sprintf('Expected ip address. Got: %s', $ipAddress)
            );
        }

        $this->ipAddress = $ipAddress;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return void
     *
     * @throws InvalidArgumentException When port out of range allowed values.
     */
    private function setPort(int $port): void
    {
        Assert::greaterThanEq($port, 1);
        Assert::lessThanEq($port, 65535);

        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->getIpAddress() . ':' . $this->getPort();
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return void
     */
    private function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getAnonymityType(): string
    {
        return $this->anonymityType;
    }

    /**
     * @param string $anonymityType
     * @return void
     *
     * @throws InvalidArgumentException When anonymity type is not exist.
     */
    private function setAnonymityType(string $anonymityType): void
    {
        ProxyAnonymityType::assertExists($anonymityType);

        $this->anonymityType = $anonymityType;
    }

    /**
     * @return DateTimeInterface
     */
    public function getLastUpdatedAt(): DateTimeInterface
    {
        return $this->lastUpdatedAt;
    }

    /**
     * @param DateTimeInterface $updatedAt
     * @return void
     */
    private function setLastUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->lastUpdatedAt = $updatedAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ipAddress' => $this->getIpAddress(),
            'port' => $this->getPort(),
            'country' => $this->getCountry(),
            'anonymityType' => $this->getAnonymityType(),
            'lastUpdatedAt' => $this->getLastUpdatedAt(),
        ];
    }
}
