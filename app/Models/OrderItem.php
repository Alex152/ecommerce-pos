<?php
/*
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price', // USD
        'subtotal',   // USD
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relaciones
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Eventos
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->subtotal = $item->quantity * $item->unit_price;
        });
    }
}

*/




namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'name',
        'sku',
        'barcode',
        'quantity',
        'unit_price', // Precio unitario (único campo de precio)
        'cost_price', // Solo para registro interno
        'subtotal',
        'tax_amount',
        //'tax',        // Impuesto aplicado a este ítem
        'discount',   // Descuento aplicado a este ítem
        'options'
    ];
    
    protected $casts = [
        'unit_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        //'tax' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'options' => 'array'
    ];
/* 
en el caso de querer mantener el campo tax y tax_amount al mismo tiempo en fiable se recomienda usar este mutador

// En OrderItem.php
public function setTaxAmountAttribute($value)
{
    $this->attributes['tax_amount'] = $value;
    $this->attributes['tax'] = $value; // Mantener sincronizados durante transición
}

igualmente revisar todo 
*/
    // Relaciones
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function tax(): BelongsToMany  // se cambio de taxes a tax para que coga relacion en orderitemrelationalmanager
    {
        return $this->belongsToMany(Tax::class, 'order_item_tax')->withPivot('amount');
    }




    // En  modelo OrderItem.php
    protected static function boot()
    {
        parent::boot();

        static::saving(function (OrderItem $orderItem) {
            // Guardar options como JSON si es necesario
            if (is_array($orderItem->options)) {
                $orderItem->options = json_encode($orderItem->options);
            } elseif (empty($orderItem->options)) {
                $orderItem->options = '[]';
            }

            // Calcular subtotal
            $orderItem->subtotal = $orderItem->quantity * $orderItem->unit_price;
        });

        static::saved(function (OrderItem $orderItem) {
            if ($orderItem->relationLoaded('tax')) {
                $tax = $orderItem->tax->first();
            } else {
                $tax = $orderItem->tax()->first();
            }
        
            if ($tax) {
                $taxAmount = $orderItem->subtotal * ($tax->rate / 100);
        
                $orderItem->tax_amount = $taxAmount;
                $orderItem->saveQuietly(); // evita loop infinito del evento `saved()`

        
                // También actualizamos la tabla pivote
                $orderItem->tax()->sync([
                    $tax->id => ['amount' => $taxAmount]
                ]);
        
                $orderItem->order->recalculateTotals();
            }
        });
        
        

        static::deleted(function (OrderItem $orderItem) {
            $orderItem->order->recalculateTotals();
        });
    }


public function getOptionsAttribute($value)
{
    return json_decode($value, true) ?: [];
}

public function setOptionsAttribute($value)
{
    $this->attributes['options'] = is_array($value) ? json_encode($value) : $value;
}


}