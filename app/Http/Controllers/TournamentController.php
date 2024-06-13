<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Category;
use App\Models\Team;
use App\Models\Maatch;
use App\Models\Level;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;


class TournamentController extends Controller
{

    // USER
    public function indexUser() {
        $activeTournaments = Tournament::where('isActive', true)->with('category')->get();
        $inactiveTournaments = Tournament::where('isActive', false)->with('category')->get();
        return view('tournament.index', compact('activeTournaments', 'inactiveTournaments'));
    }

    public function teamUser() {
        return view('team.index');
    }

    // ADMIN
    public function index() {
        $categoryList = Category::select('id', 'name')->get();
        $activeTournaments = Tournament::where('isActive', true)->with('category')->get();
        $inactiveTournaments = Tournament::where('isActive', false)->with('category')->get();
        return view('admin.tournament.index', compact('activeTournaments', 'inactiveTournaments', 'categoryList'));
    }

    public function create() {
        $categoryList = Category::select('id', 'name')->get();
        return view("admin.tournament.create", compact('categoryList'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate',
            'image' => 'required|mimes:png,jpg,jpeg,webp',
            'categoryId' => 'required',
        ]);

        if($request->has('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() .'.'. $extension;
            $path = 'uploads/tournament/';
            $file->move($path, $filename);
        }

        Tournament::create([
            'categoryId'=> $request->categoryId,
            'name'=> $request->name,
            'desc'=> $request->desc,
            'startDate'=> $request->startDate,
            'endDate'=> $request->endDate,
            'image'=> $path.$filename,
        ]);

        return redirect(route('admin.tournament.index'))->with('success', 'Tournament created successfully.');
    }

    public function edit(Tournament $tournament){
        $categoryList = Category::select('id', 'name')->get();
        return view('admin.tournament.edit', compact('categoryList', 'tournament'));
    }

    public function update(Tournament $tournament, Request $request) {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
            'categoryId' => 'required',
        ]);

        if($request->has('image')){
            @unlink(storage_path($tournament->image));
            if (File::exists($tournament->image)) {
                // Delete the file
                File::delete($tournament->image);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() .'.'. $extension;
            $path = 'uploads/tournament/';
            $file->move($path, $filename);

            $tournament->update([
                'categoryId'=> $request->categoryId,
                'name'=> $request->name,
                'desc'=> $request->desc,
                'startDate'=> $request->startDate,
                'endDate'=> $request->endDate,
                'image'=> $path.$filename,
            ]);
        } else {
            $tournament->update([
                'categoryId'=> $request->categoryId,
                'name'=> $request->name,
                'desc'=> $request->desc,
                'startDate'=> $request->startDate,
                'endDate'=> $request->endDate,
            ]);
        }

        return redirect(route('admin.tournament.index'))->with('success','Tournament Updated Successfully');
    }

    public function destroy(Tournament $tournament){
        @unlink(storage_path($tournament->image));

        if (File::exists($tournament->image)) {
            // Delete the file
            File::delete($tournament->image);
            $tournament->delete();
            return redirect(route('admin.tournament.index'))->with('success','Tournament Deleted Successfully');
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }

        
    }

    public function showTournamentDetails(Tournament $tournament)
    {
        $registeredTeams = $tournament->teams()->with('category')->get();

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

        return view('admin.tournament.details', compact('tournament', 'registeredTeams', 'matches', 'hasNoInactiveMatches', 'hasNoActiveMatches', 'topTeams'));
    }
}
    