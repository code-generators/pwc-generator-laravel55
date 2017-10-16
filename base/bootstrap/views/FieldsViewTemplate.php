{{!-- Model foreign keys --}}
{{#each model.belongsToRelationships}}
<div class="form-group col-xs-12 col-sm-12">
    {!! Form::label('{{foreignKeyName}}', '{{relatedModel.nameCapitalized}}') !!}
    {!! Form::select('{{foreignKeyName}}', ${{relatedModel.namePlural}}, null, ['class' => 'form-control'{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>
{{/each}}

{{#each model.fields}}
{{#if (equal element 'text')}}
<div class="form-group col-xs-12 col-sm-6">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::text('{{name}}', {{#if value}}'{{value}}'{{else}}null{{/if}}, ['class' => 'form-control'{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>

{{else if (equal element 'email')}}
<div class="form-group col-xs-12 col-sm-6">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::email('{{name}}', {{#if value}}'{{value}}'{{else}}null{{/if}}, ['class' => 'form-control'{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>

{{else if (equal element 'textarea')}}
<div class="form-group col-xs-12 col-sm-12">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::textarea('{{name}}', {{#if value}}'{{value}}'{{else}}null{{/if}}, ['class' => 'form-control'{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>

{{else if (equal element 'number')}}
<div class="form-group col-xs-12 col-sm-6">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::number('{{name}}', {{#if value}}'{{value}}'{{else}}null{{/if}}, ['class' => 'form-control'{{#if (equal type 'decimal') }}, 'step' => '0.1'{{/if}}{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>

{{else if (equal element 'password')}}
<div class="form-group col-xs-12 col-sm-12">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::password('{{name}}', ['class' => 'form-control'{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>

{{else if (equal element 'select')}}
<div class="form-group col-xs-12 col-sm-6">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::select('{{name}}', [{{#each items}}'{{value}}' => '{{label}}',{{/each}}], null, ['class' => 'form-control'{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>

{{else if (equal element 'checkbox')}}
<div class="form-group col-xs-12 col-sm-6">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::hidden('{{name}}', 0) !!}
    {!! Form::checkbox('{{name}}', 1) !!}
</div>

{{else if (equal element 'date')}}
<div class="form-group col-xs-12 col-sm-6">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::date('{{name}}', {{#if value}}'{{value}}'{{else}}null{{/if}}, ['class' => 'form-control'{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>

{{else if (equal element 'file')}}
{{#if (equal type 'image')}}
<div class="form-group col-xs-12 col-sm-12 text-left">
    @if(isset(${{@root.model.name}}))
        @if(${{@root.model.name}}->{{name}})
            <img src="\{{ asset(${{@root.model.name}}->getImagePath('{{name}}', 'thumb')) }}" width="150" style="margin: 10px">
        @endif
    @endif
</div>

<div class="form-group col-xs-12">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::file('{{name}}', ['accept' => 'image/*'{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>
{{else}}
<div class="form-group col-xs-12">
    {!! Form::label('{{name}}', '{{label}}') !!}
    @if(isset(${{@root.model.name}}))
        @if(${{@root.model.name}}->{{name}})
            <div><a href="\{{ asset($product->getFilePath('{{name}}')) }}" target="_blank">View File</a></div>
        @endif
    @endif
    {!! Form::file('{{name}}', [{{#if mimeTypes}}'accept' => '{{mimeTypesString}}'{{/if}}{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>
{{/if}}

{{/if}}
{{/each}}

{{#each model.hasManyRelationships}}
{{#if (equal element 'simple-datagrid')}}
<div class="col-sm-12">
    <h4>{{relatedModel.namePluralCapitalized}}</h4>

    <{{namePluralSlugCase}} 
        form="{{@root.model.name}}-form" 
        {{aliasPlural}}="\{{ isset(${{@root.model.name}}) ? ${{@root.model.name}}->{{aliasPlural}} : '[]' }}">
    </{{namePluralSlugCase}}>
</div>
{{/if}}

{{/each}}