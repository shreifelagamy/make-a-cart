<?php

class Cart
{
	/**
	* I will depend on SESSION to save the cart 
	*/

	protected $cart;
	public function __construct()
	{
		$this->cart = [];
	}

	public function setItems($items)
	{
		$this->cart = $items;
	}

	public function add($item) 
	{
		// check if cart is empty 
		if( count($this->cart) ) {
			foreach ($this->cart as $key => $cart_item) {

				/** 
				* Check if item id already exist 
				* if yes incrment quantity
				* if no just push to cart array 
				*/

				if( $cart_item['id'] == $item['id'] ) {
					$this->cart[$key]['price'] *= 2;
					$quantity = ( isset($this->cart[$key]['quantity']) ) ? $this->cart[$key]['quantity'] : 1;
					$quantity += 1;
					$this->cart[$key]['quantity'] = $quantity;
					break;
				}
				else {
					array_push($this->cart, $item);
					break;
				}
				
			}
		} 
		else {
			array_push($this->cart, $item);
		}
	}

	public function find($id)
	{
		$result = (OBJECT) "";
		$result->quantity = 0;
		foreach ($this->cart as $item) {
			if($item['id'] == $id) {
				$result->quantity = ( isset($item['quantity']) ) ? $item['quantity'] : 1;
				return $result;
			}
		}

		return $result;
	}

	public function count()
	{
		$count = 0;
		foreach ($this->cart as $item) {
			if( isset($item['quantity']) )
				$count += $item['quantity'];
			else 
				$count += 1;
		}
		return $count;
	}

	public function total()
	{	
		$total = 0;
		foreach ($this->cart as $item) {
			$total += $item['price'];
		}

		return $total;
	}

	public function remove($id)
	{
		foreach ($this->cart as $key => $item) {
			if( $item['id'] == $id )
				unset($this->cart[$key]);
		}
	}

	public function increment($id) 
	{
		foreach ($this->cart as $key => $item) {
			if($item['id'] == $id) {
				if( isset($item['quantity']) ) {
					$this->cart[$key]['quantity'] += 1;
				} 
				else {
					$this->cart[$key]['quantity'] = 1
				}
				// $quantity = ( isset($item['quantity']) )? $item['quantity']: 1;
				// $quantity += 1;
				// $this->cart[$key]['quantity'] = $quantity;
			}
		}
	}

	public function decrement($id)
	{
		foreach ($this->cart as $key => $item) {
			if($item['id'] == $id) {
				if( !isset($this->cart[$key]) || $this->cart[$key]['quantity'] == 1 ) {
					unset($this->cart[$key]);
				} else {
					$this->cart[$key]['quantity'] -= 1;	
				}
			}
		}
	}

	public function get_cart()
	{
		return $this->cart;
	}
}

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

	$cart = new Cart();
	$cart->setItems($items);

    $cart->increment('1');
    $cart->decrement('1');
	var_dump($item);