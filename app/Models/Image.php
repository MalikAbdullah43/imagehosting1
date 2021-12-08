<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;

class Image extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    use SoftDeletes;
    
    




    protected $connection = 'mongodb';
    protected $collection = 'images'; 
    public $timestamps = false;
   protected $dates = ['deleted_at'];








    protected $fillable = [
        'image_name ',
        'original_name',
        'extension',
        'date',
        'time',
    ];

}
