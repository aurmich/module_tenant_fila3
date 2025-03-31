<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Tenant\Models\Tenant;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'dentists';

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
            $table->string('name');
            $table->string('surname');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('specialization')->nullable();
            $table->string('license_number')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, false);
            }
        );
    }


};
