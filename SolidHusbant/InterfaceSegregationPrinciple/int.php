<?php

interface SuperHusband {
    public function eat();
    public function fixCar();
    public function knitSweater();
}


interface Eater {
    public function eat();
}

interface Mechanic {
    public function fixCar();
}

interface Knitter {
    public function knit();
}

class NotSuperHusband implements SuperHusband
{
    public function eat(){ /** Їсть*/ }

    public function fixCar()
    {
        throw new Exception();
    }

    public function knitSweater()
    {
        throw new Exception();
    }
}

class SmartHusband implements Eater, Mechanic
{
    public function eat(){ /** Їсть*/ }
    public function fixCar() { /** Ремонтує */ }
}
