<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/grimmadmin';
    
    protected $redirectAfterLogout = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'ruolo' => 'Allevatore'
        ]);
         
    }

    public function index(){
        return view('grimmadmin.page.user');
    }
    public function get(){
        return User::all();
    }
    public function createNew(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->mail;
        $user->password = bcrypt($request->password);
        $user->ruolo = $request->ruolo;
        $file = File::allFiles( public_path().'/storage/temp');
        if (count($file)<1) {
            $user->save();
            return redirect('/grimmadmin/user');
        }
        File::move( public_path().'/storage/temp/'.pathinfo($file[0])['basename'],base_path().'/storage/app/user/'.pathinfo($file[0])['basename']);   
        $user->img = '/storage/user/'.pathinfo($file[0])['basename'];
        $user->save();
        return redirect('/grimmadmin/user');
    }
    public function uploadUserFoto(Request $request){
        if(!$request->hasFile('photos')) {
            return response()->json(['upload_file_not_found'], 400);
        }

        $outsidePath = $request->file('photos');
        if(!$outsidePath->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $file = $outsidePath->storeAs('temp', $outsidePath->getClientOriginalName());
        $outsidePath = '/storage/temp/'.$outsidePath->getClientOriginalName();
        return response()->json(compact('outsidePath'));

    }
    public function getNumber($numero)
    {
        $response = User::where('approved',false)->take($numero)->get();
        return $response;
    }
    public function approva(Request $request)
    {
        $us = User::find($request->id);
        $us->approved = true;
        $us->update();
        $response = User::where('approved',false)->take($request->numero)->get();
        return $response;
    }
    public function elimina(Request $request)
    {
        $ev = User::find($request->id);
        $ev->delete();
        $response = User::where('approved',false)->take($request->numero)->get();
        return $response;
    }
    public function cancella(Request $request)
    {
        $ev = User::find($request->id);
        $ev->delete();
        $response = User::all();
        return $response;
    }
    public function count(Request $request){
        if (isset($request->giorni)) {
            $u = User::whereDate('created_at', '>=', Carbon::now()->subDays($request->giorni))->get();
            //$u = User::whereDate('created_at', '<=', Carbon::now()->subDays($request->giorni))->get();

            return count($u);
        }
        return User::count();
    }
    public function update(Request $request, int $id){
        $user = User::find($id);
        return view('grimmadmin/page/nuovo-user', ['user' => $user]);

    }
    public function modifica(Request $request){
        $user = User::find($request->_id);

        $user->name = $request->name;
        $user->email = $request->mail;
        $user->password = bcrypt($request->password);
        $user->ruolo = $request->ruolo;
        $file = File::allFiles( public_path().'/storage/temp');
        if (count($file)<1) {
            $user->save();
            return redirect('/grimmadmin/user');
        }
        File::move( public_path().'/storage/temp/'.pathinfo($file[0])['basename'],base_path().'/storage/app/user/'.pathinfo($file[0])['basename']);   
        $user->img = '/storage/user/'.pathinfo($file[0])['basename'];
        $user->save();
        return redirect('/grimmadmin/user');

    }
}
