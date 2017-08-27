<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qa extends Model
{
    public function faq() {
        return $this->belongsTo(Faq::class);
    }
}
