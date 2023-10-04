<?
// https://falbar.ru/article/pishem-pervyj-modul-dlya-1s-bitriks-s-ispolzovaniem-yadra-d7
// https://docviewer.yandex.by/view/0/?page=8&*=%2BOxQADIH1ETh9alDhb9mi5rxgc17InVybCI6Imh0dHA6Ly93ZWIuYml0cml4LnVhL2Rvd25sb2FkL3BwdC93ZWIxNzA2MTRtcC9JbnRlcmFjdGl2ZV9tYXBfMi5wZGYiLCJ0aXRsZSI6IkludGVyYWN0aXZlX21hcF8yLnBkZiIsIm5vaWZyYW1lIjp0cnVlLCJ1aWQiOiIwIiwidHMiOjE2Njc4MjI1MDAwNTAsInl1IjoiOTA3MDQwMTgzMTY2NzgyMjUwMCJ9&lang=ru
/**
 * Module: Кнопка наверх
 * Author: Андрей Ванжа
 * Site: http://andreww1000.h1n.ru/novyyblog/
 * File: index.php
 * Version: 1.0.0
 **/

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class webdo_totop extends CModule
{
    public function __construct() {

        if(file_exists(__DIR__."/version.php")) {

            $arModuleVersion = array();

            include_once(__DIR__."/version.php");

            $this->MODULE_ID 		   = str_replace("_", ".", get_class($this));
            $this->MODULE_VERSION 	   = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            $this->MODULE_NAME 		   = Loc::getMessage("WEBDO_TOTOP_NAME");
            $this->MODULE_DESCRIPTION  = Loc::getMessage("WEBDO_TOTOP_DESCRIPTION");
            $this->PARTNER_NAME 	   = Loc::getMessage("WEBDO_TOTOP_PARTNER_NAME");
            $this->PARTNER_URI  	   = Loc::getMessage("WEBDO_TOTOP_PARTNER_URI");
        }

        return false;
    }

    /**
     * Установка модуля
     *
     * @return bool|mixed
     */
    public function DoInstall() {
        global $APPLICATION;

        if (CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {
            $this->InstallFiles();
            $this->InstallDB();
            ModuleManager::registerModule($this->MODULE_ID);
            $this->InstallEvents();
        } else {
            $APPLICATION->ThrowException(Loc::getMessage("WEBDO_TOTOP_INSTALL_ERROR_VERSION"));
        }
        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("WEBDO_TOTOP_INSTALL_TITLE") . " \"" . Loc::getMessage("WEBDO_TOTOP_NAME") . "\"",
            __DIR__."/step.php"
        );

        return false;
    }

    /**
     * Установка файлов модуля
     *
     * @return bool|void
     */
    public function InstallFiles() {
        CopyDirFiles(
            __DIR__ . "assets/scripts",
            Application::getDocumentRoot() . "bitrix/js" . $this->MODULE_ID . "/",
            true,
            true
        );
        CopyDirFiles(
            __DIR__ . "assets/styles",
            Application::getDocumentRoot() . "bitrix/css" . $this->MODULE_ID . "/",
            true,
            true
        );

        return false;
    }

    /**
     * Установка базы данных
     *
     * @return bool
     */
    public function InstallDB() {
        return false;
    }

    /**
     * Установка событий
     *
     * @return bool|void
     */
    public function InstallEvents() {
        EventManager::getInstance()->registerEventHandler(
            "main",
            "OnBeforeEndBufferContent",
            $this->MODULE_ID,
            "Webdo\ToTop\Main",
            "appendScriptsToPage"
        );

        return false;
    }

    /**
     * Удаление модуля
     *
     * @return bool|mixed
     * @throws ArgumentNullException
     */
    public function DoUninstall() {
        global $APPLICATION;

        $this->UnInstallFiles();
        $this->UnInstallDB();
        $this->UnInstallEvents();
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("WEBDO_TOTOP_UNINSTALL_TITLE") . " \"" . Loc::getMessage("WEBDO_TOTOP_NAME") . "\"",
            __DIR__."/unstep.php"
        );

        return false;
    }

    /**
     * Удаление файлов модуля
     *
     * @return bool|void
     */
    public function UnInstallFiles() {
        Directory::deleteDirectory(Application::getDocumentRoot() . "bitrix/js" . $this->MODULE_ID);
        Directory::deleteDirectory(Application::getDocumentRoot() . "bitrix/css" . $this->MODULE_ID);

        return false;
    }

    /**
     * Удаление базы данных модуля
     *
     * @return bool|void
     * @throws ArgumentNullException
     */
    public function UnInstallDB() {
        Option::delete($this->MODULE_ID);

        return false;
    }

    /**
     * Удаление событий
     *
     * @return bool|void
     */
    public function UnInstallEvents() {
        EventManager::getInstance()->unRegisterEventHandler(
            "main",
            "OnBeforeEndBufferContent",
            $this->MODULE_ID,
            "Webdo\ToTop\Main",
            "appendScriptsToPage"
        );

        return false;
    }
}
