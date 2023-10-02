<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Sample.
 *
 * @package namespace App\Models;
 */
class Sample extends Model implements Transformable
{
    use HasFactory;
    use TransformableTrait;

    protected $table = 'samples';
    protected $fillable = ['code', 'name', 'value'];
    protected $casts = ['code' => 'string', 'name' => 'string', 'value' => 'float'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}

