<?php
namespace p2ee\BaseRequirements\Requirements;

use p2ee\Preparables\Requirement;

class RequestDataRequirement extends Requirement {

    protected $requestDataKey;

    /**
     * @param string $key
     * @param string|null $requestDataKey
     * @param string $required
     */
    public function __construct($key, $requestDataKey = null, $required = self::MODE_REQUIRED){
        $this->key = $key;
        $this->requestDataKey = $requestDataKey ? : $key;
        $this->required = $required;
    }

    /**
     * @return mixed
     */
    public function getRequestDataKey() {
        return $this->requestDataKey;
    }

    public function isCacheable() {
        return true;
    }

    public function getCacheKey() {
        return $this->requestDataKey;
    }
}
