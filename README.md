# php7-iptc-manager

[![Maintainability](https://api.codeclimate.com/v1/badges/8a0f32e9d6ff3948e4d6/maintainability)](https://codeclimate.com/github/ibudasov/php7-iptc-manager/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/8a0f32e9d6ff3948e4d6/test_coverage)](https://codeclimate.com/github/ibudasov/php7-iptc-manager/test_coverage)
[![CircleCI](https://circleci.com/gh/ibudasov/php7-iptc-manager.svg?style=svg)](https://circleci.com/gh/ibudasov/php7-iptc-manager)

### Why and what is it
[IPTC tags](https://iptc.org) are tags, which you can include in a picture you have taken (remember Instagram?)

This library provides simple interface to do that, because standard PHP way sucks a lot.

So, let's get started! 

### Installation

Installation is quite typical - with composer: 
```
composer require ibudasov/php7-iptc-manager
```

### How to use

Before usage you have to create the IPTC tags manager:
```
// import the Manager class
use iBudasov\Iptc\Manager;

// ... and instantiate it!
$manager = Manager::create();
```

Once you have an instance of the Manager - you'll need to specify the file to work with.
`['jpg', 'jpeg', 'pjpeg']` file types are supported, and if you try to feed something else - exception will be thrown

```
$manager->setPathToFile('/tmp/proper-file.jpg');
```



### Create an IPTC tag
Then you can add some IPTC tags. 

There are different kinds of IPTC tags, but for all of them you'll find a constant in `Tag` class.

You can specify multiple values for each tag, it is allowed by specification, so we have array of values:

```
$manager->addTag(new Tag(Tag::AUTHOR, ['IGOR BUDASOV']));
```

If a tag with the same name already exists - an exception will be thrown, so you can use `Manager::deleteTag()` to explicitly remove previous value.

It was made to avoid accidental removing of data. Yes, we were thinking about safety of your data!

### Read an IPTC tag

Once you `setPathToFile()` all the included IPTC tags will be loaded to the Manager, so you can retrieve any tag by it's codename.

If this tag doesn't exist - you'll experience an exception.
```
$manager->getTag(Tag::AUTHOR)
```

...or you can get them all at once!
```
$manager->getTags();
```

### Delete an IPTC tag

Sometimes you want to delete a tag - here is the way.

If you're trying to delete a tag which does not exist - exception will be thrown.
```
$manager->deleteTag(Tag::AUTHOR);
```


### P.S.

All the code is nicely covered by tests, but if you find a bug - feel free to contact me!

