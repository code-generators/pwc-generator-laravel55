# Laravel 5.5 PWC Generator

## Requirements

You need these technologies installed on your machine to use this generator:

- [NodeJS](https://nodejs.org)
- [NPM](https://www.npmjs.com/) package manager
- [PWC - Command Line Code Generator](https://github.com/pwc-code-generator/pwc)

## Installation

The generator needs to be installed globally, and PWC will be capable to use it:

```
npm install -g pwc-generator-laravel55
```

## Features

- Generates a customized Laravel 5.5 and Vue.js Project based on this repository: [laravel55-basic](https://github.com/KingOfCodeBrazil/laravel55-basic)
- Generates all migrations, models, controllers, routes, form requests and policies
- Generates the views and routes
- Complete ACL with Users, Policies, Permissions, and Roles
- Generates "Belongs To" Relationships with selects if ```element: false``` is not specified 
- Generates "Has Many" Relationships with Vue.js datagrid components if ```element: false``` is not specified

## How to use

1. First, you need to create a PWC Project File, that is a .yml file representing your complete project. You can see some file samples here.
2. Then you can navigate to the folder in that your project file is through the command line, and run the PWC passing this generator:

```
pwc project -f your-projec-file.yml -p pwc-generator-laravel55
```

These commands will:

- Download the git repository
- Install composer packages
- Install npm packages
- Compile the assets

Then you can follow the instructions on [laravel55-basic repository](https://github.com/KingOfCodeBrazil/laravel55-basic) to finally run your project.

## To Do
- Generate Tests

## License
MIT