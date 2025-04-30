<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PosInterface extends Component
{
    use WithPagination;

    public $search = '';
    public $barcodeInput = '';
    public $customerSearch = '';
    public $selectedCustomer = null;
    public $selectedCustomerName = '';
    public $payment_method = 'cash';
    public $cash_received = 0;
    
    public $cart = [];
    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;
    public $change = 0;

    protected $listeners = ['barcodeScanned' => 'handleBarcode'];

    public function handleBarcode($barcode)
    {
        $this->barcodeInput = $barcode;
        $this->searchByBarcode();
    }

    public function searchByBarcode()
    {
        if (!empty($this->barcodeInput)) {
            $product = Product::where('barcode', $this->barcodeInput)->first();
            
            if ($product) {
                $this->addToCart($product->id);
                $this->barcodeInput = '';
                /*
                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => $product->name.' added to cart'
                ]);*/

                $this->dispatch('showNotification', 
                    type: 'success', 
                    message: ' añadido al carrito'
                );
            } else {
                /*$this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Product not found with barcode: '.$this->barcodeInput
                ]);*/
                $this->dispatch('showNotification', 
                    type: 'error', 
                    message: ' Producto no encontrado con barcode: '.$this->barcodeInput
                );
            }
        }
    }

    public function searchCustomer()
    {
        // La búsqueda se hace automáticamente con wire:model.live
    }

    public function addToCart($productId)
    {
        $product = Product::with('media')->findOrFail($productId);

        // Verificar stock antes de añadir
        if ($product->manage_stock && $product->stock_quantity <= 0) {
            $this->dispatch('showNotification',
                type: 'error',
                message: 'Sin stock disponible para '.$product->name
            );
            return;
        }   
        ///////////////

        $existingIndex = collect($this->cart)->search(function ($item) use ($productId) {
            return $item['id'] == $productId;
        });
        
        if ($existingIndex !== false) {

            // Verificar si al incrementar excede stock
            if ($product->manage_stock && $this->cart[$existingIndex]['quantity'] >= $product->stock_quantity) {
                $this->dispatch('showNotification',
                    type: 'error',
                    message: 'Stock máximo alcanzado para '.$product->name
                );
                return;
            }
            //////////////
            $this->cart[$existingIndex]['quantity']++;
        } else {
            $this->cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->getFirstMediaUrl('main_image', 'thumb')
            ];
        }
        
        $this->calculateTotals();
        $this->dispatch('showNotification', 
            type: 'success', 
            message: $product->name.' añadido al carrito'
        );
        
        
    }
///New Countable
    public function incrementQuantity($index)
    {
        if (isset($this->cart[$index])) {

            // Validacion stock
            $product = Product::find($this->cart[$index]['id']);
            if ($product) {
                // Verificar si excede stock
                if ($product->manage_stock && $this->cart[$index]['quantity'] >= $product->stock_quantity) {
                    $this->dispatch('showNotification',
                        type: 'error',
                        message: 'Stock máximo alcanzado para '.$product->name
                    );
                    return;
                }
            }
            /////

            $this->cart[$index]['quantity']++;
            $this->calculateTotals();
        }
    }

    public function decrementQuantity($index)
    {
        if (isset($this->cart[$index]) && $this->cart[$index]['quantity'] > 1) {
            $this->cart[$index]['quantity']--;
            $this->calculateTotals();
        }
    }

    public function showSales()
    {
        return redirect()->route('filament.admin.resources.sales.index');
    }

    public function showCustomers()
    {
        return redirect()->route('filament.admin.resources.customers.index');
    }

    /////

    public function removeFromCart($index)
    {
        if (isset($this->cart[$index])) {
            $removedItem = $this->cart[$index];
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart);
            
            $this->calculateTotals();
            /*$this->dispatch('notify', [
                'type' => 'warning',
                'message' => $removedItem['name'].' removed from cart'
            ]);*/
            $this->dispatch('showNotification', 
                type: 'success', 
                message:  $removedItem['name'].' retirado del carrito'
            );
        }
    }

    public function selectCustomer($customerId)
    {
        $customer = Customer::find($customerId);
        if ($customer) {
            $this->selectedCustomer = $customerId;
            $this->selectedCustomerName = $customer->name;
            $this->customerSearch = '';
            /*$this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Customer selected: '.$customer->name
            ]);
            */
            $this->dispatch('showNotification', 
                type: 'success', 
                message: 'Customer selected: '.$customer->name
            );
            
        }
    }

    public function clearCustomer()
    {
        $this->selectedCustomer = null;
        $this->selectedCustomerName = '';
    }

    public function updatedCashReceived()
    {
        $this->change = max(0, $this->cash_received - $this->total);
    }

    public function completeSale()
    {

        //Validacion stock
        foreach ($this->cart as $item) {
            $product = Product::find($item['id']);
            if ($product && $product->manage_stock && $item['quantity'] > $product->stock_quantity) {
                $this->dispatch('showNotification',
                    type: 'error',
                    message: 'Stock insuficiente para completar la venta de '.$product->name
                );
                return;
            }
        }

        ////
        DB::transaction(function () {
            $invoiceNumber = 'VEN-' . now()->format('YmdHis') . '-' . rand(100, 999);
            
            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $this->selectedCustomer,
                'cashier_id' => auth()->id(),
                'user_id' => auth()->id(),
                'payment_method' => $this->payment_method,
                'payment_status' => 'paid',
                'subtotal' => $this->subtotal,
                'tax_amount' => $this->tax,  // Antes tax
                'total_amount' => $this->total, //Antes total
                'cash_received' => $this->cash_received,
                'change' => $this->change,
                'status' => 'completed',
            ]);
            
            foreach ($this->cart as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],  // Antes total_price
                ]);
                
                $product = Product::find($item['id']);
                if ($product && $product->manage_stock) {
                    $product->decrement('stock_quantity', $item['quantity']);
                }
            }
            /* //En el caso de querer que un POS sale cree un payment
            Payment::create([
                'payable_id' => $sale->id,
                'payable_type' => Sale::class,
                'amount' => $this->total,
                'payment_method' => $this->payment_method,
                'status' => 'completed'
            ]);
            */
        });
        
        /*$this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Sale completed successfully!'// Invoice: '.$invoiceNumber
        ]);*/
        $this->dispatch('showNotification', 
                type: 'success', 
                message: 'Venta completada!: '
            );
        
        $this->resetCart();
    }

    private function calculateTotals()
    {
        $this->subtotal = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        
        $this->tax = $this->subtotal * 0.10;
        $this->total = $this->subtotal + $this->tax;
        $this->change = max(0, $this->cash_received - $this->total);
    }

    private function resetCart()
    {
        $this->cart = [];
        $this->selectedCustomer = null;
        $this->selectedCustomerName = '';
        $this->payment_method = 'cash';
        $this->cash_received = 0;
        $this->calculateTotals();
    }

    public function render()
    {
        $products = Product::query()
            ->with(['category', 'media'])
            ->where('pos_visible', true)
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('sku', 'like', '%'.$this->search.'%')
                      ->orWhere('barcode', 'like', '%'.$this->search.'%');
                });
            })
            ->paginate(12);

        $filteredCustomers = Customer::when($this->customerSearch, function($query) {
                $query->where('name', 'like', '%'.$this->customerSearch.'%')
                      ->orWhere('email', 'like', '%'.$this->customerSearch.'%')
                      ->orWhere('phone', 'like', '%'.$this->customerSearch.'%');
            })
            ->limit(5)
            ->get();

        return view('livewire.pos.pos-interface', [
            'products' => $products,
            'filteredCustomers' => $filteredCustomers,
        ]);
    }
}