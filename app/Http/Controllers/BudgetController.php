<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Repositories\BudgetRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    private $budgetRepository;

    public function __construct(BudgetRepository $budgetRepository)
    {
        parent::__construct();
        $this->budgetRepository = $budgetRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $budgets = $this->budgetRepository->all();
        return response()->json($budgets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "title" => "required",
            "amount" => "numeric",
            "description" => "nullable",
            "for" => "nullable"
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $data = $this->budgetRepository->save($validatedData);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        //
    }


    public function unlogged() {
        $unlogged_budgets = $this->budgetRepository->unlogged();
        return response()->json($unlogged_budgets);
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

//        if(!$monthVal) return response()->json(['message' => 'Invalid Month', 'status'=>'error'], 400);

//        $date = Carbon::today()->year.'-'. $monthVal;


        $budgets = [];
        $budgets['current'] = $user->budgets()->orderBy('for', 'DESC')->whereMonth('for', Carbon::now())->get();

        $yearly_budget = $user->budgets()->whereYear('for', Carbon::now())->get();
        $budgets['yearly_count'] = $yearly_budget->count();
        $budgets['yearly_amount'] = $yearly_budget->sum('amount');

        $budgets['overall_count'] = $user->budgets()->get()->count();
        $budgets['overall_amount'] = $user->budgets()->get()->sum('amount');

        return response()->json($budgets);
    }

}
