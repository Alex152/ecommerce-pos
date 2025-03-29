<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\ConfirmsPasswords;

class UserSecurity extends Component
{
    use ConfirmsPasswords;

    public $sessions = [];
    public $confirmingPassword = false;

    public function mount()
    {
        $this->sessions = Auth::user()->sessions;
    }

    public function logoutOtherSessions()
    {
        $this->ensurePasswordIsConfirmed();

        Auth::logoutOtherDevices(request('password'));
        $this->emit('sessionsCleared');
    }

    public function render()
    {
        return view('livewire.user-security');
    }
}