<?php

namespace SoulTest\Model\Vo;

use ArrayIterator;
use Iterator;
use PHPUnit_Framework_Error_Notice;
use Soul\Exception\Exception;
use Soul\Exception\InvalidArgumentException;
use Soul\Model\Vo\Item;
use Soul\Model\Vo\ValidatorItem;
use Soul\Test\TestCase;
use Soul\Util\String;
use SoulTest\Classes\Model\Vo\Item1;
use SoulTest\Classes\Model\Vo\Item2;
use SoulTest\Classes\Model\Vo\Itemset1;

class ItemTest extends TestCase {

    private function getDataPopulate() {
        $alfabeto = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $id = 1;
        $string = str_repeat(uniqid(), mt_rand(5, 15));
        $string1 = $alfabeto[mt_rand(0, 25)];
        $string255 = String::randomString(255);
        $string50 = String::randomString(50);
        $float = mt_rand(1, 99) / 100;
        $bool = (bool) mt_rand(0, 1);
        $timestamp = strtotime('next year');
        $decimal18_2 = round(mt_rand(1, 99999) + (mt_rand(1, 99) / 100), 2);
        $decimal18_4 = round(mt_rand(1, 99999) + (mt_rand(1, 9999) / 10000), 4);
        $list = str_split(String::randomString(mt_rand(5, 25)));
        $iterator = new ArrayIterator(str_split(String::randomString(mt_rand(5, 25))));
        $object = (object) array(
                    'string' => String::randomString(mt_rand(5, 25)),
                    'number' => mt_rand(100, 200),
        );
        $text = String::randomString(mt_rand(500, 1000));
        $method = str_repeat(uniqid(), mt_rand(5, 15));

        $item = new Item1(array(
            'id' => mt_rand(1, 999)
        ));

        $itemset = new Itemset1();
        $itemset->add(new Item1(array(
            'id' => mt_rand(1, 999)
        )));
        $itemset->add(new Item1(array(
            'id' => mt_rand(1, 999)
        )));
        $itemset->add(new Item1(array(
            'id' => mt_rand(1, 999)
        )));

        return array(
            'id' => $id,
            'string' => $string,
            'string1' => $string1,
            'string255' => $string255,
            'string50' => $string50,
            'float' => $float,
            'bool' => $bool,
            'timestamp' => $timestamp,
            'decimal18_2' => $decimal18_2,
            'decimal18_4' => $decimal18_4,
            'list' => $list,
            'iterator' => $iterator,
            'object' => $object,
            'text' => $text,
            'method' => $method,
            'item' => $item,
            'itemset' => $itemset,
        );
    }

    public function testClearData() {
        $itemVo = new Item1(array(
            'id' => 1
        ));

        $this->assertAttributeEquals(array(
            'id' => 1
                ), 'data', $itemVo);

        $itemVo->clearData();

        $this->assertAttributeEquals(array(), 'data', $itemVo);
    }

    /**
     * Testa se o construtor esta executando o populate
     */
    public function testConstructPopulate() {
        $dataExpected = $this->getDataPopulate();
        $itemVo = new Item1($dataExpected);

        $this->populate_assertData($dataExpected, $itemVo);
    }

    public function testGetAll() {
        $dataExpected = $this->getDataPopulate();
        $itemVo = new Item1($dataExpected);
        
        $actual = $itemVo->getAll();
        $this->assertEquals($dataExpected['id'], $actual['id']);
    }

    public function testGetAllFilledFalse() {
        $dataExpected = $this->getDataPopulate();
        unset($dataExpected['string']);
        
        $itemVo = new Item1($dataExpected);
        
        $actual = $itemVo->getAllValues(Item::GETALL_ARRAY, [
            'onlyFilled' => false,
        ]);
        $this->assertTrue(isset($actual['id']));
        $this->assertFalse(isset($actual['string']));
    }
    
    /**
     * Testa se o metodo Item::getAll retorna a mesma coisa que o Itemset::getAll
     */
    public function testGetAllItem() {
        $data = $this->getDataPopulate();

        $itemVo = new Item1($data);
        $type = Item::GETALL_ARRAY;

        $actual = $this->invokeMethod($itemVo, 'getAllItem', [
            $type,
            $itemVo->itemset,
            []
        ]);
        $this->assertEquals($itemVo->itemset->getAll($type, []), $actual);

        $actual = $this->invokeMethod($itemVo, 'getAllItem', [
            $type,
            $itemVo->item,
            []
        ]);
        $this->assertEquals($itemVo->item->getAll($type, []), $actual);
    }

    public function testGetAllStdclass() {
        $dataExpected = $this->getDataPopulate();

        // remover o iterator, porque o (object) nao faz casting interno
        $dataExpected['iterator'] = null;
        $dataExpected['item'] = null;
        $dataExpected['itemset'] = null;

        $itemVo = new Item1($dataExpected);

        $actual = $itemVo->getAll(Item::GETALL_STDCLASS);
        $this->assertEquals((object) $dataExpected, $actual);
    }

    public function testGetAllWithIgnore() {
        $dataExpected = $this->getDataPopulate();
        $itemVo = new Item1($dataExpected);

        unset($dataExpected['id']);

        $actual = $itemVo->getAll(Item::GETALL_ARRAY, array(
            'ignore' => ['id']
        ));
        $this->assertEquals($dataExpected['string'], $actual['string']);
    }

    public function testGetSet() {
        $itemVo = new Item1();
        $expected = 10;

        $itemVo->setId($expected);
        $this->assertEquals($expected, $itemVo->getId());

        $itemVo->set('id', $expected);
        $this->assertEquals($expected, $itemVo->get('id'));

        $itemVo->id = $expected;
        $this->assertEquals($expected, $itemVo->id);
    }
    
    public function testGetTable()
    {
        $itemVo = new Item2();
        $this->assertEquals('tbclient', $itemVo->getTable());
    }
    
    public function testGetTablePkVal()
    {
        $expected = 50;
        $itemVo = new Item2(['id' => $expected]);
        $this->assertEquals($expected, $itemVo->getTablePkVal());
    }
    
    public function testGetTablePkValException()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        
        $itemVo = new Item1();
        $itemVo->getTablePkVal();
    }

    public function testGetMethod() {
        $itemVo = new Item1();

        $expected = 10;

        $itemVo->method = ++$expected;
        $actual = $itemVo->get('method');
        $this->assertSame($expected, $actual);

        $itemVo->set('method', ++$expected);
        $actual = $itemVo->get('method');
        $this->assertSame($expected, $actual);

        $itemVo->setMethod(++$expected);
        $actual = $itemVo->get('method');
        $this->assertSame($expected, $actual);

        $itemVo->method = ++$expected;
        $actual = $itemVo->getMethod();
        $this->assertSame($expected, $actual);

        $itemVo->method = ++$expected;
        $actual = $itemVo->method;
        $this->assertSame($expected, $actual);
    }

    public function testGetTypes() {
        $data = $this->getDataPopulate();
        $itemVo = new Item1($data);

        $actual = array_keys($itemVo->getTypes());
        $this->assertEquals(array_keys($data), $actual);
    }

    public function testGetUndefinedField() {
        $itemVo = new Item1();

        try {
            $v = $itemVo->get('notexists');
        } catch (Exception $exc) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exc);
        }

        $expected = 10;
        $actual = $itemVo->get('notexists', false, $expected);
        $this->assertSame($expected, $actual);
    }

    public function testIsset() {
        $itemVo = new Item1();

        $this->assertFalse(isset($itemVo->id));

        $itemVo->id = 10;

        $this->assertTrue(isset($itemVo->id));
    }

    public function testNewValidateItem() {
        $itemVo = new Item1();

        $this->assertInstanceOf(ValidatorItem::class, $itemVo->newValidateItem());
    }

    public function testPopulate() {
        $dataExpected = $this->getDataPopulate();
        $itemVo = new Item1();
        $itemVo->populate($dataExpected);

        $this->populate_assertData($dataExpected, $itemVo);
    }

    public function testPopulateUndefinedField() {
        $itemVo = new Item1();
        $itemVo->populate(array(
            'notexists' => mt_rand(10, 99)
        ));

        try {
            $itemVo->get('notexists');
        } catch (Exception $exc) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exc);
        }

        $this->assertEquals(null, $itemVo->get('notexists', false));
    }

    public function testSet() {
        $dataExpected = $this->getDataPopulate();
        $itemVo = new Item1();

        foreach ($dataExpected as $k => $v) {
            $itemVo->set($k, $v);
            $this->assertEquals($v, $itemVo->get($k));
        }
    }

    public function testSetExceptions() {
        $dataExpected = $this->getDataPopulate();
        $itemVo = new Item1();
        
        unset($dataExpected['method']);

        foreach ($dataExpected as $k => $v) {
            switch ($k) {
                case 'id':
                case 'float':
                case 'bool':
                case 'timestamp':
                case 'decimal18_2':
                case 'decimal18_4':
                case 'list':
                case 'iterator':
                case 'object':
                case 'item':
                case 'itemset':
                    $v = 'a';
                    break;
                
                case 'string':
                case 'string1':
                case 'string255':
                case 'string50':
                case 'text':
                    $v = 1;
                    break;
            }
            
            try {
                $itemVo->set($k, $v);
            } catch (PHPUnit_Framework_Error_Notice $exc) {
                die($exc);
            } catch (Exception $exc) {
                $this->assertInstanceOf(InvalidArgumentException::class, $exc);
                continue;
            }

            $this->fail("Valor de $k nao testado");
        }
    }
    
    public function testSetUnknowType() {
        $this->setExpectedException(InvalidArgumentException::class);
        
        $itemVo = new Item1();
        $itemVo->unknow = 1;
    }

    public function testUndefinedMethod() {
        $this->setExpectedException(InvalidArgumentException::class);

        $itemVo = new Item1();
        $itemVo->notexists();
    }

    private function populate_assertData($expected, Item $actual) {
        foreach ($expected as $k => $v) {
            switch ($k) {
                case 'id':
                    $this->populate_assertFieldId($v, $actual);
                    break;

                case 'string':
                    $this->populate_assertFieldString($v, $actual);
                    break;

                case 'string1':
                    $this->populate_assertFieldString1($v, $actual);
                    break;

                case 'string255':
                    $this->populate_assertFieldString255($v, $actual);
                    break;

                case 'int':
                    $this->populate_assertFieldInt($v, $actual);
                    break;

                case 'float':
                    $this->populate_assertFieldFloat($v, $actual);
                    break;

                case 'bool':
                    $this->populate_assertFieldBool($v, $actual);
                    break;

                case 'timestamp':
                    $this->populate_assertFieldTimestamp($v, $actual);
                    break;

                case 'decimal18_2':
                    $this->populate_assertFieldDecimal18_2($v, $actual);
                    break;

                case 'decimal18_4':
                    $this->populate_assertFieldDecimal18_4($v, $actual);
                    break;

                case 'list':
                    $this->populate_assertFieldList($v, $actual);
                    break;

                case 'iterator':
                    $this->populate_assertFieldIterator($v, $actual);
                    break;

                case 'object':
                    $this->populate_assertFieldObject($v, $actual);
                    break;

                case 'text':
                    $this->populate_assertFieldText($v, $actual);
                    break;

                default:
                    break;
            }
        }
    }

    private function populate_assertFieldId($expected, Item $actual) {
        foreach ([$actual->get('id'), $actual->getId(), $actual->id] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('int', $value);
        }

        $this->assertEquals($actual->get('id'), $actual->getId());
        $this->assertEquals($actual->get('id'), $actual->id);
    }

    private function populate_assertFieldString($expected, Item $actual) {
        foreach ([$actual->get('string'), $actual->getString(), $actual->string] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('string', $value);
        }

        $this->assertEquals($actual->get('string'), $actual->getString());
        $this->assertEquals($actual->get('string'), $actual->string);
    }

    private function populate_assertFieldString1($expected, Item $actual) {
        foreach ([$actual->get('string1'), $actual->getString1(), $actual->string1] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('string', $value);
        }

        $this->assertEquals($actual->get('string1'), $actual->getString1());
        $this->assertEquals($actual->get('string1'), $actual->string1);

        $this->assertEquals(1, strlen($actual->get('string1')));
    }

    private function populate_assertFieldString255($expected, Item $actual) {
        foreach ([$actual->get('string255'), $actual->getString255(), $actual->string255] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('string', $value);
        }

        $this->assertEquals($actual->get('string255'), $actual->getString255());
        $this->assertEquals($actual->get('string255'), $actual->string255);

        $this->assertEquals(255, strlen($actual->get('string255')));
    }

    private function populate_assertFieldInt($expected, Item $actual) {
        foreach ([$actual->get('int'), $actual->getInt(), $actual->int] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('int', $value);
        }

        $this->assertEquals($actual->get('int'), $actual->getInt());
        $this->assertEquals($actual->get('int'), $actual->int);
    }

    private function populate_assertFieldFloat($expected, Item $actual) {
        foreach ([$actual->get('float'), $actual->getFloat(), $actual->float] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('float', $value);
        }

        $this->assertEquals($actual->get('float'), $actual->getFloat());
        $this->assertEquals($actual->get('float'), $actual->float);
    }

    private function populate_assertFieldBool($expected, Item $actual) {
        foreach ([$actual->get('bool'), $actual->getBool(), $actual->bool] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('bool', $value);
        }

        $this->assertEquals($actual->get('bool'), $actual->getBool());
        $this->assertEquals($actual->get('bool'), $actual->bool);
    }

    private function populate_assertFieldTimestamp($expected, Item $actual) {
        foreach ([$actual->get('timestamp'), $actual->getTimestamp(), $actual->timestamp] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('int', $value);
        }

        $this->assertEquals($actual->get('timestamp'), $actual->getTimestamp());
        $this->assertEquals($actual->get('timestamp'), $actual->timestamp);
    }

    private function populate_assertFieldDecimal18_2($expected, Item $actual) {
        foreach ([$actual->get('decimal18_2'), $actual->getDecimal18_2(), $actual->decimal18_2] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('float', $value);
        }

        $this->assertEquals($actual->get('decimal18_2'), $actual->getDecimal18_2());
        $this->assertEquals($actual->get('decimal18_2'), $actual->decimal18_2);
    }

    private function populate_assertFieldDecimal18_4($expected, Item $actual) {
        foreach ([$actual->get('decimal18_4'), $actual->getDecimal18_4(), $actual->decimal18_4] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('float', $value);
        }

        $this->assertEquals($actual->get('decimal18_4'), $actual->getDecimal18_4());
        $this->assertEquals($actual->get('decimal18_4'), $actual->decimal18_4);
    }

    private function populate_assertFieldList($expected, Item $actual) {
        foreach ([$actual->get('list'), $actual->getList(), $actual->list] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('array', $value);
        }

        $this->assertEquals($actual->get('list'), $actual->getList());
        $this->assertEquals($actual->get('list'), $actual->list);
    }

    private function populate_assertFieldIterator($expected, Item $actual) {
        foreach ([$actual->get('iterator'), $actual->getIterator(), $actual->iterator] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInstanceOf(Iterator::class, $value);
        }

        $this->assertEquals($actual->get('iterator'), $actual->getIterator());
        $this->assertEquals($actual->get('iterator'), $actual->iterator);
    }

    private function populate_assertFieldObject($expected, Item $actual) {
        foreach ([$actual->get('object'), $actual->getObject(), $actual->object] as $value) {
            $this->assertEquals($expected, $value);
        }

        $this->assertEquals($actual->get('object'), $actual->getObject());
        $this->assertEquals($actual->get('object'), $actual->object);
    }

    private function populate_assertFieldText($expected, Item $actual) {
        foreach ([$actual->get('text'), $actual->getText(), $actual->text] as $value) {
            $this->assertEquals($expected, $value);
            $this->assertInternalType('string', $value);
        }

        $this->assertEquals($actual->get('text'), $actual->getText());
        $this->assertEquals($actual->get('text'), $actual->text);
    }

}
