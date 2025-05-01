<?php

class Wife {
    public function cookBorscht(): string {
        return "справжній борщ – спадщина ЮНЕСКО";
    }

    public function reactToFeedback(string $feedback): void {
        echo "Дружина посміхається: '$feedback'\n";
    }
}

class SensitiveWife extends Wife {
    public function cookBorscht(): string {
        return "не тягне на ЮНЕСКО";
    }

    public function reactToFeedback(string $feedback): void {
        throw new Exception();
    }
}

function serveBorscht(Wife $wife): void {
    $borscht = $wife->cookBorscht();
    echo "Чоловік отримав: '$borscht'\n";

    if ($borscht !== "справжній борщ – спадщина ЮНЕСКО") {
        $wife->reactToFeedback("На спадщину ЮНЕСКО не тягне...");
    } else {
        $wife->reactToFeedback("Дуже смачно, дякую!");
    }
}
