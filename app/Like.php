<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function post()
    {
        // This allows an instance of Like class to obtain an associated Post object upon r equest.
        return $this->belongsTo('App\Post', 'post_id');
    }
}
