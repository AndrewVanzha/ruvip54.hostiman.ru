<?php
/**
* @var $APPLICATION
*/
// https://falbar.ru/article/pishem-pervyj-modul-dlya-1s-bitriks-s-ispolzovaniem-yadra-d7

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;
use Tsb\Feedback\Order;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$module_id = 'tsb.feedback';
$request = Application::getInstance()->getContext()->getRequest();
$post = $request->getPostList();
$get = $request->getQueryList();
$captcha = htmlspecialchars($APPLICATION->CaptchaGetCode());
$base_path = '/home/www/andreww1000.h1n.ru/';
$base_path = $_SERVER["DOCUMENT_ROOT"];
//debugg($_SERVER["DOCUMENT_ROOT"]);

//file_put_contents($base_path . '/dopX/obratny/tsb_test' . '.txt', 'test');

try {
    //debugg('$_POST=');
    //debugg($_POST);
    if (Loader::IncludeModule($module_id)) {
        if (count($post) > 0) {
            if(empty($post['dopname'])) {
                //$number = Order::create_order($post);
                //LocalRedirect("/obratny/?id={$number}#link-form");
                if ($APPLICATION->CaptchaCheckCode($post["captcha_code"], $post["captcha_id"])) {
                    $number = Order::create_order($post);
                    LocalRedirect("/dopX/obratny/?id={$number}#link-form");
                } else {
                    throw new Exception(json_encode(['captcha_code' => 'Неверно введена капча']));
                }
            } else {
                header("HTTP/1.0 200 OK"); // ответ боту
            }
        }

        if (!empty($get['id'])) {
            $success_message = "<p>Создано обращение с номером <strong>{$get['id']}</strong>.</p>При необходимости приобщить к обращению дополнительные файлы (документы, видео- и аудио-записи), просим вас направить их в Банк отдельным электронным письмом на адрес <a href='mailto:client@transstroybank.ru'>client@transstroybank.ru</a>, указав в теме сообщения идентификационный номер.";
        }
    }
} catch (Exception $e) {
    $errors = json_decode($e->getMessage(), true);
}

$APPLICATION->SetPageProperty("description", "Онлайн обращение в Банк");
$APPLICATION->SetPageProperty("keywords", "Обратная связь АКБ «Банк»");
$APPLICATION->SetPageProperty("title", "Обратная связь | АКБ «Банк»");
$APPLICATION->SetTitle("Онлайн обращение в Банк");
Asset::getInstance()->addCss("/assets/css/style-broker-deposit.css?v=1.0.6");
Asset::getInstance()->addCss("/dopX/obratny/style.css");
Asset::getInstance()->addJs("/dopX/obratny/script.js");
?>


<div class="page-lf">
    <div class="container">
        <section class="tsb-feedback-main">
            <header class="tsb-feedback-main__header col-md-8 offset-md-2">
                <h1 class="tsb-feedback-main__title page-title">Онлайн обращение в банк</h1>
            </header>
            <div class="row">
                <div class="tsb-feedback-main__image d-none d-md-block col-md-3 offset-md-2">
                    <img src="/dopX/obratny/images/microphone.png" alt="Обратная связь"/>
                </div>
                <div class="tsb-feedback-main__info col-md-5">
                    <p>Мы ценим мнение каждого клиента о качестве финансовых услуг, оказываемых АКБ «Банк»
                        (АО).</p>
                    <p>Помогите нам стать лучше – поделитесь своим впечатлением в форме обратной связи <a
                            href="#link-form">«Качество
                            обслуживания».</a></p>
                    <p>С её помощью мы сможем узнать ваши предложения по улучшению работы банка или получить жалобу
                        по конкретному факту некачественного обслуживания.
                        <span data-tsb-looltip="Обращаем ваше внимание, что Банк внимательно рассматривает все обращения и предложения и оставляет за собой право устанавливать характер обращения и срок предоставления ответа заявителю. В случае наличия у онлайн–обращения претензионного характера, по нему будет обязательно проведена соответствующая проверка.">
                                <img src="/dopX/obratny/images/info.svg">
                            </span>
                    </p>
                </div>
            </div>
        </section>

        <section class="tsb-feedback-form">
            <header class="tsb-feedback-form__header" id="link-form">
                <h2 class="tsb-feedback-form__title">Форма «Качество обслуживания»</h2>
            </header>
            <div class="tsb-feedback-form__wrapper">
                <?/*?><form action="#link-form" method="post" enctype="text/plain"><?*/?>
                <form  method="post">
                    <input class="tsb-feedback-form__input-special" name="dopname" type="text" placeholder="dopname" value="">
                    <div class="row">
                        <div class="tsb-feedback-form__block col-md-4 offset-md-1">
                            <div class="tsb-feedback-form__row">
                                <input class="tsb-feedback-form__input <?= $errors['sname'] ? ' tsb-feedback-form__input_error' : '' ?>"
                                       name="sname" type="text" placeholder="Фамилия"
                                       value="<?= $post['sname'] ? $post['sname'] : '' ?>" required>
                            </div>
                            <div class="tsb-feedback-form__row">
                                <input class="tsb-feedback-form__input <?= $errors['fname'] ? ' tsb-feedback-form__input_error' : '' ?>"
                                       name="fname" type="text" placeholder="Имя"
                                       value="<?= $post['fname'] ? $post['fname'] : '' ?>" required>
                            </div>
                            <div class="tsb-feedback-form__row">
                                <input class="tsb-feedback-form__input <?= $errors['mname'] ? ' tsb-feedback-form__input_error' : '' ?>"
                                       name="mname" type="text" placeholder="Отчество"
                                       value="<?= $post['mname'] ? $post['mname'] : '' ?>" required>
                            </div>
                            <div class="tsb-feedback-form__row">
                                <input class="tsb-feedback-form__input <?= $errors['phone'] ? ' tsb-feedback-form__input_error' : '' ?>"
                                       name="phone" type="tel" placeholder="+7 (___) ___-__-__" data-mask="phone"
                                       value="<?= $post['phone'] ? $post['phone'] : '' ?>" required>
                            </div>
                            <div class="tsb-feedback-form__row">
                                <input class="tsb-feedback-form__input <?= $errors['email'] ? ' tsb-feedback-form__input_error' : '' ?>"
                                       name="email" type="email" placeholder="email"
                                       value="<?= $post['email'] ? $post['email'] : '' ?>" required>
                            </div>
                        </div>
                        <div class="tsb-feedback-form__block col-md-6">
                            <div class="tsb-feedback-form__row">
                                <input class="tsb-feedback-form__input <?= $errors['subject'] ? ' tsb-feedback-form__input_error' : '' ?>"
                                       name="subject" type="text" placeholder="Тема обращения"
                                       value="<?= $post['subject'] ? $post['subject'] : '' ?>" required>
                            </div>
                            <div class="tsb-feedback-form__row">
                                <textarea name="text" cols="30" rows="10"
                                          class="tsb-feedback-form__textarea <?= $errors['text'] ? ' tsb-feedback-form__textarea_error' : '' ?>"
                                          placeholder="Текст обращения"
                                          required><?= $post['text'] ? $post['text'] : '' ?></textarea>
                            </div>
                            <label class="tsb-feedback-form__policy-label">
                                <div class="tsb-feedback-form__policy-input">
                                    <input type="checkbox" name="policy" <?= $post['policy'] ? 'checked' : '' ?>>
                                    <span></span>
                                </div>
                                <p>Настоящим подтверждаю, что я ознакомлен и согласен с <a href="/assets/docs/Правила оформления онлайн заявок.pdf" target="_blank">Правилами оформления онлайн заявки</a> и даю свое <a href="/assets/docs/Согласие на обработку ПД для сайта.pdf" target="_blank">Согласие на обработку персональных данных</a></p>
                            </label>
                        </div>
                    </div>
                    <?php if (!empty($errors) || !empty($success_message)): ?>
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="tsb-feedback-form__message <?= !empty($errors) ? 'tsb-feedback-form__message_error' : 'tsb-feedback-form__message_success' ?>">
                                    <?= !empty($errors) ? current($errors) : $success_message ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="tsb-feedback-form__footer">
                        <??>
                        <div class="tsb-feedback-form__captcha captcha clearfix">
                            <div class="captcha_image">
                                <input type="hidden" id="captchaSid" name="captcha_id" value="<?= $captcha ?>">
                                <img id="captchaImg"
                                     src="/bitrix/tools/captcha.php?captcha_sid=<?= $captcha ?>"
                                     alt=""
                                     style="display: none;">
                            </div>
                            <a id="reloadCaptcha" title="Обновить капчу"></a>
                            <div class="captcha_input">
                                <input type="text" name="captcha_code" placeholder="Код с картинки"
                                       class="input-field <?= $errors['captcha_code'] ? 'tsb-feedback-form__input_error' : '' ?>">
                            </div>
                        </div>
                        <??>
                        <button class="tsb-feedback-form__submit">Отправить</button>
                    </div>
                </form>
            </div>

        </section>
    </div>
</div>

<script>
    $(function() {
        $('.tsb-feedback-form__submit').on('click', function () {
            $('form').submit(function (e) {
                //e.preventDefault();
                let specialString = $('.tsb-feedback-form__input-special')[0].value; // ловим значение в скрытом поле
                //console.log('specialString');
                //console.log(specialString);
                if(specialString) {
                    e.preventDefault();
                    console.log('value in hidden field');
                } else {}
            });
        });
    });
</script>
