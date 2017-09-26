{{#each model.fields}}
{{#if (equal type 'image')}}
<div class="form-group">
    \{{ Form::label('{{name}}', '{{label}}') }}
</div>
<div>
    @if(isset(${{@root.model.name}}))
        @if(${{@root.model.name}}->{{name}})
            <img src="\{{ asset(${{@root.model.name}}->image_url) }}" width="150" style="margin: 10px">
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