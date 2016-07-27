<?php
// Generated by https://github.com/bramp/protoc-gen-php// Please include protocolbuffers before this file, for example:
//   require('protocolbuffers.inc.php');
//   require('POGOProtos/Data/Player/DailyBonus.php');

namespace POGOProtos\Data\Player {

  use Protobuf;
  use ProtobufIO;
  use ProtobufMessage;

  // message POGOProtos.Data.Player.DailyBonus
  final class DailyBonus extends ProtobufMessage {

    private $_unknown;
    private $nextCollectedTimestampMs = 0; // optional int64 next_collected_timestamp_ms = 1
    private $nextDefenderBonusCollectTimestampMs = 0; // optional int64 next_defender_bonus_collect_timestamp_ms = 2

    public function __construct($in = null, &$limit = PHP_INT_MAX) {
      parent::__construct($in, $limit);
    }

    public function read($fp, &$limit = PHP_INT_MAX) {
      $fp = ProtobufIO::toStream($fp, $limit);
      while(!feof($fp) && $limit > 0) {
        $tag = Protobuf::read_varint($fp, $limit);
        if ($tag === false) break;
        $wire  = $tag & 0x07;
        $field = $tag >> 3;
        switch($field) {
          case 1: // optional int64 next_collected_timestamp_ms = 1
            if($wire !== 0) {
              throw new \Exception("Incorrect wire format for field $field, expected: 0 got: $wire");
            }
            $tmp = Protobuf::read_signed_varint($fp, $limit);
            if ($tmp === false) throw new \Exception('Protobuf::read_varint returned false');
            if ($tmp < Protobuf::MIN_INT64 || $tmp > Protobuf::MAX_INT64) throw new \Exception('int64 out of range');$this->nextCollectedTimestampMs = $tmp;

            break;
          case 2: // optional int64 next_defender_bonus_collect_timestamp_ms = 2
            if($wire !== 0) {
              throw new \Exception("Incorrect wire format for field $field, expected: 0 got: $wire");
            }
            $tmp = Protobuf::read_signed_varint($fp, $limit);
            if ($tmp === false) throw new \Exception('Protobuf::read_varint returned false');
            if ($tmp < Protobuf::MIN_INT64 || $tmp > Protobuf::MAX_INT64) throw new \Exception('int64 out of range');$this->nextDefenderBonusCollectTimestampMs = $tmp;

            break;
          default:
            $limit -= Protobuf::skip_field($fp, $wire);
        }
      }
    }

    public function write($fp) {
      if ($this->nextCollectedTimestampMs !== 0) {
        fwrite($fp, "\x08", 1);
        Protobuf::write_varint($fp, $this->nextCollectedTimestampMs);
      }
      if ($this->nextDefenderBonusCollectTimestampMs !== 0) {
        fwrite($fp, "\x10", 1);
        Protobuf::write_varint($fp, $this->nextDefenderBonusCollectTimestampMs);
      }
    }

    public function size() {
      $size = 0;
      if ($this->nextCollectedTimestampMs !== 0) {
        $size += 1 + Protobuf::size_varint($this->nextCollectedTimestampMs);
      }
      if ($this->nextDefenderBonusCollectTimestampMs !== 0) {
        $size += 1 + Protobuf::size_varint($this->nextDefenderBonusCollectTimestampMs);
      }
      return $size;
    }

    public function clearNextCollectedTimestampMs() { $this->nextCollectedTimestampMs = 0; }
    public function getNextCollectedTimestampMs() { return $this->nextCollectedTimestampMs;}
    public function setNextCollectedTimestampMs($value) { $this->nextCollectedTimestampMs = $value; }

    public function clearNextDefenderBonusCollectTimestampMs() { $this->nextDefenderBonusCollectTimestampMs = 0; }
    public function getNextDefenderBonusCollectTimestampMs() { return $this->nextDefenderBonusCollectTimestampMs;}
    public function setNextDefenderBonusCollectTimestampMs($value) { $this->nextDefenderBonusCollectTimestampMs = $value; }

    public function __toString() {
      return ''
           . Protobuf::toString('next_collected_timestamp_ms', $this->nextCollectedTimestampMs, 0)
           . Protobuf::toString('next_defender_bonus_collect_timestamp_ms', $this->nextDefenderBonusCollectTimestampMs, 0);
    }

    // @@protoc_insertion_point(class_scope:POGOProtos.Data.Player.DailyBonus)
  }

}