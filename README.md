Memebership application
==================

# Get the dev started

A simple application in order for the organization to manage its memberships.

** UNDER VERY HEAVY DEVELOPMENT **

In order ot get started run the following commands:

```
git clone git@github.com:pc-magas/member_app.git
composer install
npm install
gulp
```

> For the management of the frontend we use the gulp.
> For now it moves the frontend 3rd party libraries into the folder `frontend/vendor`
> Also it symlinks any folder located in `frontend` to the `web/assets`

Also Homestead is used for the development as wellm so you need to install both vagrant and the homestead first, then run:

```
vagrant up
```

# Enviromental Variables

For now theese enviromental variables are being supported:

Name  | homestead default value | description
--- | --- | ---
`database_host` | 127.0.0.1 | Mysql database host
`database_port` | 3306 | Mysql database port
`database_name` | homestead | Mysql database
`database_user` | homestead | Mysql database username
`database_password` | secret | Password for authenticating the applciation to the mysql
`smtp_host` | localhost | Host for sending the emails
`smtp_port` | 1025 | Port for sending the emails
`smtp_user` | no-reply@example.com | Email that all the **REGISTRATION** related email will get sent
