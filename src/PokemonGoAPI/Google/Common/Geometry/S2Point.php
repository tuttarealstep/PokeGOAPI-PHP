<?php

namespace PokemonGoAPI\Google\Common\Geometry;

class S2Point {
    // coordinates of the points
    public $x;
    public $y;
    public $z;

    public function __construct($x = null, $y = null, $z = null) {
        if ($z === null || $y === null || $x === null) $this->x = $this->y = $this->z = 0;
        else {
            $this->x = $x;
            $this->y = $y;
            $this->z = $z;
        }
    }

    public static function minus(S2Point $p1, S2Point $p2) {
        return self::sub($p1, $p2);
    }

    public static function neg(S2Point $p) {
        return new S2Point(-$p->x, -$p->y, -$p->z);
    }

    public function norm2() {
        return $this->x * $this->x + $this->y * $this->y + $this->z * $this->z;
    }

    public function norm() {
        return sqrt($this->norm2());
    }

    public static function crossProd(S2Point $p1, S2Point $p2) {
        return new S2Point(
            $p1->y * $p2->z - $p1->z * $p2->y,
            $p1->z * $p2->x - $p1->x * $p2->z,
            $p1->x * $p2->y - $p1->y * $p2->x
        );
    }

    public static function add(S2Point $p1, S2Point $p2) {
        return new S2Point($p1->x + $p2->x, $p1->y + $p2->y, $p1->z + $p2->z);
    }

    public static function sub(S2Point $p1, S2Point $p2) {
        return new S2Point($p1->x - $p2->x, $p1->y - $p2->y, $p1->z - $p2->z);
    }

    public function dotProd(S2Point $that) {
        return $this->x * $that->x + $this->y * $that->y + $this->z * $that->z;
    }

    public static function mul(S2Point $p, $m) {
        return new S2Point($m * $p->x, $m * $p->y, $m * $p->z);
    }

    public static function div(S2Point $p, $m) {
        return new S2Point($p->x / $m, $p->y / $m, $p->z / $m);
    }

    /** return a vector orthogonal to this one */
    public function ortho() {
        $k = $this->largestAbsComponent();
        if ($k == 1) {
            $temp = new S2Point(1, 0, 0);
        } else if ($k == 2) {
            $temp = new S2Point(0, 1, 0);
        } else {
            $temp = new S2Point(0, 0, 1);
        }
        return S2Point::normalize($this->crossProd($this, $temp));
    }

    /** Return the index of the largest component fabs */
    public function largestAbsComponent() {
        $temp = $this->fabs($this);
        if ($temp->x > $temp->y) {
            if ($temp->x > $temp->z) {
                return 0;
            } else {
                return 2;
            }
        } else {
            if ($temp->y > $temp->z) {
                return 1;
            } else {
                return 2;
            }
        }
    }

    public static function fabs(S2Point $p) {
        return new S2Point(abs($p->x), abs($p->y), abs($p->z));
    }

    public static function normalize(S2Point $p) {
        $norm = $p->norm();
        if ($norm != 0) {
            $norm = 1.0 / $norm;
        }
        return S2Point::mul($p, $norm);
    }

    public function get($axis) {
        return ($axis == 0) ? $this->x : (($axis == 1) ? $this->y : $this->z);
    }

    /** Return the angle between two vectors in radians */
    public function angle(S2Point $va) {
        return atan2($this->crossProd($this, $va)->norm(), $this->dotProd($va));
    }

    /**
     * Compare two vectors, return true if all their components are within a
     * difference of margin.
     */
    private function aequal(S2Point $that, $margin) {
        return (abs($this->x - $that->x) < $margin) && (abs($this->y - $that->y) < $margin)
            && (abs($this->z - $that->z) < $margin);
    }

    public function equals($that) {
        if (!($that instanceof S2Point)) {
            return false;
        }
        $thatPoint = $that;
        return $this->x == $thatPoint->x && $this->y == $thatPoint->y && $this->z == $thatPoint->z;
    }

    public function lessThan(S2Point $vb) {
        if ($this->x < $vb->x) {
            return true;
        }
        if ($vb->x < $this->x) {
            return false;
        }
        if ($this->y < $vb->y) {
            return true;
        }
        if ($vb->y < $this->y) {
            return false;
        }
        if ($this->z < $vb->z) {
            return true;
        }
        return false;
    }

    public function compareTo(S2Point $other) {
        return ($this->lessThan($other) ? -1 : ($this->equals($other) ? 0 : 1));
    }

    public function toString() {
        return "(" . $this->x . ", " . $this->y . ", " . $this->z . ")";
    }

    public function toDegreesString() {
        $s2LatLng = new S2LatLng($this);
        return "(" . $s2LatLng->latDegrees() . ", "
            . $s2LatLng->lngDegrees() . ")";
    }

    /**
     * Calcualates hashcode based on stored coordinates. Since we want +0.0 and
     * -0.0 to be treated the same, we ignore the sign of the coordinates.
     */
    public function hashCode() {
        $value = 17;
//      $value += 37 * $value + Double.doubleToLongBits(Math.abs(x));
//      $value += 37 * $value + Double.doubleToLongBits(Math.abs(y));
//      $value += 37 * $value + Double.doubleToLongBits(Math.abs(z));
//      return (int) ($value ^ ($value >>> 32));
    }
}
