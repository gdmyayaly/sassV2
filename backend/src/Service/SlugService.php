<?php

namespace App\Service;


class SlugService
{
    public function clean_string($name)
    {
        $name = str_replace('"', '', $name);
        $name = str_replace(' ', '_', $name);
        $name = str_replace("'", '', $name);
        $name = str_replace("?", '', $name);
        $name = str_replace("/", '', $name);
        $name = str_replace("\\", '', $name);
        $name = str_replace(",", '', $name);
        $name = strtolower($name);
        $name = $this->skip_accents($name);
        return $name;
    }
    public function skip_accents($str, $charset = 'utf-8')
    {

        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);

        return $str;
    }
}