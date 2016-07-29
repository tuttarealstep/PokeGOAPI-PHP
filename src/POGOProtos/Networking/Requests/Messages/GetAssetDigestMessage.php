<?php
// Generated by https://github.com/bramp/protoc-gen-php// Please include protocolbuffers before this file, for example:
//   require('protocolbuffers.inc.php');
//   require('POGOProtos/Networking/Requests/Messages/GetAssetDigestMessage.php');

namespace POGOProtos\Networking\Requests\Messages {

  use POGOProtos\Enums\Platform;
  use Protobuf;
  use ProtobufIO;
  use ProtobufMessage;


  // message POGOProtos.Networking.Requests.Messages.GetAssetDigestMessage
  final class GetAssetDigestMessage extends ProtobufMessage {

    private $_unknown;
    private $platform = Platform::UNSET; // optional .POGOProtos.Enums.Platform platform = 1
    private $deviceManufacturer = ""; // optional string device_manufacturer = 2
    private $deviceModel = ""; // optional string device_model = 3
    private $locale = ""; // optional string locale = 4
    private $appVersion = 0; // optional uint32 app_version = 5

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
          case 1: // optional .POGOProtos.Enums.Platform platform = 1
            if($wire !== 0) {
              throw new \Exception("Incorrect wire format for field $field, expected: 0 got: $wire");
            }
            $tmp = Protobuf::read_varint($fp, $limit);
            if ($tmp === false) throw new \Exception('Protobuf::read_varint returned false');
            $this->platform = $tmp;

            break;
          case 2: // optional string device_manufacturer = 2
            if($wire !== 2) {
              throw new \Exception("Incorrect wire format for field $field, expected: 2 got: $wire");
            }
            $len = Protobuf::read_varint($fp, $limit);
            if ($len === false) throw new \Exception('Protobuf::read_varint returned false');
            $tmp = Protobuf::read_bytes($fp, $len, $limit);
            if ($tmp === false) throw new \Exception("read_bytes($len) returned false");
            $this->deviceManufacturer = $tmp;

            break;
          case 3: // optional string device_model = 3
            if($wire !== 2) {
              throw new \Exception("Incorrect wire format for field $field, expected: 2 got: $wire");
            }
            $len = Protobuf::read_varint($fp, $limit);
            if ($len === false) throw new \Exception('Protobuf::read_varint returned false');
            $tmp = Protobuf::read_bytes($fp, $len, $limit);
            if ($tmp === false) throw new \Exception("read_bytes($len) returned false");
            $this->deviceModel = $tmp;

            break;
          case 4: // optional string locale = 4
            if($wire !== 2) {
              throw new \Exception("Incorrect wire format for field $field, expected: 2 got: $wire");
            }
            $len = Protobuf::read_varint($fp, $limit);
            if ($len === false) throw new \Exception('Protobuf::read_varint returned false');
            $tmp = Protobuf::read_bytes($fp, $len, $limit);
            if ($tmp === false) throw new \Exception("read_bytes($len) returned false");
            $this->locale = $tmp;

            break;
          case 5: // optional uint32 app_version = 5
            if($wire !== 0) {
              throw new \Exception("Incorrect wire format for field $field, expected: 0 got: $wire");
            }
            $tmp = Protobuf::read_varint($fp, $limit);
            if ($tmp === false) throw new \Exception('Protobuf::read_varint returned false');
            if ($tmp < Protobuf::MIN_UINT32 || $tmp > Protobuf::MAX_UINT32) throw new \Exception('uint32 out of range');$this->appVersion = $tmp;

            break;
          default:
            $limit -= Protobuf::skip_field($fp, $wire);
        }
      }
    }

    public function write($fp) {
      if ($this->platform !== Platform::UNSET) {
        fwrite($fp, "\x08", 1);
        Protobuf::write_varint($fp, $this->platform);
      }
      if ($this->deviceManufacturer !== "") {
        fwrite($fp, "\x12", 1);
        Protobuf::write_varint($fp, strlen($this->deviceManufacturer));
        fwrite($fp, $this->deviceManufacturer);
      }
      if ($this->deviceModel !== "") {
        fwrite($fp, "\x1a", 1);
        Protobuf::write_varint($fp, strlen($this->deviceModel));
        fwrite($fp, $this->deviceModel);
      }
      if ($this->locale !== "") {
        fwrite($fp, "\"", 1);
        Protobuf::write_varint($fp, strlen($this->locale));
        fwrite($fp, $this->locale);
      }
      if ($this->appVersion !== 0) {
        fwrite($fp, "(", 1);
        Protobuf::write_varint($fp, $this->appVersion);
      }
    }

    public function size() {
      $size = 0;
      if ($this->platform !== Platform::UNSET) {
        $size += 1 + Protobuf::size_varint($this->platform);
      }
      if ($this->deviceManufacturer !== "") {
        $l = strlen($this->deviceManufacturer);
        $size += 1 + Protobuf::size_varint($l) + $l;
      }
      if ($this->deviceModel !== "") {
        $l = strlen($this->deviceModel);
        $size += 1 + Protobuf::size_varint($l) + $l;
      }
      if ($this->locale !== "") {
        $l = strlen($this->locale);
        $size += 1 + Protobuf::size_varint($l) + $l;
      }
      if ($this->appVersion !== 0) {
        $size += 1 + Protobuf::size_varint($this->appVersion);
      }
      return $size;
    }

    public function clearPlatform() { $this->platform = Platform::UNSET; }
    public function getPlatform() { return $this->platform;}
    public function setPlatform($value) { $this->platform = $value; }

    public function clearDeviceManufacturer() { $this->deviceManufacturer = ""; }
    public function getDeviceManufacturer() { return $this->deviceManufacturer;}
    public function setDeviceManufacturer($value) { $this->deviceManufacturer = $value; }

    public function clearDeviceModel() { $this->deviceModel = ""; }
    public function getDeviceModel() { return $this->deviceModel;}
    public function setDeviceModel($value) { $this->deviceModel = $value; }

    public function clearLocale() { $this->locale = ""; }
    public function getLocale() { return $this->locale;}
    public function setLocale($value) { $this->locale = $value; }

    public function clearAppVersion() { $this->appVersion = 0; }
    public function getAppVersion() { return $this->appVersion;}
    public function setAppVersion($value) { $this->appVersion = $value; }

    public function __toString() {
      return ''
           . Protobuf::toString('platform', $this->platform, Platform::UNSET)
           . Protobuf::toString('device_manufacturer', $this->deviceManufacturer, "")
           . Protobuf::toString('device_model', $this->deviceModel, "")
           . Protobuf::toString('locale', $this->locale, "")
           . Protobuf::toString('app_version', $this->appVersion, 0);
    }

    // @@protoc_insertion_point(class_scope:POGOProtos.Networking.Requests.Messages.GetAssetDigestMessage)
  }

}