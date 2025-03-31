<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Tenant\Models\Tenant;
use Modules\Patient\Models\Patient;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'isees';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                $table->foreignIdFor(Tenant::class)->constrained()
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->foreignIdFor(Patient::class)->constrained()
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->string('isee_code')->nullable();
                $table->decimal('isee_value', 10, 2)->nullable();
                $table->date('isee_expiry_date')->nullable();
                $table->date('isee_issue_date')->nullable();
                $table->string('isee_type')->nullable();
                $table->string('isee_document_path')->nullable();
                $table->boolean('is_valid')->default(true);
                $table->text('notes')->nullable();
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );
    }
};