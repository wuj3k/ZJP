<?php


class GildedRose
{
    /** @var OtherItem[] $items */
    private $items;

    function __construct($items)
    {
        $this->items = $items;
    }

    function update_quality()
    {
        foreach ($this->items as $item) {
            $item->checkPassDay();
            $item->checkQuality();
            $item->isLimit();
            $item->changeSellIn();
        }
    }
}

class OtherItem
{
    public $name;
    public $sell_in;
    public $quality;
    public $passDay = false;
    public $counter = 1;

    public function __construct($name, $sell_in, $quality)
    {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function __toString()
    {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

    public function changeQuality(int $number)
    {
        $this->quality -= $number;
    }

    public function isLimit()
    {
        if(($this->quality + $this->howManyDegradesQuality() >= 50) || ($this->quality + 2*$this->howManyDegradesQuality() >= 50)) $this->quality = 50;
    }

    public function checkQuality(): void
    {
        if ($this->quality - $this->howManyDegradesQuality() >= 0) $this->changeQuality($this->howManyDegradesQuality());
    }

    public function checkPassDay(): void
    {
        if ($this->sell_in <= 0) {
            $this->passDay = true;
            $this->counter = 2;
        }
    }

    public function changeSellIn(): void
    {
        $this->sell_in -= 1;
    }

    public function howManyDegradesQuality(int $number = 1): int
    {
        return $number * $this->counter;
    }
}

class AgedBrie extends OtherItem
{
    public function checkQuality(): void
    {
        $this->changeQuality($this->howManyDegradesQuality());
    }

    public function changeQuality(int $number)
    {
        $this->quality += $number;
    }
}

class Sulfuras extends OtherItem
{
    public function changeQuality(int $number)
    {
    }

    public function changeSellIn(): void
    {
    }

    public function isLimit()
    {
    }
}

class BackstagePasses extends OtherItem
{
    public function changeQuality(int $number)
    {
        $this->quality += $number;
    }

    public function howManyDegradesQuality(int $number = 1): int
    {
        if($this->sell_in <= 10 && $this->sell_in > 5) return 2;
        if($this->sell_in <= 5) return 3;
        return 1;
    }

    public function checkQuality(): void
    {
        parent::checkQuality();
        if($this->passDay) $this->quality = 0;
    }
}

class Conjured extends OtherItem
{
    public function howManyDegradesQuality(int $number = 1): int
    {
        return 2;
    }
}
