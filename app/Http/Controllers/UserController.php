<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Client;

class UserController extends Controller
{
    use IssueTokenTrait;

    private $client;

   public function __construct()
   {
       $this->client = Client::find(1);
   }

    public function index()
    {
        dd('test');
    }


    public function addChild(Request $request)
    {
        //un parent ajout un enfant
        $this->validate($request, [
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'adresse' => 'required',
            'tel' => 'required',
        ]);

        $child = User::create([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'adresse' => $request->input('adresse'),
            'tel' => $request->input('tel'),
            'role_id' => Role::find(2)->id,
        ]);

        User::where('id',$child->id)->update(['parent_id'=> \Auth::user()->id]);

        return User::find($child->id, ['id', 'nom', 'prenom','email', 'adresse', 'tel']);

    }


    public function register(Request $request)
    {
        $this->validate($request,[
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',//|confirmed
            'adresse' => 'required',
            'tel' => 'required',
            //'role_id' => 'required'
        ]);

        User::create([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'adresse' => $request->input('adresse'),
            'tel' => $request->input('tel'),
            'role_id' => Role::find(1)->id,//$request->input('role_id'),
        ]);

        return $this->issueToken($request, 'password');
    }

    public function children(){

        $children = User::where('parent_id',\Auth::user()->id)->get(['id', 'nom', 'prenom','email', 'adresse', 'tel','image_url']);

        return ['data' => $children];
    }

    // Ajouter la photo de profil du user

    public function addPhoto(Request $request){
        $this->validate($request, [
            'image_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        $user = \Auth::user();

        $uploadedFile = $request->file('image_url');
        $filename = time().$uploadedFile->getClientOriginalName();
        $fileDName = explode('.', $filename);

        Storage::disk('mes_images')->putFileAs(
            $fileDName[0],
            $uploadedFile,
            $filename
        );
        User::where('id',$user->id)->update(['image_url' => $filename]);

        return User::find($user->id, ['id', 'image_url']);
    }

    public function showImage($id){
        $user =User::find($id);

        $path = Storage::disk('local')->path($user->image_url);
        //$file = Storage::download(public_path()."/storage/".$user->image_url);
        //dd($path);
        //$file = new File($path);
        return [
            'image' => file_get_contents($path)
        ];
    }

    public function addChildPhoto(Request $request){
//        $this->validate($request, [
//            'image_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
//            'id' => 'required',
//        ]);

        //$path = "";

        $user = User::findOrFail($request->input('id'));

        $uploadedFile = $request->file('image_url');
        $filename = time().$uploadedFile->getClientOriginalName();
        $fileDName = explode('.', $filename);

        Storage::disk('mes_images')->putFileAs(
            $fileDName[0],
            $uploadedFile,
            $filename
        );

        User::where('id',$user->id)->update(['image_url' => $filename]);

        return  User::find($user->id, ['id', 'image_url']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
