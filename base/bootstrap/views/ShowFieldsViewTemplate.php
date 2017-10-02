{{#each model.fields}}
{{#if (equal type 'image')}}
<div class="form-group">
    \{{ Form::label('{{name}}', '{{label}}') }}
</div>
<div class="form-group col-xs-12 col-sm-12 text-left">
    @if(isset(${{@root.model.name}}))
        @if(${{@root.model.name}}->{{name}})
            <img src="\{{ asset(${{@root.model.name}}->getImagePath('{{name}}', 'thumb')) }}" width="150" style="margin: 10px">
        @endif
    @endif
</div>

{{else if (equal type 'file')}}
<div class="form-group">
    \{{ Form::label('{{name}}', '{{label}}') }}
</div>
<div class="form-group col-xs-12 col-sm-12 text-left">
    @if(isset(${{@root.model.name}}))
        @if(${{@root.model.name}}->{{name}})
            <div><a href="\{{ asset($product->getFilePath('{{name}}')) }}" target="_blank">View File</a></div>
        @endif
    @endif
</div>

{{else}}
<div class="form-group">
    \{{ Form::label('{{name}}', '{{label}}') }}
    <p>\{{ ${{@root.model.name}}->{{name}} }}</p>
</div>

{{/if}}
{{/each}}