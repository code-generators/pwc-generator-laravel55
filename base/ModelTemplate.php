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
        {{#each model.relationships}}
        {{#if hasForeignKey}}
        '{{foreignKeyName}}',
        {{/if}}
        {{/each}}
    ];

    protected $casts = [
        {{!-- Model fields --}}
        {{#each model.fields}}
        {{#if (equal type 'boolean') }}
        '{{name}}' => 'boolean',
        {{/if}}
        {{/each}}
    ];
}