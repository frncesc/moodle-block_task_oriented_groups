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
 * Javascript components used on the view/auto_fill_in.php.
 *
 * @package block_tog
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([ 'jquery', 'core/ajax', 'core/notification' ], function($, ajax,notification) {

	/**
	 * Called when a page item has been clicked.
	 *
	 * @param event
	 *          with the clicked information.
	 */
	function pageItemClicked(event) {

		event.stopPropagation();

		$('.fill-in-row').hide();
		$('.page-' + $(this).text().trim()).show();
	}

	/**
	 * Called when has to auto fill in the personality of an user.
	 *
	 * @param event
	 *          with the clicked information.
	 */
	function autoFillInPersonalityClicked(event) {

		event.stopPropagation();
		var cellElement = $(event.target).parent().parent();
		var promises = ajax.call([ {
		  methodname : 'block_tog_auto_fill_in_personality',
		  args : {
		    userid : cellElement.attr("data-user-id")
		  }
		} ]);
		promises[0].done(function(response) {

			if (typeof response === 'object' && response.success !== true) {

				notification.exception(response.message);

			}else{

				cellElement.children(".personality-cell-success").show();
				cellElement.children(".personality-cell-submit").hide();

			}

		}).fail(function(error){notification.exception(error);});

	}

	/**
	 * Called when has to auto fill in the intelligences of an user.
	 *
	 * @param event
	 *          with the clicked information.
	 */
	function autoFillInIntelligencesClicked(event) {

		event.stopPropagation();
		var cellElement = $(event.target).parent().parent();
		var promises = ajax.call([ {
		  methodname : 'block_tog_auto_fill_in_intelligences',
		  args : {
		    userid : cellElement.attr("data-user-id")
		  }
		} ]);
		promises[0].done(function(response) {

			if (typeof response === 'object' && response.success !== true) {

				notification.exception(response.message);

			}else{

				cellElement.children(".intelligences-cell-success").show();
				cellElement.children(".intelligences-cell-submit").hide();
			}

		}).fail(function(error){notification.exception(error);});


	}

	return {
	  pageItemClicked : pageItemClicked,
	  initialise : function($params) {

	  	$('.generated-personality').hide();
	  	$('.generated-intelligences').hide();
		  $('.fill-in-row').hide();
		  $('.personality-cell-success').hide();
		  $('.auto-fill-in-personality').click(autoFillInPersonalityClicked);
		  $('.intelligences-cell-success').hide();
		  $('.auto-fill-in-intelligences').click(autoFillInIntelligencesClicked);
		  $('.page-1').show();
		  $('.page-item').click(pageItemClicked);
		  $('.send-icon').click(sendIconClicked);
		  $('#composite__progress').hide();
		  membersPerGroupChanged();
	  }
	};
});