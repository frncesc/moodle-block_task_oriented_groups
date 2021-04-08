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
/**
 * General configurations of the block.
 *
 * @package block_tog
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
if ($ADMIN->fulltree) {

    // Introductory explanation.
    $settings->add(
            new admin_setting_heading('block_tog/pluginname', '',
                    new lang_string('settings:heading', 'block_tog')));

    // The URL to the SAAS
    $settings->add(
            new admin_setting_configtext('block_tog/base_api_url',
                    new lang_string('settings:base_api_url_title', 'block_tog'),
                    new lang_string('settings:base_api_url_description',
                            'block_tog'), 'https://eduteams.iiia.csic.es/saas/',
                    PARAM_URL));
}