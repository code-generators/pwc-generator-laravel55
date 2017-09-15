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
        this.makeModelFile(model);    
    }

    makeModelFile(model) {
        let modelFile = this.modelsDirectory + model.getNameCapitalized() + '.php';
        this.utils.makeFileFromTemplate(modelFile, this.modelTemplateFile, {model: model});
    }

    finalizeProject() {

    }

}

module.exports = Plug;