<?php

namespace PokemonGoAPI\Google\Common\Geometry;

class S2LatLng {
    const EARTH_RADIUS_METERS = 6367000.0;

    /** @var double */
    private $latRadians;
    /** @var double */
    private $lngRadians;

    /**
     * @param $latRadians
     * @param $lngRadians
     * @return S2LatLng
     */
    public static function fromRadians($latRadians, $lngRadians) {
        return new S2LatLng($latRadians, $lngRadians);
    }

    /**
     * @param double $latDegrees
     * @param double $lngDegrees
     * @return S2LatLng
     */
    public static function fromDegrees($latDegrees, $lngDegrees) {
        return new S2LatLng(S1Angle::sdegrees($latDegrees), S1Angle::sdegrees($lngDegrees));
    }

    public static function fromE5($latE5, $lngE5) {
        return new S2LatLng(S1Angle::se5($latE5), S1Angle::se5($lngE5));
    }

    public static function fromE6($latE6, $lngE6) {
        return new S2LatLng(S1Angle::se6($latE6), S1Angle::se6($lngE6));
    }

    public static function fromE7($latE7, $lngE7) {
        return new S2LatLng(S1Angle::se7($latE7), S1Angle::se7($lngE7));
    }

    public static function latitude(S2Point $p) {
        // We use atan2 rather than asin because the input vector is not necessarily
        // unit length, and atan2 is much more accurate than asin near the poles.
        return S1Angle::sradians(
            atan2(
                $p->get(2),
                sqrt($p->get(0) * $p->get(0) + $p->get(1) * $p->get(1))
            )
        );
    }

    public static function longitude(S2Point $p) {
        // Note that atan2(0, 0) is defined to be zero.
        return S1Angle::sradians(atan2($p->get(1), $p->get(0)));
    }

    /**
     * This is internal to avoid ambiguity about which units are expected.
     * @param double|S1Angle $latRadians
     * @param double|S1Angle $lngRadians
     */
    public function __construct($latRadians = null, $lngRadians = null) {
        if ($latRadians instanceof S1Angle && $lngRadians instanceof S1Angle) {
            $this->latRadians = $latRadians->radians();
            $this->lngRadians = $lngRadians->radians();
        } else if ($lngRadians === null && $latRadians instanceof S2Point) {
            $this->latRadians = atan2($latRadians->z, sqrt($latRadians->x * $latRadians->x + $latRadians->y * $latRadians->y));
            $this->lngRadians = atan2($latRadians->y, $latRadians->x);
        } else if ($latRadians === null && $lngRadians === null) {
            $this->latRadians = 0;
            $this->lngRadians = 0;
        } else {
            $this->latRadians = $latRadians;
            $this->lngRadians = $lngRadians;
        }
    }

    /** Returns the latitude of this point as a new S1Angle. */
    public function lat() {
        return S1Angle::sradians($this->latRadians);
    }

    /** Returns the latitude of this point as radians. */
    public function latRadians() {
        return $this->latRadians;
    }

    /** Returns the latitude of this point as degrees. */
    public function latDegrees() {
        return 180.0 / M_PI * $this->latRadians;
    }

    /** Returns the longitude of this point as a new S1Angle. */
    public function lng() {
        return S1Angle::sradians($this->lngRadians);
    }

    /** Returns the longitude of this point as radians. */
    public function lngRadians() {
        return $this->lngRadians;
    }

    /** Returns the longitude of this point as degrees. */
    public function lngDegrees() {
        return 180.0 / M_PI * $this->lngRadians;
    }

    /**
     * Return true if the latitude is between -90 and 90 degrees inclusive and the
     * longitude is between -180 and 180 degrees inclusive.
     *#/
     * public boolean isValid() {
     * return Math.abs(lat().radians()) <= S2.M_PI_2 && Math.abs(lng().radians()) <= S2.M_PI;
     * }
     *
     * /**
     * Returns a new S2LatLng based on this instance for which {@link #isValid()}
     * will be {@code true}.
     * <ul>
     * <li>Latitude is clipped to the range {@code [-90, 90]}
     * <li>Longitude is normalized to be in the range {@code [-180, 180]}
     * </ul>
     * <p>If the current point is valid then the returned point will have the same
     * coordinates.
     *#/
     * public S2LatLng normalized() {
     * // drem(x, 2 * S2.M_PI) reduces its argument to the range
     * // [-S2.M_PI, S2.M_PI] inclusive, which is what we want here.
     * return new S2LatLng(Math.max(-S2.M_PI_2, Math.min(S2.M_PI_2, lat().radians())),
     * Math.IEEEremainder(lng().radians(), 2 * S2.M_PI));
     * }
     *
     * // Clamps the latitude to the range [-90, 90] degrees, and adds or subtracts
     * // a multiple of 360 degrees to the longitude if necessary to reduce it to
     * // the range [-180, 180].
     *
     * /** Convert an S2LatLng to the equivalent unit-length vector (S2Point). */
    public function toPoint() {
        $phi = $this->lat()->radians();
        $theta = $this->lng()->radians();
        $cosphi = cos($phi);
        return new S2Point(cos($theta) * $cosphi, sin($theta) * $cosphi, sin($phi));
    }

    /**
     * Return the distance (measured along the surface of the sphere) to the given
     * point.
     *#/
     * public S1Angle getDistance(final S2LatLng o) {
     * // This implements the Haversine formula, which is numerically stable for
     * // small distances but only gets about 8 digits of precision for very large
     * // distances (e.g. antipodal points). Note that 8 digits is still accurate
     * // to within about 10cm for a sphere the size of the Earth.
     * //
     * // This could be fixed with another sin() and cos() below, but at that point
     * // you might as well just convert both arguments to S2Points and compute the
     * // distance that way (which gives about 15 digits of accuracy for all
     * // distances).
     *
     * double lat1 = lat().radians();
     * double lat2 = o.lat().radians();
     * double lng1 = lng().radians();
     * double lng2 = o.lng().radians();
     * double dlat = Math.sin(0.5 * (lat2 - lat1));
     * double dlng = Math.sin(0.5 * (lng2 - lng1));
     * double x = dlat * dlat + dlng * dlng * Math.cos(lat1) * Math.cos(lat2);
     * return S1Angle.radians(2 * Math.atan2(Math.sqrt(x), Math.sqrt(Math.max(0.0, 1.0 - x))));
     * // Return the distance (measured along the surface of the sphere) to the
     * // given S2LatLng. This is mathematically equivalent to:
     * //
     * // S1Angle::FromRadians(ToPoint().Angle(o.ToPoint())
     * //
     * // but this implementation is slightly more efficient.
     * }
     *
     * /**
     * Returns the surface distance to the given point assuming a constant radius.
     *#/
     * public double getDistance(final S2LatLng o, double radius) {
     * // TODO(dbeaumont): Maybe check that radius >= 0 ?
     * return getDistance(o).radians() * radius;
     * }
     *
     * /**
     * Returns the surface distance to the given point assuming the default Earth
     * radius of {@link #EARTH_RADIUS_METERS}.
     *#/
     * public double getEarthDistance(final S2LatLng o) {
     * return getDistance(o, EARTH_RADIUS_METERS);
     * }
     *
     * /**
     * Adds the given point to this point.
     * Note that there is no guarantee that the new point will be <em>valid</em>.
     *#/
     * public S2LatLng add(final S2LatLng o) {
     * return new S2LatLng(latRadians + o.latRadians, lngRadians + o.lngRadians);
     * }
     *
     * /**
     * Subtracts the given point from this point.
     * Note that there is no guarantee that the new point will be <em>valid</em>.
     *#/
     * public S2LatLng sub(final S2LatLng o) {
     * return new S2LatLng(latRadians - o.latRadians, lngRadians - o.lngRadians);
     * }
     *
     * /**
     * Scales this point by the given scaling factor.
     * Note that there is no guarantee that the new point will be <em>valid</em>.
     */
    public function mul($m) {
        // TODO(dbeaumont): Maybe check that m >= 0 ?
        return new S2LatLng($this->latRadians * $m, $this->lngRadians * $m);
    }

    /*
  @Override
  public boolean equals(Object that) {
    if (that instanceof S2LatLng) {
      S2LatLng o = (S2LatLng) that;
      return (latRadians == o.latRadians) && (lngRadians == o.lngRadians);
    }
    return false;
  }

  @Override
  public int hashCode() {
    long value = 17;
    value += 37 * value + Double.doubleToLongBits(latRadians);
    value += 37 * value + Double.doubleToLongBits(lngRadians);
    return (int) (value ^ (value >>> 32));
  }

  /**
   * Returns true if both the latitude and longitude of the given point are
   * within {@code maxError} radians of this point.
   *#/
  public boolean approxEquals(S2LatLng o, double maxError) {
    return (Math.abs(latRadians - o.latRadians) < maxError)
        && (Math.abs(lngRadians - o.lngRadians) < maxError);
  }

  /#**
   * Returns true if the given point is within {@code 1e-9} radians of this
   * point. This corresponds to a distance of less than {@code 1cm} at the
   * surface of the Earth.
   *#/
  public boolean approxEquals(S2LatLng o) {
    return approxEquals(o, 1e-9);
  }
*/
    public function __toString() {
        return "(" . $this->latRadians . ", " . $this->lngRadians . ")";
    }

    public function toStringDegrees() {
        return "(" . $this->latDegrees() . ", " . $this->lngDegrees() . ")";
    }
}
