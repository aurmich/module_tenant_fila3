<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Tenant\Models\Tenant;
use Modules\User\Models\User;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected string $table = 'reports';

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('type');
                $table->dateTime('period_start')->nullable();
                $table->dateTime('period_end')->nullable();
                $table->string('status')->default('pending');
                $table->json('parameters')->nullable();
                $table->dateTime('last_generated_at')->nullable();
                $table->foreignIdFor(User::class, 'created_by')->constrained('users');
                $table->foreignIdFor(Tenant::class)->constrained();
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
