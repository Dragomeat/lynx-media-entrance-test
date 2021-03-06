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

use CommerceGuys\Enum\AbstractEnum;

/**
 * Class FPLProxyAnonymityType.
 */
class FPLProxyAnonymityType extends AbstractEnum
{
    public const ELITE_PROXY = 'elite proxy';
    public const ANONYMOUS_PROXY = 'anonymous';
    public const TRANSPARENT_PROXY = 'transparent';
}
