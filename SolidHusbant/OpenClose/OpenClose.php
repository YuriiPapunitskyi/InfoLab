<?php

class BorschtProvider {
    public function getBorscht($type) {
        if ($type == "звичайний") {
            return "борщ";
        } elseif ($type == "з авокадо") {
            return "модний борщ";
        }
    }
}

//good
interface Borscht {
    public function serve();
}

class ClassicBorscht implements Borscht {
    public function serve() {
        return "звичайний борщ";
    }
}

class AvocadoBorscht implements Borscht {
    public function serve() {
        return "модний борщ";
    }
}

class Husband {
    public function eat(Borscht $borscht) {
        echo "Їсть: " . $borscht->serve();
    }
}

