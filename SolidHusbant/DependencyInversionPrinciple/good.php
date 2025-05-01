<?php

interface FoodProvider {
    public function serveFood();
}

class Wife implements FoodProvider {
    public function serveFood() {
        return "борщ від жінки";
    }
}

class Restaurant implements FoodProvider {
    public function serveFood() {
        return "ресторанний борщ";
    }
}

class SmartHusband {
    private FoodProvider $provider;

    public function __construct(FoodProvider $provider) {
        $this->provider = $provider;
    }

    public function eat() {
        echo "Їсть: " . $this->provider->serveFood();
    }
}