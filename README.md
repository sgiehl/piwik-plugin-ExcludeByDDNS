# Matomo Exclude IP By DDNS

[![Build Status](https://travis-ci.com/sgiehl/piwik-plugin-ExcludeByDDNS.png?branch=4.x-dev)](https://travis-ci.com/sgiehl/piwik-plugin-ExcludeByDDNS)
[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=sgiehl&url=https://github.com/sgiehl/piwik-plugin-ExcludeByDDNS&title=Piwik%20Plugin%20ExcludeByDDNS=&tags=github&category=software)

## Description

This plugin allows the Matomo users to dynamically exclude their IP address using DDNS update.

### Requirements

[Matomo](https://github.com/matomo-org/matomo) 4.0.0 or higher is required.

### Features

- Exclude one IP for each Matomo user 
- Exclude and IP using an already updated hostname

## FAQ

__Which update method should I use, _DDNS Update_ or _DDNS Hostname_?__

If available, ___DDNS Update___ is recommended. This method is a bit more complicated to set up, but it leads to immediately updated IP's, as the client will trigger the update whenever a new IP is assigned.
But it may not be viable for all users, eg. 
* Not all DDNS clients allow custom update-URL's.
* The client may be already serving another server and have no ability to talk to multiple servers at the same time.

So, the ___DDNS Hostname___ can be an alternative. Use a DDNS service that is compatible with your client and enter the hostname from there to have the plugin resolve your dynamic IP. The downside: Updating happens via a scheduled task every hour, so there might be small windows with the new IP still being tracked, but not the old one.

__What data do I need to set for DDNS Update__

You need to set a custom URL to be triggered for an update.
Your personal update-URL is shown in your Matomo installation (user-menu > Personal > DDNS Settings).

The URL has the following scheme:
```
http{s}://{matomo.url}/index.php?module=ExcludeByDDNS&action=update&token_auth={token_auth}
```

- {s} Use HTTPS if available.
- {matomo.url}: The URL to your Matomo installation.
- {token_auth}: A token auth (user-menu > Personal > Security).

There is no need to set user, password or domain name.

## Changelog

- Version 4.0.0 - Compatibility for Matomo > 4.0.0
- Version 3.0.0 - Compatibility for Piwik > 3.0.0
- Version 0.4.0 - Compatibility for Piwik > 2.4.0
- Version 0.3.0 - Various improvements and translations
- Version 0.2.0 - Beta Release
- Version 0.1.0 - Alpha Release

## Support

Please direct any feedback to [stefan@matomo.org](mailto:stefan@matomo.org)

## Contribute

Feel free to create issues and pull requests.

## License

GPLv3 or later

