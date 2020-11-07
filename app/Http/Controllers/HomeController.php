<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class HomeController extends Controller {

    public function dashboard()
    {
        $dashboard_stats = [];
        $user= auth()->user();

        $monthly_expenses = $user->expenses()->whereMonth('date_logged', Carbon::now())->get()->sum('amount');

        $monthly_budget = $user->budgets()->whereMonth('for', Carbon::now())->get()->sum('amount');


        $dashboard_stats['monthly_total_expense'] = $monthly_expenses;
        $dashboard_stats['monthly_total_budget'] = $monthly_budget;
        $dashboard_stats['monthly_difference'] = $monthly_budget - $monthly_expenses;

        return response()->json($dashboard_stats);
    }
}
