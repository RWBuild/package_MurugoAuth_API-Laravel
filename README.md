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

First Party applications can authenticate via browser without saving user sessions. In order to achieve that, the `disable_user_session` configuration should be set to `true` in the config file.


```json
    'murugo' => [
        'client_id' => env('MURUGO_CLIENT_ID'),
        'client_secret' => env('MURUGO_CLIENT_SECRET'),
        'redirect' => env('APP_REDIRECT_URL', 'YOUR LOGIN REDIRECT URL'),
        'murugo_url' => env('MURUGO_URL'),          // e.g. https://murugo.cloud (with or without a trailing slash)
        'murugo_app_key' => env('MURUGO_APP_KEY'),
        'disable_user_session' => true|false,
        'connect_timeout' => 5,                       // optional, seconds (default 5)
        'timeout' => 15,                              // optional, seconds per request to Murugo (default 15)
    ],
```

Requests to Murugo give up after `timeout` seconds; the user then sees "Murugo is unreachable right now" (`MurugoAuthException`, status 503). If `murugo_url` is missing or not an http(s) URL, the package logs an error and throws `MurugoAuthException` (status 500) instead of calling a wrong address.

#### 3. Don't forget to publish your migration by running the following command, when you want to upgrade
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

a) When you need only the murugo user model:

```json
   use RwandaBuild\MurugoAuth\Facades\MurugoAuth;

    public function murugoCallback()
    { 
        $murugoUser = MurugoAuth::user()
        
        // or using the stateless way for SPAs
         MurugoAuth::stateless()->user()
    }
```

`stateless()` skips the state check for that one `user()` call in the current request only. Call it each time, right before `user()`; it never carries over to later requests (Octane, queue workers).

b) When you need extra details from the user being authenticated, you will need to use a callback:

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
$murugoUser = MurugoAuth::setForeignKey('custom_child_key');
```


NOTES: By default, package is using `App\User` model or `App\Models|user` for making relationship between your user and Murugo user model

#### 9. At this step, this is how you refresh tokens

First, you should know that the Murugo user model keeps the ``access_token``, ``refresh_token`` and the `token_expires_at`
, now in case you may need to refresh the token of an existing user, just do it in the following way:

```php
$user = User::find(2);

// Refreshing murugo user token

$murugoUser = MurugoAuth::refreshToken($user->murugoUser);

```
#### 10. Log out (SSO logout)

`MurugoAuth::logout($murugoUser)` logs the user out of Murugo for your app: Murugo revokes your app's
token for that user and ends the Murugo browser session the user logged in from. Other apps and
other browsers of the user stay logged in. The tokens stored on the `MurugoUser` are cleared.

```php
use RwandaBuild\MurugoAuth\Facades\MurugoAuth;

public function logout(Request $request)
{
    $user = $request->user();

    MurugoAuth::logout($user->murugoUser); // true = Murugo confirmed; false = couldn't reach it (logged)

    Auth::logout();                        // then log out of your own app as usual
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
```

If the stored access token has expired, it is refreshed once before logging out. Even when Murugo
can't be reached, call your own logout afterwards: the local tokens are cleared either way.

#### Tokens are hidden from JSON

`MurugoUser`'s `token` and `refresh_token` are in `$hidden`: they are not included by `toArray()` / `toJson()` (API responses, frontend props, a `User` with `murugoUser` loaded). Server code still reads `$murugoUser->token`. If you really need one in a response, use `$murugoUser->makeVisible('token')` on purpose.

#### 11. Publish the package assets

The error page uses an image from the package. Publish it once (and after updating the package):

```bash
php artisan vendor:publish --tag=murugo-public
```

To do it automatically, add it to **your app's** `composer.json` (scripts in the package's own
`composer.json` don't run in your app):

```json
"scripts": {
    "post-update-cmd": [
        "@php artisan vendor:publish --tag=murugo-public --force"
    ]
}
```

#### 12. Tests (package development)

```bash
composer require --dev orchestra/testbench phpunit/phpunit
composer test
```

## Follow RwandaBuild bellow and contact us

- [Rwanda Build Website](https://rwandabuildprogram.com/)
- [Rwanda Build On Twitter](https://twitter.com/RwandaBuild)
