<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Odigos\Symfony\Component\VarDumper\Cloner;

use Odigos\Symfony\Component\VarDumper\Caster\Caster;
use Odigos\Symfony\Component\VarDumper\Exception\ThrowingCasterException;
/**
 * AbstractCloner implements a generic caster mechanism for objects and resources.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractCloner implements ClonerInterface
{
    public static array $defaultCasters = ['__PHP_Incomplete_Class' => ['Odigos\Symfony\Component\VarDumper\Caster\Caster', 'castPhpIncompleteClass'], 'AddressInfo' => ['Odigos\Symfony\Component\VarDumper\Caster\AddressInfoCaster', 'castAddressInfo'], 'Socket' => ['Odigos\Symfony\Component\VarDumper\Caster\SocketCaster', 'castSocket'], 'Odigos\Symfony\Component\VarDumper\Caster\CutStub' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'castStub'], 'Odigos\Symfony\Component\VarDumper\Caster\CutArrayStub' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'castCutArray'], 'Odigos\Symfony\Component\VarDumper\Caster\ConstStub' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'castStub'], 'Odigos\Symfony\Component\VarDumper\Caster\EnumStub' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'castEnum'], 'Odigos\Symfony\Component\VarDumper\Caster\ScalarStub' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'castScalar'], 'Fiber' => ['Odigos\Symfony\Component\VarDumper\Caster\FiberCaster', 'castFiber'], 'Closure' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castClosure'], 'Generator' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castGenerator'], 'ReflectionType' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castType'], 'ReflectionAttribute' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castAttribute'], 'ReflectionGenerator' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castReflectionGenerator'], 'ReflectionClass' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castClass'], 'ReflectionClassConstant' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castClassConstant'], 'ReflectionFunctionAbstract' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castFunctionAbstract'], 'ReflectionMethod' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castMethod'], 'ReflectionParameter' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castParameter'], 'ReflectionProperty' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castProperty'], 'ReflectionReference' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castReference'], 'ReflectionExtension' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castExtension'], 'ReflectionZendExtension' => ['Odigos\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castZendExtension'], 'Odigos\Doctrine\Common\Persistence\ObjectManager' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'Odigos\Doctrine\Common\Proxy\Proxy' => ['Odigos\Symfony\Component\VarDumper\Caster\DoctrineCaster', 'castCommonProxy'], 'Odigos\Doctrine\ORM\Proxy\Proxy' => ['Odigos\Symfony\Component\VarDumper\Caster\DoctrineCaster', 'castOrmProxy'], 'Odigos\Doctrine\ORM\PersistentCollection' => ['Odigos\Symfony\Component\VarDumper\Caster\DoctrineCaster', 'castPersistentCollection'], 'Odigos\Doctrine\Persistence\ObjectManager' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'DOMException' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castException'], 'Odigos\Dom\Exception' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castException'], 'DOMStringList' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'DOMNameList' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'DOMImplementation' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castImplementation'], 'Odigos\Dom\Implementation' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castImplementation'], 'DOMImplementationList' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'DOMNode' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'Odigos\Dom\Node' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'DOMNameSpaceNode' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'DOMDocument' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDocument'], 'Odigos\Dom\XMLDocument' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castXMLDocument'], 'Odigos\Dom\HTMLDocument' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castHTMLDocument'], 'DOMNodeList' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'Odigos\Dom\NodeList' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'DOMNamedNodeMap' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'Odigos\Dom\DTDNamedNodeMap' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'DOMXPath' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'Odigos\Dom\XPath' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'Odigos\Dom\HTMLCollection' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'Odigos\Dom\TokenList' => ['Odigos\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDom'], 'XMLReader' => ['Odigos\Symfony\Component\VarDumper\Caster\XmlReaderCaster', 'castXmlReader'], 'ErrorException' => ['Odigos\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castErrorException'], 'Exception' => ['Odigos\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castException'], 'Error' => ['Odigos\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castError'], 'Odigos\Symfony\Bridge\Monolog\Logger' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'Odigos\Symfony\Component\DependencyInjection\ContainerInterface' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'Odigos\Symfony\Component\EventDispatcher\EventDispatcherInterface' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'Odigos\Symfony\Component\HttpClient\AmpHttpClient' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClient'], 'Odigos\Symfony\Component\HttpClient\CurlHttpClient' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClient'], 'Odigos\Symfony\Component\HttpClient\NativeHttpClient' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClient'], 'Odigos\Symfony\Component\HttpClient\Response\AmpResponse' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'Odigos\Symfony\Component\HttpClient\Response\AmpResponseV4' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'Odigos\Symfony\Component\HttpClient\Response\AmpResponseV5' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'Odigos\Symfony\Component\HttpClient\Response\CurlResponse' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'Odigos\Symfony\Component\HttpClient\Response\NativeResponse' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'Odigos\Symfony\Component\HttpFoundation\Request' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castRequest'], 'Odigos\Symfony\Component\Uid\Ulid' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castUlid'], 'Odigos\Symfony\Component\Uid\Uuid' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castUuid'], 'Odigos\Symfony\Component\VarExporter\Internal\LazyObjectState' => ['Odigos\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castLazyObjectState'], 'Odigos\Symfony\Component\VarDumper\Exception\ThrowingCasterException' => ['Odigos\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castThrowingCasterException'], 'Odigos\Symfony\Component\VarDumper\Caster\TraceStub' => ['Odigos\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castTraceStub'], 'Odigos\Symfony\Component\VarDumper\Caster\FrameStub' => ['Odigos\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castFrameStub'], 'Odigos\Symfony\Component\VarDumper\Cloner\AbstractCloner' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'Odigos\Symfony\Component\ErrorHandler\Exception\FlattenException' => ['Odigos\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castFlattenException'], 'Odigos\Symfony\Component\ErrorHandler\Exception\SilencedErrorContext' => ['Odigos\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castSilencedErrorContext'], 'Odigos\Imagine\Image\ImageInterface' => ['Odigos\Symfony\Component\VarDumper\Caster\ImagineCaster', 'castImage'], 'Odigos\Ramsey\Uuid\UuidInterface' => ['Odigos\Symfony\Component\VarDumper\Caster\UuidCaster', 'castRamseyUuid'], 'Odigos\ProxyManager\Proxy\ProxyInterface' => ['Odigos\Symfony\Component\VarDumper\Caster\ProxyManagerCaster', 'castProxy'], 'PHPUnit_Framework_MockObject_MockObject' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'Odigos\PHPUnit\Framework\MockObject\MockObject' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'Odigos\PHPUnit\Framework\MockObject\Stub' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'Odigos\Prophecy\Prophecy\ProphecySubjectInterface' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'Odigos\Mockery\MockInterface' => ['Odigos\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'PDO' => ['Odigos\Symfony\Component\VarDumper\Caster\PdoCaster', 'castPdo'], 'PDOStatement' => ['Odigos\Symfony\Component\VarDumper\Caster\PdoCaster', 'castPdoStatement'], 'AMQPConnection' => ['Odigos\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castConnection'], 'AMQPChannel' => ['Odigos\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castChannel'], 'AMQPQueue' => ['Odigos\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castQueue'], 'AMQPExchange' => ['Odigos\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castExchange'], 'AMQPEnvelope' => ['Odigos\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castEnvelope'], 'ArrayObject' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castArrayObject'], 'ArrayIterator' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castArrayIterator'], 'SplDoublyLinkedList' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castDoublyLinkedList'], 'SplFileInfo' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castFileInfo'], 'SplFileObject' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castFileObject'], 'SplHeap' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castHeap'], 'SplObjectStorage' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castObjectStorage'], 'SplPriorityQueue' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castHeap'], 'OuterIterator' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castOuterIterator'], 'WeakMap' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castWeakMap'], 'WeakReference' => ['Odigos\Symfony\Component\VarDumper\Caster\SplCaster', 'castWeakReference'], 'Redis' => ['Odigos\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedis'], 'Odigos\Relay\Relay' => ['Odigos\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedis'], 'RedisArray' => ['Odigos\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedisArray'], 'RedisCluster' => ['Odigos\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedisCluster'], 'DateTimeInterface' => ['Odigos\Symfony\Component\VarDumper\Caster\DateCaster', 'castDateTime'], 'DateInterval' => ['Odigos\Symfony\Component\VarDumper\Caster\DateCaster', 'castInterval'], 'DateTimeZone' => ['Odigos\Symfony\Component\VarDumper\Caster\DateCaster', 'castTimeZone'], 'DatePeriod' => ['Odigos\Symfony\Component\VarDumper\Caster\DateCaster', 'castPeriod'], 'GMP' => ['Odigos\Symfony\Component\VarDumper\Caster\GmpCaster', 'castGmp'], 'MessageFormatter' => ['Odigos\Symfony\Component\VarDumper\Caster\IntlCaster', 'castMessageFormatter'], 'NumberFormatter' => ['Odigos\Symfony\Component\VarDumper\Caster\IntlCaster', 'castNumberFormatter'], 'IntlTimeZone' => ['Odigos\Symfony\Component\VarDumper\Caster\IntlCaster', 'castIntlTimeZone'], 'IntlCalendar' => ['Odigos\Symfony\Component\VarDumper\Caster\IntlCaster', 'castIntlCalendar'], 'IntlDateFormatter' => ['Odigos\Symfony\Component\VarDumper\Caster\IntlCaster', 'castIntlDateFormatter'], 'Memcached' => ['Odigos\Symfony\Component\VarDumper\Caster\MemcachedCaster', 'castMemcached'], 'Odigos\Ds\Collection' => ['Odigos\Symfony\Component\VarDumper\Caster\DsCaster', 'castCollection'], 'Odigos\Ds\Map' => ['Odigos\Symfony\Component\VarDumper\Caster\DsCaster', 'castMap'], 'Odigos\Ds\Pair' => ['Odigos\Symfony\Component\VarDumper\Caster\DsCaster', 'castPair'], 'Odigos\Symfony\Component\VarDumper\Caster\DsPairStub' => ['Odigos\Symfony\Component\VarDumper\Caster\DsCaster', 'castPairStub'], 'mysqli_driver' => ['Odigos\Symfony\Component\VarDumper\Caster\MysqliCaster', 'castMysqliDriver'], 'CurlHandle' => ['Odigos\Symfony\Component\VarDumper\Caster\CurlCaster', 'castCurl'], 'Odigos\Dba\Connection' => ['Odigos\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castDba'], ':dba' => ['Odigos\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castDba'], ':dba persistent' => ['Odigos\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castDba'], 'GdImage' => ['Odigos\Symfony\Component\VarDumper\Caster\GdCaster', 'castGd'], 'SQLite3Result' => ['Odigos\Symfony\Component\VarDumper\Caster\SqliteCaster', 'castSqlite3Result'], 'Odigos\PgSql\Lob' => ['Odigos\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castLargeObject'], 'Odigos\PgSql\Connection' => ['Odigos\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castLink'], 'Odigos\PgSql\Result' => ['Odigos\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castResult'], ':process' => ['Odigos\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castProcess'], ':stream' => ['Odigos\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castStream'], 'OpenSSLAsymmetricKey' => ['Odigos\Symfony\Component\VarDumper\Caster\OpenSSLCaster', 'castOpensslAsymmetricKey'], 'OpenSSLCertificateSigningRequest' => ['Odigos\Symfony\Component\VarDumper\Caster\OpenSSLCaster', 'castOpensslCsr'], 'OpenSSLCertificate' => ['Odigos\Symfony\Component\VarDumper\Caster\OpenSSLCaster', 'castOpensslX509'], ':persistent stream' => ['Odigos\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castStream'], ':stream-context' => ['Odigos\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castStreamContext'], 'XmlParser' => ['Odigos\Symfony\Component\VarDumper\Caster\XmlResourceCaster', 'castXml'], 'RdKafka' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castRdKafka'], 'Odigos\RdKafka\Conf' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castConf'], 'Odigos\RdKafka\KafkaConsumer' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castKafkaConsumer'], 'Odigos\RdKafka\Metadata\Broker' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castBrokerMetadata'], 'Odigos\RdKafka\Metadata\Collection' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castCollectionMetadata'], 'Odigos\RdKafka\Metadata\Partition' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castPartitionMetadata'], 'Odigos\RdKafka\Metadata\Topic' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopicMetadata'], 'Odigos\RdKafka\Message' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castMessage'], 'Odigos\RdKafka\Topic' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopic'], 'Odigos\RdKafka\TopicPartition' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopicPartition'], 'Odigos\RdKafka\TopicConf' => ['Odigos\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopicConf'], 'Odigos\FFI\CData' => ['Odigos\Symfony\Component\VarDumper\Caster\FFICaster', 'castCTypeOrCData'], 'Odigos\FFI\CType' => ['Odigos\Symfony\Component\VarDumper\Caster\FFICaster', 'castCTypeOrCData']];
    protected int $maxItems = 2500;
    protected int $maxString = -1;
    protected int $minDepth = 1;
    /**
     * @var array<string, list<callable>>
     */
    private array $casters = [];
    /**
     * @var callable|null
     */
    private $prevErrorHandler;
    private array $classInfo = [];
    private int $filter = 0;
    /**
     * @param callable[]|null $casters A map of casters
     *
     * @see addCasters
     */
    public function __construct(?array $casters = null)
    {
        $this->addCasters($casters ?? static::$defaultCasters);
    }
    /**
     * Adds casters for resources and objects.
     *
     * Maps resources or object types to a callback.
     * Use types as keys and callable casters as values.
     * Prefix types with `::`,
     * see e.g. self::$defaultCasters.
     *
     * @param array<string, callable> $casters A map of casters
     */
    public function addCasters(array $casters): void
    {
        foreach ($casters as $type => $callback) {
            $this->casters[$type][] = $callback;
        }
    }
    /**
     * Adds default casters for resources and objects.
     *
     * Maps resources or object types to a callback.
     * Use types as keys and callable casters as values.
     * Prefix types with `::`,
     * see e.g. self::$defaultCasters.
     *
     * @param array<string, callable> $casters A map of casters
     */
    public static function addDefaultCasters(array $casters): void
    {
        self::$defaultCasters = [...self::$defaultCasters, ...$casters];
    }
    /**
     * Sets the maximum number of items to clone past the minimum depth in nested structures.
     */
    public function setMaxItems(int $maxItems): void
    {
        $this->maxItems = $maxItems;
    }
    /**
     * Sets the maximum cloned length for strings.
     */
    public function setMaxString(int $maxString): void
    {
        $this->maxString = $maxString;
    }
    /**
     * Sets the minimum tree depth where we are guaranteed to clone all the items.  After this
     * depth is reached, only setMaxItems items will be cloned.
     */
    public function setMinDepth(int $minDepth): void
    {
        $this->minDepth = $minDepth;
    }
    /**
     * Clones a PHP variable.
     *
     * @param int $filter A bit field of Caster::EXCLUDE_* constants
     */
    public function cloneVar(mixed $var, int $filter = 0): Data
    {
        $this->prevErrorHandler = set_error_handler(function ($type, $msg, $file, $line, $context = []) {
            if (\E_RECOVERABLE_ERROR === $type || \E_USER_ERROR === $type) {
                // Cloner never dies
                throw new \ErrorException($msg, 0, $type, $file, $line);
            }
            if ($this->prevErrorHandler) {
                return ($this->prevErrorHandler)($type, $msg, $file, $line, $context);
            }
            return \false;
        });
        $this->filter = $filter;
        if ($gc = gc_enabled()) {
            gc_disable();
        }
        try {
            return new Data($this->doClone($var));
        } finally {
            if ($gc) {
                gc_enable();
            }
            restore_error_handler();
            $this->prevErrorHandler = null;
        }
    }
    /**
     * Effectively clones the PHP variable.
     */
    abstract protected function doClone(mixed $var): array;
    /**
     * Casts an object to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     */
    protected function castObject(Stub $stub, bool $isNested): array
    {
        $obj = $stub->value;
        $class = $stub->class;
        if (str_contains($class, "@anonymous\x00")) {
            $stub->class = get_debug_type($obj);
        }
        if (isset($this->classInfo[$class])) {
            [$i, $parents, $hasDebugInfo, $fileInfo] = $this->classInfo[$class];
        } else {
            $i = 2;
            $parents = [$class];
            $hasDebugInfo = method_exists($class, '__debugInfo');
            foreach (class_parents($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            foreach (class_implements($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            $parents[] = '*';
            $r = new \ReflectionClass($class);
            $fileInfo = $r->isInternal() || $r->isSubclassOf(Stub::class) ? [] : ['file' => $r->getFileName(), 'line' => $r->getStartLine()];
            $this->classInfo[$class] = [$i, $parents, $hasDebugInfo, $fileInfo];
        }
        $stub->attr += $fileInfo;
        $a = Caster::castObject($obj, $class, $hasDebugInfo, $stub->class);
        try {
            while ($i--) {
                if (!empty($this->casters[$p = $parents[$i]])) {
                    foreach ($this->casters[$p] as $callback) {
                        $a = $callback($obj, $a, $stub, $isNested, $this->filter);
                    }
                }
            }
        } catch (\Exception $e) {
            $a = [(Stub::TYPE_OBJECT === $stub->type ? Caster::PREFIX_VIRTUAL : '') . '⚠' => new ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
    /**
     * Casts a resource to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     */
    protected function castResource(Stub $stub, bool $isNested): array
    {
        $a = [];
        $res = $stub->value;
        $type = $stub->class;
        try {
            if (!empty($this->casters[':' . $type])) {
                foreach ($this->casters[':' . $type] as $callback) {
                    $a = $callback($res, $a, $stub, $isNested, $this->filter);
                }
            }
        } catch (\Exception $e) {
            $a = [(Stub::TYPE_OBJECT === $stub->type ? Caster::PREFIX_VIRTUAL : '') . '⚠' => new ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
}
