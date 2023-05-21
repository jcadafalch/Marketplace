<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Database\DBAL\TimestampType;
use Tests\TestCase;

class ProducteTest extends TestCase
{
    public function testGetProductName()
    {
        $p = new Product();
        $p->name = "Joguina";
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = "Joguina";
        $actual = $p->name;
        $this->assertEquals($expected, $actual);
    }

    public function testGetProductDescription()
    {
        $p = new Product();
        $p->name = "Joguina";
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = "Joguina d'alta qualitat";
        $actual = $p->description;
        $this->assertEquals($expected, $actual);
    }

    public function testGetProductSelledAt()
    {
        $p = new Product();
        $p->name = "Joguina";
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = time();
        $actual = $p->selled_at;
        $this->assertEquals($expected, $actual);
    }

    public function testGetProductNameIsNotString()
    {
        $p = new Product();
        $p->name = true;
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = gettype("string");
        $actual = gettype($p->name);
        $this->assertNotEquals($expected, $actual);
    }

    public function testGetProductSelledAtIsTimestamp()
    {
        $p = new Product();
        $p->name = "Joguina";
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = gettype(time());
        $actual = gettype($p->selled_at);
        $this->assertEquals($expected, $actual);
    }
}