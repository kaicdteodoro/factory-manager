<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Order.
 *
 * @package namespace App\Models;
 */
class Order extends Model implements Transformable
{
    use HasFactory;
    use TransformableTrait;

    protected $table = 'orders';
    protected $fillable = ['sample_id', 'order_status_id', 'observation', 'finished_at'];
    protected $casts = ['sample_id' => 'int', 'order_status_id' => 'int', 'observation' => 'string', 'finished_at' => 'date'];

    const numbers = [34, 36, 38, 40, 42, 44, 46];

    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function addQuantities(array $numbers): array
    {
        $id = $this->attributes['id'];
        return array_map(static function ($value) use ($id) {
            DB::table('order_quantities')
                ->updateOrInsert(['order_id' => $id, 'number' => $value['number']], ['quantity' => $value['quantity']]);;
            return $value['number'];
        }, $numbers);
    }

    public function updateQuantities(array $numbers): void
    {
        $all = $this->addQuantities($numbers);

        DB::table('order_quantities')
            ->where('order_id', '=', $this->attributes['id'])
            ->whereNotIn('number', $all)
            ->delete();
    }
}
