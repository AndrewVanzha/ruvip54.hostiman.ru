<?php
/**
 * @var $result
 */

$type = !empty($result['data']['type']) && $result['data']['type'] === 'email' ? 'email' : 'phone';
print_r('<br>$result=');
print_r($result);
print_r('<br>$type=');
print_r($type);
?>
<script>
    function changeType(type) {
        const emailField = document.getElementById('vs-form-field-email')
        const emailFieldInput = emailField.querySelector('input')
        if (type === 'email') {
            emailField.style.display = 'block'
            emailFieldInput.disabled = false
        } else {
            emailField.style.display = 'none'
            emailFieldInput.disabled = true
        }
    }
</script>

<h2 class="vs-orders__title">Создание заявки</h2>
<div class="vs-order__wrapper">
    <form class="vs-order__block vs-form" action="/local/modules/webdo.verification/process/manager.php" method="post">
        <div class="vs-form__field">
            <div class="vs-form__label">Тип заявки</div>
            <div class="vs-form__row vs-form__row_flex">
                <div class="vs-form__radio">
                    <input
                            type="radio"
                            name="type"
                            value="phone"
                            id="type_phone"
                        <?= $type === 'phone' ? 'checked' : '' ?>
                            onchange="changeType('phone')"
                    >
                    <label for="type_phone">верификация телефона</label>
                </div>
                <div class="vs-form__radio">
                    <input
                            type="radio"
                            name="type"
                            value="email"
                            id="type_email"
                        <?= $type === 'email' ? 'checked' : '' ?>
                            onchange="changeType('email')"
                    >
                    <label for="type_email">верификация email</label>
                </div>
            </div>
        </div>
        <div class="vs-form__field">
            <div class="vs-form__label">Код клиента в АБС</div>
            <div class="vs-form__row">
                <input
                        type="text"
                        name="abs_id"
                        class="vs-input vs-form__input"
                        value="<?= !empty($result['data']['abs_id']) ? $result['data']['abs_id'] : '' ?>"
                >
            </div>
        </div>
        <div class="vs-form__field">
            <div class="vs-form__label">Номер телефона</div>
            <div class="vs-form__row">
                <input
                        type="tel"
                        name="phone"
                        class="vs-input vs-form__input"
                        data-mask="phone"
                        placeholder="+7 (___) ___-__-__"
                        value="<?= !empty($result['data']['phone']) ? $result['data']['phone'] : '' ?>"
                >
            </div>
        </div>
        <div class="vs-form__field" id="vs-form-field-email" <?= $type === 'phone' ? 'style="display: none"' : '' ?>>
            <div class="vs-form__label">Email-адрес</div>
            <div class="vs-form__row">
                <input
                        type="email"
                        name="email"
                        class="vs-input vs-form__input"
                    <?= $type === 'phone' ? 'disabled' : '' ?>
                        value="<?= !empty($result['data']['email']) ? $result['data']['email'] : '' ?>"
                >
            </div>
        </div>
        <? if (!empty($result['error'])): ?>
            <div class="vs-form__field vs-form__error"><?= $result['error'] ?></div>
        <? endif; ?>
        <input type="hidden" name="action" value="create_order">
        <button class="vs-button vs-form__button">Создать заявку</button>
    </form>
</div>