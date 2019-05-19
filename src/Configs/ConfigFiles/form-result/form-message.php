<?php
use ES\Kernel\System\Validators\Validators;

return [
	Validators::AUTH => [
		'login'          => 'Не заполнен логин или email.',
		'password'       => 'Не заполнен пароль.',
		'fail-auth-data' => 'Не верно введен логин(email) или пароль.',
		'query'          => 'Не корректный запрос.',
	],
	Validators::AUTH_APP => [
		'clientId'     => 'Не заполнен clientId.',
		'clientSecret' => 'Не заполнен clientSecret.',
		'site'         => 'Не заполнен site.',
		'login'        => 'Не заполнен логин или email.',
		'password'     => 'Не заполнен пароль.',
		'query'        => 'Не корректный запрос.',
	],
	Validators::REGISTER => [
		'login'      => 'Не заполнен логин.',
		'email'      => 'Не верно заполнен email.',
		'password'   => 'Не заполнен пароль.',
		'query'      => 'Не корректный запрос.',
		'user-exist' => 'Пользователь с такимии данными уже есть на сайте.'
	],
	Validators::ADD_WORD => [
		'text'      => 'Поле со словом не заполнено',
		'translate' => 'Перевод не заполнен'
	],
	Validators::EDIT_WORD => [
		'translate' => 'Перевод не заполнен',
		'type'      => 'Текст не может быть пустым'
	],
	Validators::COMMON => [
		'error-query'     => 'Ошибка при выполнении опреации, попробуйте позже.',
		'error-save'      => 'Возникла ошибка при сохранении данных.',
		'already-auth'    => 'Вы уже вшли на сайт.',
		'unknown-clients' => 'Не найдено приложение с такими clientId и clientSecret.',
		'unknown-refresh' => 'Получен не известный refreshToken.',
		'unknown-access'  => 'Получен неизвестный accessToken.',
		'CSRFToken'       => 'Отправлен невалидный CSRFToken.'
	],
	Validators::SUCCESS => [
		'success' => 'Запрос выполнен успешно.',
	],
];