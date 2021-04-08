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
use block_tog\Intelligences;
use block_tog\Personality;

$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('intelligences_title', 'block_tog'));
$PAGE->set_heading(get_string('intelligences_heading', 'block_tog'));
$PAGE->set_url($CFG->wwwroot . '/blocks/tog/view/intelligences.php');
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
$intelligences = Intelligences::getIntelligencesOfCurrentUser();
echo $OUTPUT->header();
?>
<div class="container">
<?php
if ($intelligences) {
    ?>
	<div class="row">
		<p><?=get_string('intelligences_msg', 'block_tog')?></p>
	</div>
	<div class="row">
		<ul>
			<li><b><?=get_string('intelligences_verbal_factor', 'block_tog')?>:</b>&nbsp;<?=Intelligences::valueToString($intelligences->verbal)?></li>
			<li><b><?=get_string('intelligences_logic_mathematics_factor', 'block_tog')?>:</b>&nbsp;<?=Intelligences::valueToString($intelligences->logic_mathematics)?></li>
			<li><b><?=get_string('intelligences_visual_spatial_factor', 'block_tog')?>:</b>&nbsp;<?=Intelligences::valueToString($intelligences->visual_spatial)?></li>
			<li><b><?=get_string('intelligences_kinestesica_corporal_factor', 'block_tog')?>:</b>&nbsp;<?=Intelligences::valueToString($intelligences->kinestesica_corporal)?></li>
			<li><b><?=get_string('intelligences_musical_rhythmic_factor', 'block_tog')?>:</b>&nbsp;<?=Intelligences::valueToString($intelligences->musical_rhythmic)?></li>
			<li><b><?=get_string('intelligences_intrapersonal_factor', 'block_tog')?>:</b>&nbsp;<?=Intelligences::valueToString($intelligences->intrapersonal)?></li>
			<li><b><?=get_string('intelligences_interpersonal_factor', 'block_tog')?>:</b>&nbsp;<?=Intelligences::valueToString($intelligences->interpersonal)?></li>
			<li><b><?=get_string('intelligences_naturalist_environmental_factor', 'block_tog')?>:</b>&nbsp;<?=Intelligences::valueToString($intelligences->naturalist_environmental)?></li>
		</ul>
	</div>
    <?php
} else {
    echo html_writer::div(
            get_string('intelligences_error_not_answered_all_questions',
                    'block_tog'), 'alert alert-danger', array('role' => 'alert'
            ));
}
$intelligences_test_url = $CFG->wwwroot . '/blocks/tog/view/intelligences_test.php';
if ($courseid) {
    $intelligences_test_url .= '?courseid=' . $courseid;
}
?>
	<div class="row justify-content-md-center actions-row">
		<?php
$personality = Personality::getPersonalityOfCurrentUser();
if (!$personality) {
    $personality_test_url = $CFG->wwwroot . '/blocks/tog/view/personality_test.php';
    if ($courseid) {
        $personality_test_url .= '?courseid=' . $courseid;
    }
    ?>
		<button
			type="button"
			class="btn btn-secondary"
			onclick="location.href='<?=$personality_test_url?>';"
			role="button"
		>
			<?=get_string('intelligences_go_to_personality_test', 'block_tog')?>
		</button>
        <?php
}
?>
		<button
			type="button"
			class="btn btn-primary"
			onclick="location.href='<?=$intelligences_test_url?>';"
			role="button"
		>
			<?=get_string('intelligences_go_to_test', 'block_tog')?>
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
        	<?=get_string('intelligences_go_to_course', 'block_tog')?>
        </button>
        <?php
}
?>
	</div>
</div>
<?php
echo $OUTPUT->footer();