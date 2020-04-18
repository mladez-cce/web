# Web evangelické mládeže

Oficiální (jak jen mohou být) webové stránky mládeže Českobratrské církve
evangelické.

## How to run the website locally

The following instructions should work on any Unix-like system (MacOS, Linux).
For Windows, some steps will have to be worked around.

**Prerequisites:**

*   Local web server with PHP support and MySQL-like database. For more details
    check the requirements of
    [WordPress](https://wordpress.org/support/article/requirements/) and [Nette
    2.4](https://doc.nette.org/en/2.4/requirements).
*   PHP CLI (to run PHP scripts from command line)
*   node.js
*   yarn
*   Composer

Clone the Git repository:

```
$ git clone https://github.com/mladez-cce/web.git
```

Install PHP & JavaScript dependencies:

```
$ composer install
$ yarn install
```

Download WordPress into the `public` directory. You can use the WordPress CLI
which was automatically installed by composer:

```
$ vendor/bin/wp core download --path=public
```

As an alternative, you can manually [download](https://wordpress.org/download/)
WordPress and unzip it into the `public` directory.

Now create a local config file:

```
$ bin/create-local-config.sh
```

If the bash script doesn't work, you can manually copy
`config/config.local.sample.neon` to `config/config.local.neon` and populate the
auth keys (just insert some random values).

Add your database information to the newly created local config file,
`config/config.local.neon`. The relevant section should look like this:

```
database:
	host: 127.0.0.1
	database: mladez
	username: mladez
	password: YourSecretDatabasePassword
```

Make the `log` and `temp` directories writable:

```
$ chmod 777 log
$ chmod 777 temp
```

(Ideally, make it writable only by the web server.)

Install WordPress. You can either go through the standard wizard by accessing
the page URL or use the WP CLI for express installation:

```
$ vendor/bin/wp core install \
    --url=http://localhost \
    --title="Evangelická mládež" \
    --admin_user=admin \
    --admin_email=your@email.com \
    --path=public
```

The administrator password will be printed on the screen.

Clear cache to avoid potential permission problems:

```
$ rm -r temp/*
```

Build CSS files:

```
$ yarn build-css
```

Done. The website should be now up and running. You can access the
administration on `/wp-admin`.

## Import default site content

You can import the default site content (sample pages, posts, events, menus etc)
from [`wp-site-content-export.xml`](wp-site-content-export.xml).

1.  Log in into WordPress admin
2.  Go to `Tools → Import` and run `WordPress Importer`
3.  Upload [`wp-site-content-export.xml`](wp-site-content-export.xml)

For best experience (e.g. to get also the default media imported), first open
the XML file and replace all instances of the base site url (e.g.
`http://31.31.74.63/`) with your WordPress URL.

Note that the export is not intended as backup of the actual website. Its
purpose is merely to simplify setting up the local dev environment.
