<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PosInterface extends Component
{
    public $cart = [];
    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;
    public $customer_id;
    public $payment_method = 'cash';
    public $cash_received = 0;
    public $change = 0;

    protected $listeners = ['productScanned' => 'addToCart'];

    //protected $layout = 'layouts.app'; // Usará el layout de Jetstream
    public $errorMessage = ''; //Variable para eeror validad para mostrar en navegador o dentro del sistema
///Para busqueda de customers
    public $customerSearch = '';

    public function updatedCustomerSearch($value)
    {
        $this->customer_id = null; // Resetear el ID seleccionado al buscar
    }

    public function selectCustomer($customerId)
    {
        $this->customer_id = $customerId;
        $this->customerSearch = Customer::find($customerId)->name;
    }
//////////
    public function addToCart($barcode)         
    {   
        //$this->reset('errorMessage');  Para eventos con navegador 
        $this->errorMessage = ''; // Reiniciar mensaje de error
        $product = Product::where('barcode', $barcode)->first();
        
        if (!$product) {
            //$this->dispatch('showAlert', message: 'Product not found', type: 'error'); // Mal planteado la Syntaxis
            //$this->dispatch('show-alert', ['message' => 'Product not found', 'type' => 'error']);   // Para alerta con navegador correcta
            $this->errorMessage = '⚠️ Producto no encontrado';  // Alerta interna en el sistema 
            return;
        }

        $found = false;
        foreach ($this->cart as &$item) {
            if ($item['id'] == $product->id) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'barcode' => $product->barcode
            ];
        }

        $this->calculateTotals();
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = array_reduce($this->cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        $this->tax = $this->subtotal * 0.10; // 10% tax
        $this->total = $this->subtotal + $this->tax;
        $this->change = $this->cash_received - $this->total;
    }

    public function completeSale()
    {
        DB::transaction(function () {

            // Para invoice_number , se puede cambiar el formato segun se requiera 
            $invoiceNumber = 'VEN-' . now()->format('YmdHis') . '-' . rand(100, 999);

            $sale = Sale::create([
                'cashier_id' => auth()->id(),
                'customer_id' => $this->customer_id,
                'invoice_number' => $invoiceNumber, //  Agregado
                'total_amount' => $this->total,
                'tax_amount' => $this->tax,
                'payment_method' => $this->payment_method,
                'payment_status' => 'paid',
                'status' => 'completed'
            ]);

            foreach ($this->cart as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                // Update inventory
                Product::where('id', $item['id'])->decrement('stock_quantity', $item['quantity']);
            }

            Payment::create([
                'payable_id' => $sale->id,
                'payable_type' => Sale::class,
                'amount' => $this->total,
                'payment_method' => $this->payment_method,
                'status' => 'completed'
            ]);
        });

        $this->reset();
        //$this->emit('saleCompleted');  // Ya no existe en versiones recientes de liveire
        $this->dispatch('saleCompleted');
    }

    public function render()
    {

        //Busqueda de customers
        $customersQuery = Customer::query();
    
        if ($this->customerSearch) {
            $customersQuery->where('name', 'like', '%'.$this->customerSearch.'%');
        }
        
        $selectedCustomerName = $this->customer_id 
            ? Customer::find($this->customer_id)->name 
            : null;
        //////
        return view('livewire.pos.pos-interface', [

            'products' => Product::all(), 
            //'customers' => Customer::all()
            'filteredCustomers' => $customersQuery->limit(10)->get(),
            'selectedCustomerName' => $selectedCustomerName
        ]);
    }
}