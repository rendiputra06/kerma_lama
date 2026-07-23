<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('_ent')) {
    function _ent($string = null)
    {
        return htmlentities($string);
    }
}

function convert_setting_data($data)
{
    $result = array();
    foreach ($data as $row) {
        $result[$row->kunci] = $row->nilai;
    }
    return $result;
}

if (!function_exists('make_slug')) {
    function make_slug($string)
    {
        $slug = trim($string); // trim the string
        $slug = preg_replace('/[^a-zA-Z0-9 -]/', '', $slug); // only take alphanumerical characters, but keep the spaces and dashes too...
        $slug = str_replace(' ', '-', $slug); // replace spaces by dashes
        $slug = strtolower($slug);  // make it lowercase
        return $slug;
    }
}
if (!function_exists('random')) {
    function random()
    {
        $pass = "";
        for ($i = 0; $i < 4; $i++) {
            $pass .= chr(mt_rand(35, 126));
        }
        return md5($pass);
    }
}
if (!function_exists('is_valid')) {
    function is_valid($uuid)
    {
        return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?' .
            '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
    }
}
if (!function_exists('make_sms')) {
    function make_sms($name = '')
    {
        if ($name == '') {
            $name = random();
        }
        $namespace = 'cb5032cf-9efe-42bb-8e40-a823e091e7aa';
        if (!is_valid($namespace)) return false;
        $nhex = str_replace(array('-', '{', '}'), '', $namespace);
        $nstr = '';
        for ($i = 0; $i < strlen($nhex); $i += 2) {
            $nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
        }
        $hash = md5($nstr . $name);
        return sprintf(
            '%08s-%04s-%04x-%04x-%12s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            substr($hash, 20, 12)
        );
    }
}
