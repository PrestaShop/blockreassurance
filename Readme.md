# Customer reassurance block

## About

Adds an information block aimed at offering helpful information to reassure customers that your store is trustworthy.

![Screenshot](widget-screenshot.png?raw=true "Screenshot")

## Contributing

PrestaShop modules are open-source extensions to the PrestaShop e-commerce solution. Everyone is welcome and even encouraged to contribute with their own improvements.

### Requirements

Contributors **must** follow the following rules:

* **Make your Pull Request on the "dev" branch**, NOT the "master" branch.
* Do not update the module's version number.
* Follow [the coding standards][1].

### Process in details

Contributors wishing to edit a module's files should follow the following process:

1. Create your GitHub account, if you do not have one already.
2. Fork the blockreassurance project to your GitHub account.
3. Clone your fork to your local machine in the ```/modules``` directory of your PrestaShop installation.
4. Create a branch in your local clone of the module for your changes.
5. Change the files in your branch. Be sure to follow [the coding standards][1]!
6. Push your changed branch to your fork in your GitHub account.
7. Create a pull request for your changes **on the _'dev'_ branch** of the module's project. Be sure to follow [the commit message norm][2] in your pull request. If you need help to make a pull request, read the [Github help page about creating pull requests][3].
8. Wait for one of the core developers either to include your change in the codebase, or to comment on possible improvements you should make to your code.

That's it: you have contributed to this open-source project! Congratulations!

### Overview of the module

#### Code structure

At the root folder are 2 very important classes: `BlockReassurance` which extends PrestaShop class
`Module` and is the entry point for all calls to this module ; and `ReassuranceBlockEntity` which
is the ObjectModel for database data for this module.

Then:
- `img` contains images used by the module and is also used to store user-uploaded images if the user uses its own images for the widget
- `lang` contains php classes used to handle multi-languages
- `src` folder contains php classes used for install, uninstall and manage the admin part of this module. This is PSR-4 code that is autoloaded using composer.
- `views` contains the widget Smarty template

#### Install / uninstall

When you install this module, this will
- create 2 SQL tables
- register this module for 2 hooks
- update PrestaShop configuration

The uninstall process will remove these.

This is performed by function ```install()``` and ```uninstall()``` in `BlockReassurance` main class.
The logic behind is then dispatched to several classes that will take care of each install step, managed
by the class ```BlockReassurance\Install\ModuleInstaller```.

#### Front behavior

Using the PrestaShop widget systems, this will display the following widget in your shop:

![Screenshot](widget-screenshot.png?raw=true "Screenshot")

You can choose where you want to display it by registering hooks for this module.

The widget is rendered using Smarty templating engine, by calling ```renderWidget()``` in in `BlockReassurance` main class.

#### Admin configuration

The widget is highly configurable, you can modify the number of blocks, their title, their icon ; and
modify the hooks for this module to change the widget location.

This is done from PrestaShop modules configuration page at `/admin/improve/modules/manage`.

The administration form, its display and the processing of its content, is all done by the ```getContent()``` function in `BlockReassurance` main class.
It handles both GET and POST form requests.

The Form is mainly built and configured using PrestaShop `HelperList` and
`HelperForm` classes, controlled by class `BlockReassurance\Admin\FormBuilder`.

The input is processed by the form handler class `BlockReassurance\Admin\Formhandler`.

[1]: http://doc.prestashop.com/display/PS16/Coding+Standards
[2]: http://doc.prestashop.com/display/PS16/How+to+write+a+commit+message
[3]: https://help.github.com/articles/using-pull-requests
