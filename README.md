SES Management Laravel Package
======

This package hooks into Laravel send mail events and checks the recipients (To/Bcc/Cc) against the BW SES bounce/complaint Management API using the provided application token to authenticate requests.

# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


# Installation
### BW SES Management Tool Steps
1. Log in to the BW SES Management tool.
2. Create a new application with the application name and associated URL.

### Laravel Steps
1. Add the package to the **'require'** section of your **_composer.json_** e.g:
```json
"require": {
    "php": ">=7.0.0",
    "fideloper/proxy": "~3.3",
    "laravel/framework": "5.5.*",
    "laravel/tinker": "~1.0",
    "bluewren/ses-checker": "dev-master"
}
```

2. Underneath the **'require'** section, add the following:
```json
"repositories": [{
    "type": "vcs",
    "url": "https://github.com/bluewren/ses-checker"
}],
```

3. Now run the composer update command:
```sh
composer update
```

4. Publish the configuration file with:

```sh
php artisan vendor:publish --provider="Bluewren\SESChecker\SESCheckerServiceProvider"
```

5. Add the following configuration values to your **_.env_** file and insert the relevant values:
```sh
SES_API_URL=
SES_APPLICATION_TOKEN=
```
