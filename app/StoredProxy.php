<?php
/**
 *  This file is part of the lynx-media-entrance-test package.
 *
 *  (c) Artem Prosvetov <dragomeat@dragomeat.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

/**
 *  This file is part of the lynx-media-entrance-test package.
 *
 *  (c) Artem Prosvetov <dragomeat@dragomeat.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use App\ProxyParser\Proxy;
use App\ProxyParser\ProxyAnonymityType;
use App\ProxyParser\ProxyProvider;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * Class StoredProxy.
 *
 * @property int $id
 * @property string $provider
 * @property string $ipAddress
 * @property int $port
 * @property string $country
 * @property string $anonymityType
 * @property \Illuminate\Support\Carbon $lastUpdatedAt
 * @property \Illuminate\Support\Carbon $createdAt
 * @property \Illuminate\Support\Carbon $updatedAt
 */
class StoredProxy extends Model implements Proxy
{
    /**
     * @var array
     */
    protected $fillable = [
        'provider', 'ipAddress', 'port', 'country', 'anonymityType', 'lastUpdatedAt',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'lastUpdatedAt',
        'updatesAt',
        'createdAt',
    ];

    /**
     * @param array $values
     *
     * @return static
     */
    public static function fromArray(array $values): self
    {
        foreach (['provider', 'ipAddress', 'port', 'country', 'anonymityType', 'lastUpdatedAt'] as $property) {
            Assert::keyExists($values, $property);
            Assert::notEmpty($values[$property]);
        }

        return new static($values);
    }

    /**
     * @param Builder $builder
     * @param string  $anonymityType
     *
     * @throws InvalidArgumentException When anonymity type is not exists.
     *
     * @return Builder
     */
    public function scopeOfAnonymityType(Builder $builder, string $anonymityType): Builder
    {
        ProxyAnonymityType::assertExists($anonymityType);

        return $builder->where('anonymityType', $anonymityType);
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @param string $provider
     *
     * @throws InvalidArgumentException When provide is not exist
     *
     * @return void
     */
    public function setProviderAttribute(string $provider): void
    {
        ProxyProvider::assertExists($provider);

        $this->attributes['provider'] = $provider;
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
     *
     * @throws InvalidArgumentException When ip address is not valid.
     *
     * @return void
     */
    public function setIpAddressAttribute(string $ipAddress): void
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            throw new InvalidArgumentException(
                sprintf('Expected ip address. Got: %s', $ipAddress)
            );
        }

        $this->attributes['ipAddress'] = $ipAddress;
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
     *
     * @throws InvalidArgumentException When port out of range allowed values.
     *
     * @return void
     */
    public function setPortAttribute(int $port): void
    {
        Assert::greaterThanEq($port, 1);
        Assert::lessThanEq($port, 65535);

        $this->attributes['port'] = $port;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->getIpAddress().':'.$this->getPort();
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
     *
     * @return void
     */
    public function setCountryAttribute(string $country): void
    {
        $this->attributes['country'] = $country;
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
     *
     * @throws InvalidArgumentException When anonymity type is not exist.
     *
     * @return void
     */
    public function setAnonymityTypeAttribute(string $anonymityType): void
    {
        ProxyAnonymityType::assertExists($anonymityType);

        $this->attributes['anonymityType'] = $anonymityType;
    }

    /**
     * @return DateTimeInterface
     */
    public function getLastUpdatedAt(): DateTimeInterface
    {
        return $this->lastUpdatedAt;
    }

    /**
     * @param DateTimeInterface $lastUpdatedAt
     *
     * @return void
     */
    public function setLastUpdatedAtAttribute(DateTimeInterface $lastUpdatedAt): void
    {
        $this->attributes['lastUpdatedAt'] = $lastUpdatedAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'provider'      => $this->getProvider(),
            'ipAddress'     => $this->getIpAddress(),
            'port'          => $this->getPort(),
            'country'       => $this->getCountry(),
            'anonymityType' => $this->getAnonymityType(),
            'lastUpdatedAt' => $this->getLastUpdatedAt(),
        ];
    }
}
