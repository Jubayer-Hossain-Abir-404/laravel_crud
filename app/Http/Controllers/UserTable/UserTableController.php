<?php

namespace App\Http\Controllers\UserTable;

use App\Http\Controllers\Controller;
use App\Models\UserTable;
use Illuminate\Http\Request;

class UserTableController extends Controller
{
    public function index()
    {

        $user_table = UserTable::latest('id')->get();

        return view('home.index', compact('user_table'));
    }


    public function edit(UserTable $user_table)
    {
        return view('edit.edit', compact('user_table'));
    }

    public function update(UserTable $user_table)
    {
        request()->validate([

            'name' => 'required|max:255',

            'email' => 'required|email|max:255',
        ]);
        

        $user_table->update([

            'name' => request('name'),

            'email' => request('email'),
        ]);


        return redirect()->route('home');
    }

    // public function create()
    // {
    //     return view('posts.create');
    // }

    public function store(Request $request)
    {
        request()->validate([

            'name' => 'required|max:255',

            'email' => 'required|email|max:255',
        ]);

        $input = $request->all();

        // $input = request()->all();

        if($request->hasFile('image'))
        {
            $destination_path = 'public/images/users';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destination_path, $image_name);

            $input['image'] = $image_name;
        }

        // UserTable::create([
        //     'name' => request('name'),

        //     'email' => request('email'),
        // ]);

        UserTable::create($input);


        return redirect()->route('home');
    }

    public function delete(UserTable $user_table)
    {
        return view('delete.delete', compact('user_table'));
    }

    public function destroy(UserTable $user_table)
    {
        $user_table->delete();

        return redirect()->route('home');
    }
}
