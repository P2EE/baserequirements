<?php
namespace p2ee\BaseRequirements\Resolvers;

use p2ee\Preparables\Preparer;
use p2ee\Preparables\Requirement;
use p2ee\Preparables\Resolver;
use p2ee\BaseRequirements\Requirements\ServiceRequirement;
use rg\injektor\DependencyInjectionContainer;

/**
 * @service
 */
class ServiceResolver implements Resolver {

    protected $dic;

    /**
     * @inject
     * @param DependencyInjectionContainer $dic
     */
    public function __construct(DependencyInjectionContainer $dic) {
        $this->dic = $dic;
    }

    public function resolve(Requirement $requirement, Preparer $preparer) {
        if (!($requirement instanceof ServiceRequirement)) {
            throw new \Exception('invalid requirement type for ServiceResolver');
        }

        $service = $this->dic->getInstanceOfClass($requirement->getServiceName());
        return $this->dic->callMethodOnObject($service, $requirement->getMethodName(), $requirement->getParameter());
    }

    public function getSupportedType() {
        return ServiceRequirement::class;
    }
} 
