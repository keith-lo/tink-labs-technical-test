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
        return response()->json(['foo' => 'bar']);
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
        return response()->json([
            'success' => true,
            'data' => ['account' => $account],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //Set is_active = 0 to archive the account instead of delete it.
        $account->is_active = false;

        $is_success = $account->save();

        return response()->json([
            'success' => $is_success
        ]);
    }
}
