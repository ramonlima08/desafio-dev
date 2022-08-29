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
     * @OA\Get(
     *     path="/api/importhistory",
     *     tags={"Importações"},
     *     summary="Lista as Importações",
     *     description="Endpoint destinado a listagem das Imporações",
     *     operationId="listImports",
     *     
     *     @OA\Response(
     *         response="200", 
     *         description="Lista de Imporações",
     *         @OA\MediaType(mediaType="application/json"),
     *     ),
     * )
     */
    public function index()
    {
        $importHistory = ImportHistory::all();
        return $this->successResponse($importHistory);
    }

    /**
     * @OA\Post(
     *     path="/api/importhistory/toreverse",
     *     tags={"Importações"},
     *     summary="Revert uma Importação",
     *     description="Endpoint destinado a reverter uma importação de arquivo CNAB, removendo as transações e alterando o status da importação",
     *     operationId="revertImports",
     *     @OA\MediaType(mediaType="multipart/form-data"),
     *     @OA\Response(
     *         response="201", 
     *         description="Reverção executada com sucesso",
     *         @OA\MediaType(mediaType="application/json"),
     *     ),
     *     @OA\Response(
     *         response="422", 
     *         description="Parametros esperados não foram encontrados",
     *         @OA\MediaType(mediaType="application/json"),
     *     ),
     *     @OA\Response(
     *         response="500", 
     *         description="Erro no processamento dos dados",
     *         @OA\MediaType(mediaType="application/json"),
     *     ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                     description="Id da importação",
     *                     property="id",
     *                  ),
     *              ),
     *           ),
     *      ),
     * )
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
