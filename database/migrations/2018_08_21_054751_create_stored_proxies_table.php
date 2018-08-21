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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateStoredProxiesTable.
 */
class CreateStoredProxiesTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('stored_proxies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provider');
            $table->ipAddress('ipAddress');
            $table->integer('port');
            $table->string('country');
            $table->string('anonymityType');
            $table->timestamp('lastUpdatedAt');
            $table->timestamps();

            $table->unique(['ipAddress', 'port']);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('stored_proxies');
    }
}
