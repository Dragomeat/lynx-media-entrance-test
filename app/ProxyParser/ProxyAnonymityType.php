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

use CommerceGuys\Enum\AbstractEnum;

/**
 * Class ProxyAnonymityType.
 */
class ProxyAnonymityType extends AbstractEnum
{
    public const HIGH = 'high';
    public const MEDIUM = 'medium';
    public const LOW = 'low';
    public const NOT_PROTECTED = 'not_protected';
}
