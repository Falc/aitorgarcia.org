Aitor García's website
======================

This is the source code for [aitorgarcia.org](http://aitorgarcia.org), built on Symfony2.

* Author: Aitor García Martínez (Falc)
* License: Simplified BSD License

Why do I release this?
----------------------

One of the goals behind this project was to learn things about Symfony2. And I definitely learnt a lot from other projects source code, so I think that my source code could be useful for others in my situation.

About the bundles
-----------------

### AppBundle

Contains everything that does not fit inside other bundles. This bundle is not intended to be reusable.

It includes:

* "More information" section.
* Admin index
* Main and admin navigation views (menu links).

### PortfolioBundle

A simple portfolio that displays projects information and their related project screenshots.

The frontend includes:

* Project list
* Project view
* Contact

The backend includes:

* Project management (create, edit, delete).
* Project screenshots management (create, edit, delete). They are managed through the project forms because of the direct dependency.
* Technology management (create, edit, delete).
* Translations: It allows to translate the name and description of a project, and the screenshots names.

### UserBundle

UserBundle extends from [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle).

It is used to override/customize some things.