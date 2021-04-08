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

use block_tog\PersonalityQuestionnaire;

/**
 * Class used to manage the personality of an user.
 *
 * @package block_tog
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Personality {

    /**
     * Calculate the personality of the specified user.
     *
     * @param int $userid
     * @return boolean true if the personality has been calculated.
     */
    public static function calculatePersonalityOf($userid) {
        global $DB;

        $calculated = false;

        $answers = PersonalityQuestionnaire::getAnswersOf($userid);
        if (count($answers) == PersonalityQuestionnaire::countQuestions()) {

            $record = new \stdClass();
            $record->userid = $userid;
            $record->type = '';
            $record->gender = 0;
            $record->judgment = 0.0;
            $record->attitude = 0.0;
            $record->perception = 0.0;
            $record->extrovert = 0.0;
            $total = [0, 0, 0, 0
            ];
            foreach ($answers as $answer) {

                $factor = PersonalityQuestionnaire::getQuestionFactor($answer->question);
                $value = PersonalityQuestionnaire::getAnswerQuestionValueOf($answer->question,
                        $answer->answer);
                switch ($factor) {
                    case PersonalityQuestionnaire::JUDGMENT_FACTOR:
                        $record->judgment += $value;
                        $total[0]++;
                        break;
                    case PersonalityQuestionnaire::ATTITUDE_FACTOR:
                        $record->attitude += $value;
                        $total[1]++;
                        break;
                    case PersonalityQuestionnaire::PERCEPTION_FACTOR:
                        $record->perception += $value;
                        $total[2]++;
                        break;
                    case PersonalityQuestionnaire::EXTROVERT_FACTOR:
                        $record->extrovert += $value;
                        $total[3]++;
                        break;
                    default:
                        // gender answer
                        if ($value > 0) {
                            // it is a male
                            $record->gender = 1;
                        } else {
                            // it is a female
                            $record->gender = 0;
                        }
                }
            }
            $record->judgment = $record->judgment / $total[0];
            $record->attitude = $record->attitude / $total[1];
            $record->perception = $record->perception / $total[2];
            $record->extrovert = $record->extrovert / $total[3];
            if ($record->extrovert > 0) {

                $record->type .= 'E';
            } else {
                $record->type .= 'I';
            }
            if ($record->perception > 0) {

                $record->type .= 'N';
            } else {

                $record->type .= 'S';
            }
            if ($record->judgment > 0) {

                $record->type .= 'T';
            } else {

                $record->type .= 'F';
            }
            if ($record->attitude > 0) {

                $record->type .= 'J';
            } else {

                $record->type .= 'P';
            }

            $previousAnswer = self::getPersonalityOf($userid);
            if ($previousAnswer !== false) {

                $record->id = $previousAnswer->id;
                $calculated = $DB->update_record('block_tog_personality', $record);
            } else {

                $calculated = $DB->insert_record('block_tog_personality', $record, false) === true;
            }
        }

        return $calculated;
    }

    /**
     * Return the coimpetences of teh current user.
     */
    public static function getPersonalityOfCurrentUser() {
        global $USER;
        return self::getPersonalityOf($USER->id);
    }

    /**
     * Return the the personality of an user.
     *
     * @param int $userid
     * @return stdObject/boolean the personality associated to the user or false if the user does
     *         not have a personality.
     */
    public static function getPersonalityOf($userid) {
        global $DB;

        $personality = $DB->get_record('block_tog_personality', array('userid' => $userid
        ), '*', IGNORE_MISSING);
        if ($personality !== false && isset($personality)) {

            return $personality;
        } else {

            return false;
        }
    }

    /**
     * Check if it is calculated the personality for the current user.
     */
    public static function isPersonalityCalculatedForCurrentUser() {
        global $USER;
        return self::isPersonalityCalculatedFor($USER->id);
    }

    /**
     * Check if for an user has calculated its personality.
     */
    public static function isPersonalityCalculatedFor($userid) {
        global $DB;
        return $DB->record_exists('block_tog_personality', array('userid' => $userid
        ));
    }
}