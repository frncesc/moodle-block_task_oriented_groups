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
global $CFG;
require_once ($CFG->libdir . "/externallib.php");
require_once ($CFG->dirroot . '/group/lib.php');

use block_task_oriented_groups\PersonalityQuestionnaire;
use block_task_oriented_groups\Personality;
use block_task_oriented_groups\CompetencesQuestionnaire;
use block_task_oriented_groups\Competences;

/**
 * External methods necessary to do ajax interaction.
 *
 * @package block_task_oriented_groups
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_task_oriented_groups_external extends external_api {

    /**
     * The function called to get the informatiomn of the parameter to store the personality answer.
     */
    public static function store_personality_answer_parameters() {
        return new external_function_parameters(
                array(
                    'question' => new external_value(PARAM_INT,
                            'Contains the question that the user is answering'),
                    'answer' => new external_value(PARAM_INT, 'Contains the answers of the user')
                ));
    }

    /**
     * The function called to store an answer for a personality question.
     */
    public static function store_personality_answer($question, $answer) {
        global $USER;
        $params = self::validate_parameters(self::store_personality_answer_parameters(),
                array('question' => $question, 'answer' => $answer
                ));
        $question = $params['question'];
        $answer = $params['answer'];
        $userid = $USER->id;

        $updated = PersonalityQuestionnaire::setPersonalityAnswerFor($question, $answer, $userid);
        $calculated = false;
        if ($updated) {

            $calculated = Personality::calculatePersonalityOf($userid);
        }
        $result = array();
        $result['success'] = $updated;
        $result['calculated'] = $calculated;
        return $result;
    }

    /**
     * The function called to get the informatiomn of the parameter to store the personality answer.
     */
    public static function store_personality_answer_returns() {
        return new external_single_structure(
                array(
                    'success' => new external_value(PARAM_BOOL,
                            'This is true if the answers has been stored'),
                    'calculated' => new external_value(PARAM_BOOL,
                            'This is true if it is calculated the user personality')
                ));
    }

    /**
     * The function called to get the informatiomn of the parameter to store the competences answer.
     */
    public static function store_competences_answer_parameters() {
        return new external_function_parameters(
                array(
                    'question' => new external_value(PARAM_INT,
                            'Contains the question that the user is answering'),
                    'answer' => new external_value(PARAM_INT, 'Contains the answers of the user')
                ));
    }

    /**
     * The function called to store an answer for a competences question.
     */
    public static function store_competences_answer($question, $answer) {
        global $USER;
        $params = self::validate_parameters(self::store_competences_answer_parameters(),
                array('question' => $question, 'answer' => $answer
                ));
        $question = $params['question'];
        $answer = $params['answer'];
        $userid = $USER->id;

        $updated = CompetencesQuestionnaire::setCompetencesAnswerFor($question, $answer, $userid);
        $calculated = false;
        if ($updated) {

            $calculated = Competences::calculateCompetencesOf($userid);
        }

        $result = array();
        $result['success'] = $updated;
        $result['calculated'] = $calculated;
        return $result;
    }

    /**
     * The function called to get the informatiomn of the parameter to store the competences answer.
     */
    public static function store_competences_answer_returns() {
        return new external_single_structure(
                array(
                    'success' => new external_value(PARAM_BOOL,
                            'This is true if the answers has been stored'),
                    'calculated' => new external_value(PARAM_BOOL,
                            'This is true if it is calculated the user competences')
                ));
    }

    /**
     * The function called to get the informatiomn of the parameter to composite groups.
     */
    public static function composite_groups_parameters() {
        $requirement = new external_single_structure(
                ['level' => new external_value(PARAM_FLOAT, 'The level for the requirement'),
                    'importance' => new external_value(PARAM_FLOAT,
                            'The importance for the requirement')
                ], 'Requirement values', VALUE_OPTIONAL);
        return new external_function_parameters(
                array(
                    'courseid' => new external_value(PARAM_INT,
                            'The identifier of the course to add the groups'),
                    'membersPerGroups' => new external_value(PARAM_INT,
                            'Number of memebrs per each group'),
                    'atMost' => new external_value(PARAM_BOOL,
                            'This is true if the member per group can not be more that the specified'),
                    'groupingName' => new external_value(PARAM_TEXT,
                            'Name of the grouping to generate'),
                    'namePattern' => new external_value(PARAM_TEXT,
                            'Pattern to generate the group names'),
                    'performance' => new external_value(PARAM_FLOAT,
                            'Value that indicates if the groups are under or over performance'),
                    'members' => new external_multiple_structure(
                            new external_single_structure(
                                    [
                                        'id' => new external_value(
                                                core_user::get_property_type('id'),
                                                'ID of the member'),
                                        'gender' => new external_value(PARAM_TEXT,
                                                'The gender of the member'),
                                        'personality' => new external_single_structure(
                                                [
                                                    'judgment' => new external_value(PARAM_FLOAT,
                                                            'The value for the personality judgment'),
                                                    'attitude' => new external_value(PARAM_FLOAT,
                                                            'The value for the personality attitude'),
                                                    'perception' => new external_value(PARAM_FLOAT,
                                                            'The value for the personality perception'),
                                                    'extrovert' => new external_value(PARAM_FLOAT,
                                                            'The value for the personality extrovert')
                                                ], 'Contains the member personality'),
                                        'competences' => new external_single_structure(
                                                [
                                                    'verbal' => new external_value(PARAM_FLOAT,
                                                            'The value for the competences verbal'),
                                                    'logic_mathematics' => new external_value(
                                                            PARAM_FLOAT,
                                                            'The value for the competences logic mathematics'),
                                                    'visual_spatial' => new external_value(
                                                            PARAM_FLOAT,
                                                            'The value for the competences visual_spatial'),
                                                    'kinestesica_corporal' => new external_value(
                                                            PARAM_FLOAT,
                                                            'The value for the competences kinestesica corporal'),
                                                    'musical_rhythmic' => new external_value(
                                                            PARAM_FLOAT,
                                                            'The value for the competences musical rhythmic'),
                                                    'intrapersonal' => new external_value(
                                                            PARAM_FLOAT,
                                                            'The value for the competences intrapersonal'),
                                                    'interpersonal' => new external_value(
                                                            PARAM_FLOAT,
                                                            'The value for the competences interpersonal'),
                                                    'naturalist_environmental' => new external_value(
                                                            PARAM_FLOAT,
                                                            'The value for the competences naturalist environmental')
                                                ], 'Contains the member personality')
                                    ]), 'The members that can be form part of a group'),
                    'requirements' => new external_single_structure(
                            ['verbal' => $requirement, 'logic_mathematics' => $requirement,
                                'visual_spatial' => $requirement,
                                'kinestesica_corporal' => $requirement,
                                'musical_rhythmic' => $requirement, 'intrapersonal' => $requirement,
                                'interpersonal' => $requirement,
                                'naturalist_environmental' => $requirement
                            ], 'The requirements for the groups')
                ));
    }

    /**
     * The function called to composite the new groups.
     */
    public static function composite_groups($courseid, $membersPerGroups, $atMost, $groupingName,
            $namePattern, $performance, $members, $requirements) {
        // default return values
        global $DB;
        $updated = false;
        $calculated = false;
        $message = '';

        try {
            $params = self::validate_parameters(self::composite_groups_parameters(),
                    array('courseid' => $courseid, 'membersPerGroups' => $membersPerGroups,
                        'atMost' => $atMost, 'groupingName' => $groupingName,
                        'namePattern' => $namePattern, 'performance' => $performance,
                        'members' => $members, 'requirements' => $requirements
                    ));

            $courseid = $params['courseid'];
            $membersPerGroups = $params['membersPerGroups'];
            $atMost = $params['atMost'];
            $groupingName = $params['groupingName'];
            $namePattern = $params['namePattern'];
            $performance = $params['performance'];
            $members = $params['members'];
            $requirements = $params['requirements'];

            $data = new \stdClass();
            $data->peoplePerTeam = intval($membersPerGroups);
            $data->atMost = boolval($atMost);
            $data->performance = floatVal($performance);
            $data->people = array();
            foreach ($members as $member) {

                $person = new \stdClass();
                $person->id = $member[id];
                $person->gender = $member[gender];
                $person->personality = array();
                $perception = new \stdClass();
                $perception->factor = 'PERCEPTION';
                $perception->value = floatVal($member[personality][perception]);
                $person->personality[] = $perception;
                $judgment = new \stdClass();
                $judgment->factor = 'JUDGMENT';
                $judgment->value = floatVal($member[personality][judgment]);
                $person->personality[] = $judgment;
                $extrovert = new \stdClass();
                $extrovert->factor = 'EXTROVERT';
                $extrovert->value = floatVal($member[personality][extrovert]);
                $person->personality[] = $extrovert;
                $attitude = new \stdClass();
                $attitude->factor = 'ATTITUDE';
                $attitude->value = floatVal($member[personality][attitude]);
                $person->personality[] = $attitude;
                $person->competences = array();
                $verbal = new \stdClass();
                $verbal->factor = 'VERBAL';
                $verbal->value = floatVal($member[competences][verbal]);
                $person->competences[] = $verbal;
                $logic_mathematics = new \stdClass();
                $logic_mathematics->factor = 'LOGIC_MATHEMATICS';
                $logic_mathematics->value = floatVal($member[competences][logic_mathematics]);
                $person->competences[] = $logic_mathematics;
                $visual_spatial = new \stdClass();
                $visual_spatial->factor = 'VISUAL_SPATIAL';
                $visual_spatial->value = floatVal($member[competences][visual_spatial]);
                $person->competences[] = $visual_spatial;
                $kinestesica_corporal = new \stdClass();
                $kinestesica_corporal->factor = 'KINESTESICA_CORPORAL';
                $kinestesica_corporal->value = floatVal($member[competences][kinestesica_corporal]);
                $person->competences[] = $kinestesica_corporal;
                $musical_rhythmic = new \stdClass();
                $musical_rhythmic->factor = 'MUSICAL_RHYTHMIC';
                $musical_rhythmic->value = floatVal($member[competences][musical_rhythmic]);
                $person->competences[] = $musical_rhythmic;
                $intrapersonal = new \stdClass();
                $intrapersonal->factor = 'INTRAPERSONAL';
                $intrapersonal->value = floatVal($member[competences][intrapersonal]);
                $person->competences[] = $intrapersonal;
                $interpersonal = new \stdClass();
                $interpersonal->factor = 'INTERPERSONAL';
                $interpersonal->value = floatVal($member[competences][interpersonal]);
                $person->competences[] = $interpersonal;
                $naturalist_environmental = new \stdClass();
                $naturalist_environmental->factor = 'NATURALIST_ENVIRONMENTAL';
                $naturalist_environmental->value = floatVal(
                        $member[competences][naturalist_environmental]);
                $person->competences[] = $naturalist_environmental;
                $data->people[] = $person;
            }

            $data->requirements = array();
            foreach ($requirements as $factor => $requirement) {

                $requirementData = new \stdClass();
                $requirementData->factor = strtoupper($factor);
                $requirementData->level = floatVal($requirement[level]);
                $requirementData->importance = floatVal($requirement[importance]);
                $data->requirements[] = $requirementData;
            }
            $payload = json_encode($data);
            $config = get_config('task_oriented_groups');
            $composite_url = str_replace('//composite', '/composite',
                    $config->base_api_url . '/composite');
            $options = array(CURLOPT_POST => 1, CURLOPT_HEADER => 0, CURLOPT_URL => $composite_url,
                CURLOPT_FRESH_CONNECT => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_FORBID_REUSE => 1,
                CURLOPT_TIMEOUT => 4, CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => array('Content-Type: application/json',
                    'Content-Length: ' . strlen($payload), 'Accept: application/json'
                )
            );

            $ch = curl_init();
            curl_setopt_array($ch, $options);
            if (!$response = curl_exec($ch)) {

                $message = print_r(curl_error($ch), TRUE);
            } else {

                $calculated = true;
                $teamsComposition = json_decode($response);
                if (count($teamsComposition->teams) > 0) {

                    $groupingData = new \stdClass();
                    $groupingData->name = $groupingName;
                    $groupingData->courseid = $courseid;
                    $groupingid = groups_create_grouping($groupingData);
                    if (!$groupingid) {

                        $message = "Could not create the grouping";
                    } else {

                        $index = 1;
                        foreach ($teamsComposition->teams as $team) {

                            $groupData = new \stdClass();
                            $groupData->courseid = $courseid;
                            $groupData->name = str_replace('{}', strval($index), $namePattern);
                            $groupData->description = '<ul>';
                            foreach ($team->people as $person) {

                                $groupData->description .= '<li><b>';
                                $user = $DB->get_record('user', array('id' => $person->id
                                ), '*', MUST_EXIST);
                                $groupData->description .= $user->firstname . ' ' . $user->lastname .
                                        '</b>';
                                $maxCompetences = count($person->competences);
                                if ($maxCompetences > 0) {
                                    $groupData->description .= ' ' . get_string(
                                            'externallib:group_description_reponsable_of',
                                            'block_task_oriented_groups');
                                    $competenceIndex = 1;
                                    foreach ($person->competences as $competence) {

                                        if ($competenceIndex == 1) {

                                            $groupData->description .= ' ';
                                        } else if ($competenceIndex == $maxCompetences) {

                                            $groupData->description .= ' ' . get_string(
                                                    'externallib:group_description_last_competence_and',
                                                    'block_task_oriented_groups') . ' ';
                                        } else {

                                            $groupData->description .= ', ';
                                        }

                                        $groupData->description .= get_string(
                                                'externallib:group_description_competence_' .
                                                strtolower($competence), 'block_task_oriented_groups');
                                        $competenceIndex++;
                                    }
                                } else {
                                    $groupData->description .= ' ' . get_string(
                                            'externallib:group_description_no_responsibility',
                                            'block_task_oriented_groups');
                                }
                                $groupData->description .= '</li>';
                            }
                            $groupData->description .= '</ul>';
                            $groupData->descriptionformat = FORMAT_HTML;
                            $groupid = groups_create_group($groupData);
                            if (!$groupid) {

                                $message .= "Could not create the group with " .
                                        print_r($groupData, TRUE);
                            } else {

                                if (!groups_assign_grouping($groupingid, $groupid)) {

                                    $message .= "Could not assign the group " . $groupid .
                                            " to the grouping " . $groupingid;
                                }
                                foreach ($team->people as $person) {

                                    if (!groups_add_member($groupid, $person->id)) {

                                        $message .= "\nCould not add the user " . $person->id .
                                                " to the group " . $groupid;
                                    }
                                }
                            }
                            $index++;
                        }

                        if (strlen($message) == 0) {
                            $updated = TRUE;
                        }
                    }
                } else {

                    $message = "No teams composed";
                }
            }
            curl_close($ch);
        } catch (\Throwable $e) {

            $message = $e->getMessage() . '\n' . $e->getTraceAsString();
        }
        $result = array();
        $result['success'] = $updated;
        $result['calculated'] = $calculated;
        $result['message'] = $message;
        return $result;
    }

    /**
     * The function called to get the informatiomn of the parameter to composite groups.
     */
    public static function composite_groups_returns() {
        return new external_single_structure(
                array(
                    'success' => new external_value(PARAM_BOOL,
                            'This is true if the grouping has been stored'),
                    'calculated' => new external_value(PARAM_BOOL,
                            'This is true if the groups has been calculated'),
                    'message' => new external_value(PARAM_TEXT,
                            'This contains a message that explains why is not calculated or stored')
                ));
    }
}