
## Accessing SSH:

```
vagrant ssh # In case you already are in ssh session with vagrant od use doctrine ingore them
cd ~/code # Sam as above
```

## Testing

For testing is used ***phpunit*** and in case you run into duplicate key problems run:

```
 php ./bin/console doctrine:schema:drop --env=test --force ; php ./bin/console doctrine:schema:create --env=test
```
