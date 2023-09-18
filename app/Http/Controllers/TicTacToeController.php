<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicTacToeRequest;
use App\Http\Requests\TicTacToeUpdateRequest;
use App\Models\TicTacToe;
use Illuminate\Http\Request;

class TicTacToeController extends Controller
{
    public function index(Request $request)
    {
        $deviceToken = $request->header('Device-Token');

        $ticTacToe = TicTacToe::where('device_token', $deviceToken)->get(["id", "name", "type", "game_state"]);
        
        return response()->json(['tic_tac_toe' => $ticTacToe]);
    }

    public function store(TicTacToeRequest $request)
    {
        $validated = $request->validated();

        $ticTacToe = new TicTacToe();
        $ticTacToe->device_token = $request->header('Device-Token');
        $ticTacToe->name = $validated['name'];
        $ticTacToe->type = $validated['type'];
        $ticTacToe->game_state = json_encode($validated['game_state']);
        $ticTacToe->save();

        return response()->json(['message' => $ticTacToe->name.' created'], 201);
    }
    
    public function update(TicTacToeUpdateRequest $request)
    {
        
        $validated = $request->validated();

        $ticTacToe = TicTacToe::find($request->id);

        $ticTacToe->name = $validated['name'];
        $ticTacToe->type = $validated['type'];
        $ticTacToe->game_state = json_encode($validated['game_state']);
        $ticTacToe->save();
        
        return response()->json(['message' => $ticTacToe->name.' Updated'], 201);
    }
    
}
