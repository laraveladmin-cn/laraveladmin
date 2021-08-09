<?php

namespace App\Services;

use ArrayAccess;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Config\Repository as ConfigContract;

/***
 * 生命周期内缓存数据项
 * Class LifeDataRepository
 * @package App\Services
 */
class LifeDataRepository implements ArrayAccess, ConfigContract
{
    /**
     * All of the option items.
     *
     * @var array
     */
    protected $items = [];

    protected $items_modified = [];

    /**
     * Determine if the given option value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return Arr::has($this->items, $key);
    }

    /**
     * Get the specified option value.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->items, $key, $default);
    }

    /**
     * Set a given option value.
     *
     * @param  array|string  $key
     * @param  mixed   $value
     * @return void
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                Arr::set($this->items, $innerKey, $innerValue);
                $this->items_modified[] = $innerKey;
            }
        } else {
            Arr::set($this->items, $key, $value);
            $this->items_modified[] = $key;
        }
    }


    /**
     * Prepend a value onto an array option value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function prepend($key, $value)
    {
        $array = $this->get($key);

        array_unshift($array, $value);

        $this->set($key, $array);
    }

    /**
     * Push a value onto an array option value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function push($key, $value)
    {
        $array = $this->get($key);

        $array[] = $value;

        $this->set($key, $array);
    }

    /**
     * Get all of the option items for the application.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Determine if the given option option exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get a option option.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a option option.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Unset a option option.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->set($key, null);
    }


    public function remember($key, \Closure $callback)
    {
        if($this->has($key)){
            return $this->get($key);
        }
        $this->set($key, $value = $callback());
        return $value;
    }

    public function clear(){
        $this->items = [];
        $this->items_modified = [];
    }

}
