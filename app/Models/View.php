<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'created_at'
    ];

    public function viewable() {
        return $this->morphTo();
    }
}
