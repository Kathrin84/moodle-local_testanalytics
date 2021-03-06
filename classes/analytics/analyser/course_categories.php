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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   core
 * @copyright 2017 David Monllao {@link http://www.davidmonllao.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_testanalytics\analytics\analyser;

defined('MOODLE_INTERNAL') || die();

/**
 *
 * @package   core
 * @copyright 2017 David Monllao {@link http://www.davidmonllao.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_categories extends \core_analytics\local\analyser\sitewide {

    /**
     *
     * @return string
     */
    public function get_samples_origin() {
        return 'course_categories';
    }

    /**
     * Returns the sample analysable
     *
     * @param int $sampleid
     * @return \core_analytics\analysable
     */
    public function get_sample_analysable($sampleid) {
        return new \core_analytics\site();
    }

    /**
     * Data this analyer samples provide.
     *
     * @return string[]
     */
    protected function provided_sample_data() {
        return array('course_categories');
    }

    /**
     * Returns the sample context.
     *
     * @param int $sampleid
     * @return \context
     */
    public function sample_access_context($sampleid) {
        return \context_coursecat::instance($sampleid);
    }

    /**
     * Returns all site samples.
     *
     * @param \core_analytics\analysable $site
     * @return array
     */
    protected function get_all_samples(\core_analytics\analysable $site) {
        global $DB;

        $coursecats = $DB->get_records('course_categories');

        $coursecatids = array_keys($coursecats);
        $sampleids = array_combine($coursecatids, $coursecatids);

        $data = array_map(function($coursecat) {
            return array('course_categories' => $coursecat);
        }, $coursecats);

        // No related data attached.
        return array($sampleids, $data);
    }

    /**
     * Return all complete samples data from sample ids.
     *
     * @param int[] $sampleids
     * @return array
     */
    public function get_samples($sampleids) {
        global $DB;

        list($sql, $params) = $DB->get_in_or_equal($sampleids, SQL_PARAMS_NAMED);
        $coursecats = $DB->get_records_select('course_categories', "id $sql", $params);

        $coursecatids = array_keys($coursecats);
        $sampleids = array_combine($coursecatids, $coursecatids);

        $data = array_map(function($coursecat) {
            return array('course_categories' => $coursecat);
        }, $coursecats);

        // No related data attached.
        return array($sampleids, $data);
    }

    /**
     * Returns the description of a sample.
     *
     * @param int $sampleid
     * @param int $contextid
     * @param array $sampledata
     * @return array array(string, \renderable)
     */
    public function sample_description($sampleid, $contextid, $sampledata) {
        $description = $sampledata['course_categories']->name;
        $image = new \pix_icon('i/course', get_string('view'));
        return array($description, $image);
    }
}
