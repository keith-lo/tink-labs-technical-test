<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

use App\Http\Requests\StoreAccountPost;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = \App\Account::all();

        return response()->json([
            'success' => true,
            'accounts' => $accounts->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAccountPost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountPost $request)
    {
        $account = new \App\Account();

        $account->number = $request->input('number');
        $account->balance = $request->input('balance', 0);  //Set balance as 0 if not given

        $is_success = $account->save();

        return response()->json([
            'success' => $is_success,
            'data' => ['account' => $account],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        $account->transactions; //Include account transactions
        return response()->json([
            'success' => true,
            'data' => ['account' => $account],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();

        return response()->json([
            'success' => true,
            'data' => ['account' => $account],
        ]);
    }
}
