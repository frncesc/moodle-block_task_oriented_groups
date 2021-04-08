<?php
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
 * Web service block plugin template external functions and service definitions.
 *
 * @package block_tog
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// We defined the web service functions to install.
$functions = array(
    'block_tog_store_personality_answer' => array(
        'classname' => 'block_tog_external',
        'methodname' => 'store_personality_answer',
        'classpath' => 'blocks/tog/externallib.php',
        'description' => 'Allow to store the user answer to a question of the personality test',
        'type' => 'write', 'ajax' => true
    ),
    'block_tog_store_intelligences_answer' => array(
        'classname' => 'block_tog_external',
        'methodname' => 'store_intelligences_answer',
        'classpath' => 'blocks/tog/externallib.php',
        'description' => 'Allow to store the user answer to a question of the intelligences test',
        'type' => 'write', 'ajax' => true
    ),
    'block_tog_composite_groups' => array(
        'classname' => 'block_tog_external', 'methodname' => 'composite_groups',
        'classpath' => 'blocks/tog/externallib.php',
        'description' => 'Allow to composite the groups', 'type' => 'write', 'ajax' => true
    ),
    'block_tog_auto_fill_in_personality' => array(
        'classname' => 'block_tog_external',
        'methodname' => 'auto_fill_in_personality',
        'classpath' => 'blocks/tog/externallib.php',
        'description' => 'Allow to auto fill in the personality test of an user', 'type' => 'write',
        'ajax' => true
    ),
    'block_tog_auto_fill_in_intelligences' => array(
        'classname' => 'block_tog_external',
        'methodname' => 'auto_fill_in_intelligences',
        'classpath' => 'blocks/tog/externallib.php',
        'description' => 'Allow to auto fill in the intelligences test of an user',
        'type' => 'write', 'ajax' => true
    ),
    'block_tog_feedback_group' => array(
        'classname' => 'block_tog_external', 'methodname' => 'feedback_group',
        'classpath' => 'blocks/tog/externallib.php',
        'description' => 'Allow to prodice feedback of a composed group', 'type' => 'write',
        'ajax' => true
    )
);
// We define the services to install as pre-build services. A pre-build service is not editable by
// administrator.
$services = array(
    'tog' => array(
        'functions' => array('block_tog_store_personality_answer',
            'block_tog_store_intelligences_answer',
            'block_tog_composite_groups',
            'block_tog_feedback_group'
        ), 'restrictedusers' => 0, 'enabled' => 1
    )
);