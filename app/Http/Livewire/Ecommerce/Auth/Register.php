<?php

namespace App\Http\Livewire\Ecommerce\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $terms = false;
    public $error = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'terms' => 'accepted'
    ];

    public function register()
    {
        $this->validate();

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            auth()->login($user);

            return redirect()->intended(route('ecommerce.account.dashboard'));
        } catch (\Exception $e) {
            $this->error = 'Ocurrió un error al registrar la cuenta. Por favor intenta nuevamente.';
        }
    }

    public function render()
    {
        return view('livewire.ecommerce.auth.register')
            ->layout('layouts.ecommerce', [
                'title' => 'Crear Cuenta',
                'hideAuthLinks' => true
            ]);
    }
}