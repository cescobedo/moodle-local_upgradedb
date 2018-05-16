<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * UpgradeDB
 *
 * @package    local_upgradedb
 * @author     Carlos Escobedo <http://www.twitter.com/carlosagile>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  2017 Carlos Escobedo <http://www.twitter.com/carlosagile>)
 */

// Plugin Name.
$string['pluginname']   = 'UpgradeDB';
$string['errorfile']    = 'ERROR: File is not exist.';
$string['errorxml']     = 'ERROR: Structure XML not correct, please review XMLDB specifications.';
$string['tableok']      = 'Ok.';
$string['tableko']      = 'Not exist.';
$string['strfile']      = 'Path and file XML to install XMLDB tables (local/plugin/db/install.xml)';
$string['table']        = 'Name of the table';
$string['action']       = 'Action';
$string['dmladd']       = 'Table was added successfully: ';
$string['dmldrop']      = 'Table was dropped successfully: ';
$string['submit']       = 'Submit';
$string['analyze']      = 'Analyze and refrex indexex table only for MySQL DB';
$string['dmlanalyze']   = 'Table was analyzed and refresh indexex successfully: ';
$string['showkey']      = 'Show keys';
$string['showindex']    = 'Show indexes';
$string['xmlview']      = 'View XMLDB';
$string['xmlviewout']   = 'Show XMLDB Tables definition using Moodle xmldbtool: ';
$string['privacy:metadata'] = 'The UpgradeDB plugin does not store any personal data.';
