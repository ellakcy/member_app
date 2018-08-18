#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

cd /home/vagrant/code

echo "Clearing caches for dev environment"
php ./bin/console cache:clear
php ./bin/console cache:warmup

echo "Clearing caches for test environment"
php ./bin/console cache:clear --env=test
php ./bin/console cache:warmup --env=test

echo "Creatinc schemas for test environment"
php ./bin/console doctrine:schema:drop --env=test --force
php ./bin/console doctrine:schema:create --env=test
