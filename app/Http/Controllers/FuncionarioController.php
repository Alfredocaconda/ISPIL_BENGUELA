<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class FuncionarioController extends Controller
{
    /**
     * Exibe a lista de funcionários.
     */
    public function index()
    {
        $valor = Funcionario::orderBy('name', 'asc')->get();
        return view("pages.admin.funcionario", compact("valor"));
    }

    /**
     * Cria ou atualiza um funcionário.
     */
    public function store(Request $request)
    {
        try {
            // Definir regras de validação
            $rules = [
                'name' => ['required', 'string', 'min:10', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
                'email' => 'required|email|unique:users,email',
                'telefone' => 'required|digits:9|unique:funcionarios,telefone',
            ];

            // Se for edição, desconsidera unique para o próprio funcionário
            if ($request->filled('id')) {
                $funcionarioExistente = Funcionario::find($request->id);
                if (!$funcionarioExistente) {
                    return redirect()->back()->with("Error", "Funcionário não encontrado.");
                }

                $rules['email'] = 'required|email|unique:users,email,' . $request->id;
                $rules['telefone'] = 'required|digits:9|unique:funcionarios,telefone,' . $request->id;
            }

            // Validação dos campos
            $request->validate($rules, [
                'name.required' => 'O nome é obrigatório!',
                'name.min' => 'O nome deve ter pelo menos 10 letras.',
                'email.required' => 'O e-mail é obrigatório!',
                'email.email' => 'Informe um e-mail válido!',
                'email.unique' => 'Este e-mail já está cadastrado!',
                'telefone.required' => 'O telefone é obrigatório!',
                'telefone.unique' => 'Este telefone já está cadastrado!',
                'telefone.digits' => 'O telefone deve ter exatamente 9 dígitos!',
            ]);

            // Verifica se é edição ou novo cadastro
            if ($request->filled('id')) {
                $funcionario = Funcionario::find($request->id);
            } else {
                $funcionario = new Funcionario();
                $user = User::cadastrarFuncionario($request);
                $funcionario->user_id = $user->id;
            }

            // Preenche os campos
            $funcionario->name = $request->name;
            $funcionario->cargo = $request->cargo;
            $funcionario->telefone = $request->telefone;
            $funcionario->n_bi = $request->n_bi;
            $funcionario->email = $request->email;
            $funcionario->data_contratacao = $request->data_contratacao;
            $funcionario->save();

            return redirect()->back()->with("Sucesso", $request->filled('id') ? "Funcionário atualizado com sucesso!" : "Funcionário cadastrado com sucesso!");

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (QueryException $e) {
            return redirect()->back()->with("Error", "Erro ao salvar funcionário. Tente novamente.");
        }
    }

    /**
     * Exibe um funcionário específico.
     */
    public function show($id)
    {
        $valor = Funcionario::find($id);
        if (!$valor) {
            return redirect()->back()->with("Error", "Funcionário não encontrado.");
        }
        return view("pages.admin.funcionario", compact("valor"));
    }

    /**
     * Remove um funcionário.
     */
    public function apagar($id)
    {
        $funcionario = Funcionario::find($id);
        if (!$funcionario) {
            return redirect()->back()->with("Error", "Funcionário não encontrado.");
        }
        $funcionario->delete();
        return redirect()->back()->with("Sucesso", "Funcionário eliminado com sucesso.");
    }
}
