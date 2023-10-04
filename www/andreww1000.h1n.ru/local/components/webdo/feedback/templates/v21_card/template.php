<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<? IncludeTemplateLangFile(__FILE__); ?>

<?//debugg($arResult);?>
<?//debugg($arParams);?>
<? debugg('webdo:feedback / v21_card'); ?>

<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" id="orderCard">

    <input type="hidden" name="FORM_ID" value="<?= $arResult['FORM_ID'] ?>">
    <input type="hidden" name="SESSION_ID" value="<?= bitrix_sessid() ?>">
    <input type="hidden" id="CARD_TYPE" name="CARD_TYPE" value="">
    <input type="hidden" id="CARD_NAME" name="CARD_NAME" value="">
    <input type="hidden" id="PARAMS" name="PARAMS" value='<?= json_encode($arParams["OPTIONS"]) ?>'>
    <input type="hidden" name="email2" value="">

    <div data-overlay="v21_overlay" class="v21-modal v21-fade js-v21-modal" id="v21_plasticOrder1">
        <div class="v21-modal__window js-v21-modal-window">
            <a href="#v21_plasticOrder1" class="v21-modal__close js-v21-modal-toggle">
                <svg width="24" height="24">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21/v21_v21-icons.svg#close"></use>
                </svg>
            </a>
            <h2 class="v21-modal__title v21-h2 page-header"><?= GetMessage("WEBDO_FEEDBACK_4_HEADER") ?></h2>
            <div class="v21-plastic-form">
                <div class="v21-plastic-form__heading">
                    <div class="v21-plastic-form__heading-count v21-plastic-form__count">
                        <span class="v21-plastic-form__count-current">1</span>
                        /
                        <span>2</span>
                    </div><!-- /.v21-plastic-form__heading-count -->
                    <h3 class="v21-plastic-form__heading-title v21-h5"><?= GetMessage("WEBDO_FEEDBACK_4_CONTACT_DETAIL") ?></h3>
                </div><!-- /.v21-plastic-form__heading -->

                <div class="v21-grid">
                    <?// debugg($arResult); ?>
                    <div class="v21-grid__item v21-grid-top__item">
                        <div class="v21-plastic-form__card js-v21-tabs">
                            <div class="v21-plastic-form__card-select v21-input-group">
                                <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_SELECTED_CARD") ?></span>
                                <div class="choices__inner">
                                    <select name="TYPE" class="v21-input-group__field v21-select js-v21-tabs-selector">
                                        <? if ($arResult['DEBETS_CARDS']) {
                                            foreach ($arResult['DEBETS_CARDS'] as $key => $card) {
                                                $selected = $key === 0 ? "selected" : "";
                                                ?>
                                                <?/*?><option value="<?= $card["NAME"] ?>" <?= $selected ?>><?= $card["NAME"] ?></option><?*/?>
                                                <option value="<?= $card["NAME"] ?>" ><?= $card["NAME"] ?></option>
                                                <?
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="v21-plastic-form__card-image v21-tabs-content v21-tabs-content__img">
                                <? if ($arResult['DEBETS_CARDS']) {
                                    foreach ($arResult['DEBETS_CARDS'] as $key => $card) {
                                        $isActive = $key === 0 ? " is-active" : "";
                                        ?>
                                        <div data-tab-id="<?= $card["NAME"] ?>" class="v21-tabs-content__item v21-fade<?= $isActive ?>">
                                            <img src="<?= CFile::GetPath($card["PREVIEW_PICTURE"]) ?>" alt="<?= $card["NAME"] ?>">
                                        </div>
                                        <?
                                    }
                                }
                                ?>
                            </div>
                            <?/*?>
                            <h4 class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_SELECTED_CARD") ?></h4>
                            <div class="v21-input-group__field v21-input--field" data-item></div>
                            <div class="v21-tabs-content__img">
                                <? if ($arResult['DEBETS_CARDS']) {
                                    foreach ($arResult['DEBETS_CARDS'] as $key => $card) : ?>
                                        <div data-tab-id="<?= $card["ID"] ?>" class="v21-tabs-content__item v21-hide">
                                            <img src="<?= CFile::GetPath($card["PREVIEW_PICTURE"]) ?>" alt="<?= $card["NAME"] ?>">
                                        </div>
                                    <? endforeach;
                                }
                                ?>
                            </div>
                            <?*/?>
                        </div>
                    </div>
                    <?// debugg($arResult['DEBETS_CARDS']); ?>

                </div> <!-- /.v21-grid -->

                <div class="v21-grid">
                    <!--div class="v21-grid__item v21-grid__item--1x2@sm v21-grid__item--1x3@lg"-->
                    <div class="v21-grid__item">
                        <label class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_PHONE") ?></span>
                            <input type="tel" name="PHONE" placeholder="+7 ___ _______" data-inputmask="'mask': '+7 999 9999999'" class="v21-input-group__field v21-field">
                            <span class="v21-input-group__warn">Обязательное поле к заполнению</span>
                            <span class="v21-input-group__note"><?= GetMessage("WEBDO_FEEDBACK_4_PHONE_LINE") ?></span>
                        </label>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item">
                        <label class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_EMAIL") ?></span>
                            <input type="email" name="EMAIL_TO" placeholder="example@gmail.com" class="v21-input-group__field v21-field">
                            <span class="v21-input-group__warn">Обязательное поле к заполнению</span>
                            <span class="v21-input-group__note"><?= GetMessage("WEBDO_FEEDBACK_4_EMAIL_LINE") ?></span>
                        </label>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item">
                        <div class="v21-input-group">
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_CITY") ?></span>
                            <? CModule::IncludeModule('iblock'); ?>
                            <? $cities = CIblockElement::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => 17)); ?>
                            <div class="choices__inner">
                                <select name="CITY" class="v21-input-group__field v21-select js-v21-select">
                                    <? while ($city = $cities->Fetch()) { ?>
                                        <option value="<?= $city['NAME'] ?>" <? if ($arResult['POST']['CITY'] == $city['NAME']) { ?>selected<? } ?> <? if (!isset($arResult['POST']['CITY']) && $city['NAME'] == 'Москва') { ?>selected<? } ?>>
                                            <?= $city['NAME'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item">
                        <label class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_LAST_NAME") ?></span>
                            <input type="text" name="LAST_NAME" placeholder="Пушкин" class="v21-input-group__field v21-field">
                            <span class="v21-input-group__warn">Обязательное поле к заполнению</span>
                        </label>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item">
                        <label class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_FIRST_NAME") ?></span>
                            <input type="text" name="FIRST_NAME" placeholder="Александр" class="v21-input-group__field v21-field">
                            <span class="v21-input-group__warn">Обязательное поле к заполнению</span>
                        </label>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item">
                        <label class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_SECOND_NAME") ?></span>
                            <input type="text" name="SECOND_NAME" placeholder="Сергеевич" class="v21-input-group__field v21-field">
                            <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                        </label>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item v21-grid__translit">
                        <label class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_TRANSLIT") ?></span>
                            <input type="text" name="TRANSLIT" placeholder="IVAN IVANOV" style="text-transform: uppercase;" class="v21-input-group__field v21-field">
                            <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                            <span class="v21-input-group__note"><?= GetMessage("WEBDO_FEEDBACK_4_TRANSLIT_DESC") ?></span>
                        </label>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item v21-plastic-form__controls">
                        <a href="#v21_plasticOrder2" class="v21-plastic-form__next v21-button js-v21-modal-toggle">
                        <!--button class="v21-plastic-form__next v21-button js-v21-modal-toggle v21_plasticOrder2"-->
                            <span><?= GetMessage("WEBDO_FEEDBACK_4_NEXT") ?> </span>
                            <svg width="10" height="10" class="v21-plastic-form__next-icon">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21/v21_v21-icons.svg#chevronRight"></use>
                            </svg>
                        <!--/button-->
                        </a>
                        <div class="v21-plastic-form__controls-count v21-plastic-form__count">
                            <span class="v21-plastic-form__count-current">1</span>
                            /
                            <span>2</span>
                        </div><!-- /.v21-plastic-form__controls-count -->
                    </div><!-- /.v21-plastic-form__controls -->
                </div><!-- /.v21-grid -->
            </div><!-- /.v21-plastic-form -->
        </div><!-- /.v21-modal__window -->
    </div><!-- /.v21-modal -->

    <div data-overlay="v21_overlay" class="v21-modal v21-fade js-v21-modal" id="v21_plasticOrder2">
        <div class="v21-modal__window js-v21-modal-window">
            <a href="#v21_plasticOrder2" class="v21-modal__close js-v21-modal-toggle">
                <svg width="24" height="24">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21/v21_v21-icons.svg#close"></use>
                </svg>
            </a>
            <h2 class="v21-modal__title v21-h2"><?= GetMessage("WEBDO_FEEDBACK_4_HEADER") ?></h2>
            <div class="v21-plastic-form js-v21-tabs">
                <div class="v21-plastic-form__heading">
                    <div class="v21-plastic-form__heading-count v21-plastic-form__count">
                        <span class="v21-plastic-form__count-current">2</span>
                        /
                        <span>2</span>
                    </div><!-- /.v21-plastic-form__heading-count -->
                    <h3 class="v21-plastic-form__heading-title v21-h5"><?= GetMessage("WEBDO_FEEDBACK_4_DATA_REGISTRATION") ?></h3>
                </div><!-- /.v21-plastic-form__heading -->

                <div class="v21-grid">
                    <div class="v21-grid__item">
                        <div class="v21-input-group">
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_TYPE_PASS") ?></span>
                            <div class="choices__inner">
                                <select name="TYPE_PASS" class="v21-input-group__field v21-select js-v21-select">
                                    <option value="<?= GetMessage("WEBDO_FEEDBACK_4_PASS_RF") ?>">
                                        <?= GetMessage("WEBDO_FEEDBACK_4_PASS_RF") ?>
                                    </option>
                                    <option value="<?= GetMessage("WEBDO_FEEDBACK_4_PASS_INOY") ?>">
                                        <?= GetMessage("WEBDO_FEEDBACK_4_PASS_INOY") ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item">
                        <div class="v21-input-group">
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_SEX") ?></span>
                            <div class="v21-switch">
                                <input type="radio" name="SEX" id="v21_genderMale" value="Мужской" class="v21-switch__input" <? if (!isset($arResult['POST']['SEX'])) { ?> checked <? } ?> <? if (isset($arResult['POST']['SEX'])) { ?> <? if ($arResult['POST']['SEX'] == 'Мужской') { ?> checked <? } ?> <? } ?>>
                                <label for="v21_genderMale" class="v21-switch__label"><?= GetMessage("WEBDO_FEEDBACK_4_SEX_MALE") ?></label>
                                <input type="radio" name="SEX" id="v21_genderFemale" value="Женский" class="v21-switch__input" <? if (isset($arResult['POST']['SEX'])) { ?> <? if ($arResult['POST']['SEX'] == 'Женский') { ?> checked <? } ?> <? } ?>>
                                <label for="v21_genderFemale" class="v21-switch__label"><?= GetMessage("WEBDO_FEEDBACK_4_SEX_FEMALE") ?></label>
                                <div class="v21-switch__handle"></div>
                            </div>
                        </div>
                    </div><!-- /.v21-grid__item -->
                </div><!-- /.v21-grid -->

                <div class="v21-plastic-form__tabs v21-tabs-content">
                    <div data-tab-id="document1" class="v21-fade is-active">
                        <div class="v21-grid">
                            <div class="v21-grid__item">
                                <label class="v21-input-group">
                                    <!-- добавить is-error для выделения при ошибке -->
                                    <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_PASS_SERIYA") ?></span>
                                    <input type="text" name="PASS_SERIYA" inputmode="numeric" placeholder="__-__" data-inputmask="'mask': '99 99'" class="v21-input-group__field v21-field">
                                    <span class="v21-input-group__warn">Обязательное поле к заполнению</span>
                                    <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                                </label>
                            </div><!-- /.v21-grid__item -->

                            <div class="v21-grid__item">
                                <label class="v21-input-group">
                                    <!-- добавить is-error для выделения при ошибке -->
                                    <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_PASS_NUMBER") ?></span>
                                    <input type="text" name="PASS_NUMBER" inputmode="numeric" placeholder="______" data-inputmask="'mask': '999999'" class="v21-input-group__field v21-field">
                                    <span class="v21-input-group__warn">Обязательное поле к заполнению</span>
                                    <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                                </label>
                            </div><!-- /.v21-grid__item -->

                            <div class="v21-grid__item">
                                <div class="v21-input-group">
                                    <!-- добавить is-error для выделения при ошибке -->
                                    <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_PASS_DATA") ?></span>
                                    <input type="text" inputmode="numeric" name="PASS_DATA" data-inputmask="'mask': '99.99.9999'" placeholder="__.__.____" class="v21-input-group__field v21-field v21-datepicker js-v21-datepicker">
                                    <span class="v21-input-group__warn">Обязательное поле к заполнению</span>
                                    <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                                </div>
                            </div><!-- /.v21-grid__item -->

                            <div class="v21-grid__item">
                                <label class="v21-input-group">
                                    <!-- добавить is-error для выделения при ошибке -->
                                    <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_PASS_KEM") ?></span>
                                    <input type="text" name="PASS_KEM" class="v21-input-group__field v21-field">
                                    <span class="v21-input-group__warn">Обязательное поле к заполнению</span>
                                    <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                                </label>
                            </div><!-- /.v21-grid__item -->

                            <div class="v21-grid__item">
                                <label class="v21-input-group">
                                    <!-- добавить is-error для выделения при ошибке -->
                                    <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_PASS_COD") ?></span>
                                    <input type="text" name="PASS_COD" inputmode="numeric" placeholder="___-___" data-inputmask="'mask': '999-999'" class="v21-input-group__field v21-field">
                                    <span class="v21-input-group__warn">Обязательное поле к заполнению</span>
                                    <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                                </label>
                            </div><!-- /.v21-grid__item -->
                        </div><!-- /.v21-grid -->
                    </div><!-- /.v21-tabs-content__item -->
                </div><!-- /.v21-tabs-content -->

                <div class="v21-grid">
                    <div class="v21-grid__item">
                        <label class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_PASS_MESTO") ?></span>
                            <input type="text" name="PASS_MESTO" class="v21-input-group__field v21-field">
                            <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                        </label>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item">
                        <div class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_BIRTHDATE") ?></span>
                            <input type="text" inputmode="numeric" name="BIRTHDATE" data-inputmask="'mask': '99.99.9999'" placeholder="__.__.____" class="v21-input-group__field v21-field v21-datepicker js-v21-datepicker">
                            <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                        </div>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item">
                        <label class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_PASS_ADDR_R") ?></span>
                            <input type="text" name="PASS_ADDR_R" class="v21-input-group__field v21-field">
                            <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                        </label>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item v21-grid__item--end block_deliveryHome">
                        <div class="v21-plastic-form__sync v21-input-group">
                            <div class="v21-switch v21-switch--check">
                                <input type="checkbox" name="DELIVERYCARD" id="v21_deliveryHome" class="v21-switch__input js-v21-sync-field">
                                <label for="v21_deliveryHome" class="v21-switch__label"><?= GetMessage("WEBDO_FEEDBACK_4_DELIVERYCARD") ?></label>
                                <div class="v21-switch__handle"></div>
                            </div>
                        </div>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item">
                        <label class="v21-input-group">
                            <!-- добавить is-error для выделения при ошибке -->
                            <span class="v21-input-group__label"><?= GetMessage("WEBDO_FEEDBACK_4_PASS_ADDR_F") ?></span>
                            <input type="text" name="PASS_ADDR_F" class="v21-input-group__field v21-field">
                            <!-- <span class="v21-input-group__warn">Пример сообщения об ошибке</span> -->
                        </label>
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-grid__item v21-grid__item--end">
                        <div class="v21-plastic-form__sync v21-input-group">
                            <div class="v21-switch v21-switch--check">
                                <input type="checkbox" data-sync-to="PASS_ADDR_F" data-sync-from="PASS_ADDR_R" autocomplete="off" name="" id="v21_addressSync" class="v21-switch__input js-v21-sync-field">
                                <label for="v21_addressSync" class="v21-switch__label"><?= GetMessage("WEBDO_FEEDBACK_4_PASS_ADDR_S") ?></label>
                                <div class="v21-switch__handle"></div>
                            </div>
                        </div>
                    </div><!-- /.v21-grid__item -->

                    <??>
                    <div class="v21-grid__item">
                        <div class="captcha_image">
                            <input type="hidden" id="captchaSid" name="CAPTCHA_ID" value="<?= $arResult['CAPTCHA'] ?>" />
                            <img id="captchaImg" src="/local/tools/captcha.php?captcha_sid=<?= $arResult['CAPTCHA'] ?>" alt="">
                        </div>

                        <a id="reloadCaptcha" title="Обновить капчу"></a>

                        <div class="captcha_input v21-input-group">
                            <input type="text" name="CAPTCHA_WORD" placeholder="<?= GetMessage('WEBDO_FEEDBACK_CAPTCHA') ?>" class="v21-input-group__field v21-field" id="CAPTCHA_WORD">
                            <span class="v21-input-group__warn">Неверно введен код с картинки</span>
                        </div>
                    </div>
                    <??>

                    <div class="v21-grid__item">
                        <?
                        $politics = GetMessage("WEBDO_FEEDBACK_4_POLITICS");
                        $politics_1 = "<a class='v21-link' href='/assets/docs/Правила оформления онлайн заявок.pdf' target='_blank'><span class='v21-link__text'>" . GetMessage("WEBDO_FEEDBACK_4_POLITICS_1") . "</span></a>";
                        $politics_2 = "<a class='v21-link' href='/assets/docs/Согласие на обработку ПД для сайта.pdf' target='_blank'><span class='v21-link__text'>" . GetMessage("WEBDO_FEEDBACK_4_POLITICS_2") . "</span></a>";
                        $politics_output = sprintf($politics, $politics_1, $politics_2);
                        ?>
                        <div class="v21-checkbox">
                            <label class="v21-checkbox__content">
                                <input id="politics" type="checkbox" checked name="politics" class="v21-checkbox__input">
                                <span class="v21-checkbox__text">
                                    <?= $politics_output ?>
                                </span>
                            </label>
                            <span class="v21-checkbox__warn">Для подачи заявки необходимо подтвердить свое ознакомление и соглашение с правилами</span>
                        </div><!-- /.v21-checkbox -->
                    </div><!-- /.v21-grid__item -->

                    <div class="v21-plastic-form__controls v21-grid__item">
                        <button class="v21-plastic-form__submit v21-button" name="WEBDO_FEEDBACK">
                            <?= GetMessage("WEBDO_FEEDBACK_4_BUTTON") ?>
                        </button>
                        <a href="#v21_plasticOrder1" class="v21-button v21-button--link js-v21-modal-toggle prevPageForm">
                        <!--button class="v21-button v21-button--link js-v21-modal-toggle prevPageForm v21_plasticOrder1"-->
                            <span>Вернуться назад</span>
                            <svg width="9" height="9" class="v21-button__icon">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21/v21_v21-icons.svg#arrowBack"></use>
                            </svg>
                        <!--/button-->
                        </a>
                        <div class="v21-plastic-form__controls-count v21-plastic-form__count">
                            <span class="v21-plastic-form__count-current">2</span>
                            /
                            <span>2</span>
                        </div><!-- /.v21-plastic-form__controls-count -->
                    </div><!-- /.v21-plastic-form__controls -->
                </div><!-- /.v21-grid -->
            </div><!-- /.v21-plastic-form -->
        </div><!-- /.v21-modal__window -->
    </div><!-- /.v21-modal -->
</form>


<div data-overlay="v21_overlay" class="v21-modal v21-fade js-v21-modal" id="v21_alert_orderCard">
    <div class="v21-modal__window js-v21-modal-window">
        <a href="#v21_alert_orderCard" class="v21-modal__close js-v21-modal-toggle">
            <svg width="24" height="24">
                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21/v21_v21-icons.svg#close"></use>
            </svg>
        </a>
    </div>
</div>
