<?php

namespace p2ee\BaseRequirements\Resolvers;


use p2ee\BaseRequirements\Requirements\RequestDataRequirement;
use p2ee\Preparables\Preparer;
use Symfony\Component\HttpFoundation\Request;

class RequestDataResolverTest extends \PHPUnit_Framework_TestCase {

    public function testResolver(){
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $preparer = $this->getMockBuilder(Preparer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resolver = new RequestDataResolver($request);

        $parameterName = 'testRequestParameter';
        $requirement = new RequestDataRequirement(
            'test',
            $parameterName
        );

        $request->expects($this->once())
            ->method('get')
            ->with($parameterName)
            ->will($this->returnValue(true));

        $this->assertTrue($resolver->resolve($requirement, $preparer));
    }
}
 