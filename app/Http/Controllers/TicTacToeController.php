<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicTacToeDeleteRequest;
use App\Http\Requests\TicTacToeRequest;
use App\Http\Requests\TicTacToeUpdateRequest;
use App\Http\Resources\TicTacToeCollection;
use App\Models\TicTacToe;
use Illuminate\Http\Request;

class TicTacToeController extends Controller
{
    public function index(Request $request)
    {
        $deviceToken = $request->header('Device-Token');

        $ticTacToe = TicTacToe::where('device_token', $deviceToken)->get(["id", "name", "type", "game_state"]);

        return response()->json(TicTacToeCollection::collection($ticTacToe), 200);
    }

    public function store(TicTacToeRequest $request)
    {
        $validated = $request->validated();
        $timestamp = time();

        $ticTacToe = new TicTacToe();
        $ticTacToe->device_token = $request->header('Device-Token');
        if ($request->has('name')) {
            $ticTacToe->name = $validated['name'];
        } else {
            $date = date("j F Y", $timestamp);
            $time = date("H:i:s", $timestamp);
            $ticTacToe->name = "Saved Game On $date | $time";
        }
        $ticTacToe->type = $validated['type'];
        $ticTacToe->game_state = json_encode($validated['game_state']);

        $ticTacToe->save();

        return response()->json(['message' => $ticTacToe->name . ' created'], 201);
    }

    public function update(TicTacToeUpdateRequest $request)
    {

        $validated = $request->validated();
        $timestamp = time();
        $ticTacToe = TicTacToe::find($validated['id']);
        if ($request->has('name')) {
            $ticTacToe->name = $validated['name'];
        } else {
            $date = date("j F Y", $timestamp);
            $time = date("H:i:s", $timestamp);
            $ticTacToe->name = "Saved Game On $date | $time";
        }
        $ticTacToe->type = $validated['type'];
        $ticTacToe->game_state = json_encode($validated['game_state']);
        $ticTacToe->save();

        return response()->json(['message' => $ticTacToe->name . ' Updated'], 201);
    }

    public function delete(TicTacToeDeleteRequest $request)
    {

        $validated = $request->validated();

        $ticTacToe = TicTacToe::find($validated['id']);

        if (!$ticTacToe) {
            return response()->json(['message' => 'TicTacToe with ID ' . $validated['id'] . " is not found!"], 201);
        }

        $ticTacToe->delete();

        return response()->json(['message' => $ticTacToe->name . ' Deleted'], 201);
    }
}
