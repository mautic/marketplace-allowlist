<?php

namespace MauticPlugin\MauticCheckBundle\Tests\Unit\Helper;

use Mautic\CoreBundle\Test\MauticMysqlTestCase;
use MauticPlugin\MauticCheckBundle\Helper\FilesHelper;

class FileHelperTest extends MauticMysqlTestCase
{
    public function testGetFileContent()
    {
        $files = FilesHelper::getFiles(__DIR__.'/../../Assets/Project1/');
        $this->assertNotEmpty($files);
        $this->assertStringContainsString('ClassExample1Controller.php', $files['files'][0]);
        $this->assertStringContainsString('EntityFoo.php', $files['files'][2]);
        $this->assertStringContainsString('FooModel.php', $files['files'][4]);
    }

    public function testGetLine()
    {
        $filePath = __DIR__.'/../../Assets/Project1/Controller/ClassExample1Controller.php';
        $file     = file_get_contents($filePath);
        $line     = FilesHelper::getLine($file, 'public function method1($code)');
        $this->assertEquals(7, $line);
        $line = FilesHelper::getLine($file, '{');
        $this->assertEquals(6, $line);
    }

    public function testGetLines()
    {
        $filePath = __DIR__.'/../../Assets/Project1/Controller/ClassExample1Controller.php';
        $file     = file_get_contents($filePath);
        $lines    = FilesHelper::getLines($file, 'eval');
        $this->assertEquals([9, 10, 11, 12, 15], $lines);
        $lines = FilesHelper::getLines($file, '{');
        $this->assertEquals([6, 8, 16, 21], $lines);
    }

    public function testNumberLineCode()
    {
        $filePath = __DIR__.'/../../Assets/Project1/Controller/ClassExample1Controller.php';
        $file     = file_get_contents($filePath);
        $line     = FilesHelper::returnCodeLineByNumberCode($file, 7);
        $this->assertEquals('    public function method1($code)', $line);
        $line = FilesHelper::returnCodeLineByNumberCode($file, 6);
        $this->assertEquals('{', $line);
    }
}
