<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'comment',
        'rating',
        'user_id',
        'product_id'
    ];

    protected $hidden = [
        'updated_at'
    ];

    protected $with = [
        'user',
        'product'
    ];

    protected $appends = ['rating_label'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getRatingLabelAttribute(): string
    {
        return match ($this->rating) {
            1 => 'Péssimo',
            2 => 'Ruim',
            3 => 'Neutro',
            4 => 'Bom',
            5 => 'Excelente',
            default => 'Desconhecido',
        };
    }
}
