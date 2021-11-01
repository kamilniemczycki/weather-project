<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Traits\Attribute;
use Tests\TestCase;

class AttributeTest extends TestCase
{
    public function test_attributes(Object $createdObject = null)
    {
        $testAttribute = $createdObject ?? $this->createObject();

        $this->assertSame('Attr 1', $testAttribute->getAttr1());
        $this->assertSame('Attr 2', $testAttribute->getAttr2());
        $this->assertSame(5, $testAttribute->getAttr3());
        $this->assertSame(false, $testAttribute->getAttr4());
    }

    public function test_set_value()
    {
        $testAttribute = $this->createObject();

        $this->assertTrue($testAttribute->setAttr1('1 Attr'));
        $this->assertTrue($testAttribute->setAttr2('2 Attr'));
        $this->assertTrue($testAttribute->setAttr3(6));
        $this->assertTrue($testAttribute->setAttr4(true));

        $this->assertSame('1 Attr', $testAttribute->getAttr1());
        $this->assertSame('2 Attr', $testAttribute->getAttr2());
        $this->assertSame(6, $testAttribute->getAttr3());
        $this->assertSame(true, $testAttribute->getAttr4());
    }

    public function test_wrong_set_value()
    {
        $testAttribute = $this->createObject();

        $this->assertFalse($testAttribute->setAttr1(1));
        $this->assertFalse($testAttribute->setAttr2(2));
        $this->assertFalse($testAttribute->setAttr3(false));
        $this->assertFalse($testAttribute->setAttr4('Hello World'));

        $this->test_attributes($testAttribute);
    }

    public function test_not_exists_attribute()
    {
        $testAttribute = $this->createObject();

        $this->assertEquals(null, $testAttribute->getNotExists());
    }

    protected function createObject(): object
    {
        return new class ('Attr 1', 'Attr 2', 5, false) {
            use Attribute;

            public function __construct(
                protected ?string $attr1 = null,
                protected ?string $attr2 = null,
                protected ?int $attr3 = null,
                protected ?bool $attr4 = null
            ) {}
        };
    }
}
