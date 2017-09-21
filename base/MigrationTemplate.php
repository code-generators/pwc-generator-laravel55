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
            {{#if (equal type 'string' 'file' 'image')}}
            $table->string('{{name}}'{{#if size}},{{size}}{{/if}}){{#if default}}->default('{{default}}'){{/if}}{{#unless required}}->nullable(){{/unless}};
            {{!-- Enum Field --}}
            {{else if (equal type 'enum')}}
            $table->enum('{{name}}',[{{#each value}}'{{value}}',{{/each}}]){{#if default}}->default('{{default}}'){{/if}}{{#unless required}}->nullable(){{/unless}};
            {{!-- Other Fields --}}
            {{else}}
            $table->{{type}}('{{name}}'{{#if size}},{{size}}{{/if}}){{#if default}}->default('{{default}}'){{/if}}{{#unless required}}->nullable(){{/unless}};
            {{/if}}
            {{/each}}
            $table->timestamps();
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