<style>
    .add-button {
        color: #3498db;
        cursor: pointer;
    }

    .remove-button {
        cursor: pointer;
        color: #e74c3c; 
        font-size: 25px; 
        font-weight: bold;
    }
</style>

<template>
    <table class="table table-bordered table-form">
        <thead>
            <tr>
                {{!-- Relationships --}}
                {{#each relationship.relatedModel.belongsToRelationships}}
                {{#if element}}
                <th>{{ relatedModel.description }}</th>
                {{/if}}
                {{/each}}
                
                {{!-- Model fields --}}
                {{#each relationship.relatedModel.fields}}
                <th>{{ label }}</th>
                {{/each}}
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="({{ relationship.alias }}, index) in list">
                {{!-- Relationships --}}
                {{#each relationship.relatedModel.belongsToRelationships}}
                {{#if element}}
                <td>
                    <select class="form-control" v-model="{{ @root.relationship.alias }}.{{ foreignKeyName }}" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ foreignKeyName }}]'">
                      <option value="">---</option>
                      <option v-for="{{ relatedModel.name }} in list_{{ relatedModel.namePlural }}" v-bind:value="{{ relatedModel.name }}.id">
                        \{{ {{ relatedModel.name }}.{{displayField}} }}
                      </option>
                    </select>
                </td>
                {{/if}}
                {{/each}}

                {{#each relationship.relatedModel.fields}}
                <td>
                {{#if (equal element 'text')}}
                <input :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" type="text" class="form-control" v-model="{{ @root.relationship.alias }}.{{ name }}"
                {{#if value}} value="{{value}}"{{/if}}{{#if required}} required="required"{{/if}}>

                {{else if (equal element 'email')}}
                <input :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" type="email" class="form-control" v-model="{{ @root.relationship.alias }}.{{ name }}"
                {{#if value}} value="{{value}}"{{/if}}{{#if required}} required="required"{{/if}}>

                {{else if (equal element 'textarea')}}
                <textarea :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" class="form-control" v-model="{{ @root.relationship.alias }}.{{ name }}"
                {{#if required}} required="required"{{/if}}>{{#if value}}{{value}}{{/if}}</textarea>

                {{else if (equal element 'number')}}
                <input :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" type="number" class="form-control" v-model="{{ @root.relationship.alias }}.{{ name }}"{{#if value}} value="{{value}}"{{/if}}{{#if required}} required="required"{{/if}}{{#if (equal type 'decimal') }} step="0.1"{{/if}}>

                {{else if (equal element 'password')}}
                <input :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" type="password" class="form-control" v-model="{{ @root.relationship.alias }}.{{ name }}"
                {{#if required}} required="required"{{/if}}>

                {{else if (equal element 'select')}}
                <select :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" class="form-control" v-model="{{ @root.relationship.alias }}.{{ name }}"
                {{#if required}} required="required"{{/if}}>
                    <option value="">---</option>
                    {{#each items}}
                    <option value="{{value}}">{{label}}</option>
                    {{/each}}
                </select>

                {{else if (equal element 'checkbox')}}
                <div>
                    <input :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" type="checkbox" class="form-control" v-model="{{ @root.relationship.alias }}.{{ name }}"
                value="1"{{#if required}} required="required"{{/if}}>
                </div>

                {{else if (equal element 'date')}}
                <input :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" type="date" class="form-control" v-model="{{ @root.relationship.alias }}.{{ name }}"
                {{#if value}} value="{{value}}"{{/if}}{{#if required}} required="required"{{/if}}>

                {{else if (equal element 'file')}}
                {{#if (equal type 'image')}}
                <input :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" type="file" 
                {{#if required}} required="required"{{/if}} accept="image/*">
                
                {{else}}
                <div class="form-group col-xs-12">
                    <input :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" type="file" 
                {{#if required}} required="required"{{/if}} {{#if mimeTypes}}accept="{{mimeTypesString}}"{{/if}}>
                </div>
                {{/if}}

                {{/if}}
                </td>
                {{/each}}
                <td class="text-center">
                    <span @click="remove(index)" class="remove-button">&times;</span>
                </td>    
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="100%">
                    <span @click="addLine" class="add-button">+ Add Item</span>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
    export default {
        props: [
            'form', 
            '{{ relationship.aliasPlural  }}',
            {{#each relationship.relatedModel.belongsToRelationships}}
            {{#if element}}
            '{{ aliasPlural  }}',
            {{/if}}
            {{/each}}
        ],

        data () {
            return {
                list: [],
                {{#each relationship.relatedModel.belongsToRelationships}}
                {{#if element}}
                list_{{ aliasPlural }}: [],
                {{/if}}
                {{/each}}
            }
        },

        mounted () {
            this.list = JSON.parse(this.{{ relationship.aliasPlural }});
            {{#each relationship.relatedModel.belongsToRelationships}}
            {{#if element}}
            this.list_{{ aliasPlural }} = JSON.parse(this.{{ aliasPlural }});
            {{/if}}
            {{/each}}
        },

        methods: {
            addLine: function() {
                let lineData = {
                    {{#each relationship.relatedModel.belongsToRelationships}}
                    {{#if element}}
                    {{ foreignKeyName }}: '',
                    {{/if}}
                    {{/each}}
                    {{#each relationship.relatedModel.fields}}
                    {{ name }}: '',
                    {{/each}}
                };

                this.list.push(lineData);
            },

            remove: function(index) {
                if(confirm('Are you sure to delete this item?'))
                    Vue.delete(this.list, index);
            }
        }
    }
</script>