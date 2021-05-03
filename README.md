# SodionAuthFlarum

Flarum plugin for SodionAuth

## How to use

Install it by

```shell
composer require mohist/flarum-sodion-auth
```

Enable it in Admin Panel

Generate an api-key by
```shell
php flarum sodionauth:key
```

Configure SodionAuth
```json
{
  "api": {
    "web": {
      "flarum": {
        "url": "http://example.com/api/sodionauth",
        "key": "YOUR_KEY_HERE",
        "allow login": true,
        "allow register": true,
        "friendly name": "flarum"
      }
    }
  }
}
```
