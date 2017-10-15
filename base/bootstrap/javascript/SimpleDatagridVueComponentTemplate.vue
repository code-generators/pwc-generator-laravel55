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
                <th>{{ relationship.namePluralCapitalized }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="({{ relationship.alias }}, index) in list">
                {{#each relationship.relatedModel.fields}}
                <td>
                    <input :form="form" :name="'{{ @root.relationship.aliasPlural }}[' + index + '][{{ name }}]'" type="text" class="form-control" v-model="{{ @root.relationship.alias }}.{{ name }}">
                </td>
                {{/each}}
                <td class="text-center">
                    <span @click="remove(index)" class="remove-button">&times;</span>
                </td>    
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <span @click="addLine" class="add-button">+ Add Item</span>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
    export default {
        props: ['form', '{{ relationship.relatedModel.namePlural }}'],

        data () {
            return {
                list: []
            }
        },

        mounted () {
            this.list = JSON.parse(this.{{ relationship.relatedModel.namePlural }});
        },

        methods: {
            addLine: function() {
                let lineData = {
                    {{#each relationship.relatedModel.fields}}
                    {{ name }}: ''
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