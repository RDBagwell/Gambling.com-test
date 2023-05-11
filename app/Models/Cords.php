<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cords extends Model
{
    use HasFactory;
    public $latitude = 53.3340285;
    public $longitude = -6.2535495;
    public $earthRadiusInKM = 6371;
    public $radius = 100;  
}
