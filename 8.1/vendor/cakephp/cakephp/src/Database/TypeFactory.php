<?php

declare (strict_types=1);
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         4.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Database;

use InvalidArgumentException;
/**
 * Factory for building database type classes.
 */
class TypeFactory
{
    /**
     * List of supported database types. A human-readable
     * identifier is used as key and a complete namespaced class name as value
     * representing the class that will do actual type conversions.
     *
     * @var array<string, string>
     * @phpstan-var array<string, class-string<\Cake\Database\TypeInterface>>
     */
    protected static array $_types = ['tinyinteger' => \Cake\Database\Type\IntegerType::class, 'smallinteger' => \Cake\Database\Type\IntegerType::class, 'integer' => \Cake\Database\Type\IntegerType::class, 'biginteger' => \Cake\Database\Type\IntegerType::class, 'binary' => \Cake\Database\Type\BinaryType::class, 'binaryuuid' => \Cake\Database\Type\BinaryUuidType::class, 'boolean' => \Cake\Database\Type\BoolType::class, 'date' => \Cake\Database\Type\DateType::class, 'datetime' => \Cake\Database\Type\DateTimeType::class, 'datetimefractional' => \Cake\Database\Type\DateTimeFractionalType::class, 'decimal' => \Cake\Database\Type\DecimalType::class, 'float' => \Cake\Database\Type\FloatType::class, 'json' => \Cake\Database\Type\JsonType::class, 'string' => \Cake\Database\Type\StringType::class, 'char' => \Cake\Database\Type\StringType::class, 'text' => \Cake\Database\Type\StringType::class, 'time' => \Cake\Database\Type\TimeType::class, 'timestamp' => \Cake\Database\Type\DateTimeType::class, 'timestampfractional' => \Cake\Database\Type\DateTimeFractionalType::class, 'timestamptimezone' => \Cake\Database\Type\DateTimeTimezoneType::class, 'uuid' => \Cake\Database\Type\UuidType::class, 'nativeuuid' => \Cake\Database\Type\UuidType::class, 'linestring' => \Cake\Database\Type\StringType::class, 'geometry' => \Cake\Database\Type\StringType::class, 'point' => \Cake\Database\Type\StringType::class, 'polygon' => \Cake\Database\Type\StringType::class];
    /**
     * Contains a map of type object instances to be reused if needed.
     *
     * @var array<\Cake\Database\TypeInterface>
     */
    protected static array $_builtTypes = [];
    /**
     * Returns a Type object capable of converting a type identified by name.
     *
     * @param string $name type identifier
     * @throws \InvalidArgumentException If type identifier is unknown
     * @return \Cake\Database\TypeInterface
     */
    public static function build(string $name): \Cake\Database\TypeInterface
    {
        if (isset(static::$_builtTypes[$name])) {
            return static::$_builtTypes[$name];
        }
        if (!isset(static::$_types[$name])) {
            throw new InvalidArgumentException(sprintf('Unknown type `%s`', $name));
        }
        return static::$_builtTypes[$name] = new static::$_types[$name]($name);
    }
    /**
     * Returns an arrays with all the mapped type objects, indexed by name.
     *
     * @return array<\Cake\Database\TypeInterface>
     */
    public static function buildAll(): array
    {
        foreach (static::$_types as $name => $type) {
            static::$_builtTypes[$name] ??= static::build($name);
        }
        return static::$_builtTypes;
    }
    /**
     * Set TypeInterface instance capable of converting a type identified by $name
     *
     * @param string $name The type identifier you want to set.
     * @param \Cake\Database\TypeInterface $instance The type instance you want to set.
     * @return void
     */
    public static function set(string $name, \Cake\Database\TypeInterface $instance): void
    {
        static::$_builtTypes[$name] = $instance;
    }
    /**
     * Registers a new type identifier and maps it to a fully namespaced classname.
     *
     * @param string $type Name of type to map.
     * @param string $className The classname to register.
     * @return void
     * @phpstan-param class-string<\Cake\Database\TypeInterface> $className
     */
    public static function map(string $type, string $className): void
    {
        static::$_types[$type] = $className;
        unset(static::$_builtTypes[$type]);
    }
    /**
     * Set type to classname mapping.
     *
     * @param array<string, string> $map List of types to be mapped.
     * @return void
     * @phpstan-param array<string, class-string<\Cake\Database\TypeInterface>> $map
     */
    public static function setMap(array $map): void
    {
        static::$_types = $map;
        static::$_builtTypes = [];
    }
    /**
     * Get mapped class name for given type or map array.
     *
     * @param string|null $type Type name to get mapped class for or null to get map array.
     * @return array<string, class-string<\Cake\Database\TypeInterface>>|string|null Configured class name for given $type or map array.
     */
    public static function getMap(?string $type = null): array|string|null
    {
        if ($type === null) {
            return static::$_types;
        }
        return static::$_types[$type] ?? null;
    }
    /**
     * Clears out all created instances and mapped types classes, useful for testing
     *
     * @return void
     */
    public static function clear(): void
    {
        static::$_types = [];
        static::$_builtTypes = [];
    }
}
