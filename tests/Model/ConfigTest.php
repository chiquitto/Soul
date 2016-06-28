<?php

namespace DinaZendTest\Model;

use Chiquitto\Soul\Test\TestCase;
use Chiquitto\SoulTest\Classes\Model\Config1;


/**
 * Description of ConfigTest
 *
 * @author chiquitto
 */
class ConfigTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        Config1::getInstance()->clearCache();
        Config1::clearInstance();
    }

    public function testGetAll()
    {
        $actual = Config1::getInstance()->getAll();
        $this->assertCount(7, $actual);
    }

    public function testGetParamType()
    {
        $expected = Config1::getInstance()->getParamType(Config1::PARAM_ID);
        $this->assertEquals($expected, Config1::TYPE_INT);

        $expected = Config1::getInstance()->getParamType(Config1::PARAM_NAME);
        $this->assertEquals($expected, Config1::TYPE_STRING);
    }

    public function testGetVarPadrao()
    {
        $config = Config1::getInstance();

        $expected = $this->invokeMethod($config, 'getVarPadrao', [Config1::PARAM_BOOLEAN_F]);
        $this->assertEquals($expected, false);

        $expected = $this->invokeMethod($config, 'getVarPadrao', [Config1::PARAM_BOOLEAN_T]);
        $this->assertEquals($expected, true);
    }

    public function testLoadConfig()
    {
        $config = Config1::getInstance();

        // force clear cache
        $cacheFile = $config->getCacheFile();
        $this->assertFileExists($cacheFile);
        $config->clearCache();
        $this->assertFileNotExists($cacheFile);
        $config->clearInstance();

        // create instance & create cache
        $config = Config1::getInstance();
        $this->assertFileExists($cacheFile);
        $expected = $config->get(Config1::PARAM_ID);
        $config->clearInstance();

        // create instance from cache file
        $config = Config1::getInstance();
        $actual = $config->get(Config1::PARAM_ID);
        $config->clearInstance();

        $this->assertEquals($expected, $actual);
    }

    public function testSetTypeBoolean()
    {
        $expected = 'abc';

        $config = Config1::getInstance();
        $config->set(Config1::PARAM_BOOLEAN_T, $expected);
        $config->clearCache();
        $config->clearInstance();

        $this->assertEquals((boolean)$expected, Config1::getInstance()->get(Config1::PARAM_BOOLEAN_T));
    }

    public function testSetTypeFloat()
    {
        $expected = '3.1415';

        $config = Config1::getInstance();
        $config->set(Config1::PARAM_VALUE, $expected);
        $config->clearCache();
        $config->clearInstance();

        $this->assertEquals((float)$expected, Config1::getInstance()->get(Config1::PARAM_VALUE));
    }

    public function testSetTypeInt()
    {
        $expected = '3.1415';

        $config = Config1::getInstance();
        $config->set(Config1::PARAM_ID, $expected);
        $config->clearCache();
        $config->clearInstance();

        $this->assertEquals((int)$expected, Config1::getInstance()->get(Config1::PARAM_ID));
    }

    public function testSetInvalidParam()
    {
        $this->expectException(\Zend\Validator\Exception\InvalidArgumentException::class);

        $config = Config1::getInstance();
        $config->set('INVALID', 1);
    }

    public function testSetTypeObject()
    {
        $expected = (object)array(
            'name' => 'John Doe',
            'age' => mt_rand(25, 40),
        );

        $config = Config1::getInstance();
        $config->set(Config1::PARAM_CLIENT, $expected);
        $config->clearCache();
        $config->clearInstance();

        $this->assertEquals($expected, Config1::getInstance()->get(Config1::PARAM_CLIENT));
    }
}
