Local Plugin - Upgrade DataBase
======================

Information
-----------

This plugin allow install new tables into DB using xmldb files under developer control.
You can choose which install.xml table want to install in place to install all tables and
upgrade tables whenever you want.
You cannot drop tables was with data.
It was created thinking in developers to plugins.

Features
------------------
- Analyze and Refresh Indexes in MySQL and MariaDB Tables.
- Show Keys and Indexes.
- Show XMLFile using xmldbtools.

Version
-------
Moodle 3.11+, 3.10+, 3.9+, 3.8, 3.7+, 3.6+, 3.5+, 3.4+, 3.3+, 3.2+, 3.1+, 3.0+, 2.9, 2.8, 2.6, 2.7+, 2.6+ and 2.5+

TO INSTALL:

Git way
- To install it using git, type this command in the root of your Moodle install:
```
git clone git@github.com:cescobedo/moodle-local_upgradedb.git local/upgradedb
```

Download way
- Download the zip from <https://github.com/cescobedo/moodle-local_upgradedb/archive/master.zip>
- Unzip it into  local/ folder in your Moodle,
- Rename the new folder "moodle-local_upgradedb-master" to "upgradedb"
- Enjoy!!!

NEW FEATURE
- Privacy Subsystem implementation for auth_dev. <https://docs.moodle.org/dev/Privacy_API>

Author
------
Carlos Escobedo
- <http://www.twitter.com/carlosagile>
- <https://coderwall.com/carlosagile>
