<?php
namespace App\Http\Controllers;
 
use App\Helpers\Contracts\RocketShipContract;

class DemoController extends Controller
{

    public function index(RocketShipContract $rocketship)
    {
        $boom = $rocketship->blastOff();
        return view('demo.index', compact('boom'));
    }

}
