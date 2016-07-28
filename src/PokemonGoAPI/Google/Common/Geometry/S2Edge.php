<?php

namespace PokemonGoAPI\Google\Common\Geometry;

/**
 * An abstract directed edge from one S2Point to another S2Point.
 */

class S2Edge {
    /** @var S2Point */
    private $start;
    /** @var S2Point */
    private $end;

    /**
     * @param S2Point $start
     * @param S2Point $end
     */
    public function __construct($start, $end) {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \S2Point
     */
    public function getStart() {
        return $this->start;
    }

    public function getEnd() {
        return $this->end;
    }

    public function toString() {
        return sprintf(
            "Edge: (%s -> %s)\n   or [%s -> %s]",
            $this->start->toDegreesString(),
            $this->end->toDegreesString(),
            $this->start,
            $this->end
        );
    }

    public function hashCode() {
        return $this->getStart()->hashCode() - $this->getEnd()->hashCode();
    }

    public function equals($o) {
        if ($o == null || !($o instanceof S2Edge)) {
            return false;
        }
        $other = $o;
        return $this->getStart()->equals($other->getStart()) && $this->getEnd()->equals($other->getEnd());
    }
}
