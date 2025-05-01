<?php

namespace App\Http\Livewire\Ecommerce\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $error = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            return redirect()->intended(route('ecommerce.account.dashboard'));
        }

        $this->error = 'Credenciales incorrectas. Por favor intenta nuevamente.';
    }

    public function render()
    {
        return view('livewire.ecommerce.auth.login')
            ->layout('layouts.ecommerce', [
                'title' => 'Iniciar Sesión',
                'hideAuthLinks' => true
            ]);
    }
}