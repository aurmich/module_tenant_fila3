<?php
/**
 * --.
 */
declare(strict_types=1);

namespace Modules\Notify\Models\Panels\Actions;

// -------- services --------

use Modules\Notify\Services\MailService;
use Modules\Theme\Services\ThemeService;
use Modules\Xot\Models\Panels\Actions\XotBasePanelAction;

// -------- bases -----------

/**
 * Class TrySendMailAction.
 */
class TrySendMailAction extends XotBasePanelAction {
    public bool $onItem = true;
    public string $icon = '<i class="fas fa-vial"></i>TrySendMail';

    /**
     * @return mixed
     */
    public function handle() {
        $view = ThemeService::getView();

        $view_params = [
            'view' => $view,
        ];

        return view()->make($view, $view_params);
    }

    /**
     * ---.
     */
    public function postHandle() {
        $data = request()->all();
        dddx($data);
        try {
            Mail::raw($data['body'], function ($msg) {
                $msg->to($data['to'])->subject('Test Email');
            });
        } catch (ErrorException $e) {
            throw new Exception('['.__LINE__.']['.__FILE__.']');
        }
    }
}
