<?php

class Theme
{
    function __construct()
    {
        $this->skininfo = array();
        #$this->skin        = isset($_SESSION['dpath']) ? $_SESSION['dpath'] : DEFAULT_THEME;
        if ($USER['raza'] == 0) {
            $this->skin = "gultra";
        } elseif ($USER['raza'] == 1) {
            $this->skin = "voltra";
        }
        $this->template = ROOT_PATH . 'styles/templates';
    }

    function isHome()
    {
        $this->template = ROOT_PATH . 'styles/home/';
    }

    function setUserTheme($Theme)
    {
        if (!file_exists(ROOT_PATH . 'styles/theme/' . $Theme . '/style.cfg')) {
            return false;
        }

        $this->skin     = $Theme;
        $this->parseStyleCFG();
    }

    function getTheme()
    {
        return './styles/theme/' . $this->skin . '/';
    }
    function getThemeName()
    {
        return $this->skin;
    }

    function getTemplatePath()
    {
        return $this->template;
    }

    function parseStyleCFG()
    {
        require(ROOT_PATH . 'styles/theme/' . $this->skin . '/style.cfg');
        $this->skininfo = $Skin;
        $this->template = ROOT_PATH . 'styles/templates';
    }

    static function getAvalibleSkins()
    {
        $Skins  = array_diff(scandir(ROOT_PATH . 'styles/theme/'), array('..', '.', '.svn', '.htaccess', 'index.htm'));
        $Themen = array();
        foreach ($Skins as $Theme) {
            require(ROOT_PATH . 'styles/theme/' . $Theme . '/style.cfg');
            $Themen[$Theme] = $Skin['name'];
        }

        return $Themen;
    }
}
