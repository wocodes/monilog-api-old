<?php

namespace App\Http\Controllers;

use App\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExpenseController extends Controller
{
    public $user;

    public function __construct()
    {
//        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing all expenses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = auth()->user();
        $expenses = $user->expenses()->orderBy('date_logged', 'DESC')->get();
        return response()->json(['message' => 'List of Expenses', 'data' => $expenses, 'status' => 'success']);
    }

    /**
     * Display a today's expenses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function today()
    {
        $user = auth()->user();
        $today = substr(Carbon::today(), 0, 10);

        $expenses = $user->expenses()->orderBy('date_logged', 'DESC')->where('date_logged', 'LIKE', '%'.$today.'%')->get();
        return response()->json(['message' => 'List of Expenses', 'data' => $expenses, 'status' => 'success']);
    }

    /**
     * Display a listing of the month's expenses.
     *
     * @param $year
     * @param $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function yearMonth($year, $month = null)
    {
        $user = auth()->user();
        $monthVal = Carbon::parse($month)->month;
        $monthVal = str_pad($monthVal, '2', 0, STR_PAD_LEFT);

        if(!$monthVal) return response()->json(['message' => 'Invalid Month', 'status'=>'error'], 400);

        $expenses = $user->expenses()->orderBy('date_logged', 'DESC');

        if($year && !$month) {
            $date = $year;
            $expenses = $expenses->where('date_logged', 'LIKE', $date.'%')->get();
        } else if($year && $month) {
            $date = $year.'-'. $monthVal;
            $expenses = $expenses->where('date_logged', 'LIKE', $date . '%')->get();
        }

        return response()->json(['message' => 'List of Expenses', 'data' => $expenses, 'status' => 'success']);
    }


    /**
     * Display a listing of the month's expenses.
     *
     * @param $year
     * @param $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentMonth()
    {
        $user = auth()->user();
        $monthVal = Carbon::today()->month;
        $monthVal = str_pad($monthVal, '2', 0, STR_PAD_LEFT);

        if(!$monthVal) return response()->json(['message' => 'Invalid Month', 'status'=>'error'], 400);

        $date = Carbon::today()->year.'-'. $monthVal;
        $expenses = $user->expenses()->orderBy('date_logged', 'DESC')->where('date_logged', 'LIKE', $date . '%')->get();

        return response()->json(['message' => 'List of Expenses', 'data' => $expenses, 'status' => 'success']);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'amount' => 'required',
            ]);
        } catch(ValidationException $e) {
            return response()->json([
                'message' => 'Invalid data supplied.',
                'data' => $e->getMessage(),
                'status' => 'error'
            ], 400);
        }

        $user = auth()->user();
        $storedExpense = $user->expenses()->firstOrCreate([
            'title' => $request->title,
            'amount' => $request->amount,
            'description' => $request->description,
            'date_logged' => $request->date_logged ?: Carbon::now(),
        ], [
            'category' => $request->category,
        ]);

        if($storedExpense)
            return response()->json([
                'message' => 'Expense logged successfully.',
                'data' => $storedExpense,
                'status' => 'success']);
        else
            return response()->json(['message' => 'Error Creating Expense', 'status'=>'error'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
