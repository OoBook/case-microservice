<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Library;
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
        $user_ids = [];
        if($request->city || $request->order_field == 'city'){
            
            if($request->city){
                $m_query = Address::where('city','LIKE','%'.$request->city.'%');
            }else{
                $m_query = Address::query();
            }
            
            if($request->order_field == 'city'){
                $m_query->orderBy('city', $request->order);
            }


            $user_ids = $m_query
                ->get()
                ->pluck('user_id')
                ->unique();
        }

        // dd($user_ids);

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
                            case 'any':
                                $query->orWhere('normalized_name', 'like', '%'.$normalized.'%')->get();
                                break;
                        }
                    }
                    // dd($query);
                }
            ]
        ]);

        if(count($user_ids))
            $query->whereIn('id', $user_ids);

        if($request->order_field == 'city'){
            // dd( array_values($user_ids->toArray()), $user_ids->toArray(), $m_query->get());
            $query->orderByRaw('FIELD (id, ' . implode(', ', array_values($user_ids->toArray()) ) . ') ASC');
        }

        $query = $query->without('addresses');
        
        if($request->order_field == 'name'){
            $query = $query->orderBy('name', $request->order);
        }
        // dd($query, $query->toSql());
        $users = $query->paginate( 10 );

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
            'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^[a-zA-Z0-9]*$/'],
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
        $libraries = Library::all();

        return view('users.show', compact('libraries', 'user'));
    }


    public function syncLibrary(User $user, Request $request )
    {
        if( count($request->libraries) > 0 ){
            
            if(count($request->libraries) > 3){
                return redirect()
                    ->back()
                    ->withErrors(['library' => 'A user cannot be added to more than three libraries!']);
            }
            

            $old_libraries = $user->libraries;
            $new_libraries = $request->libraries;
            $removed_libraries = [];

            foreach($old_libraries as $_library){
                if(!array_key_exists($_library->id, $request->libraries)){
                    array_push($removed_libraries, $_library->id);
                }else{
                    unset($new_libraries[$_library->id]);
                }
            }
            
            $isAttachable = true;
            foreach($new_libraries as $i => $nl){
                $library = Library::find($i);

                if(!$library->canAttach()){
                    $isAttachable = false;
                    break;
                }
            }

            // dd($old_libraries, $new_libraries, $removed_libraries, $isAttachable);
            
            if(!$isAttachable){
                return redirect()->back()
                    ->withErrors(['library' => 'No more than 10 users can be added to a library!']);
            }

            if( count($removed_libraries) ){
                $user->libraries()->detach($removed_libraries);
            }

            $user->libraries()->attach(array_keys($new_libraries));

        }else{
            $user->libraries()->detach();
        }

        return redirect()->back();
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

        $libraries = Library::all();


        return view('users.edit', compact('user', 'roles', 'libraries'));
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

}
