<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Database\Factories\ListingFactory;

class ListingController extends Controller
{
    public function showAll(){
        
        return view('listings', [
            'headings'=> 'Latest listings',
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(3)
            ]
            
        );
    }

    public function showSingle(Listing $listing){
        return view('listing', [
            'listing' => $listing
        ]);
    }


    public function create(){
        return view ('create');
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $formFields['user_id'] = auth()->id();
        Listing::create($formFields);
        return redirect('/');
    }


    public function edit(Listing $listing){
        return view('edit', [
            'listing' => $listing
        ]);
    }

    public function update(Request $request, Listing $listing){

        if ($listing->user_id !== auth()->id()) {
            abort(403, 'unthorised');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $listing->update($formFields);
        return view('listing', [
            'listing' => $listing
        ]);
    }
        
    public function delete(Listing $listing){
        if ($listing->user_id == auth()->id()) {
            
            abort(403, 'unthorised');
        }
        $listing->delete();
        return redirect('/manage');
    }
    

    public function showManage(){
        return view('manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
