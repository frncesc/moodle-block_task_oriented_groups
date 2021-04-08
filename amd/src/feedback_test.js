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
/**
 * Javascript components used to manage the feedback questionaire.
 *
 * @package block_tog
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([ 'jquery', 'core/ajax', 'core/str', 'core/notification' ], function($, ajax, Str, notification) {

	/**
	 * Return the number maximum of questions.
	 */
	function getFeedbackQuestionnaireMaxQuestions() {

		return Number($('#feedback_test__max_questions').val());
	}

	/**
	 * Called when want to composite the groups.
	 *
	 * @param event
	 *          with the clicked information.
	 */
	function feedbackSubmitClicked(event) {

		event.stopPropagation();
		$('#feedback_test__submit').hide();
		$('#feedback_test__progress').show();

		var exceptionhandler = function(error) {

			$('#feedback_test__submit').show();
			$('#feedback_test__progress').hide();
			notification.exception(error);
		};
		$('.hidden-feedback_test-question-input').each(function() {
			var value = Number($(this).val());
			answerValues.push(value);
		});

		var feedbackId = $('#feedback_test__feedbackid').val();
		var answerValues = [];
		var max = getFeedbackQuestionnaireMaxQuestions();
		for (var i = 0; i < max; i++) {
			var value = Number($('#feedback_test__question_' + i).val());
			answerValues.push(value);
		}
		var promises = ajax.call([ {
		  methodname : 'block_tog_feedback_group',
		  args : {
		    'feedbackid' : feedbackId,
		    'answervalues' : answerValues
		  }
		} ]);
		promises[0].done(function(response) {

			if (!response || (typeof response === 'object' && response.success !== true)) {

				Str.get_strings([ {
				  key : 'feedback_test_groups_error_title',
				  component : 'block_tog'
				}, {
				  key : 'feedback_test_groups_error_text',
				  component : 'block_tog'
				}, {
				  key : 'feedback_test_groups_error_continue',
				  component : 'block_tog'
				} ]).done(function(s) {
					$('#feedback_test__submit').show();
					$('#feedback_test__progress').hide();
					notification.alert(s[0], s[1], s[2]);
				}).fail(exceptionhandler);

			} else {

				$('#feedback_test__submit').show();
				$('#feedback_test__progress').hide();
				$('#feedback_test__submit').prop("disabled", true);
				var max = getFeedbackQuestionnaireMaxQuestions();
				for (var i = 0; i < max; i++) {

					$('#feedback_test__question_' + i).val(-2);
				}
				$('.feedback_test-answer-input').prop('checked', false);
				$('#feedback_test__alert_submit_success').show();
				setTimeout(function() {
					$('#feedback_test__alert_submit_success').hide();
				}, 3000);

				var option = $('.feedback_test-group_option[value="' + feedbackId + '"]');
				var selection = option.parent();
				option.remove();
				var options = selection.children();
				if (options.length > 0) {

					var newFeedbackId = options.first().val();
					$('#feedback_test__feedbackid').val(newFeedbackId);

				} else {

					var groupingId = $('#feedback_test__grouping_selector').val();
					$('#feedback_test__group_row_for_' + groupingId).remove();
					var groupingSelector = $('#feedback_test__grouping_selector');
					$('.feedback_test-grouping_option[value="'+groupingId+'"]').remove();
					if( groupingSelector.children().length == 0 ){

						// If not more groups posibles
						$('#feedback_test__alert_empty').show();
						$('#feedback_test__form').hide();

					}else{

						var newGroupingId = groupingSelector.children().first().val();
						$('#feedback_test__grouping_selector').val(newGroupingId);
						groupingChanged();
					}
				}

			}

		}).fail(exceptionhandler);

	}

	/**
	 * Called when an user selected an answer for a question.
	 */
	function selectedAnswer(event) {

		event.stopPropagation();
		var inputId = $(this).attr('id');
		var value = $(this).val();
		var start = inputId.indexOf('_') + 1;
		var end = inputId.indexOf('_', start);
		start = inputId.lastIndexOf('_') + 1;
		var question = inputId.substring(start);
		$('#feedback_test__question_' + question).val(value);

		var disableSubmit = false;
		var max = getFeedbackQuestionnaireMaxQuestions();
		for (var i = 0; i < max; i++) {

			value = Number($('#feedback_test__question_' + i).val());
			if (value < -1) {
				disableSubmit = true;
				break;
			}
		}
		$('#feedback_test__submit').prop("disabled", disableSubmit);

	}

	/**
	 * Called when changed the grouping.
	 */
	function groupingChanged() {

		$('.feedback_test__group_row').hide();
		var groupingId = $('#feedback_test__grouping_selector').val();
		$('#feedback_test__group_row_for_' + groupingId).show();
		var feedbackId = $('#feedback_test__group_selector_for_' + groupingId).val();
		$('#feedback_test__feedbackid').val(feedbackId);

	}

	/**
	 * Called when changed the group.
	 */
	function groupChanged(event) {

		var feedbackId = $(event.target).val();
		$('#feedback_test__feedbackid').val(feedbackId);

	}

	/**
	 * Called when changed an answer.
	 */
	function answerChanged(event) {

		var answerInput = $(event.target);
		var id = answerInput.attr('id');
		var index = id.lastIndexOf('_') + 1;
		var questionId = id.substring(index);
		var value = answerInput.val();
		$('#feedback_test__question_' + questionId).val(value);

		var answered = 0;
		var max = getFeedbackQuestionnaireMaxQuestions();
		for (var i = 0; i < max; i++) {

			var answer = Number($('#feedback_test__question_' + i).val());
			if (answer > -2) {

				answered++;
			}

		}

		var disable = (answered != max);
		$('#feedback_test__submit').prop("disabled", disable);

	}

	return {
	  getFeedbackQuestionnaireMaxQuestions : getFeedbackQuestionnaireMaxQuestions,
	  selectedAnswer : selectedAnswer,
	  feedbackSubmitClicked : feedbackSubmitClicked,
	  groupingChanged : groupingChanged,
	  answerChanged : answerChanged,
	  initialise : function($params) {

		  $('#feedback_test__submit').click(feedbackSubmitClicked);
		  $('#feedback_test__submit').prop("disabled", true);
		  $('#feedback_test__progress').hide();
		  $('#feedback_test__alert_empty').hide();
		  groupingChanged();
		  $('.feedback_test__group_selector').change(groupChanged);
		  $('#feedback_test__grouping_selector').change(groupingChanged);
		  $('.feedback_test-answer-input').change(answerChanged);
		  $('#feedback_test__alert_submit_success').hide();
	  }
	};

});
