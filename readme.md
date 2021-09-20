# p7_BileMo
RESTful API made with Symfony 5 and API Plateform.

## About The Project

I made this API to improve my skills in Symfony / API Plateform, in the context of my PHP/Symfony OpenClassRooms formation.
Your comments and suggestions are welcome.

### Features

BileMo is a fake enterprise which offers mobile phones. This API give possibility to BileMo clients (BtoB) to consult BileMo products and to manage their own clients.

This API :
*   Give a doc with Swagger
*   Accept and return content in json format
*   Give possibility to BileMo clients to get BileMo products
*   Give possibility to BileMo clients (named Customer in the project) to create/read/patch/delete their own clients only (named User in the project)
*   Implements JWT token system to authenticate customers and a refresh token to keep the authentication active instead of reconnect when token is expired
*   Is RESTful, respect level 1, 2 and 3 of Richardson Maturity Model
*   Is monitored by Codacy and Code Climate

### Built With

*   🐘️ PHP 8.0.0
*   ⛵ phpMyAdmin 5.0.2
*   🐬  MySQL 5.7.31
*   ✒️Apache 2.4.46
*   ⛕️Git 2.31.1.windows.1<p>&nbsp;</p>
*   🖊️ Dia for UML
*   🖊️ Draw.io for UML
*   🐬 MySQL Workbench for UML

### Code quality

Codacy : [![Codacy Badge](https://app.codacy.com/project/badge/Grade/dd93064a48c84bf38760e9cea3fc4bbb)](https://www.codacy.com/gh/Drx85/p7_api_bilemo/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Drx85/p7_api_bilemo&amp;utm_campaign=Badge_Grade)

Code Climate : [![Maintainability](https://api.codeclimate.com/v1/badges/da6878b880de8ab96eb5/maintainability)](https://codeclimate.com/github/Drx85/p7_api_bilemo/maintainability)

## Getting Started

To get a copy up and running follow these simple steps.

### PREREQUISITES

### Server

*   PHP > 8.0.0
*   Host provider or XAMPP/WAMP for local use
*   MySQL DMBS like phpMyAdmin : https://docs.phpmyadmin.net/fr/latest/setup.html

### Framework and libraries

*   Symfony > 5.3.6
*   Libraries will be installed using Composer

### INSTALLATION

### Clone / Download

1.  Git clone the repository from this page. **See** [GitHub Documentation](https://docs.github.com/en/github/creating-cloning-and-archiving-repositories/cloning-a-repository-from-github/cloning-a-repository)

### Config 

1.  Open .env.example file, replace SMTP field (line 25) with your own information, and rename it .env
2.  If you are missing any information, please ask you webhost for Database credentials

### Install all dependencies
1.  Install Composer if you don't have it yet. **See** [Composer Documentation](https://getcomposer.org/download/)
2.  In your CMD, move on your project directory using cd command :
```sh
cd your/directory
```
    
3.  Run : 
```sh
composer install
```
All dependencies should be installed in a vendor directory.

### Database

1.  Create new Database in your favorite MySQL DMBS running
```sh
php bin/console doctrine:database:create
```

2.  Import database tables running
```sh
php bin/console doctrine:migrations:migrate
```

3.  Import fixtures running
```sh
php bin/console doctrine:fixtures:load
```

### Finalization

1.  Generate your own SSL keys running (if needed see [Lexik Documentation](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/2.x/Resources/doc/index.md))
```sh
php bin/console lexik:jwt:generate-keypair
```

2.  (local only) To start the server, run
```sh
symfony s:start
```

3.  Go to "/api" to see the API documentation

## Usage

### Online example version

Please see an hosted example version here : *waiting end of project to share link*

## Contact

Cédric Deperne - cedric@deperne.fr

Project Link: [https://github.com/Drx85/p7_api_bilemo](https://github.com/Drx85/p7_api_bilemo)
