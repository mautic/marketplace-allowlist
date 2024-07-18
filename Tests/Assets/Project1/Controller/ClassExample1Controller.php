<?php

namespace MauticPlugin\MauticCheckBundle\Tests\Assets\Project1\Controller;

class ClassExample1Controller
{
    public function method1($code)
    {
        $result1 = eval($code);
        $result3 = eval('ls -lha');
        $result2 = eval('ls '.$code);
        $result4 = $this->testeval($code);
    }

    private function testeval($code)
    {
        return $code;
    }

    public function method2($code)
    {
        $result    = system($code);
        $result1   = shell_exec($code);
        $result2   = system('--->'.$code);
        $result3   = system('echo ');
    }
}
