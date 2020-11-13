<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\BSON\ObjectId;

class Stores extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'mycustomer_stores';
}
