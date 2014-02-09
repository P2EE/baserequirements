<?php
namespace p2ee\BaseRequirements\Resolvers;

use p2ee\BaseRequirements\Requirements\ServiceRequirement;
use p2ee\Preparables\Preparer;
use rg\injektor\DependencyInjectionContainer;

class ServiceResolverTest extends \PHPUnit_Framework_TestCase {

    public function testServiceResolver(){
        $dic = $this->getMockBuilder(DependencyInjectionContainer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $preparer = $this->getMockBuilder(Preparer::class)
            ->disableOriginalConstructor()
            ->getMock();
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
}
 