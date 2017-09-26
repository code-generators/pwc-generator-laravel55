@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li><a href="\{{ route('home.{{model.namePlural}}.index') }}">{{model.descriptionPlural}}</a></li>
      <li class="active">View {{model.description}}</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>View {{model.description}}</h3>
        </div>
        <div class="panel-body">
        
                @include('home.{{model.namePlural}}.show_fields')

                <a href="\{{ route('home.{{model.namePlural}}.index') }}" class="btn btn-default">Back</a>
            {!! Form::close() !!}  
        </div>
    </div>

</div>
@endsection