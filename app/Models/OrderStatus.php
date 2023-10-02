<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'order_statuses';
    protected $fillable = ['name'];
    protected $casts = ['name' => 'string'];

    const default = [
        1 => 'DISPONIBILIZADO',
        2 => 'EM PRODUÇÃO',
        3 => 'FINALIZADO',
        4 => 'ENTREGUE'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
