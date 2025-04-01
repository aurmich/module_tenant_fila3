<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Patient\Models\Patient;
use Modules\Tenant\Models\Tenant;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'anamnesis';

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
                $table->json('allergies')->nullable();
                $table->json('chronic_diseases')->nullable();
                $table->json('medications')->nullable();
                $table->json('family_history')->nullable();
                $table->json('lifestyle')->nullable();
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
