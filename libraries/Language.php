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
    /**
     * default language folder
     *
     * @var string
     */
    private $language_folder;
    /**
     * default prefix on language array key
     *
     * @var string
     */
    private $language_prefix;

    private $language_list = array(
            'en-us' => 'english',
            'zh-tw' => 'zh-tw'
        );

    public function __construct()
    {
        // check session
        $session_id = session_id();
        empty($session_id) and session_start();
    }

    public function load($langfile = '', $idiom = '')
    {
        $this->_set_language();

        $langfile = str_replace('.php', '', $langfile);
        // add prefix on language key
        $this->language_prefix = $langfile;

        $langfile .= '.php';

        if (in_array($langfile, $this->is_loaded, TRUE))
        {
            return;
        }

        if ($idiom == '')
        {
            $deft_lang = $this->language_folder;
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
        // add prefix value of array key
        $lang = $this->_set_prefix($lang);
        $this->language = array_merge($this->language, $lang);
        unset($lang);

        return TRUE;
    }

    public function line($line = '')
    {
        $value = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];

        return $value;
    }

    private function _set_prefix($lang = array())
    {
        $output = array();
        foreach ($lang as $key => $val)
        {
            $key = $this->language_prefix . "." . $key;
            $output[$key] = $val;
        }

        return $output;
    }

    private function _set_language()
    {
        $lang = (isset($_GET['lang'])) ? strtolower($_GET['lang']) : ((isset($_POST['lang'])) ? strtolower($_POST['lang']) : "");
        if ($lang != '')
        {
            // check lang is exist in group
            if (array_key_exists($lang, $this->language_list))
            {
                $_SESSION['lang'] = $lang;
            }
        }

        // set default browser language
        if (!isset($_SESSION['lang']))
        {
            $_SESSION['lang'] = $this->_default_lang();
        }

        $this->language_folder = $this->language_list[$_SESSION['lang']];
        return $this;
    }

    private function _default_lang()
    {
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtolower(strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',')) : '';
        return (!empty($browser_lang) and array_key_exists($browser_lang, $this->language_list)) ? strtolower($browser_lang) : 'en-us';
    }
}
