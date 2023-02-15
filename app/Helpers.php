<?php

namespace App\Helpers;

use DB;

class Helper
{

    public static function dbQuery($query = "")
    {
        if ($query) {
            $get_res = DB::select($query);
            return json_decode(json_encode($get_res), true);
        }
    }
    function mysql_escape($inp)
    {
        return preg_replace('/[^A-Za-z0-9. -]/', '', $inp);

        return htmlspecialchars($inp,  ENT_COMPAT | ENT_XHTML, 'ISO-8859-1');
        return mb_convert_encoding($inp, 'UTF-8', 'UTF-8');

        return utf8_encode($inp);
        return htmlentities($inp,  ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
        return $inp;
        if (is_array($inp)) return array_map(__METHOD__, $inp);

        if (!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a", "©"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z', ''), $inp);
        }
        return html_entity_decode($inp);
    }

    function getUniqueArrayByKey($array, $key)
    {
        $unique = array();
        foreach ($array as $row) {
            $needle = $row[$key];
            if (array_key_exists($needle, $unique)) continue;
            $unique[$needle] = $row;
        }
        $final = array();
        foreach ($unique as $row) {
            array_push($final, $row);
        }
        return $final;
    }
}
