
## Basic commands for accessing ssh vagrant vm and running cli commnds:

```
vagrant ssh
cd ~/code
```

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
