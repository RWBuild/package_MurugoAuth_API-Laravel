# Laravel API Authentication with MurugoCloudCore Package

[![Issues](https://img.shields.io/github/issues/RWBuild/package_MurugoAuth_API-Laravel.svg?style=flat-square)](https://github.com/RWBuild/package_MurugoAuth_API-Laravel/issues)
[![Stars](https://img.shields.io/github/stars/RWBuild/package_MurugoAuth_API-Laravel.svg?style=flat-square)](https://github.com/RWBuild/package_MurugoAuth_API-Laravel/stargazers)
[![Total Downloads](https://img.shields.io/packagist/dt/rwandabuild/murugo_api_auth.svg?style=flat-square)](https://packagist.org/packages/rwandabuild/murugo_api_auth)

Package that will be used for Murugo auth to all 3rd party laravel projects with only API structure

## Follow the following steps to get started:

#### 1. Install package by running the following command

```json
composer require rwandabuild/murugo_api_auth
```

#### 2. Include the following variables in ENV file and replace them your their values
```json
MURUGO_URL= "MURUGO BASE URL/"
```

#### 3. Use the following migration
```php
Schema::create('murugo_users', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('name');
    $table->string('email')->unique();
    $table->string('murugo_user_id');
    $table->string('murugo_user_avatar');
    $table->string('murugo_user_public_name');
    $table->text('token');
    $table->timestamp('token_expires_at')->nullable();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password')->nullable();
    $table->rememberToken();
    $table->timestamps();
});
```
#### 4. Dont forget to publish your migration by running the following command
```json
php artisan vendor:publish
```

## By Default package will add the following api routes in your laravel project

- api/murugo-auth >>> This route will be used to get response sent from murugo and save in your laravel project database
- api/authenticate-user >>>This route will authenticate user by checking uuid of user and by checking if token is still valid and if true return user object
- api/logout >>> This route will logout user on murugo server
## Follow RwandaBuild bellow and contact us

- [Rwanda Build Website](https://rwandabuildprogram.com/)
- [Rwanda Build On Twitter](https://twitter.com/RwandaBuild)