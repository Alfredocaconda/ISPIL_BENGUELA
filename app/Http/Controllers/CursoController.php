<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Plank\Mediable\Facades\MediaUploader;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=curso::all();
        return view('pages.secretaria.cursos',compact('valor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        try {
            // Definir regras de validação
            $rules = [
                'name' => ['required', 'string', 'min:10', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            ];

            // Se for edição, desconsidera unique para o próprio funcionário
            if (!$request->filled('id')) { // Se for um novo cadastro
                $rules['foto'] = ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'];
            }
            

            // Validação dos campos
            $request->validate($rules, [
                'name.required' => 'O nome é obrigatório!',
                'name.min' => 'O nome deve ter pelo menos 10 letras.',
            ]);

            // Verifica se é edição ou novo cadastro
            if ($request->filled('id')) {
                $valor = Curso::find($request->id);
            } else {
                $valor = new Curso();
            }
            if (request()->hasFile('foto')) {
            $doc = MediaUploader::fromSource(request()->file('foto'))
            ->toDirectory('docCurso')->onDuplicateIncrement()
            ->useHashForFilename()
            ->setAllowedAggregateTypes(['image'])->upload();
            $valor->foto=$doc->basename;
        } else {
                return redirect()->back()->with("Error", "O upload da foto é obrigatório!");
            }
            
            // Preenche os campos
            $valor->name = $request->name;
            $valor->vagas = $request->vagas;
            $valor->preco = $request->preco;
            $valor->save();

            return redirect()->back()->with("Sucesso", $request->filled('id') ? "Curso atualizado com sucesso!" : "Funcionário cadastrado com sucesso!");

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (QueryException $e) {
            return redirect()->back()->with("Error", "Erro ao salvar Curso. Tente novamente.");
        }
    }

    /**
     * Exibe um funcionário específico.
     */
    public function show($id)
    {
        $valor = Curso::find($id);
        if (!$valor) {
            return redirect()->back()->with("Error", "Curso não encontrado.");
        }
        return view("pages.secretaria.Curso", compact("valor"));
    }

    /**
     * Remove um funcionário.
     */
    public function apagar($id)
    {
        $valor = Curso::find($id);
        if (!$valor) {
            return redirect()->back()->with("Error", "Curso não encontrado.");
        }
        $valor->delete();
        return redirect()->back()->with("Sucesso", "Curso eliminado com sucesso.");
    }
}

