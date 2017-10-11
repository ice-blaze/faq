<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $primaryKey = "id";
    public $incrementing = false;

    public function qas() {
        return $this->hasMany(Qa::class);
    }

    public function path() {
        return '/faq/'.$this->id.'?admin_code='.$this->admin_code;
    }

    public function guestPath() {
        return '/faq/'.$this->id;
    }
}
