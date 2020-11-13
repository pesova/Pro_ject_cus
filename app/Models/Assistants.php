<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Assistants extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'store_assistants';
}
