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
namespace block_tog;

defined('MOODLE_INTERNAL') || die();

use block_tog\IntelligencesQuestionnaire;

/**
 * Class that represents the intelligences questionnaire.
 *
 * @package block_tog
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Intelligences {

    /**
     * Return the coimpetences of teh current user.
     */
    public static function getIntelligencesOfCurrentUser() {
        global $USER;
        return self::getIntelligencesOf($USER->id);
    }

    /**
     * Return the the intelligences of an user.
     *
     * @param int $userid
     * @return stdObject/boolean the intelligences associated to the user or false if the user does
     *         not have a intelligences.
     */
    public static function getIntelligencesOf($userid) {
        global $DB;

        $intelligences = $DB->get_record('block_tog_intelligences', array('userid' => $userid
        ), '*', IGNORE_MISSING);
        if ($intelligences !== false && isset($intelligences)) {

            return $intelligences;
        } else {

            return false;
        }
    }

    /**
     * Calculate the intelligences of the specified user.
     *
     * @param int $userid
     * @return boolean true if the intelligences has been calculated.
     */
    public static function calculateIntelligencesOf($userid) {
        global $DB;

        $calculated = false;

        $answers = IntelligencesQuestionnaire::getAnswersOf($userid);
        if (count($answers) == IntelligencesQuestionnaire::countQuestions()) {

            $record = new \stdClass();
            $record->userid = $userid;
            $record->verbal = 0.0;
            $record->logic_mathematics = 0.0;
            $record->visual_spatial = 0.0;
            $record->kinestesica_corporal = 0.0;
            $record->musical_rhythmic = 0.0;
            $record->intrapersonal = 0.0;
            $record->interpersonal = 0.0;
            $record->naturalist_environmental = 0.0;
            $total = [0, 0, 0, 0, 0, 0, 0, 0
            ];
            foreach ($answers as $answer) {

                $factor = IntelligencesQuestionnaire::getQuestionFactor($answer->question);
                $value = IntelligencesQuestionnaire::getAnswerQuestionValueOf($answer->answer);
                switch ($factor) {
                    case IntelligencesQuestionnaire::VERBAL_FACTOR:
                        $record->verbal += $value;
                        $total[0]++;
                        break;
                    case IntelligencesQuestionnaire::LOGIC_MATHEMATICS_FACTOR:
                        $record->logic_mathematics += $value;
                        $total[1]++;
                        break;
                    case IntelligencesQuestionnaire::VISUAL_SPATIAL_FACTOR:
                        $record->visual_spatial += $value;
                        $total[2]++;
                        break;
                    case IntelligencesQuestionnaire::KINESTESICA_CORPORAL_FACTOR:
                        $record->kinestesica_corporal += $value;
                        $total[3]++;
                        break;
                    case IntelligencesQuestionnaire::MUSICAL_RHYTHMIC_FACTOR:
                        $record->musical_rhythmic += $value;
                        $total[4]++;
                        break;
                    case IntelligencesQuestionnaire::INTRAPERSONAL_FACTOR:
                        $record->intrapersonal += $value;
                        $total[5]++;
                        break;
                    case IntelligencesQuestionnaire::INTERPERSONAL_FACTOR:
                        $record->interpersonal += $value;
                        $total[6]++;
                        break;
                    default:
                        // IntelligencesQuestionnaire::NATURALIST_ENVIRONMENTAL_FACTOR:
                        $record->naturalist_environmental += $value;
                        $total[7]++;
                }
            }
            $record->verbal = $record->verbal / $total[0];
            $record->logic_mathematics = $record->logic_mathematics / $total[1];
            $record->visual_spatial = $record->visual_spatial / $total[2];
            $record->kinestesica_corporal = $record->kinestesica_corporal / $total[3];
            $record->musical_rhythmic = $record->musical_rhythmic / $total[4];
            $record->intrapersonal = $record->intrapersonal / $total[5];
            $record->interpersonal = $record->interpersonal / $total[6];
            $record->naturalist_environmental = $record->naturalist_environmental / $total[7];

            $previousAnswer = self::getIntelligencesOf($userid);
            if ($previousAnswer !== false) {

                $record->id = $previousAnswer->id;
                $calculated = $DB->update_record('block_tog_intelligences', $record);
            } else {

                $calculated = $DB->insert_record('block_tog_intelligences', $record, false) === true;
            }
        }

        return $calculated;
    }

    /**
     * Check if it is calculated the intelligences for the current user.
     */
    public static function isIntelligencesCalculatedForCurrentUser() {
        global $USER;
        return self::isIntelligencesCalculatedFor($USER->id);
    }

    /**
     * Check if for an user has calculated its intelligences.
     */
    public static function isIntelligencesCalculatedFor($userid) {
        global $DB;
        return $DB->record_exists('block_tog_intelligences', array('userid' => $userid
        ));
    }

    /**
     * Convert a intelligence value to a human readable value.
     *
     * @param number $value to obtain the
     * @return string
     */
    public static function valueToString($value) {
        $index = floor($value / 0.2);
        $index = min(4, $index);
        return get_string('intelligences_value_' . $index, 'block_tog');
    }
}