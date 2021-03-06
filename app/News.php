<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use SoftDeletes;

    protected $table = "news";

    protected $dates = ['deleted_at'];

    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
