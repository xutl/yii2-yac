<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace xutl\yac;

use Yac;
use yii\caching\Cache;

/**
 * YacCache provides Cache caching in terms of an application component.
 *
 * To use this application component, the [yac PHP extension](https://github.com/laruence/yac)
 * must be loaded. Also note that "yac.enable = 1" should be set to "On" in your php.ini file.
 *
 * See [[Cache]] manual for common cache operations that are supported by YacCache.
 *
 * For more details and usage information on Cache, see the [guide article on caching](guide:caching-overview).
 *
 * @author XUTL <xuchao.dev@gmail.com>
 * @since 1.0
 */
class YacCache extends Cache
{
    /**
     * @var Yac
     */
    private $yac;

    /**
     * Initializes this application component.
     * It creates the memcache instance and adds memcache servers.
     */
    public function init()
    {
        parent::init();
        $this->yac = new Yac();
    }

    /**
     * Checks whether a specified key exists in the cache.
     * This can be faster than getting the value from the cache if the data is big.
     * Note that this method does not check whether the dependency associated
     * with the cached data, if there is any, has changed. So a call to [[get]]
     * may return false while exists returns true.
     * @param mixed $key a key identifying the cached value. This can be a simple string or
     * a complex data structure consisting of factors representing the key.
     * @return bool true if a value exists in cache, false if the value is not in the cache or expired.
     */
    public function exists($key)
    {
        $key = $this->buildKey($key);
        $value = $this->getValue($key);

        return $value !== false;
    }

    /**
     * Retrieves a value from cache with a specified key.
     * This is the implementation of the method declared in the parent class.
     * @param string $key a unique key identifying the cached value
     * @return string|bool the value stored in cache, false if the value is not in the cache or expired.
     */
    protected function getValue($key)
    {
        return $this->yac->get($key);
    }

    /**
     * Retrieves multiple values from cache with the specified keys.
     * @param array $keys a list of keys identifying the cached values
     * @return array a list of cached values indexed by the keys
     */
    protected function getValues($keys)
    {
        return $this->yac->get($keys);
    }

    /**
     * Stores a value identified by a key in cache.
     * This is the implementation of the method declared in the parent class.
     *
     * @param string $key the key identifying the value to be cached
     * @param mixed $value the value to be cached. Most often it's a string. If you have disabled [[serializer]],
     * it could be something else.
     * @param int $duration the number of seconds in which the cached value will expire. 0 means never expire.
     * @return bool true if the value is successfully stored into cache, false otherwise
     */
    protected function setValue($key, $value, $duration)
    {
        return $this->yac->set($key, $value, $duration);
    }

    /**
     * Stores multiple key-value pairs in cache.
     * @param array $data array where key corresponds to cache key while value is the value stored
     * @param int $duration the number of seconds in which the cached values will expire. 0 means never expire.
     * @return array array of failed keys
     */
    protected function setValues($data, $duration)
    {
        return $this->yac->set($data,$duration);
    }

    /**
     * Stores a value identified by a key into cache if the cache does not contain this key.
     * This is the implementation of the method declared in the parent class.
     *
     * @param string $key the key identifying the value to be cached
     * @param mixed $value the value to be cached. Most often it's a string. If you have disabled [[serializer]],
     * it could be something else.
     * @param int $duration the number of seconds in which the cached value will expire. 0 means never expire.
     * @return bool true if the value is successfully stored into cache, false otherwise
     */
    protected function addValue($key, $value, $duration)
    {
        return $this->yac->set($key, $value, $duration);
    }

    /**
     * Adds multiple key-value pairs to cache.
     * The default implementation calls [[addValue()]] multiple times add values one by one. If the underlying cache
     * storage supports multiadd, this method should be overridden to exploit that feature.
     * @param array $data array where key corresponds to cache key while value is the value stored
     * @param int $duration the number of seconds in which the cached values will expire. 0 means never expire.
     * @return array array of failed keys
     */
    protected function addValues($data, $duration)
    {
        return $this->yac->set($data, $duration);
    }

    /**
     * Deletes a value with the specified key from cache
     * This is the implementation of the method declared in the parent class.
     * @param string $key the key of the value to be deleted
     * @return bool if no error happens during deletion
     */
    protected function deleteValue($key)
    {
        return $this->yac->delete($key);
    }

    /**
     * Deletes all values from cache.
     * This is the implementation of the method declared in the parent class.
     * @return bool whether the flush operation was successful.
     */
    protected function flushValues()
    {
        return $this->yac->flush();
    }
}
