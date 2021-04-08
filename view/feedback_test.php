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
global $CFG;
global $PAGE;
global $DB;
global $OUTPUT;
require_once ($CFG->dirroot . '/group/lib.php');
use block_tog\FeedbackQuestionnaire;

$courseid = optional_param('courseid', 0, PARAM_INT);
$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('feedback_test_title', 'block_tog'));
$PAGE->set_heading(get_string('feedback_test_heading', 'block_tog'));
$PAGE->set_url($CFG->wwwroot . '/blocks/tog/view/feedback_test.php');
$PAGE->add_body_class('block_task_oriented_group');

$course = $DB->get_record('course', array('id' => $courseid
), '*', MUST_EXIST);
require_login($course);
context_helper::preload_course($course->id);
$context = context_course::instance($course->id, MUST_EXIST);
$PAGE->set_context($context);

echo $OUTPUT->header();
if (has_capability('moodle/course:managegroups', $context)) {

    // add component to select the grouping
    $default_feedbackid = null;
    $default_groupingid = null;
    $grouping_options = '';
    $group_selectors = '';

    $groupings = groups_get_all_groupings($course->id);
    foreach ($groupings as $grouping) {

        $default_group_feedbackid = null;
        $group_selector_options = '';
        $groups = groups_get_all_groups($course->id, 0, $grouping->id);
        foreach ($groups as $group) {

            $composed = $DB->get_record('block_tog_composed',
                    array('groupingid' => $grouping->id, 'groupid' => $group->id
                    ), '*', IGNORE_MISSING);
            if ($composed !== false && isset($composed)) {

                $group_selector_options .= html_writer::tag('option', $group->name,
                        array('value' => $composed->feedbackid,
                            'class' => 'feedback_test-group_option'
                        ));
                if ($default_feedbackid == null) {

                    $default_feedbackid = $composed->feedbackid;
                }
                if ($default_group_feedbackid == null) {

                    $default_group_feedbackid = $composed->feedbackid;
                }
            }
        }

        if ($default_group_feedbackid != null) {
            if ($default_groupingid == null) {
                $default_groupingid = $grouping->id;
            }
            $grouping_options .= html_writer::tag('option', $grouping->name,
                    array('value' => $grouping->id, 'class' => 'feedback_test-grouping_option'
                    ));
            $group_selector = html_writer::start_div('form-row',
                    array('id' => 'feedback_test__group_row_for_' . $grouping->id,
                        'class' => 'feedback_test__group_row'
                    ));
            $group_selector .= html_writer::start_div('form-group');
            $group_selector .= html_writer::tag('label',
                    get_string('feedback_test_group_selector', 'block_tog') .
                    '&nbsp;&nbsp' .
                    $OUTPUT->help_icon('feedback_test_group_selector', 'block_tog',
                            ''),
                    array('for' => 'feedback_test__group_selector_for_' . $grouping->id
                    ));
            $group_selector .= html_writer::tag('select', $group_selector_options,
                    array('class' => 'form-control feedback_test__group_selector',
                        'id' => 'feedback_test__group_selector_for_' . $grouping->id,
                        'value' => $default_group_feedbackid
                    ));
            $group_selector .= html_writer::end_div();
            $group_selector .= html_writer::end_div();
            $group_selectors .= $group_selector;
        }
    }
    $grouping_selector = html_writer::start_div('form-row');
    $grouping_selector .= html_writer::start_div('form-group');
    $grouping_selector .= html_writer::tag('label',
            get_string('feedback_test_grouping_selector', 'block_tog') .
            '&nbsp;&nbsp' .
            $OUTPUT->help_icon('feedback_test_grouping_selector', 'block_tog', ''),
            array('for' => 'feedback_test__grouping_selector'
            ));
    $grouping_selector .= html_writer::start_tag('select',
            array('class' => 'form-control', 'id' => 'feedback_test__grouping_selector',
                'value' => $default_groupingid
            ));
    $grouping_selector .= $grouping_options;
    $grouping_selector .= html_writer::end_tag('select');
    $grouping_selector .= html_writer::end_div();
    $grouping_selector .= html_writer::end_div();

    $content = html_writer::div(
            get_string('feedback_test_alert_empty', 'block_tog'),
            'alert alert-danger', array('role' => 'alert', 'id' => 'feedback_test__alert_empty'
            ));
    if ($default_feedbackid == null) {

        echo $content;
    } else {

        $content .= html_writer::start_tag('form', array('id' => 'feedback_test__form'
        ));
        $content .= html_writer::start_tag('input',
                array('id' => 'feedback_test__feedbackid', 'type' => 'hidden',
                    'value' => $default_feedbackid
                ));
        $content .= html_writer::start_tag('fieldset', array('class' => 'border p-2'
        ));
        $content .= html_writer::tag('legend',
                get_string('feedback_test_group', 'block_tog') . '&nbsp;&nbsp' .
                $OUTPUT->help_icon('feedback_test_group', 'block_tog', ''),
                array('class' => 'w-auto'
                ));
        $content .= $grouping_selector;
        $content .= $group_selectors;
        $content .= html_writer::end_tag('fieldset');

        // add the questionaire
        $content .= html_writer::start_div('container feedback-questions');
        $content .= html_writer::start_tag('input',
                array('id' => 'feedback_test__max_questions', 'type' => 'hidden',
                    'value' => FeedbackQuestionnaire::MAX_QUESTIONS
                ));
        for ($i = 0; $i < FeedbackQuestionnaire::MAX_QUESTIONS; $i++) {

            $questionId = 'feedback_test__question_' . $i;
            if ($i % 2 != 0) {

                $content .= html_writer::start_div('row bg-light feedback-question');
            } else {

                $content .= html_writer::start_div('row feedback-question');
            }
            $content .= html_writer::start_tag('input',
                    array('id' => $questionId, 'type' => 'hidden', 'value' => '-2'
                    ));
            $content .= html_writer::start_div('container');

            $content .= html_writer::start_div('row');
            $content .= html_writer::tag('h4', FeedbackQuestionnaire::getQuestionTextOf($i));
            $content .= html_writer::end_div();

            $content .= html_writer::start_div('row justify-content-center');
            for ($j = 0; $j < FeedbackQuestionnaire::MAX_QUESTION_ANSWERS; $j++) {

                $content .= html_writer::start_div('form-check-inline col-md');
                $content .= html_writer::tag('input', '',
                        array('class' => 'form-check-input feedback_test-answer-input',
                            'type' => 'radio',
                            'id' => 'answer_' . $j . '_for_feedback_question_' . $i,
                            'name' => $questionId,
                            'value' => FeedbackQuestionnaire::getAnswerQuestionValueOf($j)
                        ));
                $content .= html_writer::tag('label',
                        FeedbackQuestionnaire::getAnswerQuestionTextOf($j),
                        array('for' => 'answer_' . $j . '_for_feedback_question_' . $i,
                            'class' => 'form-check-label'
                        ));
                $content .= html_writer::end_div();
            }
            $content .= html_writer::end_div();

            // end question row
            $content .= html_writer::end_div();
            $content .= html_writer::end_div();
        }
        $content .= html_writer::start_div('row feedback-question');
        $content .= html_writer::start_div('container');
        $content .= html_writer::start_div('row justify-content-center');
        $content .= html_writer::tag('button',
                get_string('feedback_test_submit', 'block_tog'),
                array('type' => 'button', 'class' => 'btn btn-primary',
                    'id' => 'feedback_test__submit'
                ));
        $content .= html_writer::end_div();
        $content .= html_writer::end_div();
        $content .= html_writer::end_div();
        $content .= html_writer::div(
                html_writer::div(
                        html_writer::span(
                                get_string('feedback_test_progress', 'block_tog') .
                                html_writer::span('', 'dotdotdot')),
                        'progress-bar progress-bar-striped progress-bar-animated',
                        array('role' => 'progressbar', 'aria-valuenow' => '75',
                            'aria-valuemin' => '0', 'aria-valuemax' => '100'
                        )), 'progress feedback_test-progress',
                array('id' => 'feedback_test__progress'
                ));

        // FINISh the content
        $content .= html_writer::end_tag('form');
        $content .= html_writer::div(
                get_string('feedback_test_alert_submit_success', 'block_tog'),
                'alert alert-success',
                array('role' => 'alert', 'id' => 'feedback_test__alert_submit_success'
                ));

        echo $content;
        $PAGE->requires->js_call_amd('block_tog/feedback_test', 'initialise');
    }
} else {
    echo html_writer::div(
            get_string('feedback_test_alert_no_capability', 'block_tog'),
            'alert alert-danger', array('role' => 'alert'
            ));
}
echo $OUTPUT->footer();