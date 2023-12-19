<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile2UpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class Profile3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): View
    {
        // Retrieve the authenticated user
        $user = $request->user();

        // Retrieve the associated profile data
        // $profile = Profile::where('user_id', $user->id)->first();
        $profile = $user->HasOneProfile;

        // Pass the user and profile data to the view
        return view('form.index', compact('user', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Profile2UpdateRequest $request): RedirectResponse
    {
        // Assuming that the user is logged in and you want to update their profile
        $profile = $request->user()->HasOneProfile;

        // Validate and update the profile data
        $profile->fill($request->validated());
        $profile->save();

        return Redirect::route('form.index')->with('status', 'profile-updated');
    }
}
