<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'tipo',
        'password'        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
   
    public static function cadastrar(Request $request){
        $nomes = explode(' ',$request->name);
        $tamanho = sizeof($nomes);
        $user = new User();
        $user->name = $request->name;
        if($tamanho == 1){
            $user->email = $nomes[0]."@ispm.ao";
        }else{
            $user->email = $nomes[$tamanho-1].$nomes[0]."@ispm.ao";
        }
        $user->tipo = "Estudante";
        $user->password = bcrypt($nomes[0]."ispm");
        $user->save();
        return $user;
    }
    public static function cadastrarCandidato(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->tipo = "Candidato";
        $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }
    public static function entrar(Request $request):bool{
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As Credencias inseridas estão erradas'],
            ]);
        }
       Auth::login($user,$remember = true);
       return true;
    }
    public static function user(){
        $tipo = Auth::user()->tipo;
        return $tipo;
    }

    public function Candidato(){
        return $this->hasOne(Candidato::class);
    }
}
