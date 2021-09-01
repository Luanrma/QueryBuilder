<?php

namespace App\Model\Pessoa;

use App\Model\Model;

class Pessoa extends Model {

    protected $table = "pessoa";
    protected $fillable = [
        'name',
        'email',
        'password'
    ];
}