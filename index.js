'use strict';

class Plug {

    constructor(utils) {
        this.utils = utils;
        this.testDependencies();
        this.initSettings();
    }

    testDependencies() {
        this.utils.testDependency('composer');
        this.utils.testDependency('laravel');
    }

    initSettings() {
        this.routesTemplateFile = __dirname + '/base/RoutesTemplate.php';
        this.routesFile = 'routes/web.php';

        this.modelTemplateFile = __dirname + '/base/ModelTemplate.php';
        this.modelsDirectory = 'app/Models/';

        this.controllerTemplateFile = __dirname + '/base/ControllerTemplate.php';
        this.controllersDirectory = 'app/Http/Controllers/';

        this.requestTemplateFile = __dirname + '/base/RequestTemplate.php';
        this.requestsDirectory = 'app/Http/Requests/';

        this.migrationTemplateFile = __dirname + '/base/MigrationTemplate.php';
        this.migrationsDirectory = 'database/migrations/';

        this.viewTemplatesDirectory = __dirname + '/base/views/';
        this.viewsDirectory = 'resources/views/home/';
    }

    initProject(project) {
        try{
            this.project = project;
            this.startLaravelProject();
            this.finalizeProject();
        }catch(e){
            console.log(e.stack);
            throw 'Problem generating the project: ' + e;
        }
    }

    startLaravelProject() {
        let command = 'laravel new ' + this.project.name;
        this.utils.executeCommand(command, () => {
            this.startCodeGeneration();
        });
    }

    startCodeGeneration() {
        this.utils.goToProjectFolder(this.project); 
        this.addRequirements();
        this.makeRoutesFile();
        this.proccessModels();
    }

    addRequirements() {
        //this.utils.executeCommand('composer require "laravelcollective/html":"^5.4.0"');
        //this.utils.executeCommand('php artisan make:auth');
        //this.utils.executeCommand('composer dump-autoload');
    }

    makeRoutesFile() {
        let models = this.project.models;
        this.utils.makeFileFromTemplate(this.routesFile, this.routesTemplateFile, {models: models});
    }

    proccessModels() {
        this.project.models.forEach((model, index) =>{
            this.initModel(model); 
        });
    }

    initModel(model) {
        this.makeMigrationFile(model);
        this.makeModelFile(model);
        
        if(!model.isOnlyModel() && !model.isRelationship()) {    
            this.makeControllerFile(model);    
            this.makeRequestFile(model);    
            this.makeViewFiles(model);    
        }
    }

    makeMigrationFile(model) {
        let migrationFile = this.makeMigrationName(model);
        this.utils.makeFileFromTemplate(migrationFile, this.migrationTemplateFile, {model: model});
    }

    makeMigrationName(model) {
        let pad = require('pad'),
            date = new Date(),
            month = pad(2, (date.getMonth() + 1).toString(), '0'),
            modelIndex = pad(6, model.getIndex().toString(), '0'),
            migrationPrefix = date.getFullYear() + '_' + month + '_' + date.getDate() + '_' + modelIndex;
        
        return this.migrationsDirectory + migrationPrefix + '_create_' + model.getNamePluralSnakeCase() + '_table.php';
    }

    makeModelFile(model) {
        let modelFile = this.modelsDirectory + model.getNameCapitalized() + '.php';
        this.utils.makeFileFromTemplate(modelFile, this.modelTemplateFile, {model: model});
    }

    makeControllerFile(model) {
        let controllerFile = this.controllersDirectory + model.getNameCapitalized() + 'Controller.php';
        this.utils.makeFileFromTemplate(controllerFile, this.controllerTemplateFile, {model: model});
    }

    makeRequestFile(model) {
        let requestFile = this.requestsDirectory + 'Store' + model.getNameCapitalized() + '.php';
        this.utils.makeFileFromTemplate(requestFile, this.requestTemplateFile, {model: model});
    }

    makeViewFiles(model) {
        let views = {
            'index': 'IndexViewTemplate.php',
            'create': 'CreateViewTemplate.php',
            'fields': 'FieldsViewTemplate.php',
            'edit': 'EditViewTemplate.php',
            'show': 'ShowViewTemplate.php',
            'show_fields': 'ShowFieldsViewTemplate.php',
        };

        Object.keys(views).map((viewName) => {
            let viewFile = this.viewsDirectory + model.getNamePlural() + '/' + viewName + '.blade.php',
                templateFile = this.viewTemplatesDirectory + views[viewName];
            this.utils.makeFileFromTemplate(viewFile,  templateFile, {model: model});
        });
    }

    finalizeProject() {

    }

}

module.exports = Plug;