<?php

namespace App\Http\Livewire\Ecommerce\Checkout;

use Livewire\Component;
use App\Models\Order;
use App\Models\Address;
use Cart;

class CheckoutWizard extends Component
{
    public $currentStep = 1;
    public $shippingAddress = [];
    public $billingSameAsShipping = true;
    public $billingAddress = [];
    public $shippingMethod = 'standard';
    public $paymentMethod = 'credit_card';
    public $cardDetails = [
        'number' => '',
        'name' => '',
        'expiry' => '',
        'cvc' => ''
    ];

    protected $listeners = ['cartUpdated' => 'checkCart'];

    public function mount()
    {
        $this->checkCart();
        
        // Load user addresses if authenticated
        if (auth()->check()) {
            $this->loadUserAddresses();
        }
    }

    public function checkCart()
    {
        if (\Cart::count() === 0) {
            return redirect()->route('ecommerce.cart');
        }
    }

    public function loadUserAddresses()
    {
        $user = auth()->user();
        $defaultAddress = $user->addresses()->where('is_default', true)->first();
        
        if ($defaultAddress) {
            $this->shippingAddress = $defaultAddress->toArray();
        }
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function validateCurrentStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'shippingAddress.first_name' => 'required',
                'shippingAddress.last_name' => 'required',
                'shippingAddress.address_1' => 'required',
                'shippingAddress.city' => 'required',
                'shippingAddress.state' => 'required',
                'shippingAddress.zip_code' => 'required',
                'shippingAddress.country' => 'required',
                'shippingAddress.phone' => 'required',
            ]);
            
            if (!$this->billingSameAsShipping) {
                $this->validate([
                    'billingAddress.first_name' => 'required',
                    'billingAddress.last_name' => 'required',
                    'billingAddress.address_1' => 'required',
                    'billingAddress.city' => 'required',
                    'billingAddress.state' => 'required',
                    'billingAddress.zip_code' => 'required',
                    'billingAddress.country' => 'required',
                ]);
            }
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'shippingMethod' => 'required',
            ]);
        } elseif ($this->currentStep === 3) {
            $this->validate([
                'paymentMethod' => 'required',
            ]);
            
            if ($this->paymentMethod === 'credit_card') {
                $this->validate([
                    'cardDetails.number' => 'required|digits:16',
                    'cardDetails.name' => 'required',
                    'cardDetails.expiry' => 'required|regex:/^\d{2}\/\d{2}$/',
                    'cardDetails.cvc' => 'required|digits:3',
                ]);
            }
        }
    }

    public function placeOrder()
    {
        $this->validateCurrentStep();
        
        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'subtotal' => \Cart::SubTotal(),
            'shipping' => $this->getShippingCost(),
            'tax' => 0, // Calculate tax based on location
            'total' => \Cart::Total() + $this->getShippingCost(),
            'shipping_method' => $this->shippingMethod,
            'payment_method' => $this->paymentMethod,
        ]);
        
        // Add shipping address
        $order->shippingAddress()->create($this->shippingAddress);
        
        // Add billing address
        $billingAddress = $this->billingSameAsShipping ? $this->shippingAddress : $this->billingAddress;
        $order->billingAddress()->create($billingAddress);
        
        // Add order items
        foreach (\Cart::Content() as $item) {
            $order->items()->create([
                'product_id' => $item->associatedModel->id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'total' => $item->price * $item->quantity,
                'attributes' => [
                    'product_slug' => $item->slug,
                    'image_url' => $item->getFirstMediaUrl('main_image', 'thumb') // URL directa
    ],

            ]);
        }
        
        // Clear cart
        \Cart::clear();
        
        // Redirect to thank you page
        return redirect()->route('ecommerce.checkout.success', $order);
    }

    public function getShippingCost()
    {
        return $this->shippingMethod === 'express' ? 15.00 : 5.00;
    }

    public function render()
    {
        return view('livewire.ecommerce.checkout.checkout-wizard')
            ->layout('layouts.ecommerce', [
                'title' => 'Checkout - Paso ' . $this->currentStep,
                'hideCart' => true
            ]);
    }
}