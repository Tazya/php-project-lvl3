# php-project-lvl3
  ![Master CI](https://github.com/Tazya/php-project-lvl3/workflows/Master%20workflow/badge.svg)
## Apllication for SEO checking. Student project from hexlet.io
  Demo: [http://still-headland-57389.herokuapp.com/](http://still-headland-57389.herokuapp.com/)
### Requirements

  * PHP ^7.3
  * Extensions: mbstring, curl, dom, xml,zip, sqlite3
  * Composer
  * Node.js & npm
  * Database: PostgreSQL
  * SQLite for testing
  * [heroku cli](https://devcenter.heroku.com/articles/heroku-cli#download-and-install)

### Setup

```sh
$ make setup
```
After setup write your database variables in .env file and run migrate:

```sh
$ make migrate
```

### Run

```sh
$ make start
```
