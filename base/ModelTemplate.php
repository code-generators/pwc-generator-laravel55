<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class {{model.nameCapitalized}} extends Model
{
    protected $fillable = [
        {{!-- Model fields --}}
        {{#each model.fields}}
        '{{name}}',
        {{/each}}
        {{!-- Model foreign keys --}}
        {{#each model.belongsToRelationships}}
        '{{foreignKeyName}}',
        {{/each}}
    ];

    protected $dates = [
        {{!-- Model fields --}}
        {{#each model.fields}}
        {{#if (equal type 'date') }}
        '{{name}}',
        {{/if}}
        {{/each}}
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        {{!-- Model fields --}}
        {{#each model.fields}}
        {{#if (equal type 'boolean') }}
        '{{name}}' => 'boolean',
        {{/if}}
        {{/each}}
    ];

    {{#each model.belongsToRelationships}}
    public function {{name}}() {
        return $this->belongsTo({{relatedModel.nameCapitalized}}::class);
    }
    {{/each}}
}