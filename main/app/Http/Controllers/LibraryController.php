<?php

namespace App\Http\Controllers;

use App\Enum\AddressCityEnum;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libraries = Library::paginate(10);

        return view('libraries.index', compact('libraries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('libraries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $library = Library::create(request()->validate([
            'name' => ['required','min:3'],
            'city' => [new Enum(AddressCityEnum::class)],
        ]));

        return redirect()->route('libraries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Library $library)
    {
        return view('libraries.edit', compact('library'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Library $library)
    {

        $library = $library->update(request()->validate([
            'name' => ['required','min:3'],
            'city' => [new Enum(AddressCityEnum::class)],
        ]));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Library $library)
    {
        //
        $res = $library->delete();

        return redirect()->back();

    }
}
