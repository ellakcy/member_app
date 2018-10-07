Memebership application
==================

# Get the dev started


A simple application in order for the organization to manage its memberships.

** UNDER VERY HEAVY DEVELOPMENT **

In order to get started run the following commands:

```
git clone git@github.com:pc-magas/member_app.git
composer install
npm install
gulp
```

> For the management of the frontend we use the gulp.
> For now it moves the frontend 3rd party libraries into the folder `frontend/vendor`
> Also it symlinks any folder located in `frontend` to the `web/assets`


Also Homestead is used for the development as well so you need to install both vagrant and the homestead first, afterwards run (only at the first time):

```
php ./vendor/bin/homestead make
```

Configure `Homestead.yaml` to your preferences as seen in homestead's [documentation](https://laravel.com/docs/5.4/homestead).


Then **each time** you start to develop just run:

```
vagrant up
```

# Enviromental Variables

For now theese enviromental variables are being supported:

Name  | homestead default value | App Default Value | description
--- | --- | ---
`database_host` | 127.0.0.1 | N/A | Mysql database host
`database_port` | 3306 | N/A | Mysql database port
`database_name` | homestead | N/A | Mysql database
`database_user` | homestead | N/A | Mysql database username
`database_password` | secret | N/A | Password for authenticating the applciation to the mysql
`smtp_host` | localhost  | N/A | Host for sending the emails
`smtp_port` | 1025  | N/A | Port for sending the emails
`smtp_user` | no-reply@example.com | N/A | Email that all the **REGISTRATION** related email will get sent
`access_log_dir` | N/A | N/A | Where the in-application access log will get generated
`notification_email_address` | `no-reply@example.com` | N/A | Email address that will be used for notifications (eg. new member registration, password reminder)
