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

use Illuminate\Contracts\Translation\Translator;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * Class ProxyAnonymityTypeTranslator.
 */
class ProxyAnonymityTypeTranslator
{
    /**
     * @var array
     */
    public static $translations = [
        ProxyAnonymityType::HIGH          => 'proxies.types.high',
        ProxyAnonymityType::MEDIUM        => 'proxies.types.medium',
        ProxyAnonymityType::LOW           => 'proxies.types.low',
        ProxyAnonymityType::NOT_PROTECTED => 'proxies.types.not_protected',
    ];

    /**
     * @var Translator
     */
    private $translator;

    /**
     * ProxyAnonymityTypeTranslator constructor.
     *
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param string $anonymityType
     *
     * @throws InvalidArgumentException When anonymity type is not exists or no translations found.
     *
     * @return string
     */
    public function translate(string $anonymityType): string
    {
        ProxyAnonymityType::assertExists($anonymityType);
        Assert::keyExists(static::$translations, $anonymityType, 'No translations found for `%s` anonymity type');

        return $this->translator->trans(static::$translations[$anonymityType]);
    }
}
