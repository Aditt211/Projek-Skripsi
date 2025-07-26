<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Commodity statistics
        $commodity_count = Commodity::count();
        $commodity_condition_good_count = Commodity::where('condition', 1)->count();
        $commodity_condition_not_good_count = Commodity::where('condition', 2)->count();
        $commodity_condition_heavily_damage_count = Commodity::where('condition', 3)->count();
        $commodity_order_by_price = Commodity::orderBy('price', 'DESC')->take(5)->get();

        // Loan statistics
        $loans_active = Loan::where('status', 'borrowed')->count();
        $loans_returned = Loan::where('status', 'returned')->count();
        $loans_overdue = Loan::where('status', 'borrowed')
            ->where('due_date', '<', Carbon::now())
            ->count();
        $recent_loans = Loan::with(['commodity'])
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact(
            'commodity_count',
            'commodity_condition_good_count',
            'commodity_condition_not_good_count',
            'commodity_condition_heavily_damage_count',
            'commodity_order_by_price',
            'loans_active',
            'loans_returned',
            'loans_overdue',
            'recent_loans'
        ));
    }
}
