<?php
namespace Chiquitto\SoulTest\Acl;

use Chiquitto\Soul\Db\Profiler\BjyProfilerProfiler;
use Chiquitto\Soul\Test\TestCase;

class BjyProfilerProfilerTest extends TestCase
{
    public function testClearProfiles()
    {
        $profiler = new BjyProfilerProfiler();

        $profiler->startQuery('Select * From table');
        $this->assertCount(1, $profiler->getQueryProfiles());

        $profiler->clearProfiles();
        $this->assertCount(0, $profiler->getQueryProfiles());
    }
}