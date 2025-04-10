<?php

declare(strict_types=1);

namespace Modules\Dental\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Xot\Providers\XotBaseServiceProvider;

class DentalServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Dental';
    
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        parent::boot();
        $this->registerCommandSchedules();
    }

    /**
     * Register additional commands
     */
    public function registerCommands(): void
    {
        parent::registerCommands();
        $this->commands([
            \Modules\Dental\Console\Commands\SendAppointmentRemindersCommand::class,
        ]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(\Illuminate\Console\Scheduling\Schedule::class);
            
            // Invio promemoria per appuntamenti di domani ogni giorno alle 10:00
            $schedule->command('dental:send-appointment-reminders --days=1 --queue')
                ->dailyAt('10:00')
                ->appendOutputTo(storage_path('logs/appointment-reminders.log'));
            
            // Invio promemoria per appuntamenti della settimana prossima ogni lunedì alle 9:00
            $schedule->command('dental:send-appointment-reminders --days=7 --queue')
                ->weeklyOn(1, '9:00')
                ->appendOutputTo(storage_path('logs/appointment-reminders-weekly.log'));
        });
    }
}
