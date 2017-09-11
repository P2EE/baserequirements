<?php

namespace p2ee\BaseRequirements\Resolvers;


use p2ee\BaseRequirements\Requirements\RequestDataRequirement;
use p2ee\Preparables\Preparer;
use p2ee\Preparables\Requirement;
use Symfony\Component\HttpFoundation\Request;

class RequestDataResolverTest extends \PHPUnit\Framework\TestCase {

    public function testResolver(){
        $request = $this->getMockRequest();
        $preparer = $this->getMockPreparer();

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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNotSupportedTypes() {
        $request = $this->getMockRequest();
        $preparer = $this->getMockPreparer();

        $resolver = new RequestDataResolver($request);

        $requirement = $this->getMockBuilder(Requirement::class)->getMock();

        $resolver->resolve($requirement, $preparer);
    }

    public function testGetSupportedType(){
        $request = $this->getMockRequest();

        $resolver = new RequestDataResolver($request);

        $this->assertEquals($resolver->getSupportedType(), RequestDataRequirement::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockRequest()
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $request;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockPreparer()
    {
        $preparer = $this->getMockBuilder(Preparer::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $preparer;
    }
}
 
