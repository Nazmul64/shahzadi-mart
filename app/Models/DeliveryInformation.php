<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryInformation extends Model
{
    use HasFactory;

    protected $table = 'delivery_information';

    protected $fillable = [
        'header_title',

        'home_delivery_title',
        'home_delivery_description',

        'pickup_title',
        'pickup_description',

        'instant_download_title',
        'instant_download_description',

        'secure_title',
        'secure_description',

        'cod_title',
        'cod_description',

        'mobile_banking_title',
        'mobile_banking_description',

        'footer_company_information',
    ];
}
