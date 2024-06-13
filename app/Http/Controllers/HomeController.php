<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Tournament;
use App\Models\Maatch;
use App\Models\Team;
use App\Models\Category;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $allActiveTournaments = Tournament::where('isActive', true)->get();
        $allInactiveTournaments = Tournament::where('isActive', false)->get();

        $totalTournaments = Tournament::count();
        $activeTournaments = Tournament::where('isActive', true)->count(); // Assuming 'active' is the status for active tournaments
        $inactiveTournaments = Tournament::where('isActive', false)->count();

        $categories = Category::all();
        $teams = Team::with('category')->get();

        $totalTeams = Team::count();
        $totalMatches = Maatch::count();
        return view("admin.dashboard", compact(
            "totalTournaments","totalTeams","totalMatches","activeTournaments","inactiveTournaments","allActiveTournaments","allInactiveTournaments","categories", "teams"
        ));
    }

    public function home(){
        $countAllActiveTournaments = Tournament::where('isActive', true)->count();

        $allActiveTournaments = Tournament::where('isActive', true)->get();
        $allInactiveTournaments = Tournament::where('isActive', false)->get();

        $categories = Category::all();
        $teams = Team::with('category')->get();

        $totalTeams = Team::count();
        $totalMatches = Maatch::count();
        return view("home", compact(
            "totalTeams","totalMatches","allActiveTournaments","allInactiveTournaments","categories", "teams", "countAllActiveTournaments"
        ));
    }
}
