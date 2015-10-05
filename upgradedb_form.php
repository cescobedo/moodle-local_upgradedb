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
 * @package    local
 * @subpackage upgradedb
 * @author     Carlos Escobedo <http://www.twitter.com/carlosagile>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class upgradedb_form extends moodleform {
    public function definition() {
        global $CFG, $USER;

        $mform =& $this->_form;

        $mform->addElement('header', 'settingsheader', get_string('pluginname', 'local_upgradedb'));
        $mform->addElement('text', 'filexml', get_string('strfile', 'local_upgradedb'));
        $mform->setDefault('filexml', '');
        $mform->setType('filexml', PARAM_RAW);

        $mform->addElement('checkbox', 'showkey', '', get_string('showkey', 'local_upgradedb'));
        $mform->addElement('checkbox', 'showindex', '', get_string('showindex', 'local_upgradedb'));

        // Action Butttons.
        $this->add_action_buttons(true,  get_string('submit', 'local_upgradedb'));
    }
}

