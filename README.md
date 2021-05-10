# Smart read out Extension

[![Build Status](https://travis-ci.org/dmzx/Copyright-Extended.svg?branch=master)](https://travis-ci.org/dmzx/Smart-read-out)

## Information
Based on Willem's [DSMR-logger](https://willem.aandewiel.nl) this extension will display the [API](https://willem.aandewiel.nl/index.php/2020/02/28/restapis-zijn-hip-nieuwe-firmware-voor-de-dsmr-logger) recieved from the DSMR-Logger.<br>
Information is displayed on index of your forum and can be stored in database for other extensions, one already under construction 🚧 
ACP options to set the IP local or remote if you port forward that in your router, and other options to set like phase, total watss, solar power total, refresh interval.<br>
Permission can be set to allow who can view the Smart read out on index.

Detailed information can be found on [dmzx-web.net](https://www.dmzx-web.net) of course 👍


## Install
1. Download the latest release.
2. In the `ext` directory of your phpBB board, create a new directory named `dmzx` (if it does not already exist).
3. Copy the `smartreadout` folder to `phpBB/ext/dmzx/` (if done correctly, you'll have the main extension class at (your forum root)/ext/dmzx/smartreadout/composer.json).
4. Navigate in the ACP to `Customise -> Manage extensions`.
5. Look for `Smart read out` under the Disabled Extensions list, and click its `Enable` link.

## Uninstall
1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `Smart read out` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/dmzx/smartreadout` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
