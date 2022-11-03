<?php

declare(strict_types = 1);

namespace ImageModifier\Tests\Unit\Utility;

use PHPUnit\Framework\TestCase;
use ImageModifier\Utility\Normalizer;

class NormalizerTest extends TestCase
{
    public function patternProvider()
    {
        return [
            ['%6-%4-%6', '/^\w{6}-\w{4}-\w{6}$/'],
            ['%16', '/^\w{16}$/'],
            ['Y-m-d', '/^\d{4}-\d{2}-\d{2}$/'],
        ];
    }

    /**
     * @dataProvider patternProvider()
     *
     * @param string $pattern      The pattern
     * @param string $regExMatcher RegEx to validate output
     */
    public function testGenerateFilename($pattern, $regExMatcher)
    {
        $this->assertMatchesRegularExpression($regExMatcher, Normalizer::generateFilename($pattern));
    }
}
