# php7-iptc-manager

[![Maintainability](https://api.codeclimate.com/v1/badges/8a0f32e9d6ff3948e4d6/maintainability)](https://codeclimate.com/github/ibudasov/php7-iptc-manager/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/8a0f32e9d6ff3948e4d6/test_coverage)](https://codeclimate.com/github/ibudasov/php7-iptc-manager/test_coverage)
[![CircleCI](https://circleci.com/gh/ibudasov/php7-iptc-manager.svg?style=svg)](https://circleci.com/gh/ibudasov/php7-iptc-manager)

# why and what is it?
Recently I've been trying to create/read/update IPTC tags from PHP7 environment 
and found out that all the available libraries suck a lot.

So, here is my solution, which gonna suck a little bit less! 

# installation
```
composer require ibudasov/php7-iptc-manager
```

# usage
```
use IgorBudasov\IptcManager\IptcManager;

$manager = new IptcManager();

$manager->setPathToFile($pathToFile);

```

# ⚠️ Under construction, get back later!
