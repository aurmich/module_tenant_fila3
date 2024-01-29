<?php

declare(strict_types=1);

namespace Modules\Blog\Http\Livewire;

use Illuminate\Support\Arr;
use Modules\Blog\Models\Order;
use Filament\Widgets\ChartWidget;

class ArticleChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts';

    public string $type_chart;
    public string $article_id;
    public array $optionsRatingsIdTitle;
    public array $datasets = [];

    protected function getData(): array
    {
        $data_article = Order::where('article_id', $this->article_id)
            ->get()
            ->sortBy('date')
            // ->take(-20)
            // ->toArray()
            // ->groupBy('date')
            // ->map(function($value){
            //     dddx($value);
            // })
            ;

        $labels = [];

        $tmp_labels = array_unique(Arr::pluck($data_article->toArray(), 'date'));
        foreach($tmp_labels as $lbl){
            $labels[] = $lbl;
        }

        $data_chart = [];

        foreach($this->optionsRatingsIdTitle as $key => $opt){
            $data_options = $data_article->where('rating_id', $key);
            $tmp = [];
            foreach($labels as $date){
                $data_option = $data_options->where('date', $date)->first();
                if($data_option == null){
                    $tmp[] = 0;
                }else{
                    $tmp[] = $data_option->bet_credits;
                }
            }
            $data_chart['datasets'][] = ['label' => $opt, 'data' => $tmp];
        }

        $data_chart['labels'] = $labels;

        return $data_chart;
    }

    protected function getType(): string
    {
        return $this->type_chart;
    }
}
