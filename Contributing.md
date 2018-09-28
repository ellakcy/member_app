# Notes for contributors

Because sharing (knowledge) is caring. So any dev problems should get answered here.

## Basic commands for accessing ssh vagrant vm and running cli commnds:

**BEFORE** running unit tests or run any command you must run the followind commands first in orger to get ssh access:

```
vagrant ssh
cd ~/code
```

One you have gained ssh access then you are able to run any command you want.

## Xdebug Configuration
You can configure the xdebug connection via creating a `xdebug.conf` file.
Also you can specify the `$ip` in it, in order to get autofilled it with the appropriate value, for example by defining the following file:

```zend_extension = xdebug.so
xdebug.remote_enable = 1
xdebug.remote_host = $ip
xdebug.remote_port = 9091
xdebug.max_nesting_level = 1000
xdebug.remote_handler=dbgp
xdebug.remote_mode=req
xdebug.remote_autostart=true
xdebug.remote_log=xdebug.log
```

The `after.sh` script will look for `$ip` string in it and will replace with the actual ip required for xdebug.

## Testing

### Base Superclasses

For testing you can extend your tests using the following classes:

Superclass Name | Purpoce
--- | ---
`Tests\AppBundle\Controller\DefaultControllerTest` | Bootstrapping tests and perform common test actions for client functional testing

### Troubleshooting

For testing is used ***phpunit*** and in case you run into duplicate key problems run:

```
 php ./bin/console doctrine:schema:drop --env=test --force ; php ./bin/console doctrine:schema:create --env=test
```
This can get caused for a test thast is yet to get completed due to an error (eg. a syntax one)
