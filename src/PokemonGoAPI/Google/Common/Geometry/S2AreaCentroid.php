<?php

namespace PokemonGoAPI\Google\Common\Geometry;

class S2AreaCentroid {
    /** @var double */
    private $area;
    /** @var S2Point */
    private $centroid;

    public function __construct($area, $centroid) {
        $this->area = $area;
        $this->centroid = $centroid;
    }

    public function getArea() {
        return $this->area;
    }

    public function getCentroid() {
        return $this->centroid;
    }
}
