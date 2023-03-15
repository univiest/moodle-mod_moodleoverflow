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
 * Prints a particular instance of moodleoverflow
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package   mod_moodleoverflow
 * @copyright 2023 Tamaro Walter
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Include config and locallib.
require_once(__DIR__.'/../../config.php');
global $CFG, $PAGE, $DB, $OUTPUT, $SESSION;
require_once($CFG->dirroot.'/mod/moodleoverflow/locallib.php');

use mod_moodleoverflow\tables\userstats_table;
// Declare optional parameters.
$cmid = optional_param('id', 0, PARAM_INT);             // Course Module ID.
$courseid = optional_param('courseid', 0, PARAM_INT);   // Course ID.

// Define important variables.
if ($courseid) {
    $course = $DB->get_record('course', array('id' => $courseid), '*');
}
if ($cmid) {
    $cm = get_coursemodule_from_id('moodleoverflow', $cmid, 0, false, MUST_EXIST);
}
// Require a login.
require_login();

// Set the context.
$context = context_course::instance($course->id);
$PAGE->set_context($context);

// Print the page header.
$PAGE->set_url('/mod/moodleoverflow/userstats.php');
$PAGE->set_title('User statistics');
$PAGE->set_heading('User statistics of course: ' . $course->fullname);


// Output starts here.
echo $OUTPUT->header();
$table = new userstats_table('statisticstable' , $course->id, $context);
echo $table->out();
echo $OUTPUT->footer();

