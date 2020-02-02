<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSettingsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			/** @noinspection PhpComposerExtensionStubsInspection */
			if (
				class_exists(PDO::class) &&
				DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql' &&
				version_compare(DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge')
			) {
				$table->json('settings')->default('[]');
			} else {
				$table->text('settings');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('settings');
		});
	}

}
