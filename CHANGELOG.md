# Changelog

## 1.2 (2014-Jan-12)

### Main

* Brand new responsive design built with Bootstrap 3
* Upgrade to Symfony 2.3.*
* Remove deprecated things
* *AppBundle* renamed to *MainBundle*
* Move the contact section from *MainBundle* (old *AppBundle*) to *ContactBundle*
* Remove the *"more information"* page
* Use Capifony to deploy

### Projects

* Fix *"Project-screenshot relationship brokes after editing a project"*
* Fix *"Project slug translation not working correctly"*
* Technologies can be selected through typeahead

### Vendors

* Upgrade to TinyMCE 4.*
* Upgrade to jQuery 1.10.*
* TinySlider 2 replaced with jQuery Glide

### Others

* Code cleaning
* Optimize images
* Binding updates (Vala joke)

## 1.1 (2012-Nov-25)

### Forms

* Add *form_errors()* for each field
* Replace *getDefaultOptions()* with *setDefaultOptions()*
* Change some button labels

### I18n

* Internationalization and localization work in the backend
* Reorganize the content of the translation files

### Projects

* Add an optional *source link* field that will render a button like the *view project* one

### Others

* Bundles were renamed according to [these "best practices"](http://symfony.com/doc/current/cookbook/bundles/best_practices.html)
* Index logic was moved from *PortfolioBundle* to *AppBundle*
* Added validation constraints to all the entities
* Added *title* blocks to all the views
* Code documentation
* Minor CSS changes

## 1.0 (2012-Nov-19)

Initial release
