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
 * Javascript components used to manage the intelligences questionnaire answers.
 *
 * @package block_tog
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([ 'jquery', 'core/ajax', 'core/str', 'core/notification' ], function($, ajax, str, notification) {
	return {
		initialise : function($params) {
			console.debug("Intelligences test initialize with:" + $params);
			$('.actions-row').find('.alert').hide();
			$('input:radio').click(function(event) {
				event.stopPropagation();
				var actions = $('.actions-row');
				var updating = Math.max(0,actions.attr('data-updating') || 0);
				updating++;
				actions.attr('data-updating', updating);
				actions.find('button').hide();
				actions.find('.alert').show();
				var inputId = $(this).attr('id');
				var start = inputId.indexOf('_') + 1;
				var end = inputId.indexOf('_', start);
				var answer = inputId.substring(start, end);
				start = inputId.lastIndexOf('_') + 1;
				var question = inputId.substring(start);
				var promises = ajax.call([ {
				  methodname : 'block_tog_store_intelligences_answer',
				  args : {
				    'answer' : answer,
				    'question' : question
				  }
				} ]);
				promises[0].done(function(response) {

					var actions = $('.actions-row');
					var updating = Math.max(1,actions.attr('data-updating') || 1);
					updating--;
					actions.attr('data-updating', updating);
					if (updating <= 0) {

						actions.find('button').show();
						actions.find('.alert').hide();
					}

					if (!response || (typeof response === 'object' && response.success !== true)) {

						str.get_strings([ {
						  key : 'store_intelligences_answer_error_title',
						  component : 'block_tog'
						}, {
						  key : 'store_intelligences_answer_error_text',
						  component : 'block_tog'
						}, {
						  key : 'store_intelligences_answer_error_continue',
						  component : 'block_tog'
						} ]).done(function(s) {
							notification.alert(s[0], s[1], s[2]);
						}).fail(notification.exception);

					}

				}).fail(notification.exception);
			});
		}
	};
});
