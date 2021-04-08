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
use block_tog\Personality;
use block_tog\Intelligences;

$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('personality_title', 'block_tog'));
$PAGE->set_heading(get_string('personality_heading', 'block_tog'));
$PAGE->set_url($CFG->wwwroot . '/blocks/tog/view/personality.php');
$PAGE->add_body_class('block_task_oriented_group');

$courseid = optional_param('courseid', 0, PARAM_INT);
if ($courseid) {

    $course = $DB->get_record('course', array('id' => $courseid
    ), '*', MUST_EXIST);
    require_login($course);
    context_helper::preload_course($course->id);
    $context = context_course::instance($course->id, MUST_EXIST);
    $PAGE->set_context($context);
} else {

    require_login();
}
$personality = Personality::getPersonalityOfCurrentUser();
echo $OUTPUT->header();
?>
<div class="container">
<?php
if ($personality) {

    $l10npersonality = new \stdClass();
    $l10npersonality->type = $personality->type;
    $l10npersonality->name = get_string('personality_' . $personality->type . '_name',
            'block_tog');
    $l10npersonality->description = get_string('personality_' . $personality->type . '_description',
            'block_tog');
    ?>
	<div class="row">
		<p><?=get_string('personality_msg', 'block_tog', $l10npersonality)?></p>
	</div>
    <?php
} else {
    echo html_writer::div(
            get_string('personality_error_not_answered_all_questions', 'block_tog'),
            'alert alert-danger', array('role' => 'alert'
            ));
}
$personality_test_url = $CFG->wwwroot . '/blocks/tog/view/personality_test.php';
if ($courseid) {
    $personality_test_url .= '?courseid=' . $courseid;
}
?>
	<div class="row justify-content-md-center actions-row">
		<?php
$intelligences = Intelligences::getIntelligencesOfCurrentUser();
if (!$intelligences) {
    $intelligences_test_url = $CFG->wwwroot .
            '/blocks/tog/view/intelligences_test.php';
    if ($courseid) {
        $intelligences_test_url .= '?courseid=' . $courseid;
    }
    ?>
		<button
			type="button"
			class="btn btn-secondary"
			onclick="location.href='<?=$intelligences_test_url?>';"
			role="button"
		>
			<?=get_string('personality_go_to_intelligences_test', 'block_tog')?>
		</button>
        <?php
}
if ($personality) {
    ?>
		<button
			type="button"
			class="btn btn-secondary"
			onclick="location.href='<?=get_string('personality_' . $personality->type . '_more','block_tog')?>';"
			role="button"
		>
			<?=get_string('personality_read_more', 'block_tog')?>
		</button>
		<?php
}
?>
		<button
			type="button"
			class="btn btn-primary"
			onclick="location.href='<?=$personality_test_url?>';"
			role="button"
		>
			<?=get_string('personality_go_to_test', 'block_tog')?>
		</button>
		<?php
if ($courseid) {
    ?>
		<button
			type="button"
			class="btn btn-secondary"
			onclick="location.href='<?=$CFG->wwwroot . '/course/view.php?id=' . $courseid?>';"
			role="button"
		>
        	<?=get_string('personality_go_to_course', 'block_tog')?>
        </button>
        <?php
}
?>
</div>
<?php
echo $OUTPUT->footer();