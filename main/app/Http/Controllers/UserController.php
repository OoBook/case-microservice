<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all(), empty($request->all()));

        $query = User::where([
            ['normalized_name', '!=', Null],
            [
                function($query) use($request){
                    if( ($normalized = preg_replace('/\-/', ' ', Str::slug($request->name)) ) ){
                        switch($request->action){
                            case 'post-match':
                                $query->orWhere('normalized_name', 'like', '%'.$normalized)->get();

                                break;
                            case 'pre-match':
                                $query->orWhere('normalized_name', 'like', $normalized . '%')->get();
                                break;
                            case 'match':
                                $query->orWhere('normalized_name', $normalized)->get();

                                break;
                            default:
                                $query->orWhere('normalized_name', 'like', '%'.$normalized . '%')->get();
                                break;
                        }
                    }
                    // dd($query);
                }
            ]
        ]);
        $users = $query->orderBy('')->paginate( 10 );
        // dd($users);

        // $users = User::query()
        //     ->where('normalized_name', 'LIKE', "%{$search}%")
        //     // ->orWhere('body', 'LIKE', "%{$search}%")
        //     ->paginate(10);
        return view('users.index', compact('users'));
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /***
         * Standartta role_id validation'ı aşağıda yapılıp, 
         * lang/validation içerisinden exists keyinden oto-mesaj dönmesi gerekiyor.
         * Ancak siz böyle istediğiniz için öncesinde böyle bir kontrol eklendi.
         */
        if(!Role::find(request()->role_id)){
            return redirect()->back()
                ->withErrors(['role' => 'Invalid request body: ROLE']);
        }

        $user = User::create(request()->validate([
            'name' => ['required','min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role_id' => ['exists:roles,id']
        ]));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        /***
         * Standartta role_id validation'ı aşağıda yapılıp, 
         * lang/validation içerisinden exists keyinden oto-mesaj dönmesi gerekiyor.
         * Ancak siz böyle istediğiniz için öncesinde böyle bir kontrol eklendi.
         */
        if(!Role::find(request()->role_id)){
            return redirect()->back()
                ->withErrors(['role' => 'Invalid request body: ROLE']);
        }


        $user = $user->update(request()->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'role_id' => ['exists:roles,id']
        ]));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $res = $user->delete();

        return redirect()->back();

    }

    public function filter(Request $request, User $user)
    {
        $user = $user->newQuery();

        // Search for a user based on their name.
        if ($request->has('name')) {
            $user->where('name', $request->input('name'));
        }

        // Search for a user based on their company.
        if ($request->has('company')) {
            $user->where('company', $request->input('company'));
        }

        // Search for a user based on their city.
        if ($request->has('city')) {
            $user->where('city', $request->input('city'));
        }

        // Continue for all of the filters.

        // Get the results and return them.
        return $user->get();
    }
}
