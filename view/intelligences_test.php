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
use block_tog\IntelligencesQuestionnaire;
use block_tog\Intelligences;
use block_tog\Personality;

$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('intelligences_test_title', 'block_tog'));
$PAGE->set_heading(get_string('intelligences_test_heading', 'block_tog'));
$PAGE->set_url($CFG->wwwroot . '/blocks/tog/view/intelligences_test.php');
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
$answers = IntelligencesQuestionnaire::getAnswersOfCurrentUser();
echo $OUTPUT->header();
?>
<div class="container intelligences-questions">
 <?php
for ($i = 0; $i < IntelligencesQuestionnaire::countQuestions(); $i++) {
    $questionId = 'intelligencesQuestion_' . $i;
    ?>
  <div class="row<?php

    if ($i % 2 != 0) {
        echo ' bg-light';
    }
    ?> intelligences-question">
		<div class="container">
			<div class="row">
				<h4><?=IntelligencesQuestionnaire::getQuestionTextOf($i)?><?php

    if (IntelligencesQuestionnaire::hasQuestionHelp($i)) {
        echo '&nbsp;&nbsp;';
        echo $OUTPUT->help_icon(IntelligencesQuestionnaire::getQuestionHelpIdentifier($i),
                'block_tog', '');
    }
    ?></h4>
			</div>
			<div class="row justify-content-center">
  <?php
    $selected = -1;
    foreach ($answers as $k => $answer) {
        if ($answer->question == $i) {
            $selected = $answer->answer;
            unset($answers[$k]);
            break;
        }
    }

    for ($j = 0; $j < IntelligencesQuestionnaire::MAX_QUESTION_ANSWERS; $j++) {
        ?>
   <div class="form-check-inline col-md">
					<input
						class="form-check-input"
						type="radio"
						id="answer_<?=$j?>_for_intelligences_question_<?=$i?>"
						name="<?=$questionId?>"
						value="<?=IntelligencesQuestionnaire::getAnswerQuestionValueOf($j)?>"
						<?php

        if ($selected == $j) {
            echo 'checked="checked"';
        }
        ?>
					><label
						class="form-check-label"
						for="answer_<?=$j?>_for_intelligences_question_<?=$i?>"
					><?=IntelligencesQuestionnaire::getAnswerQuestionTextOf($j)?></label>
				</div>
  <?php
    }
    ?>
   </div>
		</div>
	</div>
  <?php
}
$intelligences_url = $CFG->wwwroot . '/blocks/tog/view/intelligences.php';
if ($courseid) {
    $intelligences_url .= '?courseid=' . $courseid;
}
?>
   	<div class="row justify-content-md-center actions-row">
		<div
			class="alert alert-warning blink"
			role="alert"
			style="display: none;"
		>
   			<?=get_string('intelligences_test_storing_msg', 'block_tog')?>
   		</div>
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
			<?=get_string('intelligences_test_go_to_personality_test', 'block_tog')?>
		</button>
        <?php
}
?>
		<button
			type="button"
			class="btn btn-primary"
			onclick="location.href='<?=$intelligences_url?>';"
			role="button"
		>
			<?=get_string('intelligences_test_go_to_intelligences', 'block_tog')?>
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
        	<?=get_string('intelligences_test_go_to_course', 'block_tog')?>
        </button>
        <?php
}
?>
	</div>
</div>
<?php
$PAGE->requires->js_call_amd('block_tog/intelligences_test', 'initialise');
echo $OUTPUT->footer();