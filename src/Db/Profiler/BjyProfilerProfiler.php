<?php

namespace Chiquitto\Soul\Db\Profiler;

use BjyProfiler\Db\Profiler\Profiler;

/**
 * Description of Profiler
 *
 * @author alisson
 */
class BjyProfilerProfiler extends Profiler {

    public function clearProfiles() {
        $this->profiles = [];
    }

}
