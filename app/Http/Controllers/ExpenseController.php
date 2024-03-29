<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Repositories\BudgetRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExpenseController extends Controller
{
    public $user;
    public $budgetRepository;


    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
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

        $expenses = $user->expenses()->orderBy('created_at', 'DESC')->where('date_logged', 'LIKE', '%'.$today.'%')->get();
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
//        $monthVal = Carbon::today()->month;
//        $monthVal = str_pad($monthVal, '2', 0, STR_PAD_LEFT);
//
//        if(!$monthVal) return response()->json(['message' => 'Invalid Month', 'status'=>'error'], 400);
//
//        $date = Carbon::today()->year.'-'. $monthVal;


        $expenses = [];
        $expenses['current'] = $user->expenses()->with('budget')->orderBy('date_logged', 'DESC')->whereMonth('date_logged', Carbon::now())->get();

        $yearly_expense = $user->expenses()->whereYear('date_logged', Carbon::now())->get();
        $expenses['yearly_count'] = $yearly_expense->count();
        $expenses['yearly_amount'] = $yearly_expense->sum('amount');

        $expenses['overall_count'] = $user->expenses()->get()->count();
        $expenses['overall_amount'] = $user->expenses()->get()->sum('amount');

        return response()->json($expenses);
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
        $this->validate($request, [
            'title' => 'required_without:budget_id',
            'amount' => 'required',
            'budget_id' => 'numeric|nullable',
        ]);

        $user = auth()->user();
        $storedExpense = $user->expenses()->firstOrCreate([
            'title' => $request->title,
            'budget_id' => $request->budget_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date_logged' => $request->date_logged ?: Carbon::now(),
        ], [
            'category' => $request->category,
        ]);

        if($storedExpense) {
            if($request->budget_id) {
                $budget = $this->budgetRepository->find($request->budget_id);
                $budget->logged_as_expense = 1;
                $budget->save();
            }
            return response()->json([
                'message' => 'Expense logged successfully.',
                'data' => $storedExpense,
                'status' => 'success']);
        } else {
            return response()->json(['message' => 'Error Creating Expense', 'status' => 'error'], 400);
        }
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();
        $expense = $user->expenses()->find($request->id);
        if(!$expense) return response()->json("No expense found", 401);
        $expense->delete();

        return response()->json("Deleted expense");
    }
}
