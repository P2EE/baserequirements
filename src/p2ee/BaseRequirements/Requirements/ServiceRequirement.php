<?php
namespace p2ee\BaseRequirements\Requirements;

use p2ee\Preparables\Requirement;

class ServiceRequirement extends Requirement {

    protected $serviceName;

    protected $methodName;

    protected $parameter = [];

    /**
     * @param string $key
     * @param string $serviceName
     * @param string $methodName
     * @param array $parameter
     * @param string $required
     */
    function __construct($key, $serviceName, $methodName, $parameter = [], $required = self::MODE_REQUIRED) {
        $this->key = $key;
        $this->methodName = $methodName;
        $this->parameter = $parameter;
        $this->serviceName = $serviceName;
        $this->required = $required;
    }

    /**
     * @return mixed
     */
    public function getMethodName() {
        return $this->methodName;
    }

    /**
     * @return mixed
     */
    public function getParameter() {
        return $this->parameter;
    }

    /**
     * @return mixed
     */
    public function getServiceName() {
        return $this->serviceName;
    }

    public function isCacheable() {
        return true;
    }
}
