<?php
/**
 * Time
 *
 * PHP version 7.1.3
 *
 * @category Class
 * @package  OpenAPI\Server\Model
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */

/**
 * Issue tracking service
 *
 * Issue tracking service
 *
 * The version of the OpenAPI document: 1.0.0
 * 
 * Generated by: https://github.com/openapitools/openapi-generator.git
 *
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 * Do not edit the class manually.
 */

namespace OpenAPI\Server\Model;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class representing the Time model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class Time 
{
        /**
     * time spent
     *
     * @var float
     * @SerializedName("time")
     * @Assert\NotNull()
     * @Assert\Type("float")
     * @Type("float")
     */
    protected $time;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->time = isset($data['time']) ? $data['time'] : null;
    }

    /**
     * Gets time.
     *
     * @return float
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Sets time.
     *
     * @param float $time  time spent
     *
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }
}


