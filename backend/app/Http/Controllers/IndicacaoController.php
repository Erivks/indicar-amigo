<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicacoes;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateIndicacao;

class IndicacaoController extends Controller
{
    public function create(Request $request) {
        $result = $this->validateCreate(
            $request, 
            CreateIndicacao::rules(), 
            CreateIndicacao::messages()
        ); 
        if ($result->fails()) {
            return $this->responseJSON($result->errors()->all(), 400);
        }

        $result = $this->checkIfCpfExists($request->input("cpf"));
        if ($result) {
            return $this->responseJSON("Este CPF já foi indicado!", 500);
        }

        if (!Indicacoes::create($request->all())) {
            return $this->responseJSON("Não foi possível cadastrar indicação ao banco!", 500);
        }

        return $this->responseJSON("Indicação incluida com sucesso!", 201);
    }

    public function responseJSON($data, Int $code) {
        return response()->json([
            'code'      => $code,
            'message'   => $data
        ], $code);
    }

    public function checkIfCpfExists(String $cpf) {
        return Indicacoes::where('cpf', '=', $cpf)->first();
    }
    
    public function getAll() {
        return Indicacoes::all();
    }

    public function delete($id) {
        $indicacao = Indicacoes::find($id);

        if ($indicacao) {
            $indicacao->delete();
            return $this->responseJSON("Registro deletado com sucesso!", 200);
        }

        return $this->responseJSON("Não foi possível deletar registro!", 500);
    }

    public function updateByID(Resquest $request, $id) {
        
    }

    public function validateRequest(Request $request, Array $rules, Array $messages) {
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }
}
