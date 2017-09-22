@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li><a href="\{{ route('home.{{model.namePlural}}.index') }}">{{model.descriptionPlural}}</a></li>
      <li class="active">New {{model.description}}</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>New {{model.description}}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => 'home.{{model.namePlural}}.store', 'files' => true]) !!}    
        
                @include('home.{{model.namePlural}}.form')

                <div class="form-group col-xs-12 col-sm-12">
                    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                </div>

            {!! Form::close() !!}  
        </div>
    </div>

</div>
@endsection