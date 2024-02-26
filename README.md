# Mautic Marketplace allowlist

During the Mautic Marketplace beta (introduced in Mautic 4.1), we are using an allowlist to explicitly define plugins that we know work correctly with Mautic 4.

**Important note**: Mautic caches `allowlist.json` for 60 minutes (3600 seconds) by default. If you want to set a custom cache timeout, set `marketplace_allowlist_cache_ttl_seconds` to any number you want in your `app/config/local.php`.


### Items in the JSON list

| key | meaning | type
| --- | --- | --- |
| package | Package name as found on Packagist | required |
| display_name | Human readable name that will be displayed in the Marketplace user interface | optional |
| minimum_mautic_version | Minimum Mautic version that this item will be visible in. Example: 4.1.0 means that the package will show up in Mautic 4.1.0 and higher. | optional |
| maximum_mautic_version | Maximum Mautic version that this item will be visible in. Example: 4.1.0 means that this package will show up in Mautic 4.1.0 and lower. | optional |

### Next Features
- [ ] Validate evil PHP methods
- [ ] Validate readable files (.env,json,ini,etc)
- [ ] Validate permissions for files and folders
- [ ] Validate sql injection
- [ ] Validate XSS
- [ ] If plugin is used without activation
