<?php

namespace Propel\Bundle\PropelBundle\Attribute;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
class MapModel
{
    public function __construct(
        public readonly array $mapping = [],
        public readonly array $exclude = [],
        public readonly array $with = [],
        public readonly ?string $queryMethod = null,
    ) {
    }
}
