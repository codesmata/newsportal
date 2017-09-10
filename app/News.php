<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $table = "news";

    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
