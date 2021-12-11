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
        "filename",
        "extension",
        "hashname",
        "accessor",
        "date",
        "time",
        "user_id",
        "image_url",
        "key",
        "original_name"
    ];
}
