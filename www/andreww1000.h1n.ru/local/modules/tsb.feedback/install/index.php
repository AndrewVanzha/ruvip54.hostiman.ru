<?php

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class tsb_feedback extends CModule
{
    public function __construct()
    {
        if (file_exists(__DIR__ . "/version.php")) {

            $arModuleVersion = array();

            include_once(__DIR__ . "/version.php");

            $this->MODULE_ID = str_replace("_", ".", get_class($this));
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            $this->MODULE_NAME = Loc::getMessage("TSB_FEEDBACK_NAME");
            $this->MODULE_DESCRIPTION = Loc::getMessage("TSB_FEEDBACK_DESCRIPTION");
            $this->PARTNER_NAME = Loc::getMessage("TSB_FEEDBACK_PARTNER_NAME");
            $this->PARTNER_URI = Loc::getMessage("TSB_FEEDBACK_PARTNER_URI");
        }

        return false;
    }

    /**
     * Установка модуля
     *
     * @return bool|mixed
     */
    public function DoInstall()
    {
        global $APPLICATION;

        if (CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {
            $this->InstallFiles();
            $this->InstallDB();

            ModuleManager::registerModule($this->MODULE_ID);
            $this->InstallEvents();
        } else {
            $APPLICATION->ThrowException(
                Loc::getMessage("TSB_FEEDBACK_INSTALL_ERROR_VERSION")
            );
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("TSB_FEEDBACK_INSTALL_TITLE") . " \"" . Loc::getMessage("TSB_FEEDBACK_NAME") . "\"",
            __DIR__ . "/step.php"
        );

        return false;
    }

    /**
     * Установка файлов модуля
     *
     * @return bool|void
     */
    public function InstallFiles()
    {
        CopyDirFiles(
            __DIR__ . "/public",
            Application::getDocumentRoot() . "/obratny/",
            true,
            true
        );

        return true;
    }

    /**
     * Установка базы данных
     *
     * @return bool
     */
    public function InstallDB()
    {
        return $this->ImportDB('install');
    }

    /**
     * Импорт данных в таблицу
     *
     * @param $type
     * @return bool
     */
    private function ImportDB($type)
    {
        global $DB, $APPLICATION;

        $errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/db/" . $type . ".sql");

        if ($errors !== false) {
            $APPLICATION->ThrowException(implode("<br>", $errors));
            return false;
        }

        return true;
    }

    /**
     * Удаление модуля
     *
     * @return bool|mixed
     * @throws ArgumentNullException
     */
    public function DoUninstall()
    {
        global $APPLICATION;

        $this->UnInstallFiles();
        $this->UnInstallDB();
        $this->UnInstallEvents();

        ModuleManager::unRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("TSB_FEEDBACK_UNINSTALL_TITLE")." \"".Loc::getMessage("TSB_FEEDBACK_NAME")."\"",
            __DIR__."/unstep.php"
        );

        return true;
    }

    /**
     * Удаление файлов модуля
     *
     * @return bool|void
     */
    public function UnInstallFiles()
    {
        Directory::deleteDirectory(
            Application::getDocumentRoot() . "/obratny/"
        );

        return false;
    }

    /**
     * Удаление базы данных модуля
     *
     * @return bool|void
     * @throws ArgumentNullException
     */
    public function UnInstallDB()
    {
        Option::delete($this->MODULE_ID);

        return $this->ImportDB('uninstall');
    }
}