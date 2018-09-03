# Wordpress Performance & Security Checklist


### Theme checklist
#### Scripts

See [enqueue.php](./enqueue.php) example

- [ ] Don't add scripts directly to the page header. Use `wp_enqueue_script` and `wp_enqueue_style` instead (See [wordpress docs](https://developer.wordpress.org/reference/functions/wp_enqueue_script/))
- [ ] Remove Emoji script
- [ ] Remove Embeded script
- [ ] Remove jQuery Migrate
- [ ] Prevent blocking scripts using `defer` (See [enqueue.php#27](./enqueue.php#L17))
- [ ] Use automation tools (such as gulp.js) to compress and minify scripts and stylesheets (See [gulpfile.js](./gulpfile.js), [gulpconfig.json](./gulpconfig.json) and [package.json](package.json))

#### Security
- [ ] Remove wordpress version from html and RSS (See [security.php#9](./security.php#L9))
- [ ] Disable XML-RPC (See [security.php#26](./security.php#L26))
- [ ] Disable Pingbacks (See [security.php#31](./security.php#L31))

#### Template tags

- [ ] Use native post thumbnails for responsive utilities: `add_theme_support( 'post-thumbnails' );`
