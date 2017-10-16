<?php

namespace App\Models;

use KingOfCode\Upload\Uploadable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class {{model.nameCapitalized}} extends Model
{
    use SearchableTrait, Uploadable;

    protected $fillable = [
        {{!-- Model fields --}}
        {{#each model.fields}}
        {{#unless isFileField}}
        '{{name}}',
        {{/unless}}
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

    protected $searchable = [
        'columns' => [
            {{!-- Model searchable fields --}}
            {{#each model.fields}}
            {{#if searchable }}
            '{{@root.model.namePlural}}.{{name}}' => 10,
            {{/if}}
            {{/each}}
        ]
    ];

    protected $uploadableImages = [
        {{!-- Image fields --}}
        {{#each model.fields}}
        {{#if (equal type 'image') }}
        '{{name}}',
        {{/if}}
        {{/each}}
    ];

    protected $uploadableFiles = [
        {{!-- File fields --}}
        {{#each model.fields}}
        {{#if (equal type 'file') }}
        '{{name}}',
        {{/if}}
        {{/each}}
    ];

    {{#each model.belongsToRelationships}}
    public function {{alias}}() {
        return $this->belongsTo({{relatedModel.nameCapitalized}}::class{{#if differentForeignKeyName}}, '{{foreignKeyName}}'{{/if}});
    }

    {{/each}}
    {{#each model.belongsToManyRelationships}}
    public function {{aliasPlural}}() {
        return $this->belongsToMany({{relatedModel.nameCapitalized}}::class);
    }

    {{/each}}
    {{#each model.hasOneRelationships}}
    public function {{alias}}() {
        return $this->hasOne({{relatedModel.nameCapitalized}}::class{{#if differentForeignKeyName}}, '{{foreignKeyName}}'{{/if}});
    }

    {{/each}}
    {{#each model.hasManyRelationships}}
    public function {{aliasPlural}}() {
        return $this->hasMany({{relatedModel.nameCapitalized}}::class{{#if differentForeignKeyName}}, '{{foreignKeyName}}'{{/if}});
    }

    {{/each}}

}