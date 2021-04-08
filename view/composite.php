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
$roleid = optional_param('roleid', -1, PARAM_INT);
$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('composite_title', 'block_tog'));
$PAGE->set_heading(get_string('composite_heading', 'block_tog'));
$PAGE->set_url($CFG->wwwroot . '/blocks/tog/view/composite.php');
$PAGE->add_body_class('block_task_oriented_group');

$course = $DB->get_record('course', array('id' => $courseid
), '*', MUST_EXIST);
require_login($course);
context_helper::preload_course($course->id);
$context = context_course::instance($course->id, MUST_EXIST);
$PAGE->set_context($context);

echo $OUTPUT->header();
if (has_capability('moodle/course:managegroups', $context)) {

    $profileroles = get_profile_roles($context);
    if ($roleid == -1) {
        // use the role member or the last one as default for the potencial users.
        foreach ($profileroles as $profilerole) {
            $roleid = $profilerole->id;
            if (strcasecmp('member', $profilerole->shortname) == 0) {
                break;
            }
        }
    }
    $roles = role_fix_names($profileroles, $context, ROLENAME_ALIAS, true);
    $form = html_writer::start_tag('form');
    $form .= html_writer::start_tag('input',
            array('id' => 'composite__courseid', 'type' => 'hidden', 'value' => $courseid
            ));
    // --- select role input ----
    $form .= html_writer::start_div('form-group');
    $form .= html_writer::tag('label',
            get_string('composite_select_role_for_users', 'block_tog') .
            '&nbsp;&nbsp' .
            $OUTPUT->help_icon('composite_select_role_for_users', 'block_tog', ''),
            array('for' => 'selectedRoleForUsers'
            ));
    $form .= html_writer::start_tag('select',
            array('class' => 'form-control', 'id' => 'composite__selected_role_for_users'
            ));
    foreach ($roles as $fixedroleid => $fixedrolename) {

        $attributes = array('value' => $fixedroleid
        );
        if ($fixedroleid == $roleid) {

            $attributes['selected'] = 'true';
        }
        $form .= html_writer::tag('option', $fixedrolename, $attributes);
    }
    $form .= html_writer::end_tag('select');
    $form .= html_writer::end_div();
    // --- selected users table ----
    $table = new html_table();
    $table->head = array(
        new html_table_cell(get_string('composite_column_name', 'block_tog')),
        new html_table_cell(
                get_string('composite_column_personality', 'block_tog')),
        new html_table_cell(
                get_string('composite_column_intelligences', 'block_tog')),
        new html_table_cell(get_string('composite_column_send', 'block_tog'))
    );
    $table->head[0]->attributes['class'] = 'col-6';
    $table->head[1]->attributes['class'] = 'col-2 text-center';
    $table->head[2]->attributes['class'] = 'col-2 text-center';
    $table->head[3]->attributes['class'] = 'col-2 text-center';

    $pageItems = array();
    $pageIndex = 1;
    $members = array();
    foreach (groups_get_potential_members($course->id, $roleid) as $enrolledUser) {
        $personality = Personality::getPersonalityOf($enrolledUser->id);
        $intelligences = Intelligences::getIntelligencesOf($enrolledUser->id);
        if ($personality && $intelligences) {
            $member = new \stdClass();
            $member->id = $enrolledUser->id;
            $member->gender = 'FEMALE';
            if ($personality->gender > 0) {

                $member->gender = 'MALE';
            }
            $member->personality = new \stdClass();
            $member->personality->judgment = $personality->judgment;
            $member->personality->attitude = $personality->attitude;
            $member->personality->perception = $personality->perception;
            $member->personality->extrovert = $personality->extrovert;
            $member->intelligences = new \stdClass();
            $member->intelligences->verbal = $intelligences->verbal;
            $member->intelligences->logic_mathematics = $intelligences->logic_mathematics;
            $member->intelligences->visual_spatial = $intelligences->visual_spatial;
            $member->intelligences->kinestesica_corporal = $intelligences->kinestesica_corporal;
            $member->intelligences->musical_rhythmic = $intelligences->musical_rhythmic;
            $member->intelligences->intrapersonal = $intelligences->intrapersonal;
            $member->intelligences->interpersonal = $intelligences->interpersonal;
            $member->intelligences->naturalist_environmental = $intelligences->naturalist_environmental;
            $members[] = $member;
        } else {
            $personalityFilled = null;
            if ($personality) {
                $personalityFilled = $OUTPUT->pix_icon('i/grade_correct',
                        get_string('composite_column_personality_filled',
                                'block_tog'));
            } else {
                $personalityFilled = $OUTPUT->pix_icon('i/grade_incorrect',
                        get_string('composite_column_personality_not_filled',
                                'block_tog'));
            }
            $intelligencesFilled = null;
            if ($intelligences) {
                $intelligencesFilled = $OUTPUT->pix_icon('i/grade_correct',
                        get_string('composite_column_intelligences_filled',
                                'block_tog'));
            } else {
                $intelligencesFilled = $OUTPUT->pix_icon('i/grade_incorrect',
                        get_string('composite_column_intelligences_not_filled',
                                'block_tog'));
            }
            $rowPage = floor((count($table->data)) / 5) + 1;
            $send = html_writer::empty_tag('input',
                    array('class' => 'form-check-input send-select', 'type' => 'checkbox',
                        'data-userid' => $enrolledUser->id
                    )) .
                    html_writer::span(
                            $OUTPUT->pix_icon('t/message',
                                    get_string('composite_column_send_alt',
                                            'block_tog')), 'send-icon',
                            array('data-userid' => $enrolledUser->id
                            ));
            $row = new html_table_row(
                    array(fullname($enrolledUser), $personalityFilled, $intelligencesFilled, $send
                    ));
            $row->cells[0]->attributes['class'] = 'col-6';
            $row->cells[1]->attributes['class'] = 'col-2 text-center';
            $row->cells[2]->attributes['class'] = 'col-2 text-center';
            $row->cells[3]->attributes['class'] = 'col-2 text-center';
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
    }
    $unfilled = count($table->data);
    if ($unfilled > 0) {

        $form .= html_writer::start_div('alert alert-warning container-fluid',
                array('role' => 'alert'
                ));
        $form .= html_writer::div(
                get_string('composite_unfilled_msg', 'block_tog', $unfilled), 'row');
        $form .= html_writer::div(html_writer::table($table), 'row');
        $form .= html_writer::div(
                html_writer::tag('ul', implode($pageItems),
                        array('class' => 'pagination flex-wrap'
                        )), 'row justify-content-md-center actions-row');
        $form .= html_writer::div(
                html_writer::tag('button',
                        get_string('composite_send_selected', 'block_tog'),
                        array('type' => 'button', 'class' => 'btn btn-primary',
                            'id' => 'composite__send_selected'
                        )) . '&nbsp;&nbsp;' .
                html_writer::tag('button',
                        get_string('composite_send_all', 'block_tog'),
                        array('type' => 'button', 'class' => 'btn btn-primary',
                            'id' => 'composite__send_all'
                        )), 'text-center');
        $form .= html_writer::end_div();
    }
    $membersSize = count($members);
    if ($membersSize < 4) {

        $form .= html_writer::div(
                get_string('composite_error_not_enough_users', 'block_tog'),
                'alert alert-danger', array('role' => 'alert'
                ));
    } else {

        $form .= html_writer::div(
                html_writer::tag('textarea', json_encode($members),
                        array('id' => 'composite__members'
                        )) .
                html_writer::empty_tag('input',
                        array('id' => 'composite__members_size', 'value' => $membersSize
                        )) .
                html_writer::empty_tag('input',
                        array('id' => 'composite__at_most', 'value' => 'false'
                        )) .
                html_writer::tag('textarea', '{}', array('id' => 'composite__requirements'
                )), '', array('hidden' => 'hidden'
                ));
        // -- select the task requirements --
        $form .= html_writer::start_tag('fieldset', array('class' => 'border p-2'
        ));
        $form .= html_writer::tag('legend',
                get_string('composite_requirements', 'block_tog') . '&nbsp;&nbsp' .
                $OUTPUT->help_icon('composite_requirements', 'block_tog', ''),
                array('class' => 'w-auto'
                ));
        $form .= html_writer::start_div('form-row');
        $form .= html_writer::start_div('form-group col-md-4 composite-requirements-select-max');
        $form .= html_writer::tag('label',
                get_string('composite_requirements_factor', 'block_tog') .
                '&nbsp;&nbsp' .
                $OUTPUT->help_icon('composite_requirements_factor', 'block_tog', ''),
                array('for' => 'composite__requirements_factor'
                ));
        $form .= html_writer::start_tag('select',
                array('class' => 'form-control', 'id' => 'composite__requirements_factor'
                ));
        for ($i = 0; $i < 8; $i++) {

            $form .= html_writer::tag('option',
                    get_string('composite_requirements_factor_' . $i, 'block_tog'),
                    array('value' => $i, 'id' => 'composite__requirements_factor_' . $i
                    ));
        }
        $form .= html_writer::end_tag('select');
        $form .= html_writer::end_div();
        $form .= html_writer::start_div('form-group col-md-4 composite-requirements-select-max');
        $form .= html_writer::tag('label',
                get_string('composite_requirements_level', 'block_tog') .
                '&nbsp;&nbsp' .
                $OUTPUT->help_icon('composite_requirements_level', 'block_tog', ''),
                array('for' => 'composite__requirements_level'
                ));
        $form .= html_writer::start_tag('select',
                array('class' => 'form-control', 'id' => 'composite__requirements_level'
                ));
        for ($i = 0; $i < 5; $i++) {

            $form .= html_writer::tag('option',
                    get_string('composite_requirements_level_' . $i, 'block_tog'),
                    array('value' => $i, 'id' => 'composite__requirements_level_' . $i
                    ));
        }
        $form .= html_writer::end_tag('select');
        $form .= html_writer::end_div();
        $form .= html_writer::start_div('form-group col-md-3 composite-requirements-select-max');
        $form .= html_writer::tag('label',
                get_string('composite_requirements_importance', 'block_tog') .
                '&nbsp;&nbsp' .
                $OUTPUT->help_icon('composite_requirements_importance', 'block_tog',
                        ''), array('for' => 'composite__requirements_importance'
                ));
        $form .= html_writer::start_tag('select',
                array('class' => 'form-control', 'id' => 'composite__requirements_importance'
                ));
        for ($i = 0; $i < 5; $i++) {

            $form .= html_writer::tag('option',
                    get_string('composite_requirements_importance_' . $i,
                            'block_tog'),
                    array('value' => $i, 'id' => 'composite__requirements_importance_' . $i
                    ));
        }
        $form .= html_writer::end_tag('select');
        $form .= html_writer::end_div();
        $form .= html_writer::div(
                html_writer::tag('button',
                        get_string('composite_requirements_add', 'block_tog'),
                        array('class' => 'btn btn-primary', 'type' => 'button',
                            'id' => 'composite__requirements_add'
                        )), 'form-group col-md align-self-center');
        $form .= html_writer::end_div();
        $form .= html_writer::div(
                get_string('composite_requirements_none', 'block_tog'),
                'alert alert-info',
                array('id' => 'composite__requirements_none', 'role' => 'alert'
                ));
        $form .= html_writer::div('<ul class="list-group"></ul>', '',
                array('id' => 'composite__requirements_list'
                ));
        $form .= html_writer::end_tag('fieldset');
        // -- enter the grouping name --
        $form .= html_writer::start_div('form-group');
        $form .= html_writer::tag('label',
                get_string('composite_grouping_name', 'block_tog') . '&nbsp;&nbsp' .
                $OUTPUT->help_icon('composite_grouping_name', 'block_tog', ''),
                array('for' => 'composite__grouping_name'
                ));
        $form .= html_writer::empty_tag('input',
                array('id' => 'composite__grouping_name', 'type' => 'text',
                    'class' => 'form-control',
                    'placeholder' => get_string('composite_grouping_name_placeholder',
                            'block_tog')
                ));
        $form .= html_writer::end_div();
        // -- enter the grous pattern name --
        $form .= html_writer::start_div('form-group');
        $form .= html_writer::tag('label',
                get_string('composite_groups_pattern', 'block_tog') . '&nbsp;&nbsp' .
                $OUTPUT->help_icon('composite_groups_pattern', 'block_tog', ''),
                array('for' => 'composite__groups_pattern'
                ));
        $form .= html_writer::empty_tag('input',
                array('id' => 'composite__groups_pattern', 'type' => 'text',
                    'class' => 'form-control',
                    'value' => get_string('composite_groups_pattern_default',
                            'block_tog')
                ));
        $form .= html_writer::end_div();
        // -- enter members per group
        $form .= html_writer::start_div('form-group');
        $form .= html_writer::tag('label',
                get_string('composite_members_per_group', 'block_tog') .
                '&nbsp;&nbsp' .
                $OUTPUT->help_icon('composite_members_per_group', 'block_tog', ''),
                array('for' => 'composite__members_per_group'
                ));
        $form .= html_writer::empty_tag('input',
                array('id' => 'composite__members_per_group', 'type' => 'number',
                    'class' => 'form-control', 'value' => '2', 'min' => '2',
                    'max' => ceil($membersSize / 2)
                ));
        $form .= html_writer::tag('small', '',
                array('class' => 'form-text text-muted', 'id' => 'composite__members_per_group_help'
                ));
        $form .= html_writer::end_div();
        $form .= html_writer::start_div(null, array('id' => 'composite__at_most_selection'
        ));

        $form .= html_writer::start_div('form-check');
        $form .= html_writer::empty_tag('input',
                array('id' => 'composite__members_per_group_at_most_true', 'type' => 'radio',
                    'class' => 'form-check-input', 'value' => 'true',
                    'name' => 'composite_members_per_group_at_most'
                ));
        $form .= html_writer::tag('label', '',
                array('class' => 'form-check-label',
                    'for' => 'composite__members_per_group_at_most_true'
                ));
        $form .= html_writer::end_div();
        $form .= html_writer::start_div('form-check');
        $form .= html_writer::empty_tag('input',
                array('id' => 'composite__members_per_group_at_most_false', 'type' => 'radio',
                    'class' => 'form-check-input', 'value' => 'false',
                    'name' => 'composite_members_per_group_at_most'
                ));
        $form .= html_writer::tag('label', '',
                array('class' => 'form-check-label',
                    'for' => 'composite__members_per_group_at_most_false'
                ));
        $form .= html_writer::end_div();
        $form .= html_writer::end_div();
        // -- overperformance ---
        $form .= html_writer::start_div('form-group');
        $form .= html_writer::tag('label',
                get_string('composite_performance', 'block_tog') . '&nbsp;&nbsp' .
                $OUTPUT->help_icon('composite_performance', 'block_tog', ''),
                array('for' => 'composite__performance'
                ));
        $form .= html_writer::start_div('row');
        $form .= html_writer::div(
                get_string('composite_performance_over', 'block_tog'), 'col-md-3');
        $form .= html_writer::div(
                html_writer::empty_tag('input',
                        array('id' => 'composite__performance', 'type' => 'range',
                            'class' => 'form-control-range', 'value' => 'false',
                            'name' => 'composite_members_per_group_at_most', 'min' => '0',
                            'max' => '1', 'step' => '0.01'
                        )), 'col');
        $form .= html_writer::div(
                get_string('composite_performance_under', 'block_tog'), 'col-md-3');
        $form .= html_writer::end_div();
        $form .= html_writer::end_div();
        $form .= html_writer::start_div('row justify-content-md-center actions-row');
        $form .= html_writer::tag('button',
                get_string('composite_submit', 'block_tog'),
                array('type' => 'button', 'class' => 'btn btn-primary', 'id' => 'composite__submit'
                ));
        $form .= html_writer::end_div();
        $form .= html_writer::div(
                html_writer::div(
                        html_writer::span(
                                get_string('composite_progress', 'block_tog') .
                                html_writer::span('', 'dotdotdot')),
                        'progress-bar progress-bar-striped progress-bar-animated',
                        array('role' => 'progressbar', 'aria-valuenow' => '75',
                            'aria-valuemin' => '0', 'aria-valuemax' => '100'
                        )), 'progress composite-progress', array('id' => 'composite__progress'
                ));
    }
    $form .= html_writer::end_tag('form');
    echo $form;
    $PAGE->requires->js_call_amd('block_tog/composite', 'initialise');
} else {
    echo html_writer::div(get_string('composite_alert_no_capability', 'block_tog'),
            'alert alert-danger', array('role' => 'alert'
            ));
}
echo $OUTPUT->footer();
