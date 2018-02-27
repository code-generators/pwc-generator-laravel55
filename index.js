'use strict';

class Plug {

    constructor(utils) {
        this.utils = utils;
        this.initAttributes();
    }

    testDependencies() {
        this.utils.testDependency('git');
    }

    initAttributes() {
        this.simpleDatagridComponents = [];
    }

    initProject(project) {
        try{
            this.project = project;
            this.projectFolderName = this.project.index || this.project.name;
            this.startLaravelProject();
        }catch(e){
            console.log(e.stack);
            throw 'Problem generating the project: ' + e;
        }
    }

    startLaravelProject() {
        let command = 'git clone https://github.com/KingOfCodeBrazil/laravel55-basic.git "' + this.projectFolderName + '"';
        this.utils.executeCommand(command, () => {
            this.startCodeGeneration();
            this.finalizeProject();
        });
    }

    startCodeGeneration() {
        this.utils.goToFolder(this.projectFolderName);
        this.project.createGenerationFile(); 
        this.project.deleteRegisteredFiles();
        this.makeRoutesFile();
        this.makeAppLayoutViewFile();
        this.makeAuthServiceProviderFile();
        this.makePermissionsSeederFile();
        this.proccessModels();
        this.makeAppJavascriptFile();
    }

    makeRoutesFile() {
        let routesTemplateFile = __dirname + '/base/bootstrap/RoutesTemplate.silverb',
            routesFile = 'routes/web.php';
        this.utils.makeFileFromTemplate(routesFile, routesTemplateFile, {models: this.project.models});
    }

    makeAppLayoutViewFile() {
        let project = this.project,
            viewFile = 'resources/views/layouts/app.blade.php',
            templateFile = __dirname + '/base/bootstrap/views/AppViewTemplate.silverb';

        this.utils.makeFileFromTemplate(viewFile, templateFile, {project: project});
    }

    makeAuthServiceProviderFile() {
        this.utils.makeFileFromTemplate(
            'app/Providers/AuthServiceProvider.php', 
            __dirname + '/base/bootstrap/AuthServiceProviderTemplate.silverb', 
            {project: this.project}
        );
    }

    makePermissionsSeederFile() {
        this.utils.makeFileFromTemplate(
            'database/seeds/RolesAndPermissionsSeeder.php', 
            __dirname + '/base/bootstrap/PermissionsSeederTemplate.silverb', 
            {project: this.project}
        );
    }

    proccessModels() {
        this.project.models.forEach((model, index) =>{
            // User model hardcoded blocked
            if(model.name != 'user') {
                this.initModel(model);
            }
        });
    }

    initModel(model) {
        this.makeMigrationFile(model);
        this.makeModelFile(model);
        
        if(!model.isOnlyModel() && !model.isRelationship()) {    
            this.makeControllerFile(model);    
            this.makeRequestFile(model);    
            this.makePolicyFile(model);    
            this.makeViewFiles(model);
            this.makeSimpleDatagridFiles(model);
        }
    }

    makeMigrationFile(model) {
        let migrationTemplateFile = __dirname + '/base/bootstrap/MigrationTemplate.silverb',
            migrationFile = this.makeMigrationName(model);

        this.project.registerFileGeneration(migrationFile);
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
        let modelTemplateFile = __dirname + '/base/bootstrap/ModelTemplate.silverb',
            modelsDirectory = 'app/Models/',
            modelFile = modelsDirectory + model.getNameCapitalized() + '.php';

        this.utils.makeFileFromTemplate(modelFile, modelTemplateFile, {model: model});
    }

    makeControllerFile(model) {
        let controllerTemplateFile = __dirname + '/base/bootstrap/ControllerTemplate.silverb',
            controllersDirectory = 'app/Http/Controllers/',
            controllerFile = controllersDirectory + model.getNameCapitalized() + 'Controller.php';

        this.utils.makeFileFromTemplate(controllerFile, controllerTemplateFile, {model: model});
    }

    makeRequestFile(model) {
        let requestTemplateFile = __dirname + '/base/bootstrap/RequestTemplate.silverb',
            requestsDirectory = 'app/Http/Requests/',
            requestFile = requestsDirectory + 'Store' + model.getNameCapitalized() + '.php';

        this.utils.makeFileFromTemplate(requestFile, requestTemplateFile, {model: model});
    }

    makePolicyFile(model) {
        let policyTemplateFile = __dirname + '/base/bootstrap/PolicyTemplate.silverb',
            policiesDirectory = 'app/Policies/',
            policyFile = policiesDirectory + model.getNameCapitalized() + 'Policy.php';

        this.utils.makeFileFromTemplate(policyFile, policyTemplateFile, {model: model});
    }

    makeViewFiles(model) {
        let views = {
            'index': 'IndexViewTemplate.silverb',
            'create': 'CreateViewTemplate.silverb',
            'fields': 'FieldsViewTemplate.silverb',
            'edit': 'EditViewTemplate.silverb',
            'show': 'ShowViewTemplate.silverb',
            'show_fields': 'ShowFieldsViewTemplate.silverb',
        };

        Object.keys(views).map((viewName) => {
            let viewsDirectory = 'resources/views/home/',
                viewFile = viewsDirectory + model.getNamePlural() + '/' + viewName + '.blade.php',
                templateFile = __dirname + '/base/bootstrap/views/' + views[viewName];

            this.utils.makeFileFromTemplate(viewFile,  templateFile, {model: model});
        });
    }

    makeSimpleDatagridFiles(model) {
        let simpleDatagridTemplateFile = __dirname + '/base/bootstrap/javascript/SimpleDatagridVueComponentTemplate.silverb',
            simpleDatagridDirectory = 'resources/assets/js/components/';

        model.hasManyRelationships.forEach((relationship) => {
            if(relationship.element == 'simple-datagrid') {
                let simpleDatagridFile = simpleDatagridDirectory + relationship.getNamePluralCapitalized() + 'Component.vue';

                this.simpleDatagridComponents.push({component: relationship.getNamePluralCapitalized()});    
                this.utils.makeFileFromTemplate(simpleDatagridFile, simpleDatagridTemplateFile, {model: model, relationship: relationship});
            }
        });
    }

    makeAppJavascriptFile() {
        let appJavascriptTemplateFile = __dirname + '/base/bootstrap/javascript/AppJavascriptTemplate.silverb',
            appJavascriptFile = 'resources/assets/js/app.js';
        
        this.utils.makeFileFromTemplate(appJavascriptFile, appJavascriptTemplateFile, {simpleDatagridComponents: this.simpleDatagridComponents});
    }

    finalizeProject() {
        this.project.finalizeGenerationFile();
        console.log('Project successfully generated!');
    }

}

module.exports = Plug;