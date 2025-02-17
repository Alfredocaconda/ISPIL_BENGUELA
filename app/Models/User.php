<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'tipo',
        'password'        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function cadastrarFuncionario(Request $request)
    {
        $nomes = explode(' ',$request->name);
        $tamanho = sizeof($nomes);
        $user = new User();
        $user->name = $request->name;
        if($tamanho == 1){
            $user->email = $nomes[0]."@ispil.ao";
        }else{
            $user->email = $nomes[$tamanho-1].$nomes[0]."@ispil.ao";
        }
        $user->tipo = "secretaria";
        $user->password = bcrypt("ispil@2025");
        $user->save();
        return $user;
    }
    public static function cadastrar(Request $request)
    {
        $nomes = explode(' ',$request->name);
        $tamanho = sizeof($nomes);
        $user = new User();
        $user->name = $request->name;
        if($tamanho == 1){
            $user->email = $nomes[0]."@ispil.ao";
        }else{
            $user->email = $nomes[$tamanho-1].$nomes[0]."@ispil.ao";
        }
        $user->tipo = "estudante";
        $user->password = bcrypt($nomes[0]."ispil");
        $user->save();
        return $user;
    }

    public static function cadastrarCandidato(Request $request)
    {
        
        $request->validate([
            'name' => ['required', 'string', 'min:10', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 10 letras.',
            'name.regex' => 'O nome deve conter apenas letras e espaços.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        $user = new User();
        $user->name=$request->name;
        $user->email = $request->email;
        $user->tipo = "Candidato";
        $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }

    public static function entrar(Request $request): bool
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As Credencias inseridas estão erradas'],
            ]);
        }
        Auth::login($user, $remember = true);
        return true;
    }

    // Renomeado para evitar conflitos
    public static function getTipo()
    {
        return Auth::user()->tipo;
    }

    public function Candidato()
    {
        return $this->hasOne(Candidato::class);
    }
    public function funcionario(){
        return $this->hasOne(Funcionario::class,'user_id');
    }
}
