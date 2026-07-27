<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->string('description')->nullable()->after('badge');
            $table->softDeletes();
        });

        // affected_record_id and by_user_id need to allow null for system-generated
        // logs (e.g. sync jobs) that aren't tied to a record or an acting user.
        DB::statement('ALTER TABLE logs MODIFY affected_record_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE logs DROP FOREIGN KEY logs_by_user_id_foreign');
        DB::statement('ALTER TABLE logs MODIFY by_user_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE logs ADD CONSTRAINT logs_by_user_id_foreign FOREIGN KEY (by_user_id) REFERENCES users (id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE logs DROP FOREIGN KEY logs_by_user_id_foreign');
        DB::statement('ALTER TABLE logs MODIFY by_user_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE logs ADD CONSTRAINT logs_by_user_id_foreign FOREIGN KEY (by_user_id) REFERENCES users (id)');
        DB::statement('ALTER TABLE logs MODIFY affected_record_id BIGINT UNSIGNED NOT NULL');

        Schema::table('logs', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('description');
        });
    }
};
