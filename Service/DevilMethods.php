<?php

namespace MauticPlugin\MauticCheckBundle\Service;

use MauticPlugin\MauticCheckBundle\Helper\FilesHelper;

class DevilMethods
{
    public const EVIL_METHODS = [
        [
            'name'        => 'eval',
            'description' => 'Command injection is an attack in which the goal is execution of arbitrary commands on the host operating system via a vulnerable application',
            'regex'       => '/eval\(.*\$.*\)/i',
            'example'     => 'eval($_GET[\'evil\']); // or eval($evil);',
            'links'       => [
                'https://www.php.net/manual/en/function.eval.php',
                'https://cwe.mitre.org/data/definitions/77.html',
                'https://owasp.org/www-community/attacks/Code_Injection',
            ],
            'evil_parameter' => [0],
            'vulnerability'  => 'Code Injection',
            'cve'            => '',
            'cwes'           => ['CWE-77'],
        ],
        [
            'name'        => 'exec',
            'description' => 'Execute an external program',
            'regex'       => '/exec\(.*\$.*\)/i',
            'example'     => 'exec($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.exec.php',
                'https://www.php.net/manual/en/function.system.php',
                'https://www.php.net/manual/en/function.passthru.php',
                'https://www.php.net/manual/en/function.shell-exec.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'RCE',
        ],
        [
            'name'        => 'passthru',
            'description' => 'Execute an external program and display raw output',
            'regex'       => '/\bpassthru\s*\(/i',
            'example'     => 'passthru($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.passthru.php',
                'https://www.php.net/manual/en/function.exec.php',
                'https://www.php.net/manual/en/function.system.php',
                'https://www.php.net/manual/en/function.shell-exec.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'RCE',
        ],
        [
            'name'        => 'shell_exec',
            'description' => 'Execute command via shell and return the complete output as a string',
            'regex'       => '/\bshell_exec\s*\(/i',
            'example'     => 'shell_exec($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.shell-exec.php',
                'https://www.php.net/manual/en/function.exec.php',
                'https://www.php.net/manual/en/function.system.php',
                'https://www.php.net/manual/en/function.passthru.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'RCE',
        ],
        [
            'name'        => 'system',
            'description' => 'Execute an external program and display the output',
            'regex'       => '/\bsystem\s*\(/i',
            'example'     => 'system($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.system.php',
                'https://www.php.net/manual/en/function.exec.php',
                'https://www.php.net/manual/en/function.passthru.php',
                'https://www.php.net/manual/en/function.shell-exec.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'RCE',
        ],
        [
            'name'        => 'proc_open',
            'description' => 'Execute a command and open file pointers for input/output',
            'regex'       => '/\bproc_open\s*\(/i',
            'example'     => 'proc_open($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.proc-open.php',
                'https://www.php.net/manual/en/function.popen.php',
            ],
            'evil_parameter' => [0, 1, 2, 3, 4, 5, 6],
            'cve'            => 'CVE-2019-11043',
        ],
        [
            'name'        => 'unserialize',
            'description' => 'Creates a PHP value from a stored representation',
            'regex'       => '/\bunserialize\s*\(/i',
            'example'     => 'unserialize($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.unserialize.php',
                'https://www.php.net/manual/en/function.serialize.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
        ],
        [
            'name'        => 'assert',
            'description' => 'Evaluates a string as PHP code',
            'regex'       => '/\bassert\s*\(/i',
            'example'     => 'assert($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.assert.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
        ],
        [
            'name'        => 'create_function',
            'description' => 'Create an anonymous (lambda-style) function',
            'regex'       => '/\bcreate_function\s*\(/i',
            'example'     => 'create_function(\'$a,$b\',\'return $a+$b;\');',
            'links'       => [
                'https://www.php.net/manual/en/function.create-function.php',
            ],
            'evil_parameter' => [1],
            'cve'            => 'CVE-2019-11043',
        ],
        [
            'name'        => 'parse_str',
            'description' => 'Parses GET/POST/COOKIE data and sets global variables',
            'regex'       => '/\bparse_str\s*\(/i',
            'example'     => 'parse_str($_SERVER[\'HTTP_EVIL\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.parse-str.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
        ],
        [
            'name'        => 'parse_exec',
            'description' => 'Parses GET/POST/COOKIE data and sets global variables',
            'regex'       => '/\bparse_exec\s*\(/i',
            'example'     => 'parse_exec($_SERVER[\'HTTP_EVIL\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.parse-exec.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
        ],
        [
            'name'        => 'extract',
            'description' => 'Import variables into the current symbol table from an array',
            'regex'       => '/\bextract\s*\(/i',
            'example'     => 'extract($_GET);',
            'links'       => [
                'https://www.php.net/manual/en/function.extract.php',
                'https://www.php.net/manual/en/function.parse-str.php',
            ],
            'evil_parameter' => [0, 2],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'RCE',
        ],
        [
            'name'        => 'unlink',
            'description' => 'Deletes a file',
            'regex'       => '/\bunlink\s*\(/i',
            'example'     => 'unlink($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.unlink.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'LFI',
        ],
        [
            'name'        => 'rmdir',
            'description' => 'Removes directory',
            'regex'       => '/\brmdir\s*\(/i',
            'example'     => 'rmdir($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.rmdir.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'LFI',
        ],
        [
            'name'        => 'mkdir',
            'description' => 'Makes directory',
            'regex'       => '/\bmkdir\s*\(/i',
            'example'     => 'mkdir($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.mkdir.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'LFI',
        ],
        [
            'name'        => 'file_put_contents',
            'description' => 'Write data to a file',
            'regex'       => '/\bfile_put_contents\s*\(/i',
            'example'     => 'file_put_contents(\'/var/www/html/evil.php\',\'<?php phpinfo();?>\');',
            'links'       => [
                'https://www.php.net/manual/en/function.file-put-contents.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'LFI',
        ],
        [
            'name'        => 'file_get_contents',
            'description' => 'Reads entire file into a string',
            'regex'       => '/\bfile_get_contents\s*\(/i',
            'example'     => 'file_get_contents($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.file-get-contents.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'LFI',
        ],
        [
            'name'        => 'readfile',
            'description' => 'Reads a file and writes it to the output buffer',
            'example'     => 'readfile($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.readfile.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'LFI',
        ],
        [
            'name'        => 'file',
            'description' => 'File — Reads entire file into an array',
            'example'     => 'readfilefile($_GET[\'evil\']);',
            'links'       => [
                'https://www.php.net/manual/en/function.file.php',
            ],
            'evil_parameter' => [0],
            'cve'            => 'CVE-2019-11043',
            'vulnerability'  => 'LFI',
        ],
    ];

    public string $description = 'This is a devil method';
    public string $regex       =  '';

    public function __construct(
        private FilesHelper $filesHelper
    ) {
    }

    /**
     * @return array <int, array>
     */
    public function check(string $code): array
    {
        $result = [];
        foreach (self::EVIL_METHODS as $evilMethod) {
            preg_match_all(
                $this->getRegex($evilMethod['name']),
                $code,
                $output
            );
            if (empty($output)) {
                continue;
            }
            $result = array_merge($result, $this->getBlocks($code, $evilMethod, $output));
        }

        return $result;
    }

    /**
     * @return array <int, array>
     */
    private function getBlocks(string $code, array $method, array $outputResult): array
    {
        $result = [];
        foreach ($outputResult[0] as $output) {
            $line     = $this->filesHelper->getLine($code, $output);
            $lineCode = $this->filesHelper->returnCodeLineByNumberCode($code, $line);
            $result[] = $this->returnResult($method, $line, $lineCode);
        }

        return $result;
    }

    /**
     * @return array <string, mixed>
     */
    public function returnResult(array $evilMethod, int $line, string $lineCode): array
    {
        return [
            'line'     => $line,
            'lineCode' => $lineCode,
            'details'  => [
                'name'           => $evilMethod['name'],
                'description'    => $evilMethod['description'],
                'example'        => $evilMethod['example'],
                'links'          => $evilMethod['links'],
                'evil_parameter' => $evilMethod['evil_parameter'],
                'cve'            => $evilMethod['cve'] ?? '',
                'vulnerability'  => $evilMethod['vulnerability'] ?? '',
                'cwes'           => $evilMethod['cwes'] ?? [],
            ],
        ];
    }

    private function getRegex(string $name): string
    {
        return sprintf('/(^|=|\s)%s\(.*\$.*\)/i', $name);
    }
}
