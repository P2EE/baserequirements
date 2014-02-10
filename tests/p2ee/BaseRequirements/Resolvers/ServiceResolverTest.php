<?php
namespace p2ee\BaseRequirements\Resolvers;

use p2ee\BaseRequirements\Requirements\ServiceRequirement;
use p2ee\Preparables\Preparer;
use p2ee\Preparables\Requirement;
use rg\injektor\DependencyInjectionContainer;

class ServiceResolverTest extends \PHPUnit_Framework_TestCase {

    public function testServiceResolver(){
        $dic = $this->getMockDic();
        $preparer = $this->getMockPreparer();
        $resolver = new ServiceResolver($dic);

        $serviceName = 'TestService';
        $serviceMethod = 'testMethod';
        $parameter = ['a' => 'b'];
        $requirement = new ServiceRequirement(
            'test',
            $serviceName,
            $serviceMethod,
            $parameter
        );

        $testServiceObject = new \stdClass();
        $dic->expects($this->once())
            ->method('getInstanceOfClass')
            ->with($serviceName)
            ->will($this->returnValue($testServiceObject));

        $dic->expects($this->once())
            ->method('callMethodOnObject')
            ->with($this->callback(function($service)use($testServiceObject){
                return $service === $testServiceObject;
            }), $serviceMethod , $parameter)
            ->will($this->returnValue(true));

        $this->assertTrue($resolver->resolve($requirement, $preparer));
    }

    public function testInvalidRequirement(){

        $dic = $this->getMockDic();
        $preparer = $this->getMockPreparer();
        $resolver = new ServiceResolver($dic);

        $requirement = $this->getMock(Requirement::class);

        $this->setExpectedException(\InvalidArgumentException::class);

        $resolver->resolve($requirement, $preparer);
    }

    public function testGetType(){
        $dic = $this->getMockDic();
        $preparer = $this->getMockPreparer();
        $resolver = new ServiceResolver($dic);

        $this->assertEquals($resolver->getSupportedType(), ServiceRequirement::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockDic()
    {
        $dic = $this->getMockBuilder(DependencyInjectionContainer::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $dic;
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
 