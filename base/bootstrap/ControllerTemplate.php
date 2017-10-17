<?php

namespace App\Http\Controllers;

use App\Models\\{{model.nameCapitalized}};
use Illuminate\Http\Request;
use App\Http\Requests\Store{{model.nameCapitalized}};
{{!-- Model foreign keys --}}
{{#each model.belongsToRelationships}}
use App\Models\\{{relatedModel.nameCapitalized}};
{{/each}}
{{#each model.hasManyRelationships}}
use App\Models\\{{relatedModel.nameCapitalized}};
{{/each}}
{{!-- For each to get the belongsTo relationships inside hasMany relationships --}}
{{#each model.hasManyRelationships}}
{{#if (equal element 'simple-datagrid')}}
{{#each relatedModel.belongsToRelationships}}
{{#if element}}
use App\Models\\{{relatedModel.nameCapitalized}};
{{/if}}
{{/each}}
{{/if}}
{{/each}}

class {{model.nameCapitalized}}Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        ${{model.namePlural}} = {{model.nameCapitalized}}::search($search)->paginate(10);

        return view('home.{{model.namePlural}}.index')
            ->with('{{model.namePlural}}', ${{model.namePlural}})
            ->with('search', $search);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        {{!-- Model foreign keys --}}
        {{#each model.belongsToRelationships}}
        ${{relatedModel.namePlural}} = {{relatedModel.nameCapitalized}}::pluck('{{displayField}}', 'id');
        {{/each}}
        {{!-- For each to get the belongsTo relationships inside hasMany relationships --}}
        {{#each model.hasManyRelationships}}
        {{#if (equal element 'simple-datagrid')}}
        {{#each relatedModel.belongsToRelationships}}
        {{#if element}}
        ${{relatedModel.namePlural}} = {{relatedModel.nameCapitalized}}::select('id', '{{displayField}}')->get();
        {{/if}}
        {{/each}}
        {{/if}}
        {{/each}}

        {{!-- Return the views --}}
        return view('home.{{model.namePlural}}.create')
        {{#each model.hasManyRelationships}}
        {{#if (equal element 'simple-datagrid')}}
        {{#each relatedModel.belongsToRelationships}}
        {{#if element}}
        ->with('{{relatedModel.namePlural}}', ${{relatedModel.namePlural}})
        {{/if}}
        {{/each}}
        {{/if}}
        {{/each}}{{#unless model.belongsToRelationships }};{{else}}{{#each model.belongsToRelationships}}
        ->with('{{relatedModel.namePlural}}', ${{relatedModel.namePlural}}){{/each}};{{/unless}}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store{{model.nameCapitalized}} $request)
    {
        $data = $request->all();

        ${{model.name}} = {{model.nameCapitalized}}::create($data);

        {{#each model.hasManyRelationships}}
        {{#if (equal element 'simple-datagrid')}}
        ${{aliasPlural}} = collect($request->{{aliasPlural}})->transform(function(${{alias}}) {
            return new {{relatedModel.nameCapitalized}}(${{alias}});
        });

        ${{@root.model.name}}->{{aliasPlural}}()->delete();
        ${{@root.model.name}}->{{aliasPlural}}()->saveMany(${{aliasPlural}});
        {{/if}}
        {{/each}}

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
        {{!-- Model foreign keys --}}
        {{#each model.belongsToRelationships}}
        ${{relatedModel.namePlural}} = {{relatedModel.nameCapitalized}}::pluck('{{displayField}}', 'id');
        {{/each}}
        {{!-- For each to get the belongsTo relationships inside hasMany relationships --}}
        {{#each model.hasManyRelationships}}
        {{#if (equal element 'simple-datagrid')}}
        {{#each relatedModel.belongsToRelationships}}
        {{#if element}}
        ${{relatedModel.namePlural}} = {{relatedModel.nameCapitalized}}::select('id', '{{displayField}}')->get();
        {{/if}}
        {{/each}}
        {{/if}}
        {{/each}}

        {{!-- Return the views --}}
        return view('home.{{model.namePlural}}.edit')->with('{{model.name}}', ${{model.name}})
        {{#each model.hasManyRelationships}}
        {{#if (equal element 'simple-datagrid')}}
        {{#each relatedModel.belongsToRelationships}}
        {{#if element}}
        ->with('{{relatedModel.namePlural}}', ${{relatedModel.namePlural}})
        {{/if}}
        {{/each}}
        {{/if}}
        {{/each}}{{#unless model.belongsToRelationships }};{{else}}{{#each model.belongsToRelationships}}
        ->with('{{relatedModel.namePlural}}', ${{relatedModel.namePlural}}){{/each}};{{/unless}}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\\{{model.nameCapitalized}}  {{model.name}}
     * @return \Illuminate\Http\Response
     */
    public function update(Store{{model.nameCapitalized}} $request, {{model.nameCapitalized}} ${{model.name}})
    {
        $data = $request->all();
        ${{model.name}}->update($data);

        {{#each model.hasManyRelationships}}
        {{#if (equal element 'simple-datagrid')}}
        ${{aliasPlural}} = collect($request->{{aliasPlural}})->transform(function(${{alias}}) {
            return new {{relatedModel.nameCapitalized}}(${{alias}});
        });

        ${{@root.model.name}}->{{aliasPlural}}()->delete();
        ${{@root.model.name}}->{{aliasPlural}}()->saveMany(${{aliasPlural}});
        {{/if}}
        {{/each}}

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
