<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Volt\Component;
<<<<<<< HEAD
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Illuminate\Support\HtmlString;
=======
use Livewire\Attributes\Validate;
>>>>>>> 5079a23a (.)
use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('register');

new class extends Component
{
<<<<<<< HEAD
    
};


?>

<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12">
        <div class="max-w-lg mx-auto px-6">
            <!-- Logo e intestazione -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <x-ui.logo class="h-12 text-blue-900" />
                </div>
                <h1 class="text-3xl font-light text-blue-900">Benvenuto in <span class="font-bold">SaluteOra</span></h1>
                <p class="text-gray-600 mt-2">Crea il tuo account per accedere a tutti i servizi</p>
            </div>
            
            <!-- Card contenente il form di registrazione -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Intestazione card -->
                <div class="bg-blue-900 px-6 py-4">
                    <h2 class="text-xl font-medium text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Registrazione
                    </h2>
                </div>
                
                <!-- Form di registrazione -->
                <div class="p-6">
                    @livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class)
                </div>
            </div>
            
            <!-- Footer con informazioni aggiuntive -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>Hai bisogno di assistenza? <a href="#" class="text-blue-800 hover:underline">Contattaci</a></p>
            </div>
        </div>
    </div>
</x-layouts.app>
=======
    #[Validate('required')]
    public $name = '';

    #[Validate('required|email|unique:users')]
    public $email = '';

    #[Validate('required|min:8|same:passwordConfirmation')]
    public $password = '';

    #[Validate('required|min:8|same:password')]
    public $passwordConfirmation = '';

    public function register()
    {
        $this->validate();

        $user = User::create([
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended('/');
    }
};

?>

<x-layouts.main>

    <div class="flex flex-col items-stretch justify-center w-screen min-h-screen py-10 sm:items-center">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-ui.link href="{{ route('home') }}">
                <x-ui.logo class="w-auto h-10 mx-auto text-gray-700 fill-current dark:text-gray-100" />
            </x-ui.link>
            <h2 class="mt-5 text-2xl font-extrabold leading-9 text-center text-gray-800 dark:text-gray-200">Create a new
                account</h2>
            <div class="text-sm leading-5 text-center text-gray-600 dark:text-gray-400 space-x-0.5">
                <span>Or</span>
                <x-ui.text-link href="{{ route('login') }}">sign in to your account</x-ui.text-link>
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="px-10 py-0 sm:py-8 sm:shadow-sm sm:bg-white dark:sm:bg-gray-950/50 dark:border-gray-200/10 sm:border sm:rounded-lg border-gray-200/60">
                @volt('auth.register')
                <form wire:submit="register" class="space-y-6">
                    <x-ui.input label="Name" type="text" id="name" name="name" wire:model="name" />
                    <x-ui.input label="Email address" type="email" id="email" name="email" wire:model="email" />
                    <x-ui.input label="Password" type="password" id="password" name="password" wire:model="password" />
                    <x-ui.input label="Confirm Password" type="password" id="password_confirmation" name="password_confirmation" wire:model="passwordConfirmation" />
                    <x-ui.button type="primary" rounded="md" submit="true">Register</x-ui.button>
                </form>
                @endvolt
            </div>
        </div>

    </div>

</x-layouts.main>
>>>>>>> 5079a23a (.)
