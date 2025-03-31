<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Models\Dentist;
use Modules\Patient\Models\Patient;
use Modules\Dental\Filament\Resources\AppointmentResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class AppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;
    
    public static function getFormSchema(): array
    {
        return [
            'patient_id' => Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'full_name')
                ->searchable()
                ->preload()
                ->createOptionForm(
                    fn (Forms\Get $get): array => Patient::getFormSchema()
                )
                ->required(),
                
            'dentist_id' => Forms\Components\Select::make('dentist_id')
                ->relationship('dentist', 'full_name')
                ->searchable()
                ->preload()
                ->required(),
                
            'start_time' => Forms\Components\DateTimePicker::make('start_time')
                ->required(),
                
            'end_time' => Forms\Components\DateTimePicker::make('end_time')
                ->after('start_time'),
                
            'treatment_id' => Forms\Components\Select::make('treatment_id')
                ->relationship('treatment', 'name')
                ->searchable()
                ->preload(),
                
            'status' => Forms\Components\Select::make('status')
                ->options([
                    'scheduled' => 'Programmato',
                    'confirmed' => 'Confermato',
                    'in_progress' => 'In Corso',
                    'completed' => 'Completato',
                    'cancelled' => 'Annullato',
                    'no_show' => 'Non Presentato',
                ])
                ->default('scheduled')
                ->required(),
                
            'notes' => Forms\Components\Textarea::make('notes')
                ->maxLength(1000)
                ->columnSpanFull(),
                
            'eligibility_confirmed' => Forms\Components\Toggle::make('eligibility_confirmed')
                ->default(false),
        ];
    }
    
    public static function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                
            'patient.full_name' => Tables\Columns\TextColumn::make('patient.full_name')
                ->searchable()
                ->sortable(),
                
            'dentist.full_name' => Tables\Columns\TextColumn::make('dentist.full_name')
                ->searchable()
                ->sortable(),
                
            'start_time' => Tables\Columns\TextColumn::make('start_time')
                ->dateTime()
                ->sortable(),
                
            'treatment.name' => Tables\Columns\TextColumn::make('treatment.name')
                ->searchable(),
                
            'status' => Tables\Columns\SelectColumn::make('status')
                ->options([
                    'scheduled' => 'Programmato',
                    'confirmed' => 'Confermato',
                    'in_progress' => 'In Corso',
                    'completed' => 'Completato',
                    'cancelled' => 'Annullato',
                    'no_show' => 'Non Presentato',
                ])
                ->sortable(),
                
            'eligibility_confirmed' => Tables\Columns\IconColumn::make('eligibility_confirmed')
                ->boolean()
                ->sortable(),
                
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
    
    public static function getListTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'scheduled' => 'Programmato',
                    'confirmed' => 'Confermato',
                    'in_progress' => 'In Corso',
                    'completed' => 'Completato',
                    'cancelled' => 'Annullato',
                    'no_show' => 'Non Presentato',
                ]),
                
            Tables\Filters\Filter::make('eligibility_confirmed')
                ->query(fn (Builder $query): Builder => $query->where('eligibility_confirmed', true))
                ->toggle(),
                
            Tables\Filters\Filter::make('today')
                ->query(fn (Builder $query): Builder => $query->whereDate('start_time', today()))
                ->toggle(),
                
            Tables\Filters\Filter::make('upcoming')
                ->query(fn (Builder $query): Builder => $query->whereDate('start_time', '>=', today()))
                ->toggle(),
                
            Tables\Filters\DateFilter::make('start_time'),
        ];
    }
}
