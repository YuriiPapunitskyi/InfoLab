<?php

class Wife {
    public function serveFood() {
        return "домашній борщ";
    }
}

class Husband {
    private $wife;

    public function __construct() {
        $this->wife = new Wife();
    }

    public function eat() {
        echo "Їсть: " . $this->wife->serveFood();
    }
}
