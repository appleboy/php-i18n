<?php

class Language {

    /**
     * List of translations
     *
     * @var array
     */
    var $language   = array();
    /**
     * List of loaded language files
     *
     * @var array
     */
    var $is_loaded  = array();

    public function __construct()
    {
        echo "load language class\n";
    }

    public function load($langfile = '', $idiom = 'english')
    {
        $langfile = str_replace('.php', '', $langfile);

        $langfile .= '.php';

        if (in_array($langfile, $this->is_loaded, TRUE))
        {
            return;
        }

        if ($idiom == '')
        {
            $idiom = ($deft_lang == '') ? 'english' : $deft_lang;
        }

        // Determine where the language file is and load it
        if (file_exists('language/'.$idiom.'/'.$langfile))
        {
            include('language/'.$idiom.'/'.$langfile);
        }

        if ( ! isset($lang))
        {
            return;
        }

        $this->is_loaded[] = $langfile;
        $this->language = array_merge($this->language, $lang);
        unset($lang);

        return TRUE;
    }

    public function line($line = '')
    {
        $value = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];

        return $value;
    }
}
