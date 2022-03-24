# WSDL Handler

> WSDL Handler provides handful methods to manipulate/browse a WSDL and its schemas.

[![License](https://poser.pugx.org/wsdltophp/wsdlhandler/license)](https://packagist.org/packages/wsdltophp/wsdlhandler)
[![Latest Stable Version](https://poser.pugx.org/wsdltophp/wsdlhandler/version.png)](https://packagist.org/packages/wsdltophp/wsdlhandler)
[![TeamCity build status](https://teamcity.mikael-delsol.fr/app/rest/builds/buildType:id:WsdlHandler_Build/statusIcon.svg)](https://github.com/WsdlToPhp/WsdlHandler)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/WsdlToPhp/WsdlHandler/badges/quality-score.png)](https://scrutinizer-ci.com/g/WsdlToPhp/WsdlHandler/)
[![Code Coverage](https://scrutinizer-ci.com/g/WsdlToPhp/WsdlHandler/badges/coverage.png)](https://scrutinizer-ci.com/g/WsdlToPhp/WsdlHandler/)
[![Total Downloads](https://poser.pugx.org/wsdltophp/wsdlhandler/downloads)](https://packagist.org/packages/wsdltophp/wsdlhandler)
[![StyleCI](https://styleci.io/repos/87977980/shield)](https://styleci.io/repos/87977980)
[![SymfonyInsight](https://insight.symfony.com/projects/b3232a2b-83c4-4546-92ae-c3f1357f62e9/mini.svg)](https://insight.symfony.com/projects/b3232a2b-83c4-4546-92ae-c3f1357f62e9)

WsdlHandler uses the [decorator design pattern](https://en.wikipedia.org/wiki/Decorator_pattern) upon [DomHandler](https://github.com/WsdlToPhp/DomHandler).

The source code has been originally created into the [PackageGenerator](https://github.com/WsdlToPhp/PackageGenerator) project but it felt that it had the possibility to live by itself and to evolve independtly from the PackageGenerator project if necessary.

## Testing using [Docker](https://www.docker.com/)
Thanks to the [Docker image](https://hub.docker.com/r/splitbrain/phpfarm) of [phpfarm](https://github.com/fpoirotte/phpfarm), tests can be run locally under *any* PHP version using the cli:
- php-7.4

First of all, you need to create your container which you can do using [docker-compose](https://docs.docker.com/compose/) by running the below command line from the root directory of the project:
```bash
$ docker-compose up -d --build
```

You then have a container named `wsdl_handler` in which you can run `composer` commands and `php cli` commands such as:
```bash
# install deps in container (using update ensure it does use the composer.lock file if there is any)
$ docker exec -it wsdl_handler php-7.4 /usr/bin/composer update
# run tests in container
$ docker exec -it wsdl_handler php-7.4 -dmemory_limit=-1 vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## FAQ

Feel free to [create an issue](https://github.com/WsdlToPhp/WsdlHandler/issues/new).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

