<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Tenant\Models\Tenant;
use Modules\Patient\Models\Patient;
use Modules\Dental\Models\Dentist;
use Modules\Dental\Models\Appointment;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'treatments';

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
                $table->foreignIdFor(Dentist::class)->constrained()
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->foreignIdFor(Appointment::class)->nullable()->constrained()
                    ->onDelete('set null')->onUpdate('cascade');
                $table->string('type');
                $table->text('description')->nullable();
                $table->text('notes')->nullable();
                $table->string('status')->default('pending');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->decimal('cost', 10, 2)->nullable();
                $table->boolean('is_covered')->default(true);
                $table->boolean('is_pregnancy_safe')->default(false);
                $table->json('teeth_involved')->nullable();
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