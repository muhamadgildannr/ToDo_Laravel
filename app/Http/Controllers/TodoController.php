<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('dashboard.index2');
    }
    public function register()
    {
        return view('dashboard.register');
    }
    public  function inputRegister(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required',
            'name' => 'required|min:4|max:50',
            'username' => 'required|min:4|max:8',
            'password' => 'required',
        ]);
        User::create([
            'name' => $request->name,
            'username' =>
            $request->username,
            'email' =>
            $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/')->with('success', 'berhasil membuat akun');
    }
    public function auth (Request $request){
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ],
    [
        'username.exists' => "This username doesn't exists"
    ]);
    $user = $request->only('username', 'password');
    if (Auth::attempt($user)){
        return redirect()->route('todo.index');
    }else {
        return redirect('/')->with('fail', "Gagal Login, periksa dan coba lagi!");
    }  
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
    public function index()
    {
        //menampilkan halaman awal, semua data 
        //ambil semua data todo dari database
        //cari data todo yang punya user_id  nya sama dengan id orang login. kalau ketemu datanya diambil
        $todos = Todo::where([
            ['user_id', '=', Auth::user()->id],
            ['status', '=', 0],
            ])->get();     
        //tampilkan file index di folder dashboard dan bawa data dari variable yang namanya todos ke file tersebut   
        return view('dashboard.home', compact('todos'));
        //menampilkan halaman awal
    }
    public function complated()
    {
        $todos = Todo::where([
            ['user_id', '=', Auth::user()->id],
            ['status', '=', 1],
            ])->get(); 
        return view('dashboard.complated', compact('todos'));
    }
    public function updateComplated($id)
    {
        Todo::where('id', $id)->update([
            'status'=> 1,
            'done_time' => Carbon::now(),
        ]);
        return redirect()->route('todo.complated')->with('done', 'Todo sudah selesai dikerjakan!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.create');
        //menampilkan halaman input form tambah data
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:8',
        ]);
        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'status' => 0,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->route('todo.index')->with('successAdd', 
        'Berhasil menambahkan data Todo!');
        //mengirim data ke database (data baru) / menambahkan data baru ke db
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //menampilkan satu data asade
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //menampilkan form edit data
        //ambil data dari db yang id nya sama dengan id yang dikirim di route
        $todo = Todo::where('id', $id)->first();
        //lalu tampilkan halaman dari view edit dengan mengirim data
        return view('dashboard.edit', compact('todo'));
        //menampilkan edit data 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //mengubah data di database
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:8',
        ]);
        //update data yang id nya sama dengan id dari route, updatenya ke db bagian table todos
        Todo::where('id', $id)->update([
            'title'=> $request->title,
            'description'=> $request->description,
            'date'=> $request->date,
            'status'=> 0,
            'user_id'=> Auth::user()->id,        
        ]);
        //kalau berhasil bakal diarahin ke halaman awal todo dengan pemberitahuan berhasil
        return redirect('/todo/')->with('successUpdate', 'Data Berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // parameter $id akan mengambil data dari patch dinamis {id}
        // cari data yang isian column id nya sama dengan $id yang dikirm ke patch dinamis
        // kalau ada, ambil terus hapus datanya
        Todo::where('id', '=', $id)->delete();
        // kalau berhasil, bakal dibalikin ke halaman list todo dengan pemberitahuan
        return redirect()->route('todo.index')->with('successDelete', 'Berhasil menghapus data ToDo!');
    }
}
