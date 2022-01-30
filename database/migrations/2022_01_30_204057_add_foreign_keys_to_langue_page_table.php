<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToLanguePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('langue_page', function (Blueprint $table) {
            $table->foreign(['langue_id'], 'page_langue_langue_id_foreign')->references(['id'])->on('langues')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['page_id'], 'page_langue_page_id_foreign')->references(['id'])->on('pages')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('langue_page', function (Blueprint $table) {
            $table->dropForeign('page_langue_langue_id_foreign');
            $table->dropForeign('page_langue_page_id_foreign');
        });
    }
}
