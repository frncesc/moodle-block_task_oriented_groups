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

/**
 * Class that represents the intelligence questionnaire.
 *
 * @package block_tog
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class IntelligencesQuestionnaire {

    /**
     * The number maximum of posible answers for each question.
     *
     * @var integer
     */
    const MAX_QUESTION_ANSWERS = 5;

    /**
     * Factor used to evaluate the verbal intelligence.
     */
    const VERBAL_FACTOR = 0;

    /**
     * Factor used to evaluate the logic/mathematics intelligence.
     */
    const LOGIC_MATHEMATICS_FACTOR = 1;

    /**
     * Factor used to evaluate the visual/spatial intelligence.
     */
    const VISUAL_SPATIAL_FACTOR = 2;

    /**
     * Factor used to evaluate the kinestesica/corporal intelligence.
     */
    const KINESTESICA_CORPORAL_FACTOR = 3;

    /**
     * Factor used to evaluate the musical/rhythmic intelligence.
     */
    const MUSICAL_RHYTHMIC_FACTOR = 4;

    /**
     * Factor used to evaluate the intrapersonal intelligence.
     */
    const INTRAPERSONAL_FACTOR = 5;

    /**
     * Factor used to evaluate the interpersonal intelligence.
     */
    const INTERPERSONAL_FACTOR = 6;

    /**
     * Factor used to evaluate the naturalist/environmental intelligence.
     */
    const NATURALIST_ENVIRONMENTAL_FACTOR = 7;

    /**
     * The types assocaited to each question.
     */
    const QUESTION_FACTORS = [self::VERBAL_FACTOR, self::VISUAL_SPATIAL_FACTOR,
        self::INTRAPERSONAL_FACTOR, self::MUSICAL_RHYTHMIC_FACTOR, self::MUSICAL_RHYTHMIC_FACTOR,
        self::LOGIC_MATHEMATICS_FACTOR, self::INTRAPERSONAL_FACTOR, self::LOGIC_MATHEMATICS_FACTOR,
        self::KINESTESICA_CORPORAL_FACTOR, self::VERBAL_FACTOR, self::VISUAL_SPATIAL_FACTOR,
        self::INTERPERSONAL_FACTOR, self::NATURALIST_ENVIRONMENTAL_FACTOR,
        self::MUSICAL_RHYTHMIC_FACTOR, self::VISUAL_SPATIAL_FACTOR, self::LOGIC_MATHEMATICS_FACTOR,
        self::KINESTESICA_CORPORAL_FACTOR, self::VERBAL_FACTOR, self::INTERPERSONAL_FACTOR,
        self::KINESTESICA_CORPORAL_FACTOR, self::LOGIC_MATHEMATICS_FACTOR,
        self::KINESTESICA_CORPORAL_FACTOR, self::VERBAL_FACTOR, self::VISUAL_SPATIAL_FACTOR,
        self::NATURALIST_ENVIRONMENTAL_FACTOR, self::MUSICAL_RHYTHMIC_FACTOR,
        self::LOGIC_MATHEMATICS_FACTOR, self::INTRAPERSONAL_FACTOR, self::VISUAL_SPATIAL_FACTOR,
        self::MUSICAL_RHYTHMIC_FACTOR, self::NATURALIST_ENVIRONMENTAL_FACTOR,
        self::KINESTESICA_CORPORAL_FACTOR, self::VERBAL_FACTOR, self::INTRAPERSONAL_FACTOR,
        self::INTERPERSONAL_FACTOR, self::NATURALIST_ENVIRONMENTAL_FACTOR, self::INTRAPERSONAL_FACTOR,
        self::INTERPERSONAL_FACTOR, self::INTERPERSONAL_FACTOR, self::NATURALIST_ENVIRONMENTAL_FACTOR
    ];

    /**
     * The index of the questions that does not have help.
     */
    const QUESTIONS_WITHOUT_HELP = [2, 5, 9, 12, 16, 24, 29, 30, 31, 35, 38, 39
    ];

    /**
     * Load user answers.
     */
    public function __construct() {
    }

    /**
     * Return the number of questions that have the questionnaire.
     */
    public static function countQuestions() {
        return count(self::QUESTION_FACTORS);
    }

    /**
     * Return the facor associated to the question.
     *
     * @param int $index
     * @return int the factor associated to the question.
     */
    public static function getQuestionFactor($index) {
        return self::QUESTION_FACTORS[$index];
    }

    /**
     * Return the text associated to the question.
     */
    public static function getQuestionTextOf($index) {
        return get_string('intelligence_question_' . $index, 'block_tog');
    }

    /**
     * Check if the specified question has help.
     */
    public static function hasQuestionHelp($index) {
        return array_search($index, self::QUESTIONS_WITHOUT_HELP) === false;
    }

    /**
     * Return the identifier of the help string associated to the question.
     */
    public static function getQuestionHelpIdentifier($index) {
        return 'intelligence_question_' . $index;
    }

    /**
     * Return the text associated to the specified answers in the question.
     */
    public static function getAnswerQuestionTextOf($index) {
        return get_string('intelligence_question_answer_' . $index, 'block_tog');
    }

    /**
     * Return the value associated to the specified answers in the question.
     */
    public static function getAnswerQuestionValueOf($index) {
        switch ($index) {
            case 0:
                return 0.0;
            case 1:
                return 0.25;
            case 2:
                return 0.5;
            case 3:
                return 0.75;
            default:
                return 1.0;
        }
    }

    /**
     * Get the answers done by the current user for the intelligences questions.
     */
    public static function getAnswersOfCurrentUser() {
        global $USER;
        return self::getAnswersOf($USER->id);
    }

    /**
     * Get the answers done by spoecified user for the intelligences questions.
     */
    public static function getAnswersOf($userid) {
        global $DB;
        return $DB->get_records('block_tog_intel_answers', array('userid' => $userid
        ), 'question', 'question,answer');
    }

    /**
     * Store the answer of an user to a intelligences question.
     *
     * @param int $question
     * @param int $answer
     * @param int $userid
     * @return boolean true if the answer has been stored.
     */
    public static function setIntelligencesAnswerFor($question, $answer, $userid) {
        global $DB;
        $updated = false;
        $previousAnswer = $DB->get_record('block_tog_intel_answers',
                array('userid' => $userid, 'question' => $question
                ), '*', IGNORE_MISSING);

        if ($previousAnswer !== false && isset($previousAnswer)) {

            $previousAnswer->answer = $answer;
            $updated = $DB->update_record('block_tog_intel_answers', $previousAnswer);
        } else {

            $record = new \stdClass();
            $record->userid = $userid;
            $record->question = $question;
            $record->answer = $answer;
            $updated = $DB->insert_record('block_tog_intel_answers', $record, false) === true;
        }

        return $updated;
    }
}