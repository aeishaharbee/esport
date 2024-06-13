<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    // ADMIN
    public function indexAdmin() {
        $categoryList = Category::select('id', 'name')->get();
        // Fetch all teams with their respective categories
        $teams = Team::with('category')->get();
        // Return the view with the teams
        return view('admin.team.index', compact('teams', 'categoryList'));
    }

    public function destroyAdmin(Team $team) {
        // dd($team);
        @unlink(storage_path($team->logo));

        if (File::exists($team->logo)) {
            // Delete the file
            File::delete($team->logo);
            $team->delete();
            return redirect(route('admin.team.index'))->with('success','Team Deleted Successfully');
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    // USER
    public function index() {
        // $teams = Team::where('registeredId', Auth::id())->get();
        $teams = Team::where('registeredId', Auth::id())->with('category')->get();
        // Return the view with the teams
        return view('team.index', compact('teams'));
    }

    public function create() {
        $categoryList = Category::select('id', 'name')->get();
        return view("team.create", compact('categoryList'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'logo' => 'required|mimes:png,jpg,jpeg,webp',
            'categoryId' => 'required',
        ]);

        if($request->has('logo')){
            $file = $request->file('logo');
            $extension = $file->getClientOriginalName();
            $filename = time() .'.'. $extension;
            $path = 'uploads/team/';
            $file->move($path, $filename);
        }

        Team::create([
            'name'=> $request->name,
            'logo'=> $path.$filename,
            'categoryId'=> $request->categoryId,
            'registeredId' => auth()->user()->id,
        ]);

        return redirect(route('team.index'))->with('success','Team Registered Successfully');
    }

    public function edit(Team $team) {
        if (auth()->user()->id != $team->registeredId) {
            return redirect()->back()->with('error', 'You do not have permission to edit this team.');
        }

        return view('team.edit', ['team' => $team]);
    }

    public function update(Request $request, Team $team) {
        if (auth()->user()->id != $team->registeredId) {
            return redirect()->back()->with('error', 'You do not have permission to edit this team.');
        }
        
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|mimes:png,jpg,jpeg,webp',
            'categoryId' => 'required',
        ]);

        if($request->has('logo')){
            @unlink(storage_path($team->logo));
            if (File::exists($team->logo)) {
                // Delete the file
                File::delete($team->logo);
            }

            $file = $request->file('logo');
            $extension = $file->getClientOriginalName();
            $filename = time() .'.'. $extension;
            $path = 'uploads/team/';
            $file->move($path, $filename);

            $team->update([
                'name'=> $request->name,
                'logo'=> $path.$filename,
                'categoryId'=> $request->categoryId,
                'registeredId' => auth()->user()->id,
            ]);

        } else {
            $team->update([
                'name'=> $request->name,
                'categoryId'=> $request->categoryId,
                'registeredId' => auth()->user()->id,
            ]);
        }

        return redirect()->route('team.details', ['id' => $team->id])->with('success','Team Details Updated Successfully');
    }

    public function destroy(Team $team) {
        @unlink(storage_path($team->logo));

        if (File::exists($team->logo)) {
            // Delete the file
            File::delete($team->logo);
            $team->delete();
            return redirect(route('team.index'))->with('success','Team Deleted Successfully');
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    public function rank()
    {
        // Fetch all categories
        $categories = Category::all();

        $teamsByCategory = [];

        foreach ($categories as $category) {
            $teams = Team::where('categoryId', $category->id)
                ->withCount(['matchesAsTeam1 as matches_count1', 'matchesAsTeam2 as matches_count2', 'wins', 'losses'])
                ->get()
                ->filter(function ($team) {
                    return $team->score > 0; // Exclude teams with zero scores
                })
                ->map(function ($team) {
                    $team->matches_count = $team->matches_count1 + $team->matches_count2;
                    $totalMatches = $team->matches_count;
                    $team->win_ratio = $totalMatches > 0 ? $team->wins_count / $totalMatches : 0;
                    return $team;
                })
                ->sortByDesc('score')
                ->sortByDesc('win_ratio')
                ->values();
    
            // Assign ranks
            $rank = 1;
            $previousScore = null;
            $previousWinRatio = null;
            foreach ($teams as $index => $team) {
                if ($previousScore !== null && ($team->score != $previousScore || $team->win_ratio != $previousWinRatio)) {
                    $rank = $index + 1;
                }
                $team->rank = $rank;
                $previousScore = $team->score;
                $previousWinRatio = $team->win_ratio;
            }
    
            $teamsByCategory[$category->name] = $teams;
        }
        // Pass the categories and teams to the view
        return view('rank.index', compact('categories', 'teamsByCategory'));
    }

    // public function rankUser() {
    //     // Fetch all categories
    //     $categories = Category::all();

    //     // Fetch teams for each category and order them by their score
    //     $teamsByCategory = [];
    //     foreach ($categories as $category) {
    //         $teamsByCategory[$category->name] = Team::where('categoryId', $category->id)
    //                                                 ->whereHas('matches', function ($query) {
    //                                                     $query->whereHas('result');
    //                                                 })
    //                                                 ->withCount(['matches as matches_count'])
    //                                                 ->withCount(['wins as wins_count'])
    //                                                 ->withCount(['losses as losses_count'])
    //                                                 ->get()
    //                                                 ->map(function ($team) {
    //                                                     $totalMatches = $team->matches_count;
    //                                                     $team->win_ratio = $totalMatches > 0 ? $team->wins_count / $totalMatches : 0;
    //                                                     return $team;
    //                                                 })
    //                                                 ->sortByDesc('score')
    //                                                 ->sortByDesc('win_ratio')
    //                                                 ->values();
    //     }
    //     // Pass the categories and teams to the view
    //     return view('rank.index', compact('categories', 'teamsByCategory'));
    // }

    // public function details($id)
    // {
    //     // Fetch the team details
    //     $team = Team::with(['tournaments', 'matches'])->findOrFail($id);

    //     // Calculate the rank of the team based on its score
    //     $teamsInCategory = Team::where('categoryId', $team->categoryId)
    //                        ->whereHas('matches', function ($query) {
    //                            $query->whereHas('result');
    //                        })
    //                        ->withCount(['matches as matches_count'])
    //                        ->withCount(['wins as wins_count'])
    //                        ->withCount(['losses as losses_count'])
    //                        ->get()
    //                        ->map(function ($team) {
    //                            $totalMatches = $team->matches_count;
    //                            $team->win_ratio = $totalMatches > 0 ? $team->wins_count / $totalMatches : 0;
    //                            return $team;
    //                        })
    //                        ->sortByDesc('score')
    //                        ->sortByDesc('win_ratio')
    //                        ->values();


    //         $rank = $teamsInCategory->search(function($t) use ($team) {
    //         return $t->id === $team->id;
    //     });

    //     // Fetch ongoing and past tournaments
    //     $ongoingTournaments = $team->tournaments()->where('isActive', true)->get();
    //     $pastTournaments = $team->tournaments()->where('isActive', false)->get();

    //     // Pass the data to the view
    //     return view('team.details', compact('team', 'rank', 'ongoingTournaments', 'pastTournaments'));
    // }


    public function details($teamId)
    {
        $team = Team::with(['category', 'matchesAsTeam1', 'matchesAsTeam2'])->findOrFail($teamId);

        // Fetch all teams in the same category and order them by their score descendingly
        $teams = Team::where('categoryId', $team->category->id)
            ->withCount(['matchesAsTeam1 as matches_count1', 'matchesAsTeam2 as matches_count2', 'wins', 'losses'])
            ->get()
            ->filter(function ($team) {
                return $team->score > 0; // Exclude teams with zero scores
            })
            ->map(function ($team) {
                $team->matches_count = $team->matches_count1 + $team->matches_count2;
                $totalMatches = $team->matches_count;
                $team->win_ratio = $totalMatches > 0 ? $team->wins_count / $totalMatches : 0;
                return $team;
            })
            ->sortByDesc('score')
            ->sortByDesc('win_ratio')
            ->values();

        // Assign ranks and find the rank of the specific team
        $rank = 1;
        $previousScore = null;
        $previousWinRatio = null;
        $teamRank = null;
        foreach ($teams as $index => $rankedTeam) {
            if ($previousScore !== null && ($rankedTeam->score != $previousScore || $rankedTeam->win_ratio != $previousWinRatio)) {
                $rank = $index + 1;
            }
            $rankedTeam->rank = $rank;
            if ($rankedTeam->id == $team->id) {
                $teamRank = $rank;
            }
            $previousScore = $rankedTeam->score;
            $previousWinRatio = $rankedTeam->win_ratio;
        }

        // Fetch ongoing and past tournaments
        $ongoingTournaments = $team->tournaments()->where('isActive', true)->get();
        $pastTournaments = $team->tournaments()->where('isActive', false)->get();

        return view('team.details', compact('team', 'teamRank', 'ongoingTournaments', 'pastTournaments'));
    }
}
