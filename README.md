# Piwik Exclude IP By DDNS

[![Build Status](https://travis-ci.org/sgiehl/piwik-plugin-ExcludeByDDNS.png?branch=master)](https://travis-ci.org/sgiehl/piwik-plugin-ExcludeByDDNS)
[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=sgiehl&url=https://github.com/sgiehl/piwik-plugin-ExcludeByDDNS&title=Piwik%20Plugin%20ExcludeByDDNS=&tags=github&category=software)

## Description

This plugin allows the Piwik users to dynamically exclude their IP address using DDNS update.

### Requirements

[Piwik](https://github.com/piwik/piwik) 3.0.0 or higher is required.

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

You need to set a custom URL to be triggered for an update.
Your personal update-URL is shown in your piwik installation (user-menu > Personal > DDNS Settings).

The URL has the following scheme:
```
http{s}://{piwik.url}/index.php?module=ExcludeByDDNS&action=update&token_auth={token_auth}
```

- {s} Use HTTPS if available.
- {piwik.url}: The URL to your piwik installation.
- {token_auth}: Your API auth token (user-menu > Platform > API).

There is no need to set user, password or domain name.

## Changelog

- Version 3.0.0 - Compatibility for Piwik > 3.0.0
- Version 0.4.0 - Compatibility for Piwik > 2.4.0
- Version 0.3.0 - Various improvements and translations
- Version 0.2.0 - Beta Release
- Version 0.1.0 - Alpha Release

## Support

Please direct any feedback to [stefan@piwik.org](mailto:stefan@piwik.org)

## Contribute

Feel free to create issues and pull requests.

## License

GPLv3 or later

