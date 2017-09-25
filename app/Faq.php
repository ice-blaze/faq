<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public function qas() {
        return $this->hasMany(Qa::class);
    }

    public function path() {
        return '/faq/'.$this->id.'?admin_code='.$this->admin_code;
    }
}
