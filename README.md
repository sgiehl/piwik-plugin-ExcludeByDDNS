# Piwik Exclude IP By DDNS

## Description

This plugin allows the Piwik users to dynamically exclude their IP address using DDNS update.

### Requirements

[Piwik](https://github.com/piwik/piwik) 2.4.0 or higher is required.

### Features

- Exclude one IP for each Piwik user 
- Exclude and IP using an already updated hostname

## FAQ

__Which update method should i use, _DDNS Update_ or _DDNS Hostname_?__

If available, ___DDNS Update___ is recommended. This method is a bit more complicated to set up, but it leads to immediately updated IP's, as the client will trigger the update whenever a new IP is assigned.
But it may not be viable for all users, eg. 
* Not all DDNS clients allow custom update-URL's.
* The client may be already serving another Server and have no ability to talk to multiple Servers at the same time.

So, the ___DDNS Hostname___ can be an alternative. Use a DDNS Service that is compatible with your client and enter the hostname from there to have the plugin resolve your dynamic IP. The downside: Updating happens via a sheduled task every hour, so there might be small windows with the new IP still being tracked, but not the old one.

__What data do I need to set for DDNS Update__

You need to set the following URL to be triggered for an update.
```
http://piwik.url/index.php?module=ExcludeByDDNS&action=update&token_auth={token_auth}
``` 
There is no need to set user, password or domain name.

## Changelog

- Version 0.2.0 - Beta Release
- Version 0.1.0 - Alpha Release

## Support

Please direct any feedback to [stefan@piwik.org](mailto:stefan@piwik.org)

## Contribute

Feel free to create issues and pull requests.

## License

GPLv3 or later

