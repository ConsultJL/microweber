<?php
/**
 * Here you will find how to work with the cache
 * These functions will allow you to save and get data from the MW cache system
 *
 * @package Cache
 * @category Cache
 * @desc  These functions will allow you to save and get data from the MW cache system
 */

if (!isset($_mw_cache_obj) or $_mw_cache_obj == false) {
    $_mw_cache_obj = new \mw\cache\Files();
}


mw_var('is_cleaning_now', false);
/**
 * Deletes cache directory for given $cache_group recursively.
 *
 * @param string $cache_group
 *            (default is 'global') - this is the subfolder in the cache dir.
 * @param bool $cache_storage_type
 * @return boolean
 *
 * @package Cache
 * @category Cache
 *
 */
function cache_clean_group($cache_group = 'global', $cache_storage_type = false)
{
    if ($cache_storage_type == false) {
        global $_mw_cache_obj;
        $local_obj = $_mw_cache_obj;
    } else {
        $cache_storage_type = "\mw\cache\\" . $cache_storage_type;
        $local_obj = new $cache_storage_type;

    }
     $local_obj->delete($cache_group);
}

/**
 *  Gets the data from the cache.
 *
 *  If data is not found it return false
 *
 *
 *  @example
 * <pre>
 *
 * $cache_id = 'my_cache_'.crc32($sql_query_string);
 * $cache_content = cache_get_content($cache_id, 'my_cache_group');
 *
 * </pre>
 *
 *
 *
 *
 * @param string $cache_id id of the cache
 * @param string $cache_group (default is 'global') - this is the subfolder in the cache dir.
 *
 * @param bool $cache_storage_type You can pass custom cache object or leave false.
 * @return  mixed returns array of cached data or false
 * @package Cache
 * @category Cache
 *
 */
function cache_get_content($cache_id, $cache_group = 'global', $cache_storage_type = false)
{

    if ($cache_storage_type == false) {
        global $_mw_cache_obj;
        $local_obj = $_mw_cache_obj;
    } else {
        $cache_storage_type = "\mw\cache\\" . $cache_storage_type;
        $local_obj = new $cache_storage_type;

    }

    return $local_obj->get($cache_id, $cache_group);
}

/**
 * Stores your data in the cache.
 * It can store any value that can be serialized, such as strings, array, etc.
 *
 * @example
 * <pre>
 * $data = array('something' => 'some_value');
 * $cache_id = 'my_cache_id';
 * $cache_content = cache_save($data, $cache_id, 'my_cache_group');
 * </pre>
 *
 * @param mixed $data_to_cache
 *            your data, anything that can be serialized
 * @param string $cache_id
 *            id of the cache, you must define it because you will use it later to
 *            retrieve the cached content.
 * @param string $cache_group
 *            (default is 'global') - this is the subfolder in the cache dir.
 *
 * @param bool $cache_storage_type
 * @return boolean
 * @package Cache
 * @category Cache
 */
function cache_save($data_to_cache, $cache_id, $cache_group = 'global', $cache_storage_type = false)
{

    if ($cache_storage_type == false) {
        global $_mw_cache_obj;
        $local_obj = $_mw_cache_obj;
    } else {
        $cache_storage_type = "\mw\cache\\" . $cache_storage_type;
        $local_obj = new $cache_storage_type;

    }
    // d($data_to_cache);
    return $local_obj->save($data_to_cache, $cache_id, $cache_group);

}


api_expose('clearcache');
/**
 * Clears all cache data
 *
 * @param bool $cache_storage_type
 * @return boolean
 * @package Cache
 * @category Cache
 */
function clearcache($cache_storage_type = false)
{
    if ($cache_storage_type == false or trim($cache_storage_type) == '') {
        global $_mw_cache_obj;
        $local_obj = $_mw_cache_obj;
    } else {
        $cache_storage_type = "\mw\cache\\" . $cache_storage_type;
        $local_obj = new $cache_storage_type;

    }

    return $local_obj->purge();
}

/**
 * Prints cache debug information
 *
 * @return array
 * @package Cache
 * @category Cache
 */
function cache_debug()
{
    global $_mw_cache_obj;
    return $_mw_cache_obj->debug();
}
