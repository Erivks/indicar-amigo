<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicacoes;
use Illuminate\Support\Facades\Validator;

class IndicacaoController extends Controller
{
    private $messages = [
        'required'  => 'O campo :atrribute deve ser preenchido',
        'string'    => 'O campo :attribute deve ser uma string',
        'email'     => 'O campo :attribute deve ser um email válido',
        'max'       => 'O campo :attribute não pode ser maior que :max caracteres'
    ];

    public function create(Request $request) {
        $result = $this->validateCreate($request); 
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

    public function validateCreate(Request $request) {
        $validator = Validator::make($request->all(), [
            'nome'      => 'required|string|max:220',
            'cpf'       => 'required|string|max:11',
            'telefone'  => 'required|string|max:15',
            'email'     => 'required|string|email|max:255'
        ], $this->messages);

        return $validator;
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
}
