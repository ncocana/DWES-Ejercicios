<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChirpRequest;
use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChirpRequest $request): RedirectResponse
    {
        if (Gate::allows('create-chirp')) {
            $validated = $request->validated();
     
            $request->user()->chirps()->create($validated);
     
            return redirect(route('chirps.index'));
        } else {
            Abort(403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        // $this->authorize('update', $chirp);

        if (Gate::allows('edit-chirp', $chirp)) {
            return view('chirps.edit', [
                'chirp' => $chirp,
            ]);
        } else {
            Abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChirpRequest $request, Chirp $chirp): RedirectResponse
    {
        // $this->authorize('update', $chirp);

        if (Gate::allows('edit-chirp', $chirp)) {
            $validated = $request->validated();
    
            $chirp->update($validated);
    
            return redirect(route('chirps.index'));
        } else {
            Abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        // $this->authorize('delete', $chirp);
 
        if (Gate::allows('delete-chirp', $chirp)) {
            $chirp->delete();
    
            return redirect(route('chirps.index'));
        } else {
            Abort(403);
        }
    }
}
