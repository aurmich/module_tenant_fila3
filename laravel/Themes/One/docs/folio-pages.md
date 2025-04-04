# Struttura delle Pagine con Laravel Folio

## Introduzione

Laravel Folio viene utilizzato per gestire le pagine frontend del tema One. Questo documento spiega come sono organizzate le pagine e quali convenzioni seguire.

## Struttura delle Directory

```
Themes/One/resources/views/pages/
├── index.blade.php             # Homepage principale
├── about.blade.php             # Pagina "Chi siamo"
├── pages/                      # Sottocartella per le pagine dinamiche
│   ├── index.blade.php         # Indice delle pagine dinamiche
│   └── [slug].blade.php        # Gestore per le pagine dinamiche dal CMS
└── ... altre sezioni ...
```

## Convenzioni di Nomenclatura

Laravel Folio utilizza delle convenzioni specifiche:

- `/` → `index.blade.php`
- `/pages` → `pages/index.blade.php` 
- `/pages/{slug}` → `pages/[slug].blade.php`

## File [slug].blade.php

Il file `[slug].blade.php` gestisce le pagine dinamiche create attraverso il CMS:

```php
<?php
use Modules\Cms\Models\Page;
use Illuminate\View\View;
use function Laravel\Folio\{withTrashed, name, render};

withTrashed();
name('page_slug.view');

render(function (View $view, string $slug) {
    $locale = app()->getLocale();
    $page = Page::firstWhere(['slug' => $slug]);
    
    return $view->with('page', $page);
});
?>

<x-layouts.marketing>
    <!-- Template della pagina -->
</x-layouts.marketing>
```

## File index.blade.php per le Pagine

Il file `pages/index.blade.php` dovrebbe visualizzare un elenco delle pagine disponibili. Ecco un esempio base:

```php
<?php
use Modules\Cms\Models\Page;
use Illuminate\View\View;
use function Laravel\Folio\render;

render(function (View $view) {
    $pages = Page::all();
    return $view->with('pages', $pages);
});
?>

<x-layouts.marketing>
    <div class="max-w-[996px] mx-auto pb-12">
        <div class="py-10">
            <h1 class="text-[2rem] mb-4 font-semibold">
                Tutte le Pagine
            </h1>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pages as $page)
                <a href="{{ url('/pages/' . $page->slug) }}" class="block p-6 bg-white shadow-sm rounded-lg hover:shadow-md transition">
                    <h2 class="text-xl font-semibold mb-2">{{ $page->title }}</h2>
                    <!-- Eventuale descrizione o anteprima -->
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.marketing>
```

## Integrazione con il CMS

Il tema One utilizza questi helper per renderizzare i contenuti delle pagine:

- `$_theme->showPageContent($slug)`: Renderizza i blocchi principali
- `$_theme->showPageSidebarContent($slug)`: Renderizza i blocchi della sidebar

## Best Practices

1. Utilizzare sempre il layout appropriato (`<x-layouts.marketing>` per le pagine pubbliche)
2. Seguire le convenzioni di nomenclatura di Laravel Folio
3. Gestire correttamente i casi in cui la pagina non viene trovata
4. Utilizzare responsive design per tutte le pagine

## Creazione di Nuove Pagine

Per creare una nuova pagina nel tema One:

1. Decidere se si tratta di una pagina statica o dinamica
2. Per pagine statiche, creare un nuovo file `.blade.php` nella directory appropriata
3. Per pagine dinamiche, utilizzare l'interfaccia amministrativa Filament

## Troubleshooting

- Se una pagina non viene visualizzata, verificare che il percorso URL sia corretto
- Verificare che il modello `Page` contenga lo slug corretto
- Controllare i logs per eventuali errori 
