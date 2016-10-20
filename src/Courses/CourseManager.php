<?php

namespace Flip\Axcelerate\Courses;

use Flip\Axcelerate\Manager;
use Flip\Axcelerate\ManagerContract;
use Flip\Axcelerate\Courses\Instance;
use Flip\Axcelerate\Exceptions\AxcelerateException;

class CourseManager extends Manager implements ManagerContract
{
    /**
     * Find an instance with attributes
     *
     * @param array $attributes Attributes to match with
     * @return Instance|null
     */
    public function findInstance($attributes)
    {
        $instances = $this->searchForInstances($attributes);

        if (count($instances) > 1) {
            throw new AxcelerateException('Search attributes were not specific enough to find a single instance.');
        }

        return $instances ? $instances[0] : null;
    }

    /**
     * Search for instances that match the attributes
     *
     * @param array $attributes Attributes to match with
     * @return Instance[]
     */
    public function searchForInstances($attributes)
    {
        // Default search parameters
        $defaults = [
            'startDate_min' => date('Y-m-d', time() - 3153600000), // 100 years ago
            'startDate_max' => date('Y-m-d', time() + 3153600000), // 100 years from now
            'finishDate_min' => date('Y-m-d', time() - 3153600000), // 100 years ago
            'finishDate_max' => date('Y-m-d', time() + 3153600000), // 100 years from now
            'enrolmentOpen' => true,
            'public' => true
        ];

        $instances = [];

        if ($response = $this->getConnection()->post('course/instance/search', array_merge($defaults, $attributes))) {
            foreach ($response as $instance) {
                $instances[] = new Instance($instance, $this);
            }
        }

        return $instances;
    }
}
