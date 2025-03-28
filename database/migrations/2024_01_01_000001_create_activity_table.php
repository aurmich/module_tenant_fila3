<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Activity\Models\Activity;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    // protected ?string $model_class = Activity::class;
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('log_name')->nullable();
                $table->text('description');
                $table->nullableMorphs('subject', 'subject');
                $table->nullableMorphs('causer', 'causer');
                $table->json('properties')->nullable();
                $table->index('log_name');
                $table->uuid('batch_uuid')->nullable();
                // ->after('properties');
                $table->string('event')->nullable();
                // ->after('subject_type');
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if ($this->hasColumn('causer_id')) {
                    $table->string('causer_id')->change();
                }
                $this->updateTimestamps($table, true);
            }
        );
    }
};
