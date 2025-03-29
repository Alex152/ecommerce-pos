<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Jetstream;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $terms = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'terms' => 'required|accepted',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Asignar rol de "customer"
        $user->assignRole('customer');

        Auth::login($user);

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}