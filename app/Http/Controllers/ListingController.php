<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // all listing
    public function index()
    {
        // dd(request(['tag']));          // get tag value 

        return view('listings.index', [
            // 'listings' => Listing::all(),
            'listings' => Listing::latest()
                ->filter(request(['tag', 'search']))
                ->paginate(4),
        ]);
    }

    // single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }


    // create listing
    public function create()
    {
        return view('listings.create');
    }

    // store listing
    public function store()
    {
        // dd(request()->all());
        // dd(request(['title', 'company']));
        // dd(request()->file('logo')->store('logos'));     // goto config/filesystems to choose roo storage dir.  now chosen storage/app/public directory 
        $formFields = request()->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if (request()->hasFile('logo')) {
            $formFields['logo'] = request()->file('logo')->store('logos', 'public');    // store in storage/app/public/logos directory and visibility is public  - to make it publicly access able run code $ php artisan storage:link 
            // The [C:\Users\NazmulAlam\laragig\public\storage] link has been connected to [C:\Users\NazmulAlam\laragig\storage\app/public].    
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing Created Successfully');
    }

    // show edit form
    public function edit(Listing $listing)
    {
        // dd($listing);
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    public function update(Listing $listing)
    {
        // dd($listing);
        // make sure logged used is owner   - auth
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = request()->validate([
            'title' => 'required',
            'company' => ['required',],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if (request()->hasFile('logo')) {
            $formFields['logo'] = request()->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing Updated Successfully');
    }

    public function destroy(Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();

        return redirect('/')->with('message', 'Listing Deleted Successfully');
    }

    public function manage()
    {
        return view('listings.manage', [
            'listings' => auth()->user()->listings,
        ]);
    }
}
