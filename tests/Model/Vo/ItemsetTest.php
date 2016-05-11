<?php

namespace SoulTest\Model\Vo;

use Soul\Model\Vo\ValidatorItemset;
use Soul\Test\TestCase;
use SoulTest\Classes\Model\Vo\Item1;
use SoulTest\Classes\Model\Vo\Itemset1;

class ItemsetTest extends TestCase
{

    public function testAddIndexed()
    {
        $itemset = new Itemset1();

        $itemVo1 = new Item1(['id' => 10]);
        $itemVo2 = new Item1(['id' => 20]);

        $itemset->addIndexed($itemVo1, 1000);
        $itemset->addIndexed($itemVo2, 2000);

        $this->assertEquals($itemVo1->id, $itemset->getById(1000)->id);
        $this->assertEquals($itemVo2->id, $itemset->getById(2000)->id);
    }

    public function testCount()
    {
        $itemset = new Itemset1();
        $this->assertEquals(0, $itemset->count());

        $itemset->add(new Item1());
        $this->assertEquals(1, $itemset->count());

        $itemset->add(new Item1());
        $this->assertEquals(2, $itemset->count());

        // test twice
        $this->assertEquals(2, $itemset->count());

        $itemset->clear();
        $this->assertEquals(0, $itemset->count());
    }

    public function testGetAll()
    {
        $item1 = new Item1([
            'id' => 1,
        ]);
        $item2 = new Item1([
            'id' => 2,
        ]);

        $itemset = new Itemset1();
        $itemset->add($item1);
        $itemset->add($item2);

        $all = $itemset->getAll();
        $this->assertInternalType('array', $all);

        $this->assertEquals(1, $all[0]['id']);
        $this->assertEquals(2, $all[1]['id']);
    }

    public function testKey()
    {
        $itemset = new Itemset1();
        $itemset->add(new Item1());
        $itemset->add(new Item1());
        $itemset->add(new Item1());

        $this->assertEquals(0, $itemset->key());
        $itemset->next();
        $this->assertEquals(1, $itemset->key());
        $itemset->next();
        $this->assertEquals(2, $itemset->key());

        $itemset->next();
        $this->assertEquals(null, $itemset->key());
    }

    public function testNewValidateItemset()
    {
        $itemset = new Itemset1();
        $this->assertInstanceOf(ValidatorItemset::class, $itemset->newValidateItemset());
    }

    public function testNextRewind()
    {
        $item1 = new Item1([
            'id' => 1,
        ]);
        $item2 = new Item1([
            'id' => 2,
        ]);

        $itemset = new Itemset1();
        $itemset->add($item1);
        $itemset->add($item2);

        $expected = $itemset->current()->getId();
        $this->assertEquals($expected, $item1->getId());

        $expected = $itemset->next()->getId();
        $this->assertEquals($expected, $item2->getId());

        $itemset->rewind();
        $expected = $itemset->current()->getId();
        $this->assertEquals($expected, $item1->getId());
    }

    public function testSet()
    {
        $item1 = new Item1([
            'id' => 1,
        ]);
        $item2 = new Item1([
            'id' => 2,
        ]);
        $item3 = new Item1([
            'id' => 3,
        ]);

        $itemset = new Itemset1();
        $itemset->add($item1);
        $itemset->add($item3);

        $expected = $itemset->current();
        $this->assertEquals($expected->id, $item1->id);

        $itemset->set($item3);
        $expected = $itemset->current();
        $this->assertEquals($expected->id, $item3->id);

        $itemset->set($item3, 1);
        $expected = $itemset->next();
        $this->assertEquals($expected->id, $item3->id);
    }

    public function testValid()
    {
        $itemset = new Itemset1();

        // before add itens valid return false
        $this->assertEquals(false, $itemset->valid());

        $itemset->add(new Item1());
        $itemset->add(new Item1());

        // test after add itens
        $this->assertEquals(true, $itemset->valid());
        $itemset->next();
        $this->assertEquals(true, $itemset->valid());

        // next to an undefined item
        $itemset->next();
        $this->assertEquals(false, $itemset->valid());
    }

}
