<?php

declare(strict_types=1);

use Modules\Reporting\Models\Report;
use Modules\Reporting\Models\ReportData;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    //protected string $table = 'report_data';
    protected ?string $model_class = ReportData::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                $table->foreignIdFor(Report::class)->constrained()->onDelete('cascade');
                $table->string('key');
                $table->text('value')->nullable();
                $table->string('data_type')->default('string');
                $table->string('description')->nullable();
                $table->integer('order')->default(0);
                $table->string('group')->nullable();
                $table->json('metadata')->nullable();
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, false);
                
                // Indice per ricerche più veloci
                $table->index(['report_id', 'group', 'key']);
            }
        );
    }
};
