<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [ 'id', 'contact', 'contact_phone'];

    public $timestamps = false;

    public function person(){
        return $this->belongsTo('App\Person');
    }
}
