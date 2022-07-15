<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coins', function (Blueprint $table) {
            $table->string('coin_id')->after('id');
            $table->integer('is_crypto')->after('name');
            $table->integer('status')->default(0)->after('is_crypto');
            $table->string('img_path')->nullable()->after('status');
            $table->integer('is_default')->default(0)->after('img_path');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coins', function (Blueprint $table) {
            $table->dropColumn(['is_crypto','status','img_path','is_default']);
        });
    }
};
