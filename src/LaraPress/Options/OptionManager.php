<?php

namespace LaraPress\Options;

use LaraPress\Actions\Dispatcher;

class OptionManager
{

    /**
     * @var Dispatcher
     */
    private $options;

    public function __construct()
    {
    }

    /**
     * @param string $key      Name of the option to be added. Must not exceed 64 characters. Use underscores to
     *                         separate words, and do not use uppercase—this is going to be placed into the database.
     * @param mixed  $value    Value for this option name. Limited to 2^32 bytes of data
     * @param bool   $autoload Should this option be automatically loaded by the function wp_load_alloptions() (puts
     *                         options into object cache on each page load)?
     *
     * @return bool
     */
    public function add($key, $value, $autoload = false)
    {
        return add_option(str_slug($key, '_'), $value, null, boolval($autoload));
    }

    /**
     * @param string $key The option key
     *
     * @return bool
     */
    public function delete($key)
    {
        return delete_option($key);
    }

    /**
     * @param string $key      Name of the option to update. Must not exceed 64 characters.
     * @param mixed  $value    The NEW value for this option name. This value can be an integer, string, array, or
     *                         object
     * @param  bool  $autoload Whether to load the option when WordPress starts up.
     *
     * @return bool
     */
    public function update($key, $value, $autoload = true)
    {
        return update_option($key, $value, boolval($autoload));
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed|void
     */
    public function get($key, $default = null)
    {
        return get_option($key, $default);
    }

    /**
     * Clear WordPress option cache
     */
    public function clearCache()
    {
        wp_cache_delete('alloptions', 'options');
    }
}
