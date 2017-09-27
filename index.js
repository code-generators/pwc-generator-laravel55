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
        this.makeAdditionalDirectories();
        this.makeRoutesFile();
        this.makeAppLayoutViewFile();
        this.proccessModels();
    }

    addRequirements() {
        //this.utils.executeCommand('composer require "laravelcollective/html":"^5.4.0"');
        //this.utils.executeCommand('php artisan make:auth');
        //this.utils.executeCommand('composer dump-autoload');
    }

    makeAdditionalDirectories() {
        let fontAwesomeTemplateDirectory = __dirname + '/base/folders/font-awesome',
            fontAwesomeDirectory = 'public/css/';

        this.utils.makeFolderFromTemplate(fontAwesomeDirectory, fontAwesomeTemplateDirectory);
    }

    makeRoutesFile() {
        let routesTemplateFile = __dirname + '/base/RoutesTemplate.php',
            routesFile = 'routes/web.php';
        this.utils.makeFileFromTemplate(routesFile, routesTemplateFile, {models: this.project.models});
    }

    makeAppLayoutViewFile() {
        let project = this.project,
            viewFile = 'resources/views/layouts/app.blade.php',
            templateFile = __dirname + '/base/views/AppViewTemplate.php';

        this.utils.makeFileFromTemplate(viewFile, templateFile, {project: project});
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
        let migrationTemplateFile = __dirname + '/base/MigrationTemplate.php',
            migrationFile = this.makeMigrationName(model);

        this.utils.makeFileFromTemplate(migrationFile, migrationTemplateFile, {model: model});
    }

    makeMigrationName(model) {
        let pad = require('pad'),
            modelIndex = pad(model.getIndex().toString(), 6, '0'),
            migrationPrefix =  '2014_10_13_' + modelIndex,
            migrationsDirectory = 'database/migrations/';
        
        return migrationsDirectory + migrationPrefix + '_create_' + model.getNamePluralSnakeCase() + '_table.php';
    }

    makeModelFile(model) {
        let modelTemplateFile = __dirname + '/base/ModelTemplate.php',
            modelsDirectory = 'app/Models/',
            modelFile = modelsDirectory + model.getNameCapitalized() + '.php';

        this.utils.makeFileFromTemplate(modelFile, modelTemplateFile, {model: model});
    }

    makeControllerFile(model) {
        let controllerTemplateFile = __dirname + '/base/ControllerTemplate.php',
            controllersDirectory = 'app/Http/Controllers/',
            controllerFile = controllersDirectory + model.getNameCapitalized() + 'Controller.php';

        this.utils.makeFileFromTemplate(controllerFile, controllerTemplateFile, {model: model});
    }

    makeRequestFile(model) {
        let requestTemplateFile = __dirname + '/base/RequestTemplate.php',
            requestsDirectory = 'app/Http/Requests/',
            requestFile = requestsDirectory + 'Store' + model.getNameCapitalized() + '.php';

        this.utils.makeFileFromTemplate(requestFile, requestTemplateFile, {model: model});
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
            let viewsDirectory = 'resources/views/home/',
                viewFile = viewsDirectory + model.getNamePlural() + '/' + viewName + '.blade.php',
                templateFile = __dirname + '/base/views/' + views[viewName];

            this.utils.makeFileFromTemplate(viewFile,  templateFile, {model: model});
        });
    }

    finalizeProject() {

    }

}

module.exports = Plug;