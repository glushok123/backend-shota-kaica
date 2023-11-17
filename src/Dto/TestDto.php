<?php

namespace App\Dto;

class TestDto extends BasicDto
{
    public function __construct(
        public readonly ?string            $t = null,
    )
    {
    }
}
