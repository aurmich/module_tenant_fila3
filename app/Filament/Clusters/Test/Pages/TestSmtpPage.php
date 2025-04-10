<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Datas\SmtpData;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

/**
 * @property ComponentContainer $emailForm
 */
class TestSmtpPage extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $emailData = [];

    public ?string $error_message = null;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static string $view = 'notify::filament.pages.send-email';

    protected static ?string $cluster = Test::class;

    public function mount(): void
    {
        $this->fillForms();
    }

    public function emailForm(Form $form): Form
    {
        Assert::isArray($mail_config = config('mail'));
        $smtpConfig = Arr::get($mail_config, 'mailers.smtp');

        $this->emailData['subject'] = 'test';
        $defaultEmail = XotData::make()->super_admin;

        return $form
            ->schema(
                [
                    Section::make('SMTP')
                        ->schema(
                            [
                                Forms\Components\TextInput::make('host'),
                                Forms\Components\TextInput::make('port')
                                    ->numeric(),
                                Forms\Components\TextInput::make('username'),
                                Forms\Components\TextInput::make('password'),
                                Forms\Components\TextInput::make('encryption'),
                            ]
                        )->columns(3),
                    Section::make('MAIL')
                        ->schema(
                            [
                                Forms\Components\TextInput::make('from_email')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('from'),
                                Forms\Components\TextInput::make('to')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('subject')
                                    ->default('test')
                                    ->required(),
                                Forms\Components\RichEditor::make('body_html')
                                    ->default('test body')
                                    ->required()
                                    ->columnSpanFull(),
                            ]
                        )->columns(3),
                ]
            )
            ->statePath('emailData');
    }

    public function sendEmail(): void
    {
        $data = $this->emailForm->getState();
        $smtp = SmtpData::from($data);
        $emailData = EmailData::from($data);
        $smtp->send($emailData);

        Notification::make()
            ->success()
            ->title(__('Controlla il tuo client di posta'))
            ->send();
    }

    protected function getForms(): array
    {
        return ['emailForm'];
    }

    protected function getEmailFormActions(): array
    {
        return [
            Action::make('emailFormActions')
                ->submit('emailFormActions'),
        ];
    }

    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (! $user instanceof Model) {
            throw new \Exception('L\'utente autenticato deve essere un modello Eloquent per consentire l\'aggiornamento della pagina del profilo.');
        }

        return $user;
    }

    protected function fillForms(): void
    {
        Assert::isArray($mail_config = config('mail'));
        Assert::isArray($smtpConfig = Arr::get($mail_config, 'mailers.smtp'));

        $typedConfig = [];
        foreach ($smtpConfig as $key => $value) {
            if (is_string($key)) {
                $typedConfig[$key] = $value;
            }
        }

        $this->emailForm->fill($typedConfig);
    }
}
