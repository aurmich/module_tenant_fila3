<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Modules\Cms\Filament\Resources\MenuResource\Pages;
use Modules\Cms\Models\Menu;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MenuResource extends XotBaseResource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationLabel = 'Navigation';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(2048),
            Forms\Components\Repeater::make('items')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('url')
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
                        ->openable()
                        ->downloadable()
                        ->columnSpanFull()
                        ->disk('uploads')
                        ->directory('photos')
                        ->collection('menu'),

                    Forms\Components\TextInput::make('icon')
                        ->helperText('Inserisci il nome dell\'icona da https://heroicons.com/')
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ];
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
