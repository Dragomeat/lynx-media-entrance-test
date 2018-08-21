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

namespace App\Http\Transformers;

use App\ProxyParser\Proxy;
use App\ProxyParser\ProxyAnonymityTypeTranslator;
use League\Fractal\TransformerAbstract;

/**
 * Class ProxyTransformer.
 */
class ProxyTransformer extends TransformerAbstract
{
    /**
     * @var ProxyAnonymityTypeTranslator
     */
    private $translator;

    /**
     * ProxyTransformer constructor.
     *
     * @param ProxyAnonymityTypeTranslator $translator
     */
    public function __construct(ProxyAnonymityTypeTranslator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param Proxy $proxy
     *
     * @return array
     */
    public function transform(Proxy $proxy): array
    {
        return [
            'host'          => $proxy->getHost(),
            'country'       => $proxy->getCountry(),
            'anonymityType' => $this->translator->translate($proxy->getAnonymityType()),
            'lastUpdatedAt' => (string) $proxy->getLastUpdatedAt(),
        ];
    }
}
