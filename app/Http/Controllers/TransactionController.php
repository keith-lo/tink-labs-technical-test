<?php

namespace App\Http\Controllers;

use App\Account;
use App\Transaction;
use App\Purpose;

use Illuminate\Http\Request;
use App\Http\Requests\SimplyTransactionPost;
use App\Http\Requests\TransferTransactionPost;

use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Deposit cash into an account
     *
     * @param \App\Http\Requests\SimplyTransactionPost $request
     * @return \Illuminate\Http\Response
     */
    public function deposit(SimplyTransactionPost $request)
    {
        //Get and check whether the account is exists.
        $account = $this->_getAccount($request->input('number'));
        $amount = $request->input('amount');

        //Create an transaction
        $transaction = $this->_createTransaction([
            'account_id' => $account->id, 'purpose_id' => \App\Purpose::DEPOSIT,
            'is_credit' => true, 'status' => \App\Transaction::COMPLETED,
            'title' => 'Withdraw '.$amount, 'amount' => $amount
        ]);

        $account->balance += $amount;

        //Start transaction
        $is_success = false;
        \DB::transaction(function() use($transaction, $account){
            $is_success = ( $transaction->save() && $account->save() );
        });

        return response()->json([
            'success' => $is_success,
            'data' => ['account' => $account, 'transaction' => $transaction],
        ]);
    }

    /**
     * Withdraw cash from an account
     *
     * @param \App\Http\Requests\SimplyTransactionPost $request
     * @return \Illuminate\Http\Response
     */
    public function withdraw(SimplyTransactionPost $request)
    {
        //Get and check whether the account is exists.
        $account = $this->_getAccount($request->input('number'));
        $amount = $request->input('amount');

        if( $account->balance < $amount ){
            throw new \Exception('Given account insufficient fund.');
        }

        //Create an transaction
        $transaction = $this->_createTransaction([
            'account_id' => $account->id, 'purpose_id' => \App\Purpose::WITHDRAW,
            'is_credit' => true, 'status' => \App\Transaction::COMPLETED,
            'title' => 'Withdraw '.$amount, 'amount' => $amount
        ]);

        $account->balance -= $amount;

        //Start transaction
        $is_success = false;
        \DB::transaction(function() use($transaction, $account){
            $is_success = ( $transaction->save() && $account->save() );
        });

        return response()->json([
            'success' => $is_success,
            'data' => ['account' => $account, 'transaction' => $transaction],
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    public function transfer(TransferTransactionPost $request)
    {
        $from_account = $this->_getAccount($request->input('from'));
        $to_account = $this->_getAccount($request->input('to'), false);

        $amount = $request->input('amount');
        if( $from_account->balance < $amount ){
            throw new \Exception('Given account insufficient fund.');
        }

        $transactions = [];
        if( empty($to_account) ){
            $is_valid = $this->_check_valid_external_account($request->input('to'));
            if( !$is_valid ){
                throw new \Exception('External account does not exists.');
            }

            //Create an transaction
            //Status is pennding because T+2
            $charge = config('bank.service_charge');
            $transactions[] = $this->_createTransaction([
                'account_id' => $from_account->id, 'purpose_id' => \App\Purpose::TRANSFER,
                'is_credit' => true, 'status' => \App\Transaction::PENDING,
                'title' => 'Transfer '.$amount, 'amount' => $amount,
                'description' => 'External account : '.$request->input('to'),
            ]);

            //Service charge transactions
            $service_charge = 100;
            $transactions[] = $this->_createTransaction([
                'account_id' => $from_account->id, 'purpose_id' => \App\Purpose::SERVICE_CHARGE,
                'is_credit' => true, 'status' => \App\Transaction::COMPLETED,
                'title' => 'Service charge '.$service_charge, 'amount' => $service_charge
            ]);

            $from_account->balance -= $amount;
        }else{
            //Create an transaction
            $transactions[] = $this->_createTransaction([
                'account_id' => $from_account->id, 'purpose_id' => \App\Purpose::TRANSFER,
                'is_credit' => true, 'status' => \App\Transaction::COMPLETED,
                'title' => 'Transfer '.$amount, 'amount' => $amount,
                'description' => 'To account : '.$to_account->number,
            ]);

            $from_account->balance -= $amount;
            $to_account->balance += $amount;
        }

        //Start transaction
        $is_success = false;
        \DB::transaction(function() use($transactions, $from_account, $to_account){
            $is_success = true;
            foreach( $transactions as $transaction ){
                if( !$transaction->save() ){
                    $is_success = false;
                }
            }
            if( !$from_account->save() ){ $is_success = false; }
            if( $to_account ){
                if( !$to_account->save() ){ $is_success = false; }
            }
        });

        $data = ['from_account' => $from_account, 'transactions' => $transactions];
        $data['to_account'] = ( $to_account ) ? $to_account : array();
        return response()->json([
            'success' => $is_success, 'data' => $data,
        ]);

        var_dump($to_account);

        print_r($_POST);exit;
    }

    private function _check_valid_external_account($number){
        $curl = curl_init();

        $url = config('bank.check_ext_account_url');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        $arr = json_decode($result, true);

        curl_close($curl);

        if( is_array($arr) && array_key_exists('status', $arr) &&
            $arr['status'] == 'success'
        ){
            return true;
        }

        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    /**
     * Get account object by account number
     *
     * @param String $account_number
     * @param bool $is_validate, default as true
     * @return \App\Account
     */
    private function _getAccount($account_number, $is_validate = true){
        //Get and check whether the account is exists.
        $res = \App\Account::where('number', $account_number);
        return ( $is_validate ) ? $res->firstOrFail() : $res->first();
    }

    /**
     * Create a transaction object
     *
     * @return \App\Transaction
     */
    private function _createTransaction(array $values){
        $transaction = new \App\Transaction();
        foreach( $values as $field => $value ){
            $transaction->$field = $value;
        }
        return $transaction;
    }
}
