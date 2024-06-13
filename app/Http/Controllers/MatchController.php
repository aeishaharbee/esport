<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Maatch;
use App\Models\Team;
use App\Models\Level;
use App\Models\Result;
use Carbon\Carbon;

class MatchController extends Controller
{
    public function showAssignMatchesForm(Tournament $tournament)
    {
        // Fetch all matches for the tournament
        $levels = Level::select('id', 'name')->get();
        // Fetch all teams registered for the tournament
        $teams = $tournament->teams()->with('category')->get();
        return view('admin.tournament.match', compact('tournament', 'teams', 'levels'));
    }

    public function assignMatches(Request $request, Tournament $tournament)
    {
        // Check if the tournament is active
        if (!$tournament->isActive) {
            return redirect()->route('admin.tournament.details', $tournament->id)->with('error', 'Cannot assign matches to an inactive tournament.');
        }
        // Define end date to include the full day
        $endDate = Carbon::createFromFormat('Y-m-d', $tournament->endDate)->endOfDay();

        // dd($request, $tournament);
        $validatedData = $request->validate([
            'team1Id' => 'required|exists:teams,id',
            'team2Id' => 'required|exists:teams,id|different:team1Id',
            'time' => 'required|date|after_or_equal:' . $tournament->startDate . '|before_or_equal:' . $endDate,
            'levelId' => 'required|exists:levels,id',
        ]);

        // Check if the same team is assigned to both team1Id and team2Id
        if ($validatedData['team1Id'] === $validatedData['team2Id']) {
            return redirect()->back()->withErrors(['error' => 'A team cannot fight itself.']);
        }

        // Check if team1 or team2 is already assigned to the same level in this tournament
        $existingMatch = Maatch::where('tournId', $tournament->id)
            ->where('levelId', $validatedData['levelId'])
            ->where(function ($query) use ($validatedData) {
                $query->where('team1Id', $validatedData['team1Id'])
                      ->orWhere('team2Id', $validatedData['team1Id'])
                      ->orWhere('team1Id', $validatedData['team2Id'])
                      ->orWhere('team2Id', $validatedData['team2Id']);
            })
            ->exists();

            if ($existingMatch) {
                return redirect()->route('admin.tournament.match', $tournament->id)
                    ->with('error', 'One of the teams is already assigned to a match in this level.');
            }

        $conflictingMatch = Maatch::where('time', $validatedData['time'])
            ->where(function ($query) use ($validatedData) {
                $query->where('team1Id', $validatedData['team1Id'])
                      ->orWhere('team2Id', $validatedData['team1Id'])
                      ->orWhere('team1Id', $validatedData['team2Id'])
                      ->orWhere('team2Id', $validatedData['team2Id']);
            })
            ->exists();
    
        if ($conflictingMatch) {
            return redirect()->route('admin.tournament.match', $tournament->id)
                ->with('error', 'One of the teams has an existing match at the same time in another tournament.');
        }

        // Create a new match entry
        Maatch::create([
            'tournId' => $tournament->id,
            'team1Id' => $validatedData['team1Id'],
            'team2Id' => $validatedData['team2Id'],
            'time'=> $validatedData['time'],
            'levelId'=> $validatedData['levelId'],
        ]);

        return redirect()->route('admin.tournament.details', $tournament->id)->with('success', 'Match assigned successfully!');
    }

    public function edit(Tournament $tournament, Maatch $match)
    {
        $levels = Level::select('id', 'name')->get();
        $teams = $tournament->teams()->with('category')->get();
        return view('admin.match.edit', compact('tournament', 'match', 'teams', 'levels'));
    
    }

    public function update(Request $request, Tournament $tournament, Maatch $match)
    {   
        $endDate = Carbon::createFromFormat('Y-m-d', $tournament->endDate)->endOfDay();

        $validatedData = $request->validate([
            'team1Id' => 'required|exists:teams,id',
            'team2Id' => 'required|exists:teams,id|different:team1Id',
            'time' => 'required|date|after_or_equal:' . $tournament->startDate . '|before_or_equal:' . $endDate,
            'levelId' => 'required|exists:levels,id',
        ]);

        if ($validatedData['team1Id'] === $validatedData['team2Id']) {
            return redirect()->back()->withErrors(['error' => 'A team cannot fight itself.']);
        }

        $existingMatch = Maatch::where('tournId', $tournament->id)
            ->where('levelId', $validatedData['levelId'])
            ->where('id', '!=', $match->id)
            ->where(function ($query) use ($validatedData) {
                $query->where('team1Id', $validatedData['team1Id'])
                      ->orWhere('team2Id', $validatedData['team1Id'])
                      ->orWhere('team1Id', $validatedData['team2Id'])
                      ->orWhere('team2Id', $validatedData['team2Id']);
            })
            ->exists();

        if ($existingMatch) {
            return redirect()->back()->withErrors(['error' => 'One of the teams is already assigned to a match in this level.']);
        }

        // Update match details
        $match->update([
            'team1Id' => $validatedData['team1Id'],
            'team2Id' => $validatedData['team2Id'],
            'time' => $validatedData['time'],
            'levelId' => $validatedData['levelId'],
        ]);

        return redirect()->route('admin.tournament.details', $match->tournId)->with('success', 'Match updated successfully!');
    }

    public function destroy(Tournament $tournament, Maatch $match)
    {
        $match->delete();
        return redirect()->route('admin.tournament.details', $tournament->id)->with('success', 'Match deleted successfully!');
    }

    public function showTournamentDetails(Tournament $tournament)
    {
        // Fetch teams that have registered for the specific tournament and eager load the category relationship
        $registeredTeams = $tournament->teams()->with('category')->get();

        // Fetch all matches for the tournament
        $matches = Maatch::where('tournId', $tournament->id)->with(['team1', 'team2'])->get();

        // Return the view with the tournament, registered teams, and matches
        return view('admin.tournament.details', compact('tournament', 'registeredTeams', 'matches'));
    }

    public function completeMatch(Request $request, Tournament $tournament, Maatch $match)
    {

        // dd($request, $tournament, $match);
        $validatedData = $request->validate([
            'teamWon' => 'required|exists:teams,id',
        ]);

        // Get the winning team
        $winningTeam = Team::find($validatedData['teamWon']);

        // Determine the losing team
        $losingTeam = $match->team1Id == $winningTeam->id ? $match->team2 : $match->team1;

        // Get the score for the level
        $levelScore = Level::find($match->levelId)->score;

        // Update the winning team's points and won counter
        $winningTeam->increment('score', $levelScore);
        $winningTeam->increment('win');

        // Update the losing team's lost counter
        $losingTeam->increment('lost');

        // Create a new result entry
        Result::create([
            'matchId' => $match->id,
            'teamWon' => $winningTeam->id,
            'teamLost' => $losingTeam->id,
        ]);

        // Update the match to set isActive to false
        $match->update(['isActive' => false]);

        // Check if the match level is "final"
        $level = Level::find($match->levelId);
        if ($level->name == 'Final') {
            // Update the tournament to set isActive to false
            $tournament->update(['isActive' => false]);
        }

        return redirect()->route('admin.tournament.details', $tournament->id)->with('success', 'Match completed successfully!');
    }
}
