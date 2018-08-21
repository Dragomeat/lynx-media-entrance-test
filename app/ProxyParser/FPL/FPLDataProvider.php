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

namespace App\ProxyParser\FPL;

use Traversable;
use App\ProxyParser\Proxy;
use App\ProxyParser\DataProvider;
use App\ProxyParser\DomCrawler;
use App\ProxyParser\ProxyProvider;
use Symfony\Component\DomCrawler\Crawler;

use function call_user_func;

/**
 * Class FPLDataProvider
 */
class FPLDataProvider implements DataProvider
{
    public const NAME = ProxyProvider::FPL;
    public const BASE_URL = 'https://free-proxy-list.net';

    /**
     * @var DomCrawler
     */
    private $crawler;

    /**
     * @var FPLProxyTransformer
     */
    private $proxyTransformer;

    /**
     * HideMyDataProvider constructor.
     * @param DomCrawler $crawler
     * @param FPLProxyTransformer $proxyTransformer
     */
    public function __construct(DomCrawler $crawler, FPLProxyTransformer $proxyTransformer)
    {
        $this->crawler = $crawler;
        $this->proxyTransformer = $proxyTransformer;
    }

    /**
     * @return Proxy[]|Traversable
     */
    public function all(): Traversable
    {
        return $this->byPage();
    }

    /**
     * @param int $page This provider doesn't have any pages.
     * @return Proxy[]|Traversable
     */
    public function byPage(int $page = 1): Traversable
    {
        $proxies = $this->crawler->parse(static::BASE_URL)
            ->filter('#proxylisttable > tbody')
            ->children()
            ->each(function (Crawler $node) {
                return call_user_func([$this->proxyTransformer, 'transform'], $node->filter('td')->extract(['_text']));
            });

        foreach ($proxies as $proxy) {
            yield static::NAME => $proxy;
        }
    }
}
