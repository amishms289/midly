<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');
            $table->string('spotify_id')->nullable()->after('avatar');
            $table->string('sp_token')->nullable()->after('spotify_id');
            $table->string('sp_refresh_token')->nullable()->after('sp_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['sp_refresh_token', 'sp_token', 'spotify_id', 'avatar']);
        });
    }
}
