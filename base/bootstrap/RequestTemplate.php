<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Store{{model.nameCapitalized}} extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            {{!-- Model fields --}}
            {{#each model.fields}}
            {{#if validation}}
            '{{name}}' => '{{validationString}}',
            {{/if}}
            {{/each}}

            {{#each model.belongsToRelationships}}
            {{#if validation}}
            '{{foreignKeyName}}' => '{{validationString}}',
            {{/if}}
            {{/each}}

            {{#each model.hasManyRelationships}}
            {{#if (equal element 'simple-datagrid')}}
            {{#each relatedModel.fields}}
            {{#if validation}}'{{../aliasPlural}}.*.{{name}}'  => '{{validationString}}',{{/if}}
            {{/each}}
            {{#each relatedModel.belongsToRelationships}}
            {{#if element}}
            {{#if validation}}'{{../aliasPlural}}.*.{{foreignKeyName}}'  => '{{validationString}}',{{/if}}
            {{/if}}
            {{/each}}
            {{/if}}
            {{/each}}
        ];
    }
}