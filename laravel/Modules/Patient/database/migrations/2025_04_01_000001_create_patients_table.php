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
    protected string $table = 'patients';

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
                $table->string('fiscal_code')->nullable()->unique();
                $table->date('birth_date')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('province')->nullable();
                $table->string('country')->nullable();
                $table->boolean('is_pregnant')->default(false);
                $table->string('isee_code')->nullable();
                $table->decimal('isee_value', 10, 2)->nullable();
                $table->date('isee_expiry_date')->nullable();
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
