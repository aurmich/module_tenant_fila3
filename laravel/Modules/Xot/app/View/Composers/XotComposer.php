<?php

declare(strict_types=1);

namespace Modules\Xot\View\Composers;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Datas\XotData;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Laravel\Module as LaravelModule;
use Webmozart\Assert\Assert;

/**
 * Class XotComposer.
 */
class XotComposer
{
    /**
     * __call.
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (inAdmin()) {
            $prefix = 'adm_';
        } else {
            $prefix = 'pub_';
        }
        $name = $prefix.$name;
        $auth_user = auth()->user();
        if (method_exists($auth_user, $name)) {
            return $auth_user->{$name}();
        }
        return null;
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $lang = app()->getLocale();
        $view->with('lang', $lang);
        $view->with('_theme', $this);

        if (Auth::guard()->check()) {
            $profile = XotData::make()->getProfileModel();
            $view->with('_profile', $profile);
            $view->with('_user', auth()->user());
        }
    }

    public function asset(string $str): string
    {
        return asset(app(\Modules\Xot\Actions\File\AssetAction::class)->execute($str));
    }

    /**
     * Ottiene un metatag dal MetatagData.
     *
     * @param string $str Nome del metatag da ottenere
     * @return string|bool|null Valore del metatag
     */
    public function metatag(string $str): string|bool|null
    {
        $metatag = MetatagData::make();
        $fun = 'get'.Str::studly($str);
        if (method_exists($metatag, $fun)) {
            return $metatag->{$fun}();
        }

        return $metatag->{$str};
    }
}
