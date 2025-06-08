<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'total',
        'status'
    ];

    public function getStatusTextAttribute()
    {
        return [
            'pending' => 'В обработке',
            'completed' => 'Завершен',
            'cancelled' => 'Отменен',
        ][$this->status];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
