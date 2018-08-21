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

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class DomCrawler.
 */
class DomCrawler
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * DomCrawler constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $uri
     *
     * @return Crawler
     */
    public function parse(string $uri): Crawler
    {
        $html = $this->request($uri);

        return new Crawler($html);
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    protected function request(string $uri): string
    {
        try {
            return $this->client->request('GET', $uri)
                ->getBody()
                ->getContents();
        } catch (GuzzleException $exception) {
            var_dump($exception->getMessage(), $exception->getCode()); //TODO
        }
    }
}
