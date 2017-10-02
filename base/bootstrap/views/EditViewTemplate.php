@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li><a href="\{{ route('home.{{model.namePlural}}.index') }}">{{model.descriptionPlural}}</a></li>
      <li class="active">Edit {{model.description}}</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>Edit {{model.description}}</h3>
        </div>
        <div class="panel-body">
            {!! Form::model(${{model.name}}, ['route' => ['home.{{model.namePlural}}.update', ${{model.name}}->id], 'method' => 'patch', 'files' => true]) !!}    
        
                @include('home.{{model.namePlural}}.fields')

                <div class="form-group col-xs-12 col-sm-12">
                    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                </div>

            {!! Form::close() !!}  
        </div>
    </div>

</div>
@endsection