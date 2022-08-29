<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImportHistory;
use App\Models\Transaction;
use App\Traits\ApiResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImportHistoryController extends Controller
{
    use ApiResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $importHistory = ImportHistory::all();
        return $this->successResponse($importHistory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toReverse(Request $request)
    {
        
        try {
            $messages  = [
                'id.required' => 'O Id é obrigatório',
            ];
    
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ], $messages);
    
            if ($validator->fails()) 
                return $this->errorResponse(['type'=>'validator', 'messages'=>$validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            
            DB::beginTransaction();

            $importHistory = ImportHistory::FindOrFail($request->id);

            //excluindo as transações
            Transaction::where('import_history_id', $importHistory->id)->delete();

            $importHistory->status = 'reversed';
            $importHistory->update();

            DB::commit();
            return $this->successResponse([], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("ImportHistoryController - toReverse - " . $th->getMessage());
            return $this->errorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
