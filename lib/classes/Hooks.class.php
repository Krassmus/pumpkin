<?php

/*
 *  Copyright (c) 2012  Rasmus Fuhse <fuhse@data-quest.de>
 * 
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License as
 *  published by the Free Software Foundation; either version 2 of
 *  the License, or (at your option) any later version.
 */

class Hooks {

    static protected $hooks = array();

    /**
    * With this method you can create small plugins for any module. The only matter
    * is if the module listens to that hook. When a module B uses once the function
    * B::trigger('get_information'), your module A can call the
    * function B::bind('get_information', 'A::return_information')
    * in its constructor. Then module B gets some information from A. Nice, isn't it?
    * @param string $hookname : any name of the hook - there is no check if it exists
    * @param string $function : name of a function like "matrix::return_information"
    */
    static public function bind($hookname, $function) {
        self::$hooks[$hookname][] = $function;
    }

    /**
    * @param string $hookname : any name of a hook
    * @param string $expected : 'string','integer','number','boolean','array','null'
    *                           which the called function should return
    * @param array $parameter : should be an associative array
    * @return mixed : depends on $expected, null if no function was registered
    */
    static public function trigger($hookname, $expected = "string", $parameter = array()) {
        is_array(self::$hooks[$hookname]) OR self::$hooks[$hookname] = array();
        switch ($expected) {
            case "integer":
                $ret = 0;
                foreach (self::$hooks[$hookname] as $function) {
                    $ret += (int) call_user_func($function, $parameter);
                }
                break;
            case "number":
                $ret = 0;
                foreach (self::$hooks[$hookname] as $function) {
                    $ret += call_user_func($function, $parameter);
                }
                break;
            case "boolean":
                $ret = true;
                foreach (self::$hooks[$hookname] as $function) {
                    $ret = $ret && call_user_func($function, $parameter) ? true : false;
                }
                break;
            case "array":
                $ret = array();
                foreach (self::$hooks[$hookname] as $function) {
                    $ret = array_merge($ret, call_user_func($function, $parameter));
                }
                break;
            case 'null':
                foreach (self::$hooks[$hookname] as $function) {
                    call_user_func($function, $parameter);
                }
                break;
            case "string":
            default:
                $ret = "";
                foreach (self::$hooks[$hookname] as $function) {
                    $ret .= call_user_func($function, $parameter);
                }
        }
        return $ret;
    }
}
