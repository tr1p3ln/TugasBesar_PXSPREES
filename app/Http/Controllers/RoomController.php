<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];
}
