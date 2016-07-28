<?php

namespace PokemonGoAPI\Google\Common\Geometry;

class R2Vector {
    private $x;
    private $y;

    public function __construct($x = null, $y = null) {
        if ($x !== null && $y !== null) {
            $this->x = $x;
            $this->y = $y;
        } else if ($x != null) {
            if (!is_array($x) || count($x) != 2) throw new \Exception("Points must have exactly 2 coordinates");
            $this->x = $x[0];
            $this->y = $x[1];
        } else {
            $this->x = 0;
            $this->y = 0;
        }
    }

    public function x() {
        return $this->x;
    }

    public function y() {
        return $this->y;
    }

    public function get($index) {
        if ($index > 1) {
            throw new \Exception($index);
        }
        return $index == 0 ? $this->x : $this->y;
    }

    public static function add(R2Vector $p1, R2Vector $p2) {
        return new R2Vector($p1->x + $p2->x, $p1->y + $p2->y);
    }

    public static function mul(R2Vector $p, $m) {
        return new R2Vector($m * $p->x, $m * $p->y);
    }

    public function norm2() {
        return ($this->x * $this->x) + ($this->y * $this->y);
    }

    public static function sdotProd(R2Vector $p1, R2Vector $p2) {
        return ($p1->x * $p2->x) + ($p1->y * $p2->y);
    }

    public function dotProd(R2Vector $that) {
        return self::sdotProd($this, $that);
    }

    public function crossProd(R2Vector $that) {
        return $this->x * $that->y - $this->y * $that->x;
    }

    public function lessThan(R2Vector $vb) {
        if ($this->x < $vb->x) {
            return true;
        }
        if ($vb->x < $this->x) {
            return false;
        }
        if ($this->y < $vb->y) {
            return true;
        }
        return false;
    }

    public function equals($that) {
        if (!($that instanceof R2Vector)) {
            return false;
        }
        $thatPoint = $that;
        return $this->x == $thatPoint->x && $this->y == $thatPoint->y;
    }

    /**
     * Calculates hashcode based on stored coordinates. Since we want +0.0 and
     * -0.0 to be treated the same, we ignore the sign of the coordinates.
     */
    public function hashCode() {
        $value = 17;
        //$value += 37 * $value + Double.doubleToLongBits(abs($this->x));
        //$value += 37 * $value + Double.doubleToLongBits(abs($this->y));
        //return (int) ($value ^ ($value >>> 32));
    }

    public function toString() {
        return "(" . $this->x . ", " . $this->y . ")";
    }
}
