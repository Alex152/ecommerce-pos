<?php
// No hay columna DNI
namespace App\Http\Livewire\Pos;

use Livewire\Component;

class NotificationHandler extends Component
{
    public $message;
    public $type;
    public $show = false;

    protected $listeners = ['showNotification' => 'show',
                            'resetNotification' => 'resetNotification',];

    public function show($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
        $this->show = true;
        
        $this->dispatch('start-notification-timer');

    }

    public function resetNotification()
{
    $this->reset(['message', 'type', 'show']);
}


    public function render()
    {
        return view('livewire.pos.notification-handler');
    }
}