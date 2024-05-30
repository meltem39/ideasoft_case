<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable=[
        "customer_id",
        "total",
        "status",
    ];

    public function items():HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function totalUpdate(){
        $this->update([
            "total" => $this->items()->sum("total")
        ]);
    }
}
