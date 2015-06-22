<?php
namespace p2ee\BaseRequirements\Resolvers;

use p2ee\Preparables\Preparer;
use p2ee\Preparables\Requirement;
use p2ee\Preparables\Resolver;
use p2ee\BaseRequirements\Requirements\RequestDataRequirement;
use Symfony\Component\HttpFoundation\Request;

class RequestDataResolver implements Resolver {

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @inject
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @param Requirement $requirement
     * @throws \Exception
     * @return mixed
     */
    public function resolve(Requirement $requirement) {
        if (!($requirement instanceof RequestDataRequirement)) {
            throw new \InvalidArgumentException('invalid requirement type for RequestDataResolver');
        }

        return $this->request->get($requirement->getRequestDataKey());
    }

    /**
     * @return string
     */
    public function getSupportedType() {
        return RequestDataRequirement::class;
    }
}
