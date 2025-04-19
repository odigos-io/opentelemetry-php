<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# NO CHECKED-IN PROTOBUF GENCODE
# source: google/protobuf/descriptor.proto

namespace Google\Protobuf\Internal;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\GPBWire;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\InputStream;
use Google\Protobuf\Internal\GPBUtil;

/**
 * TODO Enums in C++ gencode (and potentially other languages) are
 * not well scoped.  This means that each of the feature enums below can clash
 * with each other.  The short names we've chosen maximize call-site
 * readability, but leave us very open to this scenario.  A future feature will
 * be designed and implemented to handle this, hopefully before we ever hit a
 * conflict here.
 *
 * Generated from protobuf message <code>google.protobuf.FeatureSet</code>
 */
class FeatureSet extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.FieldPresence field_presence = 1 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     */
    protected $field_presence = null;
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.EnumType enum_type = 2 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_ENUM, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     */
    protected $enum_type = null;
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.RepeatedFieldEncoding repeated_field_encoding = 3 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     */
    protected $repeated_field_encoding = null;
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.Utf8Validation utf8_validation = 4 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     */
    protected $utf8_validation = null;
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.MessageEncoding message_encoding = 5 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     */
    protected $message_encoding = null;
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.JsonFormat json_format = 6 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_MESSAGE, targets = TARGET_TYPE_ENUM, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     */
    protected $json_format = null;
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.EnforceNamingStyle enforce_naming_style = 7 [retention = RETENTION_SOURCE, targets = TARGET_TYPE_FILE, targets = TARGET_TYPE_EXTENSION_RANGE, targets = TARGET_TYPE_MESSAGE, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_ONEOF, targets = TARGET_TYPE_ENUM, targets = TARGET_TYPE_ENUM_ENTRY, targets = TARGET_TYPE_SERVICE, targets = TARGET_TYPE_METHOD, edition_defaults = {</code>
     */
    protected $enforce_naming_style = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $field_presence
     *     @type int $enum_type
     *     @type int $repeated_field_encoding
     *     @type int $utf8_validation
     *     @type int $message_encoding
     *     @type int $json_format
     *     @type int $enforce_naming_style
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Protobuf\Internal\Descriptor::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.FieldPresence field_presence = 1 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @return int
     */
    public function getFieldPresence()
    {
        return isset($this->field_presence) ? $this->field_presence : 0;
    }

    public function hasFieldPresence()
    {
        return isset($this->field_presence);
    }

    public function clearFieldPresence()
    {
        unset($this->field_presence);
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.FieldPresence field_presence = 1 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @param int $var
     * @return $this
     */
    public function setFieldPresence($var)
    {
        GPBUtil::checkEnum($var, \Google\Protobuf\Internal\FeatureSet\FieldPresence::class);
        $this->field_presence = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.EnumType enum_type = 2 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_ENUM, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @return int
     */
    public function getEnumType()
    {
        return isset($this->enum_type) ? $this->enum_type : 0;
    }

    public function hasEnumType()
    {
        return isset($this->enum_type);
    }

    public function clearEnumType()
    {
        unset($this->enum_type);
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.EnumType enum_type = 2 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_ENUM, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @param int $var
     * @return $this
     */
    public function setEnumType($var)
    {
        GPBUtil::checkEnum($var, \Google\Protobuf\Internal\FeatureSet\EnumType::class);
        $this->enum_type = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.RepeatedFieldEncoding repeated_field_encoding = 3 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @return int
     */
    public function getRepeatedFieldEncoding()
    {
        return isset($this->repeated_field_encoding) ? $this->repeated_field_encoding : 0;
    }

    public function hasRepeatedFieldEncoding()
    {
        return isset($this->repeated_field_encoding);
    }

    public function clearRepeatedFieldEncoding()
    {
        unset($this->repeated_field_encoding);
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.RepeatedFieldEncoding repeated_field_encoding = 3 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @param int $var
     * @return $this
     */
    public function setRepeatedFieldEncoding($var)
    {
        GPBUtil::checkEnum($var, \Google\Protobuf\Internal\FeatureSet\RepeatedFieldEncoding::class);
        $this->repeated_field_encoding = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.Utf8Validation utf8_validation = 4 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @return int
     */
    public function getUtf8Validation()
    {
        return isset($this->utf8_validation) ? $this->utf8_validation : 0;
    }

    public function hasUtf8Validation()
    {
        return isset($this->utf8_validation);
    }

    public function clearUtf8Validation()
    {
        unset($this->utf8_validation);
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.Utf8Validation utf8_validation = 4 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @param int $var
     * @return $this
     */
    public function setUtf8Validation($var)
    {
        GPBUtil::checkEnum($var, \Google\Protobuf\Internal\FeatureSet\Utf8Validation::class);
        $this->utf8_validation = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.MessageEncoding message_encoding = 5 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @return int
     */
    public function getMessageEncoding()
    {
        return isset($this->message_encoding) ? $this->message_encoding : 0;
    }

    public function hasMessageEncoding()
    {
        return isset($this->message_encoding);
    }

    public function clearMessageEncoding()
    {
        unset($this->message_encoding);
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.MessageEncoding message_encoding = 5 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @param int $var
     * @return $this
     */
    public function setMessageEncoding($var)
    {
        GPBUtil::checkEnum($var, \Google\Protobuf\Internal\FeatureSet\MessageEncoding::class);
        $this->message_encoding = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.JsonFormat json_format = 6 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_MESSAGE, targets = TARGET_TYPE_ENUM, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @return int
     */
    public function getJsonFormat()
    {
        return isset($this->json_format) ? $this->json_format : 0;
    }

    public function hasJsonFormat()
    {
        return isset($this->json_format);
    }

    public function clearJsonFormat()
    {
        unset($this->json_format);
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.JsonFormat json_format = 6 [retention = RETENTION_RUNTIME, targets = TARGET_TYPE_MESSAGE, targets = TARGET_TYPE_ENUM, targets = TARGET_TYPE_FILE, edition_defaults = {</code>
     * @param int $var
     * @return $this
     */
    public function setJsonFormat($var)
    {
        GPBUtil::checkEnum($var, \Google\Protobuf\Internal\FeatureSet\JsonFormat::class);
        $this->json_format = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.EnforceNamingStyle enforce_naming_style = 7 [retention = RETENTION_SOURCE, targets = TARGET_TYPE_FILE, targets = TARGET_TYPE_EXTENSION_RANGE, targets = TARGET_TYPE_MESSAGE, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_ONEOF, targets = TARGET_TYPE_ENUM, targets = TARGET_TYPE_ENUM_ENTRY, targets = TARGET_TYPE_SERVICE, targets = TARGET_TYPE_METHOD, edition_defaults = {</code>
     * @return int
     */
    public function getEnforceNamingStyle()
    {
        return isset($this->enforce_naming_style) ? $this->enforce_naming_style : 0;
    }

    public function hasEnforceNamingStyle()
    {
        return isset($this->enforce_naming_style);
    }

    public function clearEnforceNamingStyle()
    {
        unset($this->enforce_naming_style);
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.FeatureSet.EnforceNamingStyle enforce_naming_style = 7 [retention = RETENTION_SOURCE, targets = TARGET_TYPE_FILE, targets = TARGET_TYPE_EXTENSION_RANGE, targets = TARGET_TYPE_MESSAGE, targets = TARGET_TYPE_FIELD, targets = TARGET_TYPE_ONEOF, targets = TARGET_TYPE_ENUM, targets = TARGET_TYPE_ENUM_ENTRY, targets = TARGET_TYPE_SERVICE, targets = TARGET_TYPE_METHOD, edition_defaults = {</code>
     * @param int $var
     * @return $this
     */
    public function setEnforceNamingStyle($var)
    {
        GPBUtil::checkEnum($var, \Google\Protobuf\Internal\FeatureSet\EnforceNamingStyle::class);
        $this->enforce_naming_style = $var;

        return $this;
    }

}

