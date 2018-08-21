<?php
/**
 *  This file is part of the lynx-media-entrance-test package.
 *
 *  (c) Artem Prosvetov <dragomeat@dragomeat.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Console\Commands;

use App\ProxyParser\Proxy;
use App\StoredProxy;
use App\ProxyParser\Parser;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

/**
 * Class ProxiesSync
 */
class ProxiesSync extends Command
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var string
     */
    protected $signature = 'proxies:sync';

    /**
     * @var string
     */
    protected $description = 'Sync proxies from external resources.';

    /**
     * ProxiesSync constructor.
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;

        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $saves = StoredProxy::all();
        $proxies = collect();

        foreach ($this->parser->parse() as $provider => $proxy) {
            $values = ['provider' => $provider] + $proxy->toArray();

            $save = $this->findSaveForProxy($saves, $proxy);

            if ($save) {
                $diff = array_diff( // A small crutch, but I nearly missed the train. Sorry :)
                    Arr::except($save->toArray(), 'lastUpdatedAt'),
                    Arr::except($values, 'lastUpdatedAt')
                );

                $save->update($diff + ['lastUpdatedAt' => $proxy->getLastUpdatedAt()]);
                $proxies->push($save);
            } else {
                StoredProxy::fromArray($values)->save();
            }
        }

        $oldSaveIds = $saves->diff($proxies)->pluck('id')->toArray();

        StoredProxy::destroy($oldSaveIds);
    }

    /**
     * @param Collection|StoredProxy[] $collection
     * @param Proxy $proxy
     * @return StoredProxy|null
     */
    protected function findSaveForProxy(Collection $collection, Proxy $proxy): ?StoredProxy
    {
        return $collection->filter(function (StoredProxy $savedProxy) use ($proxy) {
            return $savedProxy->getHost() === $proxy->getHost();
        })->first();
    }
}
