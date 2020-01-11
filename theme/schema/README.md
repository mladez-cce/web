# Website configuration

General configuration of this WordPress website (bound to this theme).

This is an alternative to the standard WordPress configuration approach which
relies on imperative function calls in `functions.php`.

Normally, you would use similar calls to configure a theme:

```php
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
```

With neon, you can do this instead:

```neon
support:
  - automatic-feed-links
  - post-thumbnails
```

Note that you can still use the old way if you prefer.

Check `config/utils/neon-schema.php` to see what is supported. Check the
[MangoPress Theme repo](https://github.com/manGoweb/MangoPress/tree/master/theme/schema)
for sample usages.

