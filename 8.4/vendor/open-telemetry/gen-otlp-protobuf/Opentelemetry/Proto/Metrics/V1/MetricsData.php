<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: opentelemetry/proto/metrics/v1/metrics.proto

namespace Opentelemetry\Proto\Metrics\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * MetricsData represents the metrics data that can be stored in a persistent
 * storage, OR can be embedded by other protocols that transfer OTLP metrics
 * data but do not implement the OTLP protocol.
 * MetricsData
 * └─── ResourceMetrics
 *   ├── Resource
 *   ├── SchemaURL
 *   └── ScopeMetrics
 *      ├── Scope
 *      ├── SchemaURL
 *      └── Metric
 *         ├── Name
 *         ├── Description
 *         ├── Unit
 *         └── data
 *            ├── Gauge
 *            ├── Sum
 *            ├── Histogram
 *            ├── ExponentialHistogram
 *            └── Summary
 * The main difference between this message and collector protocol is that
 * in this message there will not be any "control" or "metadata" specific to
 * OTLP protocol.
 * When new fields are added into this message, the OTLP request MUST be updated
 * as well.
 *
 * Generated from protobuf message <code>opentelemetry.proto.metrics.v1.MetricsData</code>
 */
class MetricsData extends \Google\Protobuf\Internal\Message
{
    /**
     * An array of ResourceMetrics.
     * For data coming from a single resource this array will typically contain
     * one element. Intermediary nodes that receive data from multiple origins
     * typically batch the data before forwarding further and in that case this
     * array will contain multiple elements.
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.metrics.v1.ResourceMetrics resource_metrics = 1;</code>
     */
    private $resource_metrics;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Opentelemetry\Proto\Metrics\V1\ResourceMetrics[]|\Google\Protobuf\Internal\RepeatedField $resource_metrics
     *           An array of ResourceMetrics.
     *           For data coming from a single resource this array will typically contain
     *           one element. Intermediary nodes that receive data from multiple origins
     *           typically batch the data before forwarding further and in that case this
     *           array will contain multiple elements.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Opentelemetry\Proto\Metrics\V1\Metrics::initOnce();
        parent::__construct($data);
    }

    /**
     * An array of ResourceMetrics.
     * For data coming from a single resource this array will typically contain
     * one element. Intermediary nodes that receive data from multiple origins
     * typically batch the data before forwarding further and in that case this
     * array will contain multiple elements.
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.metrics.v1.ResourceMetrics resource_metrics = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getResourceMetrics()
    {
        return $this->resource_metrics;
    }

    /**
     * An array of ResourceMetrics.
     * For data coming from a single resource this array will typically contain
     * one element. Intermediary nodes that receive data from multiple origins
     * typically batch the data before forwarding further and in that case this
     * array will contain multiple elements.
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.metrics.v1.ResourceMetrics resource_metrics = 1;</code>
     * @param \Opentelemetry\Proto\Metrics\V1\ResourceMetrics[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setResourceMetrics($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Opentelemetry\Proto\Metrics\V1\ResourceMetrics::class);
        $this->resource_metrics = $arr;

        return $this;
    }

}

