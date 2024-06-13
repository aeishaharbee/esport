<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Models\Team;
use App\Models\Maatch;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class TournamentTeamController extends Controller
{
    // ADMIN
    public function destroy(Tournament $tournament, Team $team)
    {
        // Check if the team is part of the tournament
        $tournamentTeam = $tournament->teams()->where('teamId', $team->id)->first();

        if (!$tournamentTeam) {
            return redirect()->route('admin.tournament.details', $tournament->id)
                ->with('error', 'Team not found in this tournament.');
        }

        // Remove the team from the tournament
        $tournament->teams()->detach($team->id);

        return redirect()->route('admin.tournament.details', $tournament->id)
            ->with('success', 'Team removed from the tournament successfully.');
    }

    // USER
    public function store(Request $request, Tournament $tournament)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'teamId' => 'required|exists:teams,id',
        ]);

        $team = Team::find($validatedData['teamId']);

        // Check if the team's category matches the tournament's category
        if ($team->categoryId !== $tournament->categoryId) {
            return redirect()->route('tournament.details', $tournament->id)
                ->with('error', 'Your team category does not match the tournament category.');
        }

        // Check if the user has already registered a team for the tournament
        $alreadyRegistered = TournamentTeam::where('tournId', $tournament->id)
            ->where('teamId', $team->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->route('tournament.details', $tournament->id)
                ->with('error', 'You have already registered this team for the tournament.');
        }

        // Create a new tournament team entry
        TournamentTeam::create([
            'tournId' => $tournament->id,
            'teamId' => $team->id,
        ]);

        return redirect()->route('tournament.details', $tournament->id)
            ->with('success', 'Team registered successfully!');
    }

    public function detailsUser(Tournament $tournament)
    {
        // Fetch teams where the authenticated user is the owner and eager load the category relationship
        $userTeams = Team::where('registeredId', Auth::id())->with('category')->get();
        
        $participatingTeams = $tournament->teams()->with('category')->get();

        $matches = Maatch::where('tournId', $tournament->id)
                      ->with(['team1', 'team2', 'level', 'result'])
                      ->orderBy('levelId', 'asc')
                      ->get();

        $hasNoInactiveMatches = $matches->where('isActive', false)->isEmpty();
        $hasNoActiveMatches = $matches->where('isActive', true)->isEmpty();

        $topTeams = [];

        if (!$tournament->isActive) {
            $finalMatch = Maatch::where('tournId', $tournament->id)
                                ->whereHas('level', function ($query) {
                                    $query->where('name', 'Final');
                                })
                                ->first();

            if ($finalMatch) {
                $finalResult = Result::where('matchId', $finalMatch->id)->first();
                if ($finalResult) {
                    $topTeams[1] = Team::find($finalResult->teamWon);
                    $topTeams[2] = Team::find($finalResult->teamLost);
                }
            }

            $thirdPlaceMatch = Maatch::where('tournId', $tournament->id)
                                    ->whereHas('level', function ($query) {
                                        $query->where('name', 'Third-Place Playoff');
                                    })
                                    ->first();

            if ($thirdPlaceMatch) {
                $thirdPlaceResult = Result::where('matchId', $thirdPlaceMatch->id)->first();
                if ($thirdPlaceResult) {
                    $topTeams[3] = Team::find($thirdPlaceResult->teamWon);
                }
            }
        }

        // Return the view with the tournament, user's teams, and participating teams
        return view('tournament.details', compact('tournament', 'userTeams', 'participatingTeams', 'matches', 'hasNoInactiveMatches', 'hasNoActiveMatches', 'topTeams'));
    }
}
