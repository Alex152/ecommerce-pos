<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Jetstream\Agent;

class SessionSecurityService
{
    public function logNewSession(): void
    {
        $agent = new Agent;
        $session = [
            'ip' => request()->ip(),
            'device' => $agent->device(), // Método compatible
            'platform' => $agent->platform(), // Método compatible
            'browser' => $agent->browser(), // Método compatible
            'last_active' => now(),
        ];

        Session::put('current_session', $session);
    }

    protected function simplifyDeviceType(Agent $agent): string
    {
        return $agent->isMobile() ? 'mobile' : 'desktop';
    }
    //Revisar getActiveSessions , no es seguro que sea compatible con agente de jeetstream
    /*public function getActiveSessions(): array
    {
        return Auth::user()->sessions ?? [];
    }*/
}