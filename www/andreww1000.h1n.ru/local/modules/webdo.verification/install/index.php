<?
// https://falbar.ru/article/pishem-pervyj-modul-dlya-1s-bitriks-s-ispolzovaniem-yadra-d7
// https://docviewer.yandex.by/view/0/?page=8&*=%2BOxQADIH1ETh9alDhb9mi5rxgc17InVybCI6Imh0dHA6Ly93ZWIuYml0cml4LnVhL2Rvd25sb2FkL3BwdC93ZWIxNzA2MTRtcC9JbnRlcmFjdGl2ZV9tYXBfMi5wZGYiLCJ0aXRsZSI6IkludGVyYWN0aXZlX21hcF8yLnBkZiIsIm5vaWZyYW1lIjp0cnVlLCJ1aWQiOiIwIiwidHMiOjE2Njc4MjI1MDAwNTAsInl1IjoiOTA3MDQwMTgzMTY2NzgyMjUwMCJ9&lang=ru

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class webdo_verification extends CModule
{
    public function __construct(){

        if(file_exists(__DIR__."/version.php")){

            $arModuleVersion = array();

            include_once(__DIR__."/version.php");

            $this->MODULE_ID 		   = str_replace("_", ".", get_class($this));
            $this->MODULE_VERSION 	   = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            $this->MODULE_NAME 		   = Loc::getMessage("WD_VERIFICATION_NAME");
            $this->MODULE_DESCRIPTION  = Loc::getMessage("WD_VERIFICATION_DESCRIPTION");
            $this->PARTNER_NAME 	   = Loc::getMessage("WD_VERIFICATION_PARTNER_NAME");
            $this->PARTNER_URI  	   = Loc::getMessage("WD_VERIFICATION_PARTNER_URI");
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
            $this->CreateGroup();
            ModuleManager::registerModule($this->MODULE_ID);
            $this->InstallEvents();
        } else {
            $APPLICATION->ThrowException(Loc::getMessage("WD_VERIFICATION_INSTALL_ERROR_VERSION"));
        }
        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("WD_VERIFICATION_INSTALL_TITLE") . " \"" . Loc::getMessage("WD_VERIFICATION_NAME") . "\"",
            __DIR__."/step.php"
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
            Application::getDocumentRoot() . "/" . $this->MODULE_ID . "/",
            true,
            true
        );

        return true;
    }

    /**
     * Создание группы верификаторов
     */
    public function CreateGroup()
    {
        global $APPLICATION;
        $group = new CGroup;

        $arFields = array(
            "ACTIVE" => "Y",
            "C_SORT" => 100,
            "NAME" => Loc::getMessage("GROUP_NAME"),
            "DESCRIPTION" => Loc::getMessage("GROUP_DESCRIPTION"),
            "STRING_ID" => "verifiers"
        );

        $group_id = $group->Add($arFields);

        try {
            Option::set($this->MODULE_ID, "group_id", $group_id);
        } catch (\Bitrix\Main\ArgumentOutOfRangeException $e) {
            $APPLICATION->ThrowException(
                Loc::getMessage("GROUP_ERROR")
            );
        }
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
     * Установка событий
     *
     * @return bool|void
     */
    public function InstallEvents()
    {
        return false;
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
        $this->DeleteGroup();
        $this->UnInstallDB();
        $this->UnInstallEvents();

        ModuleManager::unRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("WD_VERIFICATION_UNINSTALL_TITLE") . " \"" . Loc::getMessage("WD_VERIFICATION_NAME") . "\"",
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
            Application::getDocumentRoot() . "/" . $this->MODULE_ID . "/"
        );

        return false;
    }

    /**
     * Удаление группы верификаторов
     */
    public function DeleteGroup()
    {
        global $APPLICATION;
        global $DB;
        $group = new CGroup;

        try {
            $DB->StartTransaction();
            $group_id = Option::get($this->MODULE_ID, "group_id");
            $group->Delete(IntVal($group_id));
        } catch (ArgumentNullException $e) {
            $APPLICATION->ThrowException(
                Loc::getMessage("GROUP_DELETE_ERROR")
            );
        } catch (\Bitrix\Main\ArgumentOutOfRangeException $e) {
            $APPLICATION->ThrowException(
                Loc::getMessage("GROUP_DELETE_ERROR")
            );
        }
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

    /**
     * Удаление событий
     *
     * @return bool|void
     */
    public function UnInstallEvents()
    {
        return false;
    }
}
