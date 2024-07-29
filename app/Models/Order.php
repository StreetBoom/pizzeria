<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $casts = [
        'delivery_time' => 'datetime',
    ];


    /**
     * @param $value
     * @return string
     */
    public function getStatusAttribute($value): string
    {
        return ucfirst($value);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $value
     * @return void
     */
    public function setStatusAttribute($value): void
    {
        if (!in_array($value, [self::STATUS_PENDING, self::STATUS_COMPLETED, self::STATUS_CANCELLED])) {
            throw new \InvalidArgumentException("Invalid status: $value");
        }

        $this->attributes['status'] = strtolower($value);
    }
}
