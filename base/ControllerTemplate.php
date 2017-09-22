<?php

namespace App\Http\Controllers;

use App\Models\\{{model.nameCapitalized}};
use Illuminate\Http\Request;

class {{model.nameCapitalized}}Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ${{model.namePlural}} = {{model.nameCapitalized}}::paginate(10);
        return view('home.{{model.namePlural}}.index')
            ->with('{{model.namePlural}}', ${{model.namePlural}});
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.{{model.namePlural}}.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        ${{model.name}} = {{model.nameCapitalized}}::create($data);

        return redirect()->route('home.{{model.namePlural}}.edit', ${{model.name}}->id)
            ->withSuccess('Saved successfuly!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\\{{model.nameCapitalized}}  {{model.name}}
     * @return \Illuminate\Http\Response
     */
    public function show({{model.nameCapitalized}} ${{model.name}})
    {
        return view('home.{{model.namePlural}}.show')->with('{{model.name}}', ${{model.name}});
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\\{{model.nameCapitalized}}  {{model.name}}
     * @return \Illuminate\Http\Response
     */
    public function edit({{model.nameCapitalized}} ${{model.name}})
    {
        return view('home.{{model.namePlural}}.edit')->with('{{model.name}}', ${{model.name}});
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\\{{model.nameCapitalized}}  {{model.name}}
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, {{model.nameCapitalized}} ${{model.name}})
    {
        $data = $request->all();
        ${{model.name}}->update($data);

        return redirect()->route('home.{{model.namePlural}}.edit', ${{model.name}}->id)
            ->withSuccess('Saved successfuly!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\\{{model.nameCapitalized}}  {{model.name}}
     * @return \Illuminate\Http\Response
     */
    public function destroy({{model.nameCapitalized}} ${{model.name}})
    {
        ${{model.name}}->delete();
        return redirect()->route('home.{{model.namePlural}}.index');
    }
}
