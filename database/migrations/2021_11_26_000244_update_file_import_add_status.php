<?php

use App\Models\FileImport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFileImportAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_imports', function (Blueprint $table) {
            $table->enum('status', [
                FileImport::STATUS_ON_HOLD,
                FileImport::STATUS_PROCESSING,
                FileImport::STATUS_FAILED,
                FileImport::STATUS_FINISHED,
            ])->default(FileImport::STATUS_ON_HOLD);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_imports', function (Blueprint $table) {
            $table->removeColumn('status');
        });
    }
}
