# PM Test

## How to deploy locally
do this in your linux machine to set up the environment:

```sh
git clone https://github.com/United-Ads-Ltd/pm-test && cd pm-test
cp .env.example .env
composer install
php artisan key:generate && php artisan migrate --force
```

and then to open a web server:

```sh
php artisan serve
```

if you dont use linux, read the shell scripts line by line and think to yourself how you would deploy it on your os

## How to make and use the API keys

for local testing purposes, you're likely going to want to make a key with all scopes:

```sh
php artisan make:api-key test --scope='*'
```

its going to print out this:

```
Your key is: iID4TKsZTH9oDXEuYKCyDWgA
Store it safely, as it won't be shown again!
Your bearer token is:
eyJrZXkiOiJpSUQ0VEtzWlRIOW9EWEV1WUtDeURXZ0EiLCJuYW1lIjoidGVzdCJ9
You will use this to access the API. This has the same secrecy as the key shown before it
```

out of which you want the part that says what is your bearer token is, which is `eyJrZXkiOiJpSUQ0VEtzWlRIOW9EWEV1WUtDeURXZ0EiLCJuYW1lIjoidGVzdCJ9`.

you will use this key as a bearer token in the `Authorization` header, for example with curl:

```sh
curl $URL -H 'Authorization: eyJrZXkiOiJpSUQ0VEtzWlRIOW9EWEV1WUtDeURXZ0EiLCJuYW1lIjoidGVzdCJ9'
```