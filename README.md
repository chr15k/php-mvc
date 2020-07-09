# PHP MVC
PHP MVC with Twig templating.

This is a work in progress, and just a bit of fun :-)

This project has 2 dependencies:

- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) (environment variables)
- [twig/twig](https://github.com/twigphp/Twig) (templating engine)

## Using this framework
* Clone this repo
* Install project dependencies:
```
composer install
```
* Configure your web server to use the public folder as root.
* Create your environment file and enter your database configuration:
```
cp .env.example .env
```

- Framework files are in /Core directory
- App files are in /app directory
- Add config files to /config
- Environment variables are in .env
- Routes are registered in public/index.php

## Todo (while keeping 3rd party packages to a minimum)
- DB migrations
- Security considerations
- More advanced routing options (currently very basic)
- Needs a routes file (currently registered in public/index.php)
- Console commands
- Model functionality

## License
The MIT License (MIT). Please see [License File](https://github.com/chr15k/string/blob/master/LICENSE.md) for more information.