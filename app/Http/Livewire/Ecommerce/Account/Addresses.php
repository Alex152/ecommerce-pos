<?php

namespace App\Http\Livewire\Ecommerce\Account;

use Livewire\Component;
use App\Models\Address;

class Addresses extends Component
{
    public $addresses;
    public $editingAddress = null;
    public $form = [
        'first_name' => '',
        'last_name' => '',
        'address_1' => '',
        'address_2' => '',
        'city' => '',
        'state' => '',
        'zip_code' => '',
        'country' => 'US',
        'phone' => '',
        'is_default' => false
    ];

    protected $rules = [
        'form.first_name' => 'required',
        'form.last_name' => 'required',
        'form.address_1' => 'required',
        'form.city' => 'required',
        'form.state' => 'required',
        'form.zip_code' => 'required',
        'form.country' => 'required',
        'form.phone' => 'required'
    ];

    public function mount()
    {
        $this->addresses = auth()->user()->addresses;
    }

    public function editAddress($id)
    {
        $this->editingAddress = Address::find($id);
        $this->form = $this->editingAddress->toArray();
    }

    public function saveAddress()
    {
        $this->validate();

        if ($this->form['is_default']) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        if ($this->editingAddress) {
            $this->editingAddress->update($this->form);
        } else {
            auth()->user()->addresses()->create($this->form);
        }

        $this->reset(['editingAddress', 'form']);
        $this->addresses = auth()->user()->fresh()->addresses;
    }

    public function deleteAddress($id)
    {
        Address::find($id)->delete();
        $this->addresses = auth()->user()->fresh()->addresses;
    }

    public function render()
    {
        return view('livewire.ecommerce.account.addresses')
            ->layout('layouts.ecommerce', [
                'title' => 'Mis Direcciones',
                'headerStyle' => 'bg-white shadow-sm'
            ]);
    }
}