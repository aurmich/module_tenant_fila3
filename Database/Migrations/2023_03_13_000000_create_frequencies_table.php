<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateFrequenciesTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
<<<<<<< HEAD
<<<<<<< HEAD
            function (Blueprint $table): void {
=======
            function (Blueprint $table) : void {
>>>>>>> 090be5b (first)
=======
            function (Blueprint $table) : void {
>>>>>>> dev
                $table->increments('id');
                $table->unsignedInteger('task_id');
                $table->string('label');
                $table->string('interval');
                // $table->index('task_id', 'task_frequencies_task_id_idx');
                // $table->foreign('task_id', 'task_frequencies_task_id_fk')
                //     ->references('id')
                //     ->on(TOTEM_TABLE_PREFIX.'tasks');
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->timestamps();
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
<<<<<<< HEAD
<<<<<<< HEAD
            function (Blueprint $table): void {
=======
            function (Blueprint $table) : void {
>>>>>>> 090be5b (first)
=======
            function (Blueprint $table) : void {
>>>>>>> dev
                // if (! $this->hasColumn('created_by')) {
                //     $table->string('created_by')->nullable();
                //     $table->string('updated_by')->nullable();
                // }
            }
        );
    }
}
