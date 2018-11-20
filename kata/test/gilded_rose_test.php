<?php

use PHPUnit\Framework\TestCase;

require_once 'gilded_rose.php';

class GildedRoseTest extends TestCase
{

    /**
     * test podnoszenia quality przedmiotu aged brie
     */
    public function testRiseQualityAgedBrie()
    {
        $items = [new Item("Aged Brie", 5, 20)];
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(21, $items[0]->quality);
    }

    /**
     * test negatywnej ilosci towaru
     */
    public function testNeverQualityNegative()
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(0, $items[0]->quality);
    }

    /**
     * test spadania jakości dwa razy szybciej po uplynięciu dnia zakupu
     */
    public function testQualityDegradesTwiceAsFast()
    {
        $items = [new Item('Banany Prutas', -1, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(8, $items[0]->quality);
    }

    /**
     * nie moze byc wiecej niz 50 jakosci
     */
    public function testNeverMoreThanFifty()
    {
        $items = [new Item('Aged Brie', 10, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(50, $items[0]->quality);
    }

    /**
     * nie mozna nigdy sprzedac reki ragnara ani nie spada jakosc
     */
    public function testNeverBeSold()
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 20)];
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(20, $items[0]->quality);
        $this->assertEquals(10, $items[0]->sell_in);
    }

    /**
     * test backstage passes
     */
    public function testBackstagePasses()
    {
        $items = [
            new Item('Backstage passes to a TAFKAL80ETC concert', 6, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', 4, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', -1, 20),
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(22, $items[0]->quality);
        $this->assertEquals(23, $items[1]->quality);
        $this->assertEquals(0, $items[2]->quality);
    }
}
