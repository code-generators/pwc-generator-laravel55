<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create{{model.namePluralCapitalized}}Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{model.namePluralSnakeCase}}', function (Blueprint $table) {
            $table->increments('id');
            {{!-- Model fields --}}
            {{#each model.fields}}
            {{!-- String, File or Image Field --}}
            {{#if (in type 'string' 'file' 'image')}}
            $table->string('{{name}}'{{#if size}},{{size}}{{/if}}){{#if hasDefault}}->default('{{default}}'){{/if}}{{#unless required}}->nullable(){{/unless}};
            {{!-- Enum Field --}}
            {{else if (equal type 'enum')}}
            $table->enum('{{name}}',[{{#each items}}'{{value}}',{{/each}}]){{#if hasDefault}}->default('{{default}}'){{/if}}{{#unless required}}->nullable(){{/unless}};
            {{!-- Boolean Field --}}
            {{else if (equal type 'boolean')}}
            $table->boolean('{{name}}'){{#if hasDefault}}->default({{default}}){{/if}}{{#unless required}}->nullable(){{/unless}};
            {{!-- Other Fields --}}
            {{else}}
            $table->{{type}}('{{name}}'{{#if size}},{{size}}{{/if}}){{#if hasDefault}}->default('{{default}}'){{/if}}{{#unless required}}->nullable(){{/unless}};
            {{/if}}
            {{/each}}
            $table->timestamps();

            {{!-- Model foreign keys --}}
            {{#each model.belongsToRelationships}}
            $table->unsignedInteger('{{foreignKeyName}}');
            $table->foreign('{{foreignKeyName}}')->references('id')->on('{{relatedModel.namePlural}}'){{#unless required}}->nullable(){{/unless}};
            {{/each}}
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{model.namePluralSnakeCase}}');
    }
}