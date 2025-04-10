<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Webmozart\Assert\Assert;

// use Squire\Models\Country;

class AddressField extends Forms\Components\Field
{
    /** @var string|callable|null */
    public $relationship;

    protected string $view = 'filament-forms::components.group';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (AddressField $component, ?Model $record) {
            if ($record === null) {
                return;
            }

            $data = [
                'country' => null,
                'street' => null,
                'city' => null,
                'state' => null,
                'zip' => null,
            ];

            $relationship = $this->getRelationship();
            if (!$relationship) {
                return;
            }

            $address = $record->getRelationValue($relationship);
            if ($address !== null && is_object($address) && method_exists($address, 'toArray')) {
                $data = $address->toArray();
            }

            $component->state($data);
        });

        $this->dehydrated(false);
    }

    public function relationship(string|callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();
        $record = $this->getRecord();
        
        if ($record === null) {
            return;
        }

        $relationship = $this->getRelationship();
        if (!$relationship) {
            return;
        }

        $relation = $record->{$relationship}();
        if (!$relation) {
            return;
        }

        if ($address = $relation->first()) {
            $address->update($state);
        } else {
            $relation->updateOrCreate($state);
        }

        $record->touch();
    }

    public function getChildComponents(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Select::make('country')
                        ->searchable(),
                    // ->getSearchResultsUsing(fn (string $query) => Country::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                    // ->getOptionLabelUsing(fn ($value): ?string => Country::firstWhere('id', $value)->getAttribute('name')),
                ]),
            Forms\Components\TextInput::make('street')

                ->maxLength(255),
            Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\TextInput::make('city')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('state')

                        ->maxLength(255),
                    Forms\Components\TextInput::make('zip')

                        ->maxLength(255),
                ]),
        ];
    }

    public function getRelationship(): string
    {
        Assert::string($res = $this->evaluate($this->relationship) ?? $this->getName());

        return $res;
    }
}
