<?php

declare(strict_types=1);

namespace Modules\Reporting\Tests\Unit\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Reporting\Actions\GenerateReportAction;
use Modules\Reporting\Models\Report;
use Modules\Reporting\Models\ReportData;
use Modules\Reporting\Services\ReportGenerator;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class GenerateReportActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test che l'azione generi correttamente un report.
     */
    public function testExecuteGeneratesReport(): void
    {
        // Crea un mock del ReportGenerator
        $this->mock(ReportGenerator::class, function (MockInterface $mock) {
            $mock->shouldReceive('generate')
                ->once()
                ->andReturn(true);
        });

        // Crea un record di report
        $report = new Report();
        $report->name = 'Test Report';
        $report->description = 'Report di test';
        $report->type = 'paziente_demografico';
        $report->period_start = now()->subDays(30);
        $report->period_end = now();
        $report->status = 'pending';
        $report->parameters = ['param1' => 'value1'];
        $report->created_by = 1;
        $report->tenant_id = 1;
        $report->save();

        // Parametri aggiuntivi
        $parameters = [
            'additional_param' => 'additional_value'
        ];

        // Esegui l'azione
        $action = app(GenerateReportAction::class);
        $action->execute($report, $parameters);

        // Verifica che lo stato del report sia stato aggiornato a 'completed'
        $updatedReport = Report::find($report->id);
        $this->assertEquals('completed', $updatedReport->status);
        $this->assertNotNull($updatedReport->last_generated_at);
    }

    /**
     * Test che l'azione gestisca correttamente gli errori.
     */
    public function testExecuteHandlesErrors(): void
    {
        // Crea un mock del ReportGenerator che lancia un'eccezione
        $this->mock(ReportGenerator::class, function (MockInterface $mock) {
            $mock->shouldReceive('generate')
                ->once()
                ->andThrow(new \Exception('Errore di test'));
        });

        // Crea un record di report
        $report = new Report();
        $report->name = 'Test Report';
        $report->description = 'Report di test';
        $report->type = 'paziente_demografico';
        $report->period_start = now()->subDays(30);
        $report->period_end = now();
        $report->status = 'pending';
        $report->parameters = ['param1' => 'value1'];
        $report->created_by = 1;
        $report->tenant_id = 1;
        $report->save();

        // Ci aspettiamo un'eccezione
        $this->expectException(\Exception::class);

        // Esegui l'azione
        $action = app(GenerateReportAction::class);
        $action->execute($report, []);

        // Verifica che lo stato del report sia stato aggiornato a 'error'
        $updatedReport = Report::find($report->id);
        $this->assertEquals('error', $updatedReport->status);
    }

    /**
     * Test che l'azione unisca correttamente i parametri.
     */
    public function testParametersMerging(): void
    {
        // Crea un mock del ReportGenerator che ci permette di verificare i parametri
        $this->mock(ReportGenerator::class, function (MockInterface $mock) {
            $mock->shouldReceive('generate')
                ->once()
                ->withArgs(function ($type, $parameters, $userId, $tenantId) {
                    // Verifica che i parametri originali e quelli aggiuntivi siano stati uniti
                    return $parameters['param1'] === 'value1' && 
                           $parameters['additional_param'] === 'additional_value' &&
                           $parameters['name'] === 'Test Report';
                })
                ->andReturn(true);
        });

        // Crea un record di report
        $report = new Report();
        $report->name = 'Test Report';
        $report->description = 'Report di test';
        $report->type = 'paziente_demografico';
        $report->period_start = now()->subDays(30);
        $report->period_end = now();
        $report->status = 'pending';
        $report->parameters = ['param1' => 'value1'];
        $report->created_by = 1;
        $report->tenant_id = 1;
        $report->save();

        // Parametri aggiuntivi
        $parameters = [
            'additional_param' => 'additional_value'
        ];

        // Esegui l'azione
        $action = app(GenerateReportAction::class);
        $action->execute($report, $parameters);

        // Verifica che lo stato del report sia stato aggiornato a 'completed'
        $updatedReport = Report::find($report->id);
        $this->assertEquals('completed', $updatedReport->status);
    }

    /**
     * Test che l'azione pulisca i dati precedenti prima di generare un nuovo report.
     */
    public function testReportDataCleanupBeforeGeneration(): void
    {
        // Crea un mock del ReportGenerator
        $this->mock(ReportGenerator::class, function (MockInterface $mock) {
            $mock->shouldReceive('generate')
                ->once()
                ->andReturn(true);
        });

        // Crea un record di report
        $report = new Report();
        $report->name = 'Test Report';
        $report->description = 'Report di test';
        $report->type = 'paziente_demografico';
        $report->period_start = now()->subDays(30);
        $report->period_end = now();
        $report->status = 'pending';
        $report->parameters = ['param1' => 'value1'];
        $report->created_by = 1;
        $report->tenant_id = 1;
        $report->save();

        // Aggiungi alcuni dati al report
        $reportData = new ReportData();
        $reportData->report_id = $report->id;
        $reportData->key = 'test_key';
        $reportData->value = 'test_value';
        $reportData->data_type = 'string';
        $reportData->description = 'Dati di test';
        $reportData->order = 1;
        $reportData->group = 'test_group';
        $reportData->save();

        // Verifica che ci sia un record di dati
        $this->assertEquals(1, ReportData::where('report_id', $report->id)->count());

        // Esegui l'azione
        $action = app(GenerateReportAction::class);
        $action->execute($report, []);

        // Verifica che i dati precedenti siano stati eliminati
        // Note: assumes that the mock ReportGenerator doesn't actually create new ReportData records
        $this->assertEquals(0, ReportData::where('report_id', $report->id)->count());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
