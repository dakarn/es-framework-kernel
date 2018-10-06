<?php
use System\Validators\Validators;

return [
	Validators::AUTH => [
		'login'          => 'Не заполнен логин или email.',
		'password'       => 'Не заполнен пароль.',
		'fail-auth-data' => 'Не верно введен логин(email) или пароль.',
		'query'          => 'Не корректный запрос.',
	],
	Validators::REGISTER => [
		'login'      => 'Не заполнен логин.',
		'email'      => 'Не верно заполнен email.',
		'password'   => 'Не заполнен пароль.',
		'query'      => 'Не корректный запрос.',
		'user-exist' => 'Пользователь с такимии данными уже есть на сайте.'
	],
	Validators::COMMON => [
		'error-save'   => 'Возникла ошибка при сохранении данных.',
		'already-auth' => 'Вы уже вшли на сайт',
	]
];