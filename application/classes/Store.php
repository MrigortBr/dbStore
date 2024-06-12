<?php
class Product {
    public $id;
    public $title;
    public $image;
    public $price;

    public function __construct($id, $title, $image, $price) {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->price = $price;
    }
}
