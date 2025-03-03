<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'team' => 'required|string|max:255',
        ]);

        $player = Player::create([
            'name' => $request->name,
            'position' => $request->position,
            'team' => $request->team,
        ]);

        return response()->json($player, 201);
    }

    public function index()
    {
        $players = Player::all();
        return response()->json($players);
    }
}
