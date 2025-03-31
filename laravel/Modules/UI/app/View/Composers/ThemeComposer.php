<?php

declare(strict_types=1);

namespace Modules\UI\View\Composers;

class ThemeComposer
{
    public function metatags(): \Illuminate\View\View
    {
        /**
         * @phpstan-var view-string
         */
        $view = 'ui::metatags';

        return view($view);
    }

    /**
     * @param string $index
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function metatag($index)
    {
        // $ris = self::__getStatic($index);
        // echo '<br/>['.$index.']['.$ris.']';
        // if ('' === $ris || null === $ris) {
        $ris = config('metatag.'.$index);
        // self::__setStatic($index, $ris);
        // }

        return $ris;
    }

    public function showScripts(): string
    {
        return '';
    }

    public function flag(string $lang): \Illuminate\View\View
    {
        $view = "ui::svg.flags.{$lang}";
        if (! view()->exists($view)) {
            throw new \Exception('view not exits ['.$view.']');
        }

        return view($view);
    }
}
