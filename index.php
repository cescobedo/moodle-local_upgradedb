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
 * UpgradeDB - Allo developers add and drop tables over install.xml
 *
 * @package    local
 * @subpackage upgradedb
 * @author     Carlos Escobedo <http://www.twitter.com/carlosagile>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once('../../config.php');
require_once($CFG->libdir . '/ddllib.php');
require_once('upgradedb_form.php');
global $CFG, $DB;


$filexml   = optional_param('filexml', null, PARAM_RAW);
$action    = optional_param('action', '', PARAM_RAW);
$tabledb   = optional_param('tabledb', null, PARAM_RAW);
$showkey   = optional_param('showkey', null, PARAM_RAW);
$showindex = optional_param('showindex', null, PARAM_RAW);

require_login();
$context = context_system::instance();
require_capability('moodle/site:config', $context);

$url = new moodle_url('/local/upgradedb/index.php', array('fielxml' => $filexml, 'action' => $action));
$urlhome = new moodle_url('/local/upgradedb/index.php', array('fielxml' => $filexml));

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('incourse');

$mform = new upgradedb_form(null, array('filexml' => $filexml, 'action' => $action));
$editlinkbutton = html_writer::empty_tag('img', array(
    'src' => $OUTPUT->pix_url('t/add'),
    'alt' => get_string('add'), 'class' => 'iconsmall'));
$dellinkbutton = html_writer::empty_tag('img', array(
    'src' => $OUTPUT->pix_url('t/delete'),
    'alt' => get_string('delete'), 'class' => 'iconsmall'));
$analyzebutton = html_writer::empty_tag('img', array(
    'src' => $OUTPUT->pix_url('i/course'),
    'alt' => get_string('analyze', 'local_upgradedb'), 'class' => 'iconsmall'));
$xmlbutton = html_writer::empty_tag('img', array(
    'src' => $OUTPUT->pix_url('i/restore'),
    'alt' => get_string('xmlview', 'local_upgradedb'), 'class' => 'iconsmall'));

$ismysql = 0;
$compatdb = array("mysqli","mariadb");
if (in_array($CFG->dbtype,$compatdb)) {
    $ismysql = 1;
}

$messagedml = '';
if (isset($tabledb)) {
    if ($action == 'add') {
        $dbman = $DB->get_manager();
        $table = new xmldb_table($tabledb);
        if (!$dbman->table_exists($table)) {
            $dbman->install_one_table_from_xmldb_file($CFG->dirroot .'/'. $filexml, $tabledb);
            $messagedml = get_string('dmladd', 'local_upgradedb').$tabledb;
        }
        flush();
    } else if ($action == 'del') {
        $dbman = $DB->get_manager();
        $table = new xmldb_table($tabledb);
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
            $messagedml = get_string('dmldrop', 'local_upgradedb').$tabledb;
        }
        flush();
    } else if ($action == 'analyze') {
        $dbman = $DB->get_manager();
        $engine = strtolower($DB->get_dbengine());
        $table = new xmldb_table($tabledb);
        if ($dbman->table_exists($table) && $ismysql) {
            $dml = "ALTER TABLE ".$CFG->prefix.$tabledb." ENGINE='$engine'";
            $DB->change_database_structure($dml);
            $dml = "ANALYZE TABLE $tabledb";
            $DB->execute($dml);
            
            $messagedml = get_string('dmlanalyze', 'local_upgradedb').$tabledb;
        }
        flush();
    }
}

if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot);
} else if ($data = $mform->get_data()) {
    if ($data->filexml) {
        $filexml = $data->filexml;
    }
}

$strheading = get_string('pluginname', 'local_upgradedb');
$PAGE->navbar->add($strheading);;
$PAGE->set_title($strheading);
$PAGE->set_heading($strheading);
echo $OUTPUT->header();
echo $OUTPUT->heading($strheading);

if (!empty($filexml)) {
    $dbman = $DB->get_manager();
    $file = $CFG->dirroot .'/'. $filexml;
    $xmldbfile = new xmldb_file($file);

    if ($xmldbfile->fileExists()) {
        if ($loaded = $xmldbfile->loadXMLStructure()) {
            $xmldbstructure = $xmldbfile->getStructure();
            $tables   = $xmldbstructure->getTables();
            $datatable = array();
            foreach ($tables as $table) {
                $tablename = $table->getName();
                if ($dbman->table_exists($table)) {
                    $buttona = '';
                    if ($ismysql) {
                        $analyze = new moodle_url('/local/upgradedb/index.php', array('tabledb' => $tablename,
                                    'action' => 'analyze', 'filexml' => $filexml));
                        $buttona = html_writer::link($analyze, $analyzebutton, array('title' => get_string('analyze', 'local_upgradedb')));     
                    }
                    
                    if (!$DB->record_exists($tablename, array())) {
                        $dellink = new moodle_url('/local/upgradedb/index.php', array('tabledb' => $tablename,
                                'action' => 'del', 'filexml' => $filexml));
                        $button = html_writer::link($dellink, $dellinkbutton, array('title' => get_string('delete')));
                        $datatable[] = array($tablename, $button, $buttona);
                 
                    } else {
                        $datatable[] = array($tablename, get_string('tableok', 'local_upgradedb'), $buttona);
                    }
                } else {
                    $editlink = new moodle_url('/local/upgradedb/index.php', array('tabledb' => $tablename,
                                'action' => 'add', 'filexml' => $filexml));
                    $button = html_writer::link($editlink, $editlinkbutton, array('title' => get_string('add')));
                    $datatable[] = array($tablename, $button, '&nbsp;');
                }

                if ($showkey) {
                    $keys = $table->getKeys();
                    foreach ($keys as $key) {
                        $datatable[] = array('&nbsp;&nbsp;&nbsp;Key: '.$key->getName(), '', '');
                    }
                }
                if ($showindex) {
                    $indexes = $table->getIndexes();
                    foreach ($indexes as $index) {
                        $datatable[] = array('&nbsp;&nbsp;&nbsp;Index: '.$index->getName(), '', '');
                    }
                }
                

            }
        } else {
            echo $OUTPUT->notification(get_string('errorxml', 'local_upgradedb'), 'notifyproblem');
        }
    } else {
        echo $OUTPUT->notification(get_string('errorfile', 'local_upgradedb'), 'notifyproblem');
    }
}

if ($messagedml) {
    echo $OUTPUT->notification($messagedml, 'notifysuccess');
}

echo $mform->display();

$table = new html_table();
$table->head  = array(get_string('table', 'local_upgradedb'),  get_string('action', 'local_upgradedb'));
$table->size  = array('90%', '10%');
$table->align = array('left', 'center');
$table->width = '50%';
if (isset($datatable)) {
    $table->data  = $datatable;
    echo html_writer::table($table);
}

if (!empty($filexml) && ($xmldbfile->fileExists()) ) {
    $xmldbview = new moodle_url('/admin/tool/xmldb/index.php', array('action' => 'view_xml', 'file' =>'/'.$filexml));
    $xmlview = html_writer::link($xmldbview, $xmlbutton, array('title' => get_string('xmlview', 'local_upgradedb'), 'target'=>'blank'));
    $outputhtml = html_writer::start_tag('div', array('class' => 'form-buttons'));
    $outputhtml .= get_string('xmlviewout', 'local_upgradedb').$xmlview;
    $outputhtml .= html_writer::end_tag('div');  
    echo $outputhtml;
}

echo $OUTPUT->footer();
