<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Candidato;
use App\Models\inscricao;
use App\Models\matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use User as GlobalUser;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.password
     */
    public function auth(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Este e-mail não está cadastrado.'],
            ]);
        }
    
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['A senha está incorreta.'],
            ]);
        }
    
        Auth::login($user, true);
    
        return $this->redirectUserByType($user);
    }
    
    /**
     * Redireciona o usuário com base no tipo.
     */
    private function redirectUserByType(User $user)
    {
        // Verificar a última inscrição do usuário
        $inscricao = inscricao::where('user_id', $user->id)->latest()->first();
        
        // Verificar a última matrícula (se já tem)
        $matricula = Matricula::where('user_id', $user->id)->latest()->first();
    
        return match ($user->tipo) {
            'Candidato' => match (true) {
                $matricula !== null && $matricula->reconfirmacao_pendente => redirect()->route('reconfirmacao.index'),
                $matricula !== null => redirect()->route('candidato.index'),
    
                // Se ainda não tem matrícula, mas foi admitido
                $inscricao !== null && $inscricao->estado === 'Admitido' => redirect()->route('matricula.index'),
    
                // Se não foi admitido ou inscrição ausente
                default => redirect()->route('principal')
            },
    
            'Estudante' => $matricula && $matricula->reconfirmacao_pendente
                ? redirect()->route('admin.index','matricula')
                : redirect()->route('admin.index','matricula'),

            'Admin', 'secretaria' => redirect()->route('admin.index'),
            default => redirect('login'),
        };
    }
    
    /**
     * Redireciona o usuário com base no tipo.
     */

    public function index()
    {
        //
        $user=User::where('tipo','<>','Admin')->get();
        return view("pages.admin.index",compact("user"));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $valor=null;
        if (isset($request->id)) {
            # code...
            $valor= User::find($request->id);
        } else {
            # code...
            $valor= new User();
        }
        $valor->name=$request->name;
        $valor->email=$request->email;
        $valor->tipo=$request->tipo;
        $valor->password=bcrypt($request->password);
        $valor->save();
        return redirect()->back()->with("Sucesso","Usuario cadastrado com sucesso");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $valor=user::find($id);
        return redirect()->route('user.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function apagar($id)
    {
        user::find($id)->delete();
        $sms = "ESTUDANTE Eliminado com sucesso";
        return redirect()->back()->with("Sucesso",$sms);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function cadastrar(Request $request){
         $valor=null;
         $user = null;
            if (isset($request->id)) {
                # code...
                $valor= Candidato::find($request->id);
            } else {
                $user = User::cadastrarCandidato($request);
                $valor=new Candidato();
                $valor->user_id = $user->id;
            }
                $valor->name=$request->name;
                $valor->email=$request->email;
                $valor->password=bcrypt($request->password);
                $valor->save();
            if(User::entrar($request)){
                return redirect()->route('candidato.index');
            }else{
                return redirect()->route('auth.login');
            }
    }

    public function perfil(){
       return view('pages.perfil.perfil');
   }
}
