<?php

namespace App\Http\Controllers;

class Demo extends Controller
{
    public function __construct()
    {
        $this->middleware("jwt_auth");
    }
    public function Hello()
    {
        return "Hello";
    }
}
