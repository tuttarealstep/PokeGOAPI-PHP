<?php

namespace PokemonGoAPI\Google\Common\Geometry;

class S1Angle {
    /** @var double */
    private $radians;

    /**
     * @return double
     */
    public function radians() {
        return $this->radians;
    }

    public static function sradians($radians) {
        return new S1Angle($radians);
    }

    /**
     * @return double
     */
    public function degrees() {
        return $this->radians * (180 / M_PI);
    }

    /**
     * @param double $degrees
     * @return S1Angle
     */
    public static function sdegrees($degrees) {
        return new S1Angle($degrees * (M_PI / 180));
    }

    public function e5() {
        return round($this->degrees() * 1e5);
    }

    public function e6() {
        return round($this->degrees() * 1e6);
    }

    public function e7() {
        return round($this->degrees() * 1e7);
    }

    /**
     * @param double|S2Point $radians_or_x
     * @param S2Point $y
     * Return the angle between two points, which is also equal to the distance
     * between these points on the unit sphere. The points do not need to be
     * normalized.
     */
    public function __construct($radians_or_x = null, $y = null) {
        if ($radians_or_x instanceof S2Point && $y instanceof S2Point) {
            $this->radians = $radians_or_x->angle($y);
        } else {
            $this->radians = $radians_or_x === null ? 0 : $radians_or_x;
        }
    }

    public function equals($that) {
        if ($that instanceof S1Angle) {
            return $this->radians() == $that->radians();
        }
        return false;
    }

    public function hashCode() {
//$value = Double.doubleToLongBits(radians);
//return (int) (value ^ (value >>> 32));
    }

    public function lessThan(S1Angle $that) {
        return $this->radians() < $that->radians();
    }

    public function greaterThan(S1Angle $that) {
        return $this->radians() > $that->radians();
    }

    public function lessOrEquals(S1Angle $that) {
        return $this->radians() <= $that->radians();
    }

    public function greaterOrEquals(S1Angle $that) {
        return $this->radians() >= $that->radians();
    }

    public static function max(S1Angle $left, S1Angle $right) {
        return $right->greaterThan($left) ? $right : $left;
    }

    public static function min(S1Angle $left, S1Angle $right) {
        return $right->greaterThan($left) ? $left : $right;
    }

    public static function se5($e5) {
        return self::sdegrees($e5 * 1e-5);
    }

    public static function se6($e6) {
        // Multiplying by 1e-6 isn't quite as accurate as dividing by 1e6,
        // but it's about 10 times faster and more than accurate enough.
        return self::sdegrees($e6 * 1e-6);
    }

    public static function se7($e7) {
        return self::sdegrees($e7 * 1e-7);
    }

    /**
     * Writes the angle in degrees with a "d" suffix, e.g. "17.3745d". By default
     * 6 digits are printed; this can be changed using setprecision(). Up to 17
     * digits are required to distinguish one angle from another.
     */
    public function toString() {
        return $this->degrees() . "d";
    }

    public function compareTo(S1Angle $that) {
        return $this->radians < $that->radians ? -1 : $this->radians > $that->radians ? 1 : 0;
    }
}
