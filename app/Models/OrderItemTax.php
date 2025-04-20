<?php

// app/Models/OrderItemTax.php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItemTax extends Pivot
{
    // Definir el nombre de la tabla
    protected $table = 'order_item_tax'; 

    // Especificar qué campos son asignables
    protected $fillable = [
        'order_item_id',
        'tax_id',
        'amount',  // El campo amount es necesario
    ];

    // Si quieres agregar relaciones con OrderItem y Tax:
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
