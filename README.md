# Piwik Exclude IP By DDNS

## Description

This plugin allows the Piwik users to dynamically exclude their IP address using DDNS update.

### Requirements

[Piwik](https://github.com/piwik/piwik) 2.0.4 or higher is required.

### Features

- Exclude one IP for each Piwik user 

## FAQ

__What data do I need to set for DDNS Update__

You need to set the following URL to be triggered for an update.
```
http://piwik.url/index.php?module=ExcludeByDDNS&action=update&token_auth={token_auth}
``` 
There is no need to set user, password or domain name.

## Changelog

- Version 0.1 - Alpha Release

## Support

Please direct any feedback to [stefan@piwik.org](mailto:stefan@piwik.org)

## Contribute

Feel free to create issues and pull requests.

## License

GPLv3 or later

