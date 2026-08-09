<?php

namespace MauticPlugin\MauticCheckBundle\Tests\Assets\Project1\Controller;

class ClassExample2Controller
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
        $result    = passthru($code);
        $result1   = proc_open($code);
        $result2   = proc_open('--->'.$code);
        $result3   = assert($code);
        $result4   = parse_str($code, $result);
        $result5   = pcntl_exec($code);
        $result6   = pcntl_exec($code, $result);
        $result7   = extract($code, $result, 'aaaa');
    }

    public function method3($code)
    {
        $result    = unserialize($code);
        $result1   = unlink($code);
        $result2   = rmdir($code);
        $result3   = readfile($code);
        $result4   = file_get_contents($code);
        $result5   = file_put_contents($code, $result);
        $result6   = file($code);
        $result7   = mkdir($code);
    }
}
