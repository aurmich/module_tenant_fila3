<?php

declare(strict_types=1);

namespace Modules\Tenant\Console\Commands;

use Illuminate\Console\Command;
use Modules\Tenant\Services\TenantService;

class TestCommand extends Command
{
    /** @var string */
    protected $signature = 'tenant:test';

    /** @var string */
    protected $description = 'Check Tenant';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $name = TenantService::getName();
<<<<<<< HEAD
        $this->info('tenant name :' . $name);
=======
        $this->info('tenant name :'.$name);
>>>>>>> 1cbc182 (.)
    }
}
