<?php
namespace common\ppunit;

/**
 * Provides a means of grouping together one or more tests
 * @package common\ppunit
 */
abstract class GroupTests {
    public abstract function includeTests();
    public abstract function getRunLevel();
}