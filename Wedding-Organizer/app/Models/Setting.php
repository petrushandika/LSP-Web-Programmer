<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'website_name',
        'phone_number',
        'email',
        'address',
        'maps',
        'logo',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'header_business_hour',
        'time_business_hour',
    ];
}
