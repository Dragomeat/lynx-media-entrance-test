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

namespace App\Http\Controllers;

use App\StoredProxy;
use Illuminate\Http\JsonResponse;
use App\Http\Transformers\ProxyTransformer;
use Illuminate\Http\Request;

/**
 * Class ProxiesController
 */
class ProxiesController extends Controller
{
    /**
     * @var ProxyTransformer
     */
    private $proxyTransformer;

    /**
     * ProxiesController constructor.
     * @param ProxyTransformer $proxyTransformer
     */
    public function __construct(ProxyTransformer $proxyTransformer)
    {
        $this->proxyTransformer = $proxyTransformer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 20);

        $query = StoredProxy::query();

        if ($request->filled('anonymityType')) {
            $query->ofAnonymityType($request->get('anonymityType'));
        }

        $order = $request->get('order');

        if ($order && strpos($order, '|') !== false) {
            [$column, $direction] = explode('|', $order);

            $query->orderBy($column, $direction);
        }

        $proxies = $query->paginate($perPage);

        return fractal($proxies, $this->proxyTransformer)->respond();
    }
}
