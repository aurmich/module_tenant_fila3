<?php

declare(strict_types=1);

namespace Modules\Dental\Console\Commands;

use Illuminate\Console\Command;
use Modules\Dental\Actions\SendAppointmentRemindersAction;

class SendAppointmentRemindersCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'dental:send-appointment-reminders 
                            {--days=1 : Numero di giorni prima dell\'appuntamento per cui inviare il promemoria}
                            {--batch=50 : Dimensione del batch di elaborazione}
                            {--queue : Esegui il comando in modo asincrono tramite code}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Invia promemoria per gli appuntamenti imminenti';

    /**
     * Esegue il comando console.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        $batchSize = (int) $this->option('batch');
        $useQueue = (bool) $this->option('queue');
        
        $this->info("Invio promemoria per appuntamenti tra {$days} giorni...");
        
        try {
            // Prepara l'azione
            $action = app(SendAppointmentRemindersAction::class);
            
            // Esegui l'azione in modo sincrono o asincrono
            if ($useQueue) {
                $this->info('Esecuzione in modalità asincrona (su coda)...');
                $action->onQueue('notifications')->execute($days, $batchSize);
                $this->info('Richiesta di invio promemoria accodata con successo.');
                return Command::SUCCESS;
            } else {
                $this->info('Esecuzione in modalità sincrona...');
                $remindersSent = $action->execute($days, $batchSize);
                $this->info("Inviati {$remindersSent} promemoria con successo.");
                return Command::SUCCESS;
            }
        } catch (\Exception $e) {
            $this->error('Errore durante l\'invio dei promemoria: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
