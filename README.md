# DLM Plugin PRO

Sample plugin that utilizes the Digital License Manager PRO theme activator and update server.

![Animation](https://user-images.githubusercontent.com/5760249/144770798-6a679694-955f-41f2-8faf-be473d8cc474.gif)

## Integration

Digital License Manager PRO update server is pretty simple to integrate in any plugin, this is just an example with composer support.

The main functionality resides in `includes/Bootstrap.php`.  The setup_updater() method in this class contains information like the API url, credentials, etc.

## Installation

To install the composer autoloader and packages run:

```
composer install
```

## Development

This is basic sekeleton for a plugin with Composer support. You can continue developing your own based on this, just change the namespace and etc.
