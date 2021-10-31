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

#### 2. Include the following variables in config services file

First Party applications can authenticate via browser without saving user sessions. In order to achieve that the `disable_user_session` configuration should be set to `true` in the config file.


```json
    'murugo' => [
        'client_id' => env('MURUGO_CLIENT_ID'),
        'client_secret' => env('MURUGO_CLIENT_SECRET'),
        'redirect' => env('APP_REDIRECT_URL', 'YOUR LOGIN REDIRECT URL'),
        'murugo_url' => env('MURUGO_URL', 'MURUGO_URL'),
        'murugo_app_key' => env('MURUGO_APP_KEY'),
        'disable_user_session' => true|false
    ],
```

#### 3. Dont forget to publish your migration by running the following command, when you want to upgrade 
```json
php artisan vendor:publish
```

#### 4. Use the following migration
```php
php artisan migrate
```

#### 5. Add method to redirect user to murugo

For First Party Authorizations, the user will need to include some extra params

```json
   use RwandaBuild\MurugoAuth\Facades\MurugoAuth;


    public function redirectToMurugo()
    {
        return MurugoAuth::redirect();
    }
```
#### 6. Add a callback method to be used after the redirection or when using the stateless method

a)  When you need only the murugo user model

```json
   use RwandaBuild\MurugoAuth\Facades\MurugoAuth;

    public function murugoCallback()
    { 
        $murugoUser = MurugoAuth::user()
        
        // or using the stateless way for SPAs
         MurugoAuth::stateless()->user()
    }
```

b) When you need extra details from the user being authenticated, you will need to use a callback

```json
    public function murugoCallback()
    { 
        /**
        * @param MurugoUser $murugoUser
        * @param array $userDetails
        */
        $userCallback = function($murugoUser, $userDetails) {
            // cook your stuff here...
        };
        
        // then pass your callback here
        $murugoUser = MurugoAuth::user($userCallback);

        // either way, you can grab the data in a fancy way like
        $userWithDetails = MurugoUser::user(fn($murugoUser,$userDetails) => ([
            $murugoUser, $userDetails
        ]));

        //then get what you want using it's index
        $murugoUser = $userWithDetails[0] // for the murugo user

    }
```

#### 7. Package also comes with this following method
```json

    /**
     * This one is used by client(mobile) to authenticate murugo users on their 3rd party servers
     */
   use RwandaBuild\MurugoAuth\Facades\MurugoAuth;
   $tokens = [
               'access_token' => 'murugo_user_access_token'],
              'refresh_token' => 'murugo_user_refresh_token',
              'expires_in' => integer
   ],
   $murugoUser = MurugoAuth::userFromToken($tokens);
```
#### 8. Add relationship between User and Murugo User models
- Add a Trait built in the package already that makes relationship between User model and Murugo user model
```json

    use RwandaBuild\MurugoAuth\Traits\MurugoAuthHelper;
    class User extends Authenticatable
    {
      use MurugoAuthHelper;
    }
```
- To access the murugo user when you already have user model like the following:
```json

    $user = User::find(1);
    // access the relationship
    $murugoUser = $user->murugoUser;
```

- When you have a murugo user model and you need to the related user, you can do it in the following way:

```json
$murugoUser = MurugoAuth::user();
// accessing the related user
$user = $murugoUser->user;
```

- When you want to customize the foreign key that the package will use for your relationship, you can set it up from one of your service providers:
```json
$murugoUser = MurugoAuth::Key('custom_child_key');
```


NOTES: By default package is using App\User model or App\Models|user for making relationship between your user and murugo user model
#### 9. At this step this is how you refresh tokens

First you should know that the Murugo user model keeps the ``access_token`` ``refresh_token`` and the `token_expires_at`
, now in case you may need to refresh the token of an existing, just do it in the following way:

```php
$user = User::find(2);

// refreshing murugo user token

$murugoUser = MurugoAuth::refreshToken($user->murugoUser);

```
## By Default package will add the following api routes in your laravel project

- api/murugo-auth >>> This route will be used to get response sent from murugo and save in your laravel project database
- api/authenticate-user >>>This route will authenticate user by checking uuid of user and by checking if token is still valid and if true return user object
- api/logout >>> This route will logout user on murugo server
## Follow RwandaBuild bellow and contact us

- [Rwanda Build Website](https://rwandabuildprogram.com/)
- [Rwanda Build On Twitter](https://twitter.com/RwandaBuild)
