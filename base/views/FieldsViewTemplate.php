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
    {!! Form::hidden('{{name}}', false) !!}
    {!! Form::checkbox('{{name}}', true) !!}
</div>

{{else if (equal element 'date')}}
<div class="form-group col-xs-12 col-sm-6">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::date('{{name}}', {{#if value}}'{{value}}'{{else}}null{{/if}}, ['class' => 'form-control'{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>

{{else if (equal element 'file')}}
{{#if (equal type 'image')}}
<div>
    @if(isset(${{@root.model.name}}))
        @if(${{@root.model.name}}->{{name}})
            <img src="\{{ asset(${{@root.model.name}}->image_url) }}" width="150" style="margin: 10px">
        @endif
    @endif
</div>

<div class="form-group col-xs-12">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::file('{{name}}', [{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>
{{else}}
<div class="form-group col-xs-12">
    {!! Form::label('{{name}}', '{{label}}') !!}
    {!! Form::file('{{name}}', [{{#if required}}, 'required' => 'required'{{/if}}]) !!}
</div>
{{/if}}

{{/if}}
{{/each}}