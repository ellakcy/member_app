# Notes for contributors

Because sharing (knowledge) is caring. So any dev problems should get answered here.

## Basic commands for accessing ssh vagrant vm and running cli commnds:

**BEFORE** running unit tests or run any command you must run the followind commands first in orger to get ssh access:

```
vagrant ssh
cd ~/code
```

One you have gained ssh access then you are able to run any command you want.

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
