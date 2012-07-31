<?php

class Cache {

    static $connected = false;
    static $memcache = null;
    static $flag = MEMCACHE_COMPRESSED;
    static $cachekey  = '__CACHE__';
    static $prefix = '';
    static $useCleanQueue = true;

    /**
     * @param  array $options host, connect, flag, prefix
     * @return void
     */
    static function initialize(array $options)
    {
        if (!isset($options['host'])) die('Cache class initialize: servers not assigned!');

        if (!is_array($options['host'])) $options['host'] = array($options['host']);

        if (isset($options['flag'])) self::$flag = $options['flag'];

        if (isset($options['useCleanQueue'])) self::$useCleanQueue = $options['useCleanQueue'];

        if (isset($options['prefix'])) {

            self::$prefix = $options['prefix'];
            self::$cachekey = self::$prefix.self::$cachekey;
        }

        $connect = true;
        if (isset($options['connect'])) $connect = $options['connect'];

        if ($connect) self::connect($options['host']);
    }

    /**
     * Connect to the memcached server(s)
     */
    static function connect($servers) {

        self::$memcache = new Memcache();

        // several servers - use addServer
        foreach ($servers as $server) {

            $parts = explode(':', $server);

            $host = $parts[0];
            if(isset($parts[1])) $port = $parts[1]; else $port =  11211;

            if (self::$memcache->addServer($host, $port)) self::$connected = true;
        }

        return self::$connected;
    }

    /**
     * Flush all existing items at the servers
     * @static
     * @return void
     */
    static function flush() {

        if (!self::$connected) return false;
        self::$memcache->flush();
    }

    /**
     * Set a value in the cache
     * Expiration time is one hour if not set
     */
    static function set($key, $var, $expires = 3600, $flag = false) {

        if (!self::$connected) return false;

        if (!is_numeric($expires)) die('Cache class: set expires is not numeric!');

        if ($flag === false) $flag = self::$flag;
        //fix, to avoid errors in new memcached; 
        $var = is_scalar($var) ? (string)$var: $var;

        return self::$memcache->set(self::$prefix.$key, $var, $flag, $expires);
    }

    /**
     * replace value of existing item with key. In case if item with such key doesn't exists, returns FALSE.
     * @static
     * @param string $key
     * @param mixed $var
     * @param int $expires
     * @param bool $flag
     * @return mixed
     */
    static function replace($key, $var, $expires = 3600, $flag = false) {

        if (!self::$connected) return false;

        if (!is_numeric($expires)) die('Cache class: set expires is not numeric!');

        if ($flag === false) $flag = self::$flag;

        return self::$memcache->replace(self::$prefix.$key, $var, $flag, $expires);
    }

    /**
     * Get a value from cache
     */
    static function get($key) {

        if (!self::$connected) return false;
        if (self::$useCleanQueue && self::inCleanQueue($key)) return false;
        return self::$memcache->get(self::$prefix.$key);
    }

    /**
     * Remove value from cache
     */
    static function delete($key) {

        if (!self::$connected) return false;

        return self::$memcache->delete(self::$prefix.$key, 0);
    }

    static function increment($key, $value = 1) {
        if (!self::$connected) return false;

        return self::$memcache->increment(self::$prefix.$key, $value);
    }

    /**
     * @static
     * clear key value on get after $sec seconds
     * @param  string $key
     * @param  int $sec number of seconds
     * @return void
     */
    static function cleanQueue($key, $seconds = 0) {

        if (!self::$connected) return false;

        $r = self::$memcache->get(self::$cachekey);
        if (!is_array($r)) $r = array();
        $time = time();

        if (!isset($r[$key]) || (isset($r[$key]) && $time + $seconds < $r[$key])) {

            $r[$key] = $time + $seconds;
            self::$memcache->set(self::$cachekey, $r, 0, 0);
        }
    }

    static function inCleanQueue($key) {

        if (!self::$connected) return false;

        $r = self::$memcache->get(self::$cachekey);

        if (is_array($r) && isset($r[$key]) && $r[$key] <= time()) {

            unset($r[$key]);
            self::$memcache->set(self::$cachekey, $r, 0, 0);
            return 1;
        }

        return 0;
    }

    static function flushQueue () {

        if (!self::$connected) return false;

        self::$memcache->delete(self::$cachekey, 0);
    }

    static function getCacheKeys() {

        if (!self::$connected) return false;

        return self::$memcache->get(self::$cachekey);
    }



    // experemintal code below, use on own risk

    /**
     * getKeys()
     *
     *  get all keys from Memcache
     *
     * @author         Roman Kutsy
     * @version        2.0.20090708
     *
     * @return    array     $keys
     */
    function getKeys() {
        ///////////////////////////////////////////////////////////////////////
        $s = @fsockopen('127.0.0.1',11211);
        // SLABS //////////////////////////////////////////////////////////////
        fwrite($s, 'stats slabs'."\r\n");
        $slabs = array();
        while( !feof($s) )
        {
            $temp = fgets($s, 256);
            preg_match('/^STAT\s([0-9]*)(.*)/', $temp, $slab_temp);

            if(isset($slab_temp['1']) && strlen($slab_temp['1'])>0)
            {
                $slabs[] = $slab_temp['1'];
            }

            unset($slab_temp);

            if(trim($temp)=='END')
            {
                break;
            }
        }
        unset($temp);

        // ITEMS //////////////////////////////////////////////////////////////

        fwrite($s, 'stats items'."\r\n");

        $items = array();

        while( !feof($s) )
        {
            $temp = fgets($s, 256);

            preg_match('/^STAT\sitems\:([0-9]*)(.*)/', $temp, $item_temp);

            if(isset($item_temp['1']) && strlen($item_temp['1'])>0)
            {
                $items[] = $item_temp['1'];
            }

            unset($item_temp);

            if(trim($temp)=='END')
            {
                break;
            }
        }

        unset($temp);

        $slabs = array_unique($slabs);
        $items = array_unique($items);

        // CACHEDUMP //////////////////////////////////////////////////////////

        $keys = array();

        foreach($slabs as &$slab)
        {
            foreach($items as &$item) {
                fwrite($s, 'stats cachedump '.$slab.' '.$item."\r\n");
                while( !feof($s) ){
                    $temp = fgets($s, 256);

                    // ITEM cd3aec8b1dd7ef828267408e68b6d961:user_1_status [1 b; 1247043297 s]
                    // or
                    // ITEM sql_custom_photos_showphoto_11 [1379 b; 1247064083 s]

                    preg_match('/^ITEM\s([a-f0-9]{32}\:)?([A-Za-z0-9\_\-\.]*)\s\[[0-9]*\sb\;\s([0-9]*)\s.*/', $temp, $key_temp);

                    if(isset($key_temp['2']) && strlen($key_temp['2'])>0)
                    {
                        $keys[] = $key_temp['2'];
                    }

                    unset($key_temp);

                    if(trim($temp)=='END') {
                        break;
                    }
                }
            }
        }
        unset($temp,$slabs,$items);
        fclose($s);
        ///////////////////////////////////////////////////////////////////////
        $keys_temp = array_unique($keys);
        unset($keys);
        asort($keys_temp);
        $keys = array();
        foreach($keys_temp as &$k) {
            $keys[] = $k;
        }
        return $keys;
        ///////////////////////////////////////////////////////////////////////
    }
}