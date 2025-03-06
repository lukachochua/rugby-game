<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'position'   => ['required', 'string', 'in:fly-half,scrumhalf,prop,lock,third row,number 8,center,wing,fullback'],
            'team'       => 'required|string|max:255|nullable',
            'height'     => 'nullable|integer',
            'weight'     => 'nullable|integer',
            'speed'      => 'nullable|integer|min:0|max:100',
            'strength'   => 'nullable|integer|min:0|max:100',
            'agility'    => 'nullable|integer|min:0|max:100',
            'stamina'    => 'nullable|integer|min:0|max:100',
            'tackling'   => 'nullable|integer|min:0|max:100',
            'kicking'    => 'nullable|integer|min:0|max:100',
            'passing'    => 'nullable|integer|min:0|max:100',
        ]);

        // Ensure that stat values do not exceed the total limit
        $totalStats = array_sum($request->only(['speed', 'strength', 'agility', 'stamina', 'tackling', 'kicking', 'passing']));

        $position = $request->input('position');
        $maxAllowed = 400; // Max total stat points

        if ($totalStats > $maxAllowed) {
            return response()->json([
                'message' => "Total stat points ($totalStats) exceed the allowed maximum of $maxAllowed."
            ], 422);
        }

        // Save the player
        $player = Player::create($request->all());

        return response()->json($player, 201);
    }




    public function index()
    {
        $players = Player::all();
        return response()->json($players);
    }
}
