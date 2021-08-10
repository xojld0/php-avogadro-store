<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("error_log", "log.txt");
	ini_set("log_errors", true);
	ini_set("display_errors", true);

	//MySQL
	$db_host 				= "localhost";
	$db_user 				= "root";
	$db_pass 				= "";
	$db_name 				= "shop";

	//User config
	$url					= "localhost";
	$head_title				= "Avogadro-store";
	$page_title 			= "Avogadro-store";
	$currency				= "руб.";

	$menu_index				= "Главная";
	$menu_products			= "Товары";
	$menu_registration		= "Регистрация";
	$menu_login				= "Войти";
	$menu_profile			= "Профиль";
	$menu_logout			= "Выйти";
	$menu_about				= "О нас";
	$menu_comment			= "Отзывы";
	$menu_contact			= "Контакты";

	$registration_email		= "E-mail:";
	$registration_username	= "Имя&nbsp;пользователя:";
	$registration_password1	= "Пароль:";
	$registration_password2	= "Повторите&nbsp;пароль:";
	$registration_submit	= "Зарегистрироваться";
	$registartion_sendmail 	= "<p style='color: green'>На ваш E-mail было отправлено письмо с дальнейшими указаниями.</p>";
	$registration_subject	= "Активация электронной почты";
	$registration_content	= "Перейдите по ссылке чтобы закончить регистрацию: ";
	$registration_msg		= "<p style='color: red'>Вы уже активировали E-mail!</p>";
	$registration_success	= "<p style='color: green'>Ваш E-mail активирован. Регистрация прошла успешно.</p>";
	$registration_sysfail	= "<p style='color: red'>Системная ошибка!</p>";

	$registration_error1 	= "<p style='color: red'>E-mail не заполнен!</p>";
	$registration_error2 	= "<p style='color: red'>Имя пользователя не заполнено!</p>";
	$registration_error3 	= "<p style='color: red'>Пароль не заполнен!</p>";
	$registration_error4 	= "<p style='color: red'>Повторите пароль!</p>";
	$registration_error5 	= "<p style='color: red'>Некорректный E-mail!</p>";
	$registration_error6 	= "<p style='color: red'>Этот E-mail уже зарегистрирован!</p>";
	$registration_error7 	= "<p style='color: red'>Некорректное имя пользователя!</p>";
	$registration_error8 	= "<p style='color: red'>Это имя пользователя уже зарегистрировано!</p>";
	$registration_error9 	= "<p style='color: red'>Пароли не совпадают!</p>";
	$registration_error10 	= "<p style='color: red'>Системная ошибка!</p>";

	$captcha	= "Введите&nbsp;код&nbsp;с&nbsp;картинки:";
	$captcha_error 			= "<p style='color: red'>Капча введена неверно!</p>";

	$login_email			= "E&#8209;mail:";
	$login_password			= "Пароль:";
	$login_submit			= "Войти";
	$login_recovery			= "Восстановить пароль";

	$login_error1			= "<p style='color: red'>E-mail не заполнен!</p>";
	$login_error2			= "<p style='color: red'>Пароль не заполнен!</p>";
	$login_error3 			= "<p style='color: red'>Некорректный E-mail!</p>";
	$login_error4			= "<p style='color: red'>Неверный E-mail!</p>";
	$login_error5			= "<p style='color: red'>Неверный пароль!</p>";

	$profile_email			= "E-mail:";
	$profile_username		= "Имя&nbsp;пользователя:";
	$profile_balance		= "Баланс:";
	$profile_deposit		= "Пополнить";
	$profile_email_active	= "<p style='color: green'>Активирован</p>";
	$profile_email_unactive	= "<p style='color: red'>Не&nbsp;активирован!</p>";
	$profile_email_edit		= "Изменить&nbsp;E-mail";
	$profile_password_edit	= "Изменить&nbsp;пароль";
	$profile_promo_enter	= "Ввести&nbsp;промокод";

	$profile_error1			= "<p style='color: red'>Системная ошибка!</p>";

	$recovery_email			= "E&#8209;mail:";
	$recovery_password1		= "Новый&nbsp;пароль:";
	$recovery_password2		= "Повторите&nbsp;пароль:";
	$recovery_submit		= "Восстановить";
	$recovery_subject		= "Восстановление пароля";
	$recovery_content		= "Перейдите по ссылке чтобы восстановить пароль: ";
	$recovery_message		= "<p style='color: green'>На ваш E-mail было отправлено письмо с дальнейшими указаниями.</p>";

	$recovery_error1		= "<p style='color: red'>E-mail не заполнен!</p>";
	$recovery_error2		= "<p style='color: red'>Некорректный E-mail!</p>";
	$recovery_error3		= "<p style='color: red'>Этот E-mail не существует!</p>";
	$recovery_error4		= "<p style='color: red'>Новый пароль не введен!</p>";
	$recovery_error5		= "<p style='color: red'>Повторите пароль!</p>";
	$recovery_error6		= "<p style='color: red'>Пароли не совпадают!</p>";

	$psw_edit_old_password 	= "Старый&nbsp;пароль:";
	$psw_edit_password1		= "Новый&nbsp;пароль:";
	$psw_edit_password2		= "Повторите&nbsp;пароль:";
	$psw_edit_submit		= "Изменить&nbsp;пароль";
	$psw_edit_success 		= "<p style='color: green'>Пароль успешно изменён!</p>";

	$psw_edit_error1		= "<p style='color: red'>Введите старый пароль!</p>";
	$psw_edit_error2		= "<p style='color: red'>Введите новый пароль!</p>";
	$psw_edit_error3		= "<p style='color: red'>Повторите пароль!</p>";
	$psw_edit_error4		= "<p style='color: red'>Пароли не совпадают!</p>";
	$psw_edit_error5		= "<p style='color: red'>Неверный старый пароль!</p>";
	$psw_edit_error6		= "<p style='color: red'>Системная ошибка!</p>";

	$email_edit_new			= "Новый&nbsp;E&#8209;mail:";
	$email_edit_submit		= "Изменить";
	$email_edit_subject		= "Подтверждение смены E-mail";
	$email_edit_content		= "Перейдите по ссылке чтобы подтвердить смену E-mail: ";
	$email_edit_message		= "<p style='color: green'>На ваш E-mail было отправлено письмо с дальнейшими указаниями.</p>";
	$email_edit_success		= "<p style='color: green'>Смена E-mail прошла успешно!</p>";

	$email_edit_error1		= "<p style='color: red'>Новый E-mail не заполнен!</p>";
	$email_edit_error2		= "<p style='color: red'>Некорректный E-mail!</p>";
	$email_edit_error3		= "<p style='color: red'>Системная ошибка!</p>";
	$email_edit_error4		= "<p style='color: red'>Неверный запрос!</p>";
	$email_edit_error5		= "<p style='color: red'>Этот E-mail уже зарегистрирован!</p>";

	$promo_enter 			= "Промокод:";
	$promo_submit			= "Ввести";
	$promo_success			= "<p style='color: green'>Промокод введен успешно! Вам начислено: </p>";

	$promo_error1 			= "<p style='color: red'>Введите промокод!</p>";
	$promo_error2 			= "<p style='color: red'>Системная ошибка!</p>";
	$promo_error3			= "<p style='color: red'>Неверный промокод!</p>";

	$comments_text			= "Введите&nbsp;отзыв:";
	$comments_submit		= "Отправить";
	$comments_prev			= "<<&nbsp;Предыдущая";
	$comments_next			= "Следующая&nbsp;>>";

	$comments_error1		= "<p style='color: red'>Введите отзыв!</p>";
	$comments_error2		= "<p style='color: red'>Системная ошбика!</p>";

	$contact_message		= "Введите&nbsp;ваше&nbsp;сообщение:";
	$contact_submit 		= "Отправить";
	$contact_success		= "<p style='color: green'>Выше сообщение было отправленно администратору. В скором времени он свяжется с вами по E-mail.</p>";

	$contact_error1			= "<p style='color: red'>Сообщение не может быть пустым!</p>";
	$contact_error2			= "<p style='color: red'>Системная ошибка!</p>";

	$products_count			= "В&nbsp;наличии:";

	$product_buy			= "Купить";

	$product_error1 		= "<p style='color: red'>Товар не найден!</p>";

	$buy_name 				= "Имя:";
	$buy_surname			= "Фамилия:";
	$buy_company			= "Название&nbsp;компании(Если&nbsp;есть):";
	$buy_address			= "Адрес";
	$buy_city				= "Населённый&nbsp;пункт:";
	$buy_region				= "Регион:";
	$buy_index				= "Почтовый&nbsp;индекс:";
	$buy_country			= "Страна";
	$buy_submit				= "Заказать";
	$buy_success			= "<p style='color: green'>Заказ оформлен!</p>";

	$buy_error1				= "<p style='color: red'>Введите&nbsp;имя!</p>";
	$buy_error2				= "<p style='color: red'>Введите&nbsp;фамилию!</p>";
	$buy_error3				= "<p style='color: red'>Введите&nbsp;адрес!</p>";
	$buy_error4				= "<p style='color: red'>Введите&nbsp;город!</p>";
	$buy_error5				= "<p style='color: red'>Введите&nbsp;регион!</p>";
	$buy_error6				= "<p style='color: red'>Введите&nbsp;почтовый&nbsp;индекс!</p>";
	$buy_error7				= "<p style='color: red'>Введите&nbsp;страну!</p>";
	$buy_error8				= "<p style='color: red'>Нужно больше золота!</p>";
	$buy_error9				= "<p style='color: red'>Системная ошибка!</p>";

	$deposit_success		= "<p style='color: green'>Платёж успешно завершён!</p>";
	$deposit_error			= "<p style='color: red'>Ошибка платежа!</p>";
	$deposit_submit			= "Пополнить";
	$deposit_value			= "Введите&nbsp;сумму:";

	$preg_username_pattern 	= '/^[a-zA-Z]{3,10} [0-9]{0,10}$/xis';
	$preg_email_pattern		= '/^[a-zA-Z0-9.]+ @ [a-z]+ \. [a-z]+$/xis';
?>
