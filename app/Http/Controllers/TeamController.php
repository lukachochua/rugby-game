<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the teams.
     */
    public function index()
    {
        // Fetch teams with their players
        $teams = Team::with('players')->get();
        return response()->json($teams);
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:teams,name', // Ensure team name is unique
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'coach_name' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'team_color' => 'nullable|string|max:50',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create the team
        $team = new Team($validator->validated());

        // Associate with the authenticated user if available
        if (Auth::check()) {
            $team->user_id = Auth::id();
        }

        // Save the team to the database
        $team->save();

        // Return success response with the created team
        return response()->json([
            'message' => 'Team created successfully',
            'team' => $team,
        ], 201);
    }

    /**
     * Display the specified team.
     */
    public function show(Team $team)
    {
        // Load the team with its players
        $team->load('players');
        return response()->json($team);
    }

    /**
     * Update the specified team in storage.
     */
    public function update(Request $request, Team $team)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255|unique:teams,name,' . $team->id, // Ensure name is unique, excluding the current team
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'coach_name' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'team_color' => 'nullable|string|max:50',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update the team with validated data
        $team->update($validator->validated());

        // Return success response with the updated team
        return response()->json([
            'message' => 'Team updated successfully',
            'team' => $team,
        ]);
    }

    /**
     * Remove the specified team from storage.
     */
    public function destroy(Team $team)
    {
        // Disassociate all players from this team
        Player::where('team_id', $team->id)->update(['team_id' => null]);

        // Delete the team
        $team->delete();

        // Return success response
        return response()->json([
            'message' => 'Team deleted successfully',
        ], 204);
    }

    /**
     * Add a player to the team.
     */
    public function addPlayer(Request $request, Team $team)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
        ]);

        $player = Player::findOrFail($request->player_id);

        // Check if the player is already on a team
        if ($player->team_id) {
            return response()->json([
                'message' => 'Player is already on a team',
            ], 400);
        }

        // Add the player to the team
        $player->team_id = $team->id;
        $player->save();

        // Return success response with updated player and team
        return response()->json([
            'message' => 'Player added to team successfully',
            'player' => $player,
            'team' => $team->load('players'), // Load the team with its players
        ]);
    }

    /**
     * Remove a player from the team.
     */
    public function removePlayer(Request $request, Team $team)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'player_id' => 'required|exists:players,id',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find the player
        $player = Player::findOrFail($request->player_id);

        // Check if the player belongs to this team
        if ($player->team_id != $team->id) {
            return response()->json([
                'message' => 'Player does not belong to this team',
            ], 400);
        }

        // Remove the player from the team
        $player->team_id = null;
        $player->team = null;
        $player->save();

        // Return success response
        return response()->json([
            'message' => 'Player removed from team successfully',
        ]);
    }
}
