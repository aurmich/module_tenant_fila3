<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Command;

use Illuminate\Console\Application;
use Modules\Job\Datas\CommandData;
use Spatie\LaravelData\DataCollection;

class GetCommandsAction
{
    public function __construct(
        private readonly Application $application
    ) {}

    /**
     * Execute the action.
     *
     * @return DataCollection<CommandData>
     */
    public function execute(): DataCollection
    {
        $commands = collect($this->application->all())->map(function ($command) {
            $name = $command->getName();
            $description = $command->getDescription();
            $arguments = collect($command->getDefinition()->getArguments())
                ->map(function ($argument) {
                    return [
                        'name' => $argument->getName(),
                        'description' => $argument->getDescription(),
                        'required' => $argument->isRequired(),
                    ];
                })->values();

            $options = collect($command->getDefinition()->getOptions())
                ->map(function ($option) {
                    return [
                        'name' => $option->getName(),
                        'description' => $option->getDescription(),
                        'required' => $option->isValueRequired(),
                    ];
                })->values();

            return CommandData::from([
                'name' => $name,
                'full_name' => $name.' - '.$description,
                'description' => $description,
                'arguments' => $arguments->toArray(),
                'options' => [
                    'withValue' => $options->toArray(),
                ],
            ]);
        });

        return new DataCollection(CommandData::class, $commands->values()->all());
    }
}
