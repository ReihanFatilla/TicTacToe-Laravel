<?php

namespace App\Services;

use App\Models\TicTacToe;

class TicTacToeService
{

    public function index($deviceToken)
    {
        return TicTacToe::where('device_token', $deviceToken)
            ->orderBy('updated_at', 'desc')
            ->get(["id", "name", "type", "game_state"]);
    }

    public function store($deviceToken, $request)
    {
        $timestamp = time();

        $ticTacToe = new TicTacToe();
        $ticTacToe->device_token = $deviceToken;
        if (isset($request['name']) && !empty($request['name'])) {
            $ticTacToe->name = $request['name'];
        } else {
            $date = date("j F Y", $timestamp);
            $time = date("H:i:s", $timestamp);
            $ticTacToe->name = "Saved Game On $date | $time";
        }
        $ticTacToe->type = $request['type'];
        $ticTacToe->game_state = json_encode($request['game_state']);

        $ticTacToe->save();

        return $ticTacToe->name . ' created';
    }

    public function update($deviceToken, $request, $id)
    {

        $timestamp = time();
        $ticTacToe = TicTacToe::find($id);
        if (!$ticTacToe) {
            return response()->json(['message' => 'TicTacToe with ID ' . $id . " is not found!"], 201);
        } else if($ticTacToe->device_token != $deviceToken){
            return response()->json(['message' => 'You cannot modify Game that isn\'t Yours!'], 201);
        } else if (isset($request['name']) && !empty($request['name'])) {
            $ticTacToe->name = $request['name'];
        } else {
            $date = date("j F Y", $timestamp);
            $time = date("H:i:s", $timestamp);
            $ticTacToe->name = "Saved Game On $date | $time";
        }
        $ticTacToe->type = $request['type'];
        $ticTacToe->game_state = json_encode($request['game_state']);
        $ticTacToe->save();

        return $ticTacToe->name . ' Updated';
    }

    public function delete($deviceToken, $id)
    {
        $ticTacToe = TicTacToe::find($id);
        if (!$ticTacToe) {
            return response()->json(['message' => 'TicTacToe with ID ' . $id . " is not found!"], 201);
        } else if ($ticTacToe->device_token != $deviceToken) {
            return response()->json(['message' => 'You cannot Delete Game that isn\'t Yours!'], 201);
        }

        $ticTacToe->delete();

        return $ticTacToe->name . ' Deleted';
    }
}
