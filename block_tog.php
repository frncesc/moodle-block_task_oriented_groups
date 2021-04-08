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
defined('MOODLE_INTERNAL') || die();

use block_tog\Personality;
use block_tog\Intelligences;

/**
 * Block tog is defined here.
 *
 * @package block_tog
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_tog extends block_base {

    /**
     * Initializes the block, called by the constructor
     */
    public function init() {
        $this->title = get_string('tog', 'block_tog');
    }

    /**
     * Which page types this block may appear on
     *
     * @return array
     */
    public function applicable_formats() {
        return array('site-index' => true, 'course-view-*' => true, 'all' => true
        );
    }

    /**
     * Populate this block's content object
     *
     * @return stdClass block content info
     */
    public function get_content() {
        global $COURSE;

        if (!is_null($this->content)) {
            return $this->content;
        }

        // create the links to the option of the block
        $this->content = new stdClass();
        $contents = array();

        if (has_capability('moodle/site:config', $this->page->context)) {

            $contenturl = new moodle_url('/blocks/tog/view/auto_fill_in.php',
                    array('courseid' => $COURSE->id
                    ));
            $contentlink = html_writer::link($contenturl,
                    get_string('main:auto_fill_in', 'block_tog'));
            $contents[] = html_writer::tag('li', $contentlink);
        }

        if (has_capability('moodle/course:managegroups', $this->page->context)) {

            $contenturl = new moodle_url('/blocks/tog/view/composite.php',
                    array('courseid' => $COURSE->id
                    ));
            $contentlink = html_writer::link($contenturl,
                    get_string('main:composite', 'block_tog'));
            $contents[] = html_writer::tag('li', $contentlink);
            $contenturl = new moodle_url('/blocks/tog/view/feedback_test.php',
                    array('courseid' => $COURSE->id
                    ));
            $contentlink = html_writer::link($contenturl,
                    get_string('main:feedback_test', 'block_tog'));
            $contents[] = html_writer::tag('li', $contentlink);
        }

        if (Personality::isPersonalityCalculatedForCurrentUser()) {

            $contenturl = new moodle_url('/blocks/tog/view/personality.php',
                    array('courseid' => $COURSE->id
                    ));
            $contentlink = html_writer::link($contenturl,
                    get_string('main:my_personality', 'block_tog'));
            $contents[] = html_writer::tag('li', $contentlink);
        } else {

            $contenturl = new moodle_url('/blocks/tog/view/personality_test.php',
                    array('courseid' => $COURSE->id
                    ));
            $contentlink = html_writer::link($contenturl,
                    get_string('main:fill_personality_test', 'block_tog'));
            $contents[] = html_writer::tag('li', $contentlink);
        }

        if (Intelligences::isIntelligencesCalculatedForCurrentUser()) {

            $contenturl = new moodle_url('/blocks/tog/view/intelligences.php',
                    array('courseid' => $COURSE->id
                    ));
            $contentlink = html_writer::link($contenturl,
                    get_string('main:my_intelligences', 'block_tog'));
            $contents[] = html_writer::tag('li', $contentlink);
        } else {

            $contenturl = new moodle_url('/blocks/tog/view/intelligences_test.php',
                    array('courseid' => $COURSE->id
                    ));
            $contentlink = html_writer::link($contenturl,
                    get_string('main:fill_intelligences_test', 'block_tog'));
            $contents[] = html_writer::tag('li', $contentlink);
        }
        $this->content->text = html_writer::tag('ol', implode('', $contents),
                array('class' => 'list'
                ));

        $this->content->footer = '';

        return $this->content;
    }

    /**
     * Inform that the block is configurable.
     *
     * @return boolean return {@code true} in any case.
     */
    function has_config() {
        return true;
    }
}
