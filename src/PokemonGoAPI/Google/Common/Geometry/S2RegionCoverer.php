<?php

namespace PokemonGoAPI\Google\Common\Geometry;

use Exception;
use SplPriorityQueue;

class S2RegionCoverer {
    /**
     * By default, the covering uses at most 8 cells at any level. This gives a
     * reasonable tradeoff between the number of cells used and the accuracy of
     * the approximation (see table below).
     */
    const DEFAULT_MAX_CELLS = 8;

    private static function FACE_CELLS() {
        $result = array();
        for ($face = 0; $face < 6; ++$face) {
            $result[$face] = S2Cell::fromFacePosLevel($face, 0, 0);
        }
        return $result;
    }

    private $minLevel;
    private $maxLevel;
    private $levelMod;
    private $maxCells;

    // True if we're computing an interior covering.
    private $interiorCovering;

    // Counter of number of candidates created, for performance evaluation.
    private $candidatesCreatedCounter;

    /**
     * We save a temporary copy of the pointer passed to GetCovering() in order to
     * avoid passing this parameter around internally. It is only used (and only
     * valid) for the duration of a single GetCovering() call.
     * @var S2Region
     */
    private $region;

    /**
     * A temporary variable used by GetCovering() that holds the cell ids that
     * have been added to the covering so far.
     */
    private $result;

    /*  static class QueueEntry {
    private int id;
    private Candidate candidate;

    public QueueEntry(int id, Candidate candidate) {
      this.id = id;
      this.candidate = candidate;
    }
  }*/

    /**
     * We define our own comparison function on QueueEntries in order to make the
     * results deterministic. Using the default less<QueueEntry>, entries of equal
     * priority would be sorted according to the memory address of the candidate.
     */
    /*  static class QueueEntriesComparator implements Comparator<QueueEntry> {
        @Override
        public int compare(S2RegionCoverer.QueueEntry x, S2RegionCoverer.QueueEntry y) {
          return x.id < y.id ? 1 : (x.id > y.id ? -1 : 0);
        }
      }*/


    /**
     * We keep the candidates in a priority queue. We specify a vector to hold the
     * queue entries since for some reason priority_queue<> uses a deque by
     * default.
     */
    private $candidateQueue;

    /**
     * Default constructor, sets all fields to default values.
     */
    public function __construct() {
        $this->minLevel = 0;
        $this->maxLevel = S2CellId::MAX_LEVEL;
        $this->levelMod = 1;
        $this->maxCells = self::DEFAULT_MAX_CELLS;
        $this->region = null;
        $this->result = array();
        // TODO(kirilll?): 10 is a completely random number, work out a better
        // estimate
//    $this->candidateQueue = array();//new PriorityQueue<QueueEntry>(10, new QueueEntriesComparator());
        $this->candidateQueue = new SplPriorityQueue(); //new PriorityQueue<QueueEntry>(10, new QueueEntriesComparator());
    }

    // Set the minimum and maximum cell level to be used. The default is to use
    // all cell levels. Requires: max_level() >= min_level().
    //
    // To find the cell level corresponding to a given physical distance, use
    // the S2Cell metrics defined in s2.h. For example, to find the cell
    // level that corresponds to an average edge length of 10km, use:
    //
    // int level = S2::kAvgEdge.GetClosestLevel(
    // geostore::S2Earth::KmToRadians(length_km));
    //
    // Note: min_level() takes priority over max_cells(), i.e. cells below the
    // given level will never be used even if this causes a large number of
    // cells to be returned.

    /**
     * Sets the minimum level to be used.
     */
    public function setMinLevel($minLevel) {
        // assert (minLevel >= 0 && minLevel <= S2CellId.MAX_LEVEL);
        $this->minLevel = max(0, min(S2CellId::MAX_LEVEL, $minLevel));
    }

    /**
     * Sets the maximum level to be used.
     */
    public function setMaxLevel($maxLevel) {
        // assert (maxLevel >= 0 && maxLevel <= S2CellId.MAX_LEVEL);
        $this->maxLevel = max(0, min(S2CellId::MAX_LEVEL, $maxLevel));
    }

    public function minLevel() {
        return $this->minLevel;
    }

    public function maxLevel() {
        return $this->maxLevel;
    }

//  public int maxCells() {
//    return maxCells;
//  }

    /**
     * If specified, then only cells where (level - min_level) is a multiple of
     * "level_mod" will be used (default 1). This effectively allows the branching
     * factor of the S2CellId hierarchy to be increased. Currently the only
     * parameter values allowed are 1, 2, or 3, corresponding to branching factors
     * of 4, 16, and 64 respectively.
     */
//  public void setLevelMod(int levelMod) {
    // assert (levelMod >= 1 && levelMod <= 3);
//    this.levelMod = Math.max(1, Math.min(3, levelMod));
//  }

    public function levelMod() {
        return $this->levelMod;
    }

    /**
     * Sets the maximum desired number of cells in the approximation (defaults to
     * kDefaultMaxCells). Note the following:
     *
     * <ul>
     * <li>For any setting of max_cells(), up to 6 cells may be returned if that
     * is the minimum number of cells required (e.g. if the region intersects all
     * six face cells). Up to 3 cells may be returned even for very tiny convex
     * regions if they happen to be located at the intersection of three cube
     * faces.
     *
     * <li>For any setting of max_cells(), an arbitrary number of cells may be
     * returned if min_level() is too high for the region being approximated.
     *
     * <li>If max_cells() is less than 4, the area of the covering may be
     * arbitrarily large compared to the area of the original region even if the
     * region is convex (e.g. an S2Cap or S2LatLngRect).
     * </ul>
     *
     * Accuracy is measured by dividing the area of the covering by the area of
     * the original region. The following table shows the median and worst case
     * values for this area ratio on a test case consisting of 100,000 spherical
     * caps of random size (generated using s2regioncoverer_unittest):
     *
     * <pre>
     * max_cells: 3 4 5 6 8 12 20 100 1000
     * median ratio: 5.33 3.32 2.73 2.34 1.98 1.66 1.42 1.11 1.01
     * worst case: 215518 14.41 9.72 5.26 3.91 2.75 1.92 1.20 1.02
     * </pre>
     */
//  public void setMaxCells(int maxCells) {
//    this.maxCells = maxCells;
//  }

    /**
     * Computes a list of cell ids that covers the given region and satisfies the
     * various restrictions specified above.
     *
     * @param region The region to cover
     * @param S2CellId[] covering The list filled in by this method
     */
    public function getCovering(S2Region $region, &$covering) {
        // Rather than just returning the raw list of cell ids generated by
        // GetCoveringInternal(), we construct a cell union and then denormalize it.
        // This has the effect of replacing four child cells with their parent
        // whenever this does not violate the covering parameters specified
        // (min_level, level_mod, etc). This strategy significantly reduces the
        // number of cells returned in many cases, and it is cheap compared to
        // computing the covering in the first place.

        $tmp = new S2CellUnion();

        $this->interiorCovering = false;
        $this->getCoveringInternal($region);
        $tmp->initSwap($this->result);

        $tmp->denormalize($this->minLevel(), $this->levelMod(), $covering);
    }

    /**
     * Computes a list of cell ids that is contained within the given region and
     * satisfies the various restrictions specified above.
     *
     * @param region The region to fill
     * @param interior The list filled in by this method
     */
//  public void getInteriorCovering(S2Region region, ArrayList<S2CellId> interior) {
//    S2CellUnion tmp = getInteriorCovering(region);
//    tmp.denormalize(minLevel(), levelMod(), interior);
//  }

    /**
     * Return a normalized cell union that is contained within the given region
     * and satisfies the restrictions *EXCEPT* for min_level() and level_mod().
     */
//  public S2CellUnion getInteriorCovering(S2Region region) {
//    S2CellUnion covering = new S2CellUnion();
//    getInteriorCovering(region, covering);
//    return covering;
//  }

//  public void getInteriorCovering(S2Region region, S2CellUnion covering) {
//    interiorCovering = true;
//    getCoveringInternal(region);
//    covering.initSwap(result);
//  }

    /**
     * Given a connected region and a starting point, return a set of cells at the
     * given level that cover the region.
     */
//  public static void getSimpleCovering(
//      S2Region region, S2Point start, int level, ArrayList<S2CellId> output) {
//    floodFill(region, S2CellId.fromPoint(start).parent(level), output);
//  }

    /**
     * If the cell intersects the given region, return a new candidate with no
     * children, otherwise return null. Also marks the candidate as "terminal" if
     * it should not be expanded further.
     */
    private function newCandidate(S2Cell $cell) {
        if (!$this->region->mayIntersect($cell)) {
//        echo "null\n";
            return null;
        }

        $isTerminal = false;
        if ($cell->level() >= $this->minLevel) {
            if ($this->interiorCovering) {
                if ($this->region->contains($cell)) {
                    $isTerminal = true;
                } else if ($cell->level() + $this->levelMod > $this->maxLevel) {
                    return null;
                }
            } else {
                if ($cell->level() + $this->levelMod > $this->maxLevel || $this->region->contains($cell)) {
                    $isTerminal = true;
                }
            }
        }
        $candidate = new Candidate();
        $candidate->cell = $cell;
        $candidate->isTerminal = $isTerminal;
        if (!$isTerminal) {
            $candidate->children = array_pad(array(), 1 << $this->maxChildrenShift(), new Candidate);
        }
        $this->candidatesCreatedCounter++;
        return $candidate;
    }

    /** Return the log base 2 of the maximum number of children of a candidate. */
    private function maxChildrenShift() {
        return 2 * $this->levelMod;
    }

    /**
     * Process a candidate by either adding it to the result list or expanding its
     * children and inserting it into the priority queue. Passing an argument of
     * NULL does nothing.
     */
    private function addCandidate(Candidate $candidate = null) {
        if ($candidate == null) {
//        echo "\t addCandidate null\n";
            return;
        }

        if ($candidate->isTerminal) {
//        echo "\taddCandidato terminal: " . $candidate->cell->id() . "\n";
            $this->result[] = $candidate->cell->id();
            return;
        }
        // assert (candidate.numChildren == 0);

        // Expand one level at a time until we hit min_level_ to ensure that
        // we don't skip over it.
        $numLevels = ($candidate->cell->level() < $this->minLevel) ? 1 : $this->levelMod;
        $numTerminals = $this->expandChildren($candidate, $candidate->cell, $numLevels);

//      var_dump($candidate->numChildren);

        if ($candidate->numChildren == 0) {
//        echo "\tcandidate numChildred is zero\n";
            // Do nothing
        } else if (!$this->interiorCovering && $numTerminals == 1 << $this->maxChildrenShift()
            && $candidate->cell->level() >= $this->minLevel) {
            // Optimization: add the parent cell rather than all of its children.
            // We can't do this for interior coverings, since the children just
            // intersect the region, but may not be contained by it - we need to
            // subdivide them further.
            $candidate->isTerminal = true;
            echo "addCandidato recurse: " . $candidate->cell->id() . "\n";
            $this->addCandidate($candidate);
        } else {
            // We negate the priority so that smaller absolute priorities are returned
            // first. The heuristic is designed to refine the largest cells first,
            // since those are where we have the largest potential gain. Among cells
            // at the same level, we prefer the cells with the smallest number of
            // intersecting children. Finally, we prefer cells that have the smallest
            // number of children that cannot be refined any further.
            $priority = -(((($candidate->cell->level() << $this->maxChildrenShift()) + $candidate->numChildren) << $this->maxChildrenShift()) + $numTerminals);
//        echo "Push: " . $candidate . " ($priority)\n";
            $this->candidateQueue->insert($candidate, $priority);
            // logger.info("Push: " + candidate.cell.id() + " (" + priority + ") ");
        }
    }

    /**
     * Populate the children of "candidate" by expanding the given number of
     * levels from the given cell. Returns the number of children that were marked
     * "terminal".
     */
    private function expandChildren(Candidate $candidate, S2Cell $cell, $numLevels) {
        $numLevels--;
        $childCells = array();
        for ($i = 0; $i < 4; ++$i) {
            $childCells[$i] = new S2Cell();
        }
        $cell->subdivide($childCells);
        $numTerminals = 0;
        for ($i = 0; $i < 4; ++$i) {
            if ($numLevels > 0) {
                if ($this->region->mayIntersect($childCells[$i])) {
                    $numTerminals += $this->expandChildren($candidate, $childCells[$i], $numLevels);
                }
                continue;
            }
            $child = $this->newCandidate($childCells[$i]);
//        echo "child for " . $childCells[$i] . " is " . $child . "\n";

            if ($child != null) {
                $candidate->children[$candidate->numChildren++] = $child;
                if ($child->isTerminal) {
                    ++$numTerminals;
                }
            }
        }
        return $numTerminals;
    }

    /** Computes a set of initial candidates that cover the given region. */
    private function getInitialCandidates() {
        // Optimization: if at least 4 cells are desired (the normal case),
        // start with a 4-cell covering of the region's bounding cap. This
        // lets us skip quite a few levels of refinement when the region to
        // be covered is relatively small.
        if ($this->maxCells >= 4) {
            // Find the maximum level such that the bounding cap contains at most one
            // cell vertex at that level.
            $cap = $this->region->getCapBound();
            $level = min(
                S2Projections::MIN_WIDTH()->getMaxLevel(2 * $cap->angle()->radians()),
                min($this->maxLevel(), S2CellId::MAX_LEVEL - 1)
            );
            if ($this->levelMod() > 1 && $level > $this->minLevel()) {
                $level -= ($level - $this->minLevel()) % $this->levelMod();
            }
            // We don't bother trying to optimize the level == 0 case, since more than
            // four face cells may be required.
            if ($level > 0) {
                // Find the leaf cell containing the cap axis, and determine which
                // subcell of the parent cell contains it.
                /** @var S2CellId[] $base */
                $base = array();

                $s2point_tmp = $cap->axis();

                $id = S2CellId::fromPoint($s2point_tmp);
                $id->getVertexNeighbors($level, $base);
                for ($i = 0; $i < count($base); ++$i) {

//            printf("(face=%s pos=%s level=%s)\n", $base[$i]->face(), dechex($base[$i]->pos()), $base[$i]->level());
//            echo "new S2Cell(base[i])\n";
                    $cell = new S2Cell($base[$i]);
//            echo "neighbour cell: " . $cell . "\n";
                    $c = $this->newCandidate($cell);
//            if ($c !== null)
//            echo "addCandidato getInitialCandidates: " . $c->cell->id() . "\n";
                    $this->addCandidate($c);
                }

//          echo "\n\n\n";

                return;
            }
        }
        // Default: start with all six cube faces.
        $face_cells = self::FACE_CELLS();
        for ($face = 0; $face < 6; ++$face) {
            $c = $this->newCandidate($face_cells[$face]);
            echo "addCandidato getInitialCandidates_default: " . $c->cell->id() . "\n";
            $this->addCandidate($c);
        }
    }

    /** Generates a covering and stores it in result. */
    private function getCoveringInternal(S2Region $region) {
        // Strategy: Start with the 6 faces of the cube. Discard any
        // that do not intersect the shape. Then repeatedly choose the
        // largest cell that intersects the shape and subdivide it.
        //
        // result contains the cells that will be part of the output, while the
        // priority queue contains cells that we may still subdivide further. Cells
        // that are entirely contained within the region are immediately added to
        // the output, while cells that do not intersect the region are immediately
        // discarded.
        // Therefore pq_ only contains cells that partially intersect the region.
        // Candidates are prioritized first according to cell size (larger cells
        // first), then by the number of intersecting children they have (fewest
        // children first), and then by the number of fully contained children
        // (fewest children first).

        $tmp1 = $this->candidateQueue->isEmpty();
        if (!($tmp1 && count($this->result) == 0)) throw new Exception();

        $this->region = $region;
        $this->candidatesCreatedCounter = 0;

        $this->getInitialCandidates();
        while (!$this->candidateQueue->isEmpty() && (!$this->interiorCovering || $this->result->size() < $this->maxCells)) {
            $candidate = $this->candidateQueue->extract();

            // logger.info("Pop: " + candidate.cell.id());
//        echo "Pop: " . $candidate . "\n";
            if ($candidate->cell->level() < $this->minLevel || $candidate->numChildren == 1
                || $this->result->size() + ($this->interiorCovering ? 0 : $this->candidateQueue->size()) + $candidate->numChildren <= $this->maxCells) {
                // Expand this candidate into its children.
                for ($i = 0; $i < $candidate->numChildren; ++$i) {
                    $c = $candidate->children[$i];
//            echo "call addCandidate on $c\n";
                    $this->addCandidate($c);
                }
            } else if ($this->interiorCovering) {
                // Do nothing
            } else {
                $candidate->isTerminal = true;
                $this->addCandidate($candidate);
            }
        }

        unset($this->candidateQueue);
        $this->candidateQueue = new SplPriorityQueue();
        $this->region = null;
    }

    /**
     * Given a region and a starting cell, return the set of all the
     * edge-connected cells at the same level that intersect "region". The output
     * cells are returned in arbitrary order.
     *#/
     * private static void floodFill(S2Region region, S2CellId start, ArrayList<S2CellId> output) {
     * HashSet<S2CellId> all = new HashSet<S2CellId>();
     * ArrayList<S2CellId> frontier = new ArrayList<S2CellId>();
     * output.clear();
     * all.add(start);
     * frontier.add(start);
     * while (!frontier.isEmpty()) {
     * S2CellId id = frontier.get(frontier.size() - 1);
     * frontier.remove(frontier.size() - 1);
     * if (!region.mayIntersect(new S2Cell(id))) {
     * continue;
     * }
     * output.add(id);
     *
     * S2CellId[] neighbors = new S2CellId[4];
     * id.getEdgeNeighbors(neighbors);
     * for (int edge = 0; edge < 4; ++edge) {
     * S2CellId nbr = neighbors[edge];
     * boolean hasNbr = all.contains(nbr);
     * if (!all.contains(nbr)) {
     * frontier.add(nbr);
     * all.add(nbr);
     * }
     * }
     * }
     * }
     *
     */
}

class Candidate {
    public $cell;
    public $isTerminal; // Cell should not be expanded further.
    public $numChildren = 0; // Number of children that intersect the region.
    public $children; // Actual size may be 0, 4, 16, or 64 elements.
    public function __toString() {
        return sprintf("[%s t:%s n:%d]", $this->cell, $this->isTerminal ? 'true' : 'false', $this->numChildren);
    }
}
