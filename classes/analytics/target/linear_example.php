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
 * Linear target example.
 *
 * @package   core
 * @copyright 2016 David Monllao {@link http://www.davidmonllao.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_testanalytics\analytics\target;

defined('MOODLE_INTERNAL') || die();

/**
 * Linear target example.
 *
 * @package   core
 * @copyright 2017 David Monllao {@link http://www.davidmonllao.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class linear_example extends \core_analytics\local\target\linear {

    /**
     * get_name
     *
     * @return string
     */
    public static function get_name() {
        return 'linear example';
    }

    /**
     * Overwrite default exception as this is just for testing.
     *
     * @return bool
     */
    public function is_linear() {
        return true;
    }

    /**
     * get_max_value
     *
     * @return float
     */
    public static function get_max_value() {
        return 10.0;
    }

    /**
     * get_min_value
     *
     * @return float
     */
    public static function get_min_value() {
        return 0.0;
    }

    /**
     * get_analyser_class
     *
     * @return string
     */
    public function get_analyser_class() {
        return '\local_testanalytics\analytics\analyser\config_settings';
    }

    /**
     * get_callback_boundary
     *
     * @return false
     */
    public function get_callback_boundary() {
        return false;
    }

    /**
     * is_valid_analysable
     *
     * @param \core_analytics\analysable $analysable
     * @param mixed $fortraining
     * @return true|string
     */
    public function is_valid_analysable(\core_analytics\analysable $analysable, $fortraining = true) {
        // The analysable is the site, so yes, it is always valid.
        return true;
    }

    /**
     * Only process samples which start date is getting close.
     *
     * @param int $sampleid
     * @param \core_analytics\analysable $analysable
     * @param bool $fortraining
     * @return true|string
     */
    public function is_valid_sample($sampleid, \core_analytics\analysable $analysable, $fortraining = true) {

        // Just to have a criterion to separate training data from prediction data.
        $config = $this->retrieve('config', $sampleid);
        if ($fortraining && strstr($config->name, 'a') !== false) {
            return false;
        }

        return true;
    }

    /**
     * calculate_sample
     *
     * @param int $sampleid
     * @param \core_analytics\analysable $analysable
     * @param int $starttime
     * @param int $endtime
     * @return float
     */
    protected function calculate_sample($sampleid, \core_analytics\analysable $analysable, $starttime = false, $endtime = false) {
        return (int)rand(0, 10);
    }
}
