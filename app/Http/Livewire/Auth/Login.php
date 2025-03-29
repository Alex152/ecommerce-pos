<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Jetstream;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            return $this->addError('email', __('auth.failed'));
        }

        return redirect()->intended(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}