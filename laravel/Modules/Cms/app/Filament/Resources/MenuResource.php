<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Modules\Cms\Models\Menu;
use Illuminate\Support\HtmlString;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\UI\Filament\Forms\Components\IconPicker;
use Modules\Cms\Filament\Resources\MenuResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class MenuResource extends XotBaseResource
{
    protected static ?string $model = Menu::class;

    /**
     * @return array<Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'title' => Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(2048)
            // ->reactive()
            // ->unique()
            ,
            'items' => Forms\Components\Repeater::make('items')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('url')
                            // ->helperText('Se di tipo internal inserisci lo slug del titolo, se external inserisci l\'url completo (https://dominio)')
                            ->required()
                            ->columnSpan(1),
                    ]),

                    Forms\Components\Radio::make('type')
                        ->options([
                            'internal' => 'page slug',
                            'external' => 'external',
                            'route_name' => 'route name',
                        ])
                        ->helperText(new HtmlString('- "page slug" inserire nel campo Url lo slug del titolo di una pagina creata,
                                                    <br> - "external" inserire nel campo Url il l\'intero link di un sito esterno,
                                                    <br> - "route name" inserire nel campo Url il nome della route'))
                        ->default('internal')
                        ->required()
                        ->inline(),

                    SpatieMediaLibraryFileUpload::make('image')
                        // ->image()
                        // ->maxSize(5000)
                        // ->multiple()
                        // ->enableReordering()
                        ->openable()
                        ->downloadable()
                        ->columnSpanFull()
                        // ->collection('avatars')
                        // ->conversion('thumbnail')
                        ->disk('uploads')
                        ->directory('photos')
                        ->collection('menu')
                    // ->preserveFilenames()
                    ,
                    // Forms\Components\Select::make('parent_id')
                    //
                    //     ->options(
                    //         Menu::getTreeMenuOptions()
                    //     )
                    //     ->searchable(),
                    IconPicker::make('icon')
                        ->helperText('Visualizza le icone disponibili di https://heroicons.com/')
                        ->columns([
                            'default' => 1,
                            'lg' => 3,
                            '2xl' => 5,
                        ])
                    // ->layout(\Guava\FilamentIconPicker\Layout::ON_TOP)
                    ,
                ])
                ->columnSpanFull(),
        ];
    }

  
}
