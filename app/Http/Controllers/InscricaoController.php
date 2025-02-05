<?php

namespace App\Http\Controllers;

use App\Models\inscricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscricaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=inscricao::all();
        return view('pages.estudante.inscricao',compact('valor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $valor=null;
        if (isset($request->id)) {
            # code...
            $valor=inscricao::find($request->id);
        } else {
            # code...
            $valor=new inscricao();
        }
        if(request()->hasFile('pdf_certificado')){
            $doc=MediaUploader::fromSource(request()->file('pdf_certificado'))
            ->toDirectory('DocInscricao')->onDuplicateIncrement()
            ->userHashForfilename()
            ->setAllowedExtensions(['pdf','jpg','png','jpeg'])->upload();
            $valor->pdf_certificado=$doc->basename;
        }
        if(request()->hasFile('pdf_bilhete')){
            $doc=MediaUploader::fronSource(request()->file('pdf_bilhete'))
            ->toDiretory('DocInscricao')->onDuplicateIncrement()
            ->userHashForfilename()
            ->setAllwedExtensions(['pdf','jpg','png','jpeg'])->upload();
            $valor->pdf_bilhete=$doc->basename;
        }
        if (request()->hasFile('foto')) {
            $doc = MediaUploader::fromSource(request()->file('foto'))
            ->toDirectory('DocInscricao')->onDuplicateIncrement()
            ->useHashForFilename()
            ->setAllowedAggregateTypes(['image'])->upload();
            $valor->foto=$doc->basename;
        }
        $valor->nome_completo=$request->nome;
        $valor->genero=$request->genero;
        $valor->numero_bilhete=$request->numero_bilhete;
        $valor->telefone=$request->telefone;
        $valor->nome_escola=$request->nome_escola;
        $valor->provincia=$request->provincia;
        $valor->naturalidade=$request->naturalidade;
        $valor->dt_nascimento=$request->dt_nascimento;
        $valor->curso_medio=$request->curso_medio;
        $valor->curso_superior=$request->curso_superior;
        $valor->data_inscricao=date('Y-m-d-h-i-s');
        $valor->user= Auth::user()->user->id;
        $valor->save();
        return redirect()->back()->with('INSCRIÇÃO FEITA COM SUCESSO');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(inscricao $inscricao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(inscricao $inscricao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, inscricao $inscricao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inscricao $inscricao)
    {
        //
    }
}
