<?php

use App\Cart\Cart;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * @var Cart
     */
    protected $cart;

    public function setUp()
    {
        parent::setUp();

        $items = [
            [
                'id' => '1',
                'name' => 'item_1',
                'price' => 10
            ],
            [
                'id' => '2',
                'name' => 'item_2',
                'price' => 30
            ],
            [
                'id' => '3',
                'name' => 'item_3',
                'price' => 40
            ]
        ];
        $this->cart = new Cart();
        $this->cart->setItems($items);
    }

    public function testItCanAddItems()
    {
        $item = [
            'id' => '1',
            'name' => 'item_1',
            'price' => 10
        ];
        $cart = new Cart();

        $cart->add($item);
        static::assertEquals(1, $cart->count());
    }

    public function testItCanCalculateTheTotal()
    {
        static::assertEquals(80, $this->cart->total());
    }

    public function testItDoesNotAddDuplicateItems()
    {
        $this->cart->add([
            'id' => '1',
            'price' => 10
        ]);

        // should take quantity into account.
        static::assertEquals(4, $this->cart->count());
        $item = $this->cart->find('1');
        static::assertEquals(2, $item->quantity);
    }

    public function testItRemovesItems()
    {
        static::assertEquals($this->cart->count(), 3);
        $this->cart->remove('1');
        static::assertEquals($this->cart->count(), 2);
    }

    public function testItDecrementsItems()
    {
        $this->cart->increment('1');
        $item = $this->cart->find('1');
        static::assertEquals($item->quantity, 2);

        $this->cart->decrement('1');
        $item = $this->cart->find('1');
        static::assertEquals($item->quantity, 1);
        static::assertEquals($this->cart->count(), 3);
        $this->cart->decrement('1'); // removes it because none are left.
        static::assertEquals($this->cart->count(), 2);
    }

    public function testItIncrementsItemQuantity()
    {
        $item = $this->cart->find('1');
        static::assertEquals($item->quantity, 1);

        $this->cart->increment('1');
        $item = $this->cart->find('1');
        static::assertEquals($item->quantity, 2);
    }
}
