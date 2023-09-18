<?php

namespace App\Http\Controllers;

use App\Models\TicTacToe;
use Illuminate\Http\Request;

class TicTacToeController extends Controller
{
    public function index(Request $request){

        $deviceToken = $request->header('Device-Token');

        $ticTacToe = TicTacToe::where('device_token', $deviceToken)->get();

        return response()->json(['tic_tac_toe' => $ticTacToe]);
    }
    
    public function store(Request $request){
        
    }
}
