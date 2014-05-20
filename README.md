Local Plugin - Upgrade DataBase
======================

Information
-----------

This plugin allow install new tables into DB using xmldb files under developer control.
You can choose which install.xml table want to install in place to install all tables and 
upgrade tables whenever you want.
You cannot drop tables was with data.
It was created thinking in developers to plugins.

Version  
-------
Moodle 2.7+, 2.6+ and 2.5+

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

FUTURE SCOPE:
- FILEBOX to drag a file.
- Empty tables.
- Check tables in DB to allow alter columns.

Author
------
Carlos Escobedo
- <http://www.twitter.com/carlosagile>
- <https://coderwall.com/carlosagile>


