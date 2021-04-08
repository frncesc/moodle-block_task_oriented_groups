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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.
require_once ('../../../config.php');
require_once ($CFG->dirroot . '/group/lib.php');
require_once ($CFG->libdir . '/tablelib.php');

use block_tog\Personality;
use block_tog\Intelligences;

$courseid = optional_param('courseid', 0, PARAM_INT);
$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('auto_fill_in_title', 'block_tog'));
$PAGE->set_heading(get_string('auto_fill_in_heading', 'block_tog'));
$PAGE->set_url($CFG->wwwroot . '/blocks/tog/view/auto_fill_in.php');
$PAGE->add_body_class('block_task_oriented_group');

$course = $DB->get_record('course', array('id' => $courseid
), '*', MUST_EXIST);
require_login($course);
context_helper::preload_course($course->id);
$context = context_course::instance($course->id, MUST_EXIST);
$PAGE->set_context($context);

echo $OUTPUT->header();
$table = new html_table();
$table->head = array(
    new html_table_cell(get_string('auto_fill_in_column_name', 'block_tog')),
    new html_table_cell(get_string('auto_fill_in_column_personality', 'block_tog')),
    new html_table_cell(
            get_string('auto_fill_in_column_intelligences', 'block_tog'))
);
$table->head[0]->attributes['class'] = 'col-6';
$table->head[1]->attributes['class'] = 'col-3 text-center';
$table->head[2]->attributes['class'] = 'col-3 text-center';

$pageItems = array();
$pageIndex = 1;
foreach (groups_get_potential_members($course->id) as $enrolledUser) {
    $personality = Personality::getPersonalityOf($enrolledUser->id);
    $intelligences = Intelligences::getIntelligencesOf($enrolledUser->id);

    $personalityFilled = null;
    if ($personality == false) {

        $personalityFilled = html_writer::start_div('personality-cell',
                array('data-user-id' => $enrolledUser->id
                ));
        $personalityFilled .= html_writer::div(
                $OUTPUT->pix_icon('i/grade_correct',
                        get_string('auto_fill_in_column_personality_filled',
                                'block_tog')), 'personality-cell-success');
        $personalityFilled .= html_writer::div(
                html_writer::tag('button',
                        get_string('auto_fill_in_submit_personality', 'block_tog'),
                        array('class' => 'auto-fill-in-personality'
                        )), 'personality-cell-submit');
        $personalityFilled .= html_writer::end_div();
    } else {

        $personalityFilled = $OUTPUT->pix_icon('i/grade_correct',
                get_string('auto_fill_in_column_personality_filled', 'block_tog'));
    }
    $intelligencesFilled = null;
    if ($intelligences == false) {

        $intelligencesFilled = html_writer::start_div('intelligences-cell',
                array('data-user-id' => $enrolledUser->id
                ));
        $intelligencesFilled .= html_writer::div(
                $OUTPUT->pix_icon('i/grade_correct',
                        get_string('auto_fill_in_column_intelligences_filled',
                                'block_tog')), 'intelligences-cell-success');
        $intelligencesFilled .= html_writer::div(
                html_writer::tag('button',
                        get_string('auto_fill_in_submit_intelligences', 'block_tog'),
                        array('class' => 'auto-fill-in-intelligences'
                        )), 'intelligences-cell-submit');
        $intelligencesFilled .= html_writer::end_div();
    } else {

        $intelligencesFilled = $OUTPUT->pix_icon('i/grade_correct',
                get_string('auto_fill_in_column_intelligences_filled', 'block_tog'));
    }
    $rowPage = floor((count($table->data)) / 20) + 1;
    $row = new html_table_row(
            array(fullname($enrolledUser), $personalityFilled, $intelligencesFilled
            ));
    $row->cells[0]->attributes['class'] = 'col-6';
    $row->cells[1]->attributes['class'] = 'col-3 text-center';
    $row->cells[2]->attributes['class'] = 'col-3 text-center';
    $row->attributes['class'] = 'page-' . $rowPage . ' fill-in-row';
    $table->data[] = $row;
    if ($pageIndex != $rowPage) {
        $pageItems[] = html_writer::tag('li',
                html_writer::link('#', $pageIndex, array('class' => 'page-link'
                )), array('class' => 'page-item'
                ));
        $pageIndex = $rowPage;
    }
}

echo html_writer::start_div('container-fluid');
echo html_writer::div(html_writer::table($table), 'row');
echo html_writer::div(
        html_writer::tag('ul', implode($pageItems), array('class' => 'pagination flex-wrap'
        )), 'row justify-content-md-center');
echo html_writer::end_div();
$PAGE->requires->js_call_amd('block_tog/auto_fill_in', 'initialise');
echo $OUTPUT->footer();