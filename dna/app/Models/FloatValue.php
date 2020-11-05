<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloatValue extends Model
{
    use HasFactory;

    protected $connection = "mysql";

    protected $table = "float_values";


    /** Primary Key */

    protected $primaryKey = "id_pair"; // Default 'id'

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false; // Remove 'create_at' and 'update_at'

    /** Value1 & Value2*/

    protected $attributes = [
        'value1' => null,
        'value2' => null,
    ];


}
