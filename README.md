# SES Management Laravel Package


This package hooks into Laravel send mail events and checks the recipients (To/Bcc/Cc) against the BW SES bounce/complaint Management API.


# Installation
### BW SES Management Tool Steps
1. Log in to the BW SES Management tool.
2. Create a new application with the application name and associated URL.

### Laravel Steps
1. Add the package to the 'require' section of your composer.json e.g:
```sh
    "require": {
        "php": ">=7.0.0",
        "fideloper/proxy": "~3.3",
        "laravel/framework": "5.5.*",
        "laravel/tinker": "~1.0",
		"bluewren/ses-checker" : "dev-master"
    },
```

2. Underneath the require section, add the following:
```sh
    "repositories": [
		{
			"type": "vcs",
			"url": "https://github.com/bluewren/ses-checker"
		}
	],
```

3. Now run the composer update command:
```sh
    composer update
```

4. Finally, publish the configuration file with:

```sh
php artisan vendor:publish --provider="Bluewren\SESChecker\SESCheckerServiceProvider"
```
5. Open the ses-checker.php file inside config/ses-checker.php and set the 'api-url' and the 'application-token' that is shown in the SES Management Tool.
