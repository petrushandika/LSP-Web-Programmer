<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'catalogue_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'catalogue_id',
        'image',
        'package_name',
        'description',
        'price',
        'status_publish',
        'user_id',
    ];

    /**
     * Get the user that owns the catalogue.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the orders for the catalogue.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'catalogue_id', 'catalogue_id');
    }
}
