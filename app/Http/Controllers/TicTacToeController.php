<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicTacToeDeleteRequest;
use App\Http\Requests\TicTacToeRequest;
use App\Http\Requests\TicTacToeUpdateRequest;
use App\Http\Resources\TicTacToeCollection;
use App\Models\TicTacToe;
use App\Services\TicTacToeService;
use Illuminate\Http\Request;

class TicTacToeController extends Controller
{
    public function index(
        Request $request,
        TicTacToeService $ticTacToeService
    ) {
        $deviceToken = $request->header('Device-Token');

        $result = $ticTacToeService->index($deviceToken);

        return response()->json(TicTacToeCollection::collection($result),200);
    }

    public function store(TicTacToeRequest $request,TicTacToeService $ticTacToeService) {

        $validated = $request->validated();
        $deviceToken = $request->header('Device-Token');

        $message = $ticTacToeService->store($deviceToken, $validated);

        return response()->json(['message' => $message], 200);
    }

    public function update($id,TicTacToeUpdateRequest $request,TicTacToeService $ticTacToeService) {

        $validated = $request->validated();
        $deviceToken = $request->header('Device-Token');

        $message = $ticTacToeService->update($deviceToken, $validated, $id);

        return response()->json(['message' => $message], 200);
    }

    public function delete($id,Request $request,TicTacToeService $ticTacToeService) {

        $deviceToken = $request->header('Device-Token');

        $message = $ticTacToeService->delete($deviceToken, $id);

        return response()->json(['message' => $message], 200);
    }
}
