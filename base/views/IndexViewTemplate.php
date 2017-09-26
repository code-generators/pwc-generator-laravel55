@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li class="active">{{model.descriptionPlural}}</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>{{model.descriptionPlural}}</h3>
            <br>
            
            <div class="row">
                <div class="col-sm-2">
                    <a href="\{{ route('home.{{model.namePlural}}.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> {{model.description}}</a>
                </div>
                <div class="col-sm-10">
                    <div class="input-group">
                      <input type="text" id="search" name="search" class="form-control" placeholder="Search..." value="">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="utils.search()">Search</button>
                      </span>
                    </div>
                </div>
            </div>

            <br>

        </div>
        <div class="panel-body">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        {{#each model.fields}}
                        {{#if inList}}
                        <th>{{label}}</th>
                        {{/if}}
                        {{/each}}
                        <th class="action"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach(${{model.namePlural}} as ${{model.name}})
                    <tr>
                        {{#each model.fields}}
                        {{#if inList}}
                        <td>\{{ ${{@root.model.name}}->{{name}} }}</td>
                        {{/if}}
                        {{/each}}
                        <td class="text-right">
                        {!! Form::open(['route' => ['home.{{model.namePlural}}.destroy', ${{model.name}}->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="\{{ route('home.{{model.namePlural}}.show', ${{model.name}}->id) }}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a>
                                <a href="\{{ route('home.{{model.namePlural}}.edit', ${{model.name}}->id) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>
                                {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure to delete this item?')"]) !!}
                            </div>
                        {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {!! ${{model.namePlural}}->render() !!}
        </div>
    </div>

</div>
@endsection
