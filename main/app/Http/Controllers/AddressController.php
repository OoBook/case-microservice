<?php

namespace App\Http\Controllers;

use App\Enum\AddressCityEnum;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $addresses = $user->addresses;

        return view('addresses.index', compact('addresses','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        
        return view('addresses.create', compact('user'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        // $request->user_id = $user->id;
        // dd($request->user_id);
        $this->validate($request, [
            'city' => [new Enum(AddressCityEnum::class)],
            'address' => ['required', 'min:3'],
        ]);
        
        Address::create($request->all() + ['user_id' => $user->id] );

        return redirect()->route('users.addresses.index', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Address $address)
    {
        $user_id = $user->id;

        return view('addresses.show', compact('user_id', 'address'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Address $address)
    {
        return view('addresses.edit', compact('user', 'address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request, Address $address)
    {
        $this->validate($request, [
            'city' => [new Enum(AddressCityEnum::class)],
            'address' => ['required', 'min:3'],
        ]);
        
        $address->update($request->all() + ['user_id' => $user->id] );

        return redirect()->route('users.addresses.index', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Address $address)
    {
        $address->delete();

        $user_id = $user->id;

        return redirect()->route('users.address.index', $user_id);
    }
}
