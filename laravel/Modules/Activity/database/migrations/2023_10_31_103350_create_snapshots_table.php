<?php

declare(strict_types=1);

// namespace Modules\Activity\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate( function ($table) {
            $table->bigIncrements('id');
            $table->uuid('aggregate_uuid');
            $table->unsignedInteger('aggregate_version');
            $table->jsonb('state');
            $table->index('aggregate_uuid');
        });

        $this->tableUpdate( function ($table) {
            $this->updateTimestamps($table, false);
        });
    }
};
