<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
// use Modules\Cms\Filament\Resources\PageContentResource\RelationManagers;
use Filament\Forms\Form;
// use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Support\Str;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Cms\Filament\Resources\PageContentResource\Pages;
use Modules\Cms\Models\PageContent;
use Modules\Xot\Filament\Resources\XotBaseResource;

// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageContentResource extends XotBaseResource
{
    use Translatable;

    protected static ?string $model = PageContent::class;

    public static function getTranslatableLocales(): array
    {
        return ['it', 'en'];
    }

    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->lazy()
                ->afterStateUpdated(static function (Forms\Set $set, Forms\Get $get, string $state): void {
                    if ($get('slug')) {
                        return;
                    }
                    $set('slug', Str::slug($state));
                }),

            'slug' => Forms\Components\TextInput::make('slug')
                ->required()
                ->afterStateUpdated(static fn (Forms\Set $set, string $state) => $set('slug', Str::slug($state))),

            'blocks' => Forms\Components\Section::make('Content')->schema([
                PageContentBuilder::make('blocks')
                    ->columnSpanFull(),
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageContents::route('/'),
            'create' => Pages\CreatePageContent::route('/create'),
            'view' => Pages\ViewPageContent::route('/{record}'),
            'edit' => Pages\EditPageContent::route('/{record}/edit'),
        ];
    }
}
