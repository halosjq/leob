<?php
namespace App\Config;

class Lang
{

    public static $langs = array(
        'es' => [
            'start' => [
                'day' => "<b><i>🌄 Buenos días %s</i>\nPresiona uno de los botones de abajo</b>",
                'afternoon' => "<b><i>🌆 Buenas tardes %s</i>\nPresiona uno de los botones de abajo</b>",
                'night' => "<b><i>🌃 Buenas noches %s</i>\nPresiona uno de los botones de abajo</b>",
            ],
            'extrap' => "<b>Extrapolacion</b>\n\n<b>CC Original</b> <code>%s</code>\n<b>Extrapolacion Basica:</b> <code>%s</code>\n<b>Extrapolacion Normal:</b> <code>%s</code>\n<b>Extrapolacion Avanzada:</b> <code>%s</code>",
            'br_cep' => "<b>CEP Generado</b>\n\n<b>CEP:</b> <code>%s</code>\n<b>Tipo:</b> <code>%s</code>\n<b>Calle:</b> <code>%s</code>\n<b>Vecindario:</b> <code>%s</code>\n<b>Ciudad:</b> <code>%s</code>\n<b>Estado:</b> <code>%s</code>",
            'info' => "<b>ⓘ Información del usuario:\n◈ Id:</b> <code>%s</code>\n<b>◈ Nombre:</b> %s [<b>%s</b>]\n<b>◈ Usuario:</b> %s\n<b>◈ Estado:</b> <i>%s</i>",
            'me' => "<b>♻️ <u>Información del usuario:</u>\n◈ ID: <code>%s</code>\n◈ Nombre: %s [<i>%s</i>]\n◈ Estado:</b> <i>%s | %s</i>\n<b>◈ Usuario:</b> %s\n<b>◈ Creditos:</b> <code>%s</code>\n<b>◈ Expira en:</b> <code>%s</code>\n<b>◈ Advertencias:</b> <code>%s</code>\n<b>◈ Autorizado:</b> <i>%s</i> | <b>Antispam:</b> <i>%s's</i>\n<b>◈ Ultimo check:</b> <i>%s</i>\n<b>◈ Lenguaje:</b> <code>%s</code>\n<b>◈ Guardar Lives:</b> <i>%s</i> | <b>Usuario referido:</b> <i>%s</i>",
            'muted' => "<b>Estas muteado hasta el <i>%s</i>\nEspera <i>%s</i> segundos</b>",
            'unauthorized' => 'Hola, no estas autorizado para usar este bot, primero inicia el bot en chat privado para obtener acceso',
            'banned' => "Estas baneado de este bot ❌",
            'bin' => [
                'valid' => "<b>λ Bin valido (</b><b><i>%s</i>) ✅\n❖ Marca:</b> <code>%s\n</code><b>❖ Tipo:</b> <code>%s\n</code><b>❖ Nivel:</b> <code>%s\n</code><b>❖ Banco:</b> <code>%s</code> <i>- ☎️ </i><code>%s\n</code><b>❖ Pais:</b> <code>%s[%s](</code>%s<code>)</code> - 💱 <code>%s\n</code><b>❖ Checado por:</b> %s <b>[%s]</b>",
                'invalid' => '<b>λ Bin invalido ➜ (<i>%s</i>) ❌</b>',
            ],
            'gate' => [
                'wait' => "<b>♻️ <i>%s</i> | %s | <i>%s</i>\nTarjeta:</b> <code>%s</code>",
                'final' => "<b>λ <u>%s</u> %s</b>\n⌧ CC: <code>%s</code>\n⌧ Estado: <b>%s</b>\n⌧ Resultado: <b>%s</b>%s\n\n⌧ Bin: <code>%s</code> <b>%s %s</b>\n⌧ Detalles: <b>%s - %s - %s</b>\n⌧ Banco: <b>%s</b>\n\n⌧ Tiempo: <b>%s</b>\n⌧ Checado por: %s [<b>%s</b>]\n⌧ Bot hecho por: <i>@kirarichk</i>",
                "error" => [
                    'trie' => "<b><i>Error de puerta en Solicitud [%s], Intentos (%s/3)⚠️</i></b>",
                    'max' => "<b><i> Error de puerta en la solicitud [%s], se alcanzó el máximo de intentos (3/3). Inténtelo de nuevo ⚠️</i></b>",
                ],
                'iban' => "", #ni se que mrd va ahi
            ],
            'expvpn' => ['valid' => "<b>Express VPN</b>\n<b>Llave:</b> <code>%s</code>\n<b>Estado:</b> <code>%s</code>\n<b>Respuesta:</b> <code>%s</code>\n<b>Fecha De Caducidad:</b> <code>%s</code>\n<b>Ciclo De Facturacion:</b> <code>%s</code>\n<b>Tipo De Plan:</b> <code>%s</code>", 'invalid' => "<b>Express VPN</b>\n<b>Llave:</b> <code>%s</code>\n<b>Estado:</b> <code>%s</code>\n<b>Respuesta:</b> <code>%s</code>"],
            'github' => ['valid' => "<b>Nombre de usuario: </b> <i>%s</i> [<code>%s</code>] \n <b>Bio: </b> <i>%s</i>\n<b>Sitio web: </b>%s\n<b>Empresa: </b>%s\n<b>Twitter: </b> <i>%s</i>\n<b>Reposiciones/Gits: <code>%s/%s</code>\nSeguidores: <code>%s</code>\nSiguiendo: <code>%s</code>\n\nComprobado por: </b> %s [%s]", 'invalid' => "<b><i>❌Usuario De GitHub Invalido❌</i></b>"],
        ],
        'en' => [
            'start' => ['day' => "<b><i>🌄 Good morning %s</i>\nPress one of the buttons below</b>", 'afternoon' => "<b><i>🌆 Good afternoon %s</i>\nPress one of the buttons below</b>", 'night' => "<b><i>🌃 Good night %s</i>\nPress one of the buttons below</b>"],
            'info' => "<b>ⓘ User info:\n◈ Id:</b> <code>%s</code>\n<b>◈ Name:</b> %s [<b>%s</b>]\n<b>◈ Username:</b> %s\n<b>◈ Status:</b> <i>%s</i>",
            'me' => "<b>♻️ <u>User info:</u>\n◈ ID: <code>%s</code>\n◈ Name: %s [<i>%s</i>]\n◈ Status:</b> <i>%s | %s</i>\n<b>◈ Username:</b> %s\n<b>◈ Credits:</b> <code>%s</code>\n<b>◈ Expired in:</b> <code>%s</code>\n<b>◈ Warnings:</b> <code>%s</code>\n<b>◈ Auth:</b> <i>%s</i> | <b>Antispam:</b> <i>%s's</i>\n<b>◈ Last check:</b> <i>%s</i>\n<b>◈ Lang-code:</b> <code>%s</code>\n<b>◈ Save live:</b> <i>%s</i> | <b>User ref:</b> <i>%s</i>",
            'unauthorized' => "Hi, you no are authorized to use this bot, please init the bot in private chat to get access",
            'muted' => "<b>You are muted until <i>%s</i>\nWait <i>%s</i> seconds</b>",
            'banned' => "You are banned from this bot ❌",
            'extrap' => "<b>Extrapolation</b>\n\n<b>Original CC</b> <code>%s</code>\n<b>Basic Extrapolation:</b> <code>%s</code>\n<b>Normal Extrapolation:</b> <code>%s</code>\n<b>Advanced Extrapolation:</b> <code>%s</code>",
            'br_cep' => "<b>CEP Generated</b>\n\n<b>CEP:</b> <code>%s</code>\n<b>Type:</b> <code>%s</code>\n<b>Street:</b> <code>%s</code>\n<b>Neighborhood:</b> <code>%s</code>\n<b>City:</b> <code>%s</code>\n<b>State:</b> <code>%s</code>",
            'bin' => [
                'valid' => "<b>λ Valid bin (</b><b><i>%s</i>) ✅\n❖ Card-brand:</b> <code>%s\n</code><b>❖ Card-type:</b> <code>%s\n</code><b>❖ Card-level:</b> <code>%s\n</code><b>❖ Bank:</b> <code>%s</code> <i>- ☎️ </i><code>%s\n</code><b>❖ Country:</b> <code>%s[%s](</code>%s<code>)</code> - 💱 <code>%s\n</code><b>❖ Checked by:</b> %s <b>[%s]</b>",
                'invalid' => "<b>λ Invalid bin ➜ (<i>%s</i>) ❌</b>",
            ],
            'gate' => [
                'wait' => "<b>♻️ <i>%s</i> | %s | <i>%s</i>\nCard:</b> <code>%s</code>",
                'final' => "<b>λ <u>%s</u> %s</b>\n⌧ CC: <code>%s</code>\n⌧ Status: <b>%s</b>\n⌧ Response: <b>%s</b>%s\n\n⌧ Bin: <code>%s</code> <b>%s %s</b>\n⌧ Details: <b>%s - %s - %s</b>\n⌧ Bank: <b>%s</b>\n\n⌧ Took: <b>%s</b>\n⌧ Checked by: %s [<b>%s</b>]\n⌧ Bot by: <i>@kirarichk</i>",
                "error" => [
                    'trie' => "<b><i>Gate Error In Request [%s], Tries (%s/3) ⚠️</i></b>",
                    'max' => "<b><i>Gate Error In Request [%s], Max Tries Reached (3/3), Please Try Again ⚠️</i></b>",
                ],
                'iban' => "",
            ],
            'expvpn' => ['valid' => "<b>Express VPN</b>\n<b>Key:</b> <code>%s</code>\n<b>Status:</b> <code>%s</code>\n<b>Response:</b> <code>%s</code>\n<b>Expire Date:</b> <code>%s</code>\n<b>Billing Cycle:</b> <code>%s</code>\n<b>Plan Type:</b> <code>%s</code>", 'invalid' => "<b>Express VPN</b>\n<b>Key:</b> <code>%s</code>\n<b>Status:</b> <code>%s</code>\n<b>Response:</b> <code>%s</code>"],
            'github' => ['valid' => "<b>Username:</b> <i>%s</i> [<code>%s</code>]\n<b>Bio:</b> <i>%s</i>\n<b>Website:</b> %s\n<b>Company:</b> %s\n<b>Twitter:</b> <i>%s</i>\n<b>Repos/Gits: <code>%s / %s</code>\nFollowers: <code>%s</code>\nFollowing: <code>%s</code>\n\nChecked by:</b> %s [%s]", 'invalid' => "<b><i>❌Invalid GitHub Username❌</i></b>"],
        ],
        'ru' => [
            'start' => ['day' => "<b><i>🌄 Доброе утро %s</i>\nНажмите одну из кнопок ниже</b>", 'afternoon' => "<b><i>🌆 Добрый день %s</i>\nНажмите одну из кнопок ниже</b>", 'afternoon' => "<b><i>🌃 Спокойной ночи %s</i>\nНажмите одну из кнопок ниже</b>"],
            'info' => "",
            'me' => "<b>♻️ <u>Информация о пользователе:</u>\n◈ ID: <code>%s</code>\n◈ Имя:</b> <i>%s</i> [<b><i>%s</i></b>]\n<b>◈ Имя пользователя:</b> %s \n<b>◈ Кредиты:</b> <code>%s</code>\n<b>◈ Предупреждения:</b> <code>%s</code>\n<b>◈ Статус:</b> <i>%s</i>",
            'me' => "<b> ♻️ <u> Информация о пользователе: </u> \n◈ ID: <code>%s</code> \n◈ Имя: %s [<i>%s </i>] \n◈ Статус:</b> <i>%s | %s </i> \n<b>◈ Пользователь:</b> %s \n<b>◈ Истекает в::</b> <code>%s</code> \n<b>◈ Авторы:</b> <code>%s</code>\n<b>◈ Предупреждения:</b> <code>%s </code> \n<b>◈ Авторизовано:</b> <i>%s </i> |<b> Антиспам:</b> <i>%s </i> \n<b>◈ Последняя проверка:</b> <i>%s </i> \n<b>◈ Язык: </b> <code>%s </code> \n<b>◈ Сохранить жизни:</b> <i>%s </i> | <b>Приглашенный пользователь: </b> <i>%s </i>",
            'muted' => 'Вы отключены до %s - %s \nПодождите %s секунд',
            'banned' => "Вам заблокирован доступ к этому боту ❌",
            'extrap' => "<b>Экстраполяция</b>\n\n<b>CC Оригинал</b> <code>%s</code>\n<b>Основная экстраполяция:</b> <code>%s</code>\n<b>Нормальная экстраполяция:</b> <code>%s</code>\n<b>Расширенная экстраполяция:</b> <code>%s</code>",
            'br_cep' => "<b>CEP сгенерирован</b>\n\n<b>CEP:</b> <code>%s</code>\n<b>Добрый:</b> <code>%s</code>\n<b>улица:</b> <code>%s</code>\n<b>Район:</b> <code>%s</code>\n<b>город:</b> <code>%s</code>\n<b>штат:</b> <code>%s</code>",
            'bin' => ['valid' => "<b>λ Допустимая корзина (</b><b><i>%s</i>) ✅\n❖ Карта-бренд:</b> <code>%s\n</code><b>❖ Тип карты:</b> <code>%s\n</code><b>❖ Уровень карты:</b> <code>%s\n</code><b>❖ банк:</b> <code>%s</code> <i>- ☎️ </i><code>%s\n</code><b>❖ страна:</b> <code>%s[%s](</code>%s<code>)</code> - 💱 <code>%s\n</code><b>❖ Проверено:</b> %s <b>[%s]</b>", 'invalid' => "<b>λ Неверная корзина ➜ (<i>%s</i>) ❌</b>"],
            'gate' => [
                'wait' => "<b>♻️ <i>%s</i> | %s | <i>%s</i>\nКредитная карта:</b> <code>%s</code>",
                'final' => "<b>λ <u>%s</u> %s</b>\n⌧ Кредитная карта: <code>%s</code>\n⌧ статус: <b>%s</b>\n⌧ ответ: <b>%s</b>%s\n\n⌧ бункер: <code>%s</code> <b>%s %s</b>\n⌧ подробности: <b>%s - %s - %s</b>\n⌧ банк: <b>%s</b>\n\n⌧ брать: <b>%s</b>\n⌧ Проверено: %s [<b>%s</b>]\n⌧ Бот от: <i>@kirarichk</i>",
                "error" => [
                    'trie' => "<b><i>Ошибка шлюза в запросе [%s], попытках (%s/3) ⚠️</i></b>",
                    'max' => "<b><i>Ошибка шлюза в запросах [%s], достигнуто максимальное количество попыток (3/3), повторите попытку ⚠️</i></b>",
                ],
                'iban' => "",
            ],
            'expvpn' => ['valid' => "<b>Express VPN</b>\n<b>Ключ:</b> <code>%s</code>\n<b>Положение дел:</b> <code>%s</code>\n<b>Ответ:</b> <code>%s</code>\n<b>Годен до:</b> <code>%s</code>\n<b>Платежный цикл:</b> <code>%s</code>\n<b>Тип плана:</b> <code>%s</code>", 'invalid' => "<b>Express VPN</b>\n<b>Ключ:</b> <code>%s</code>\n<b>Положение дел:</b> <code>%s</code>\n<b>Ответ:</b> <code>%s</code>"],
            'github' => ['valid' => "<b> Имя пользователя: </b> <i>%s</i> [<code>%s</code>] \n<b> Биография: </b> <i>%s</i> \n<b> Веб-сайт: </b>%s\n<b> Компания: </b>%s\n<b> Twitter: </b> <i>%s</i> \n<b> Репо / Gits: <code>%s/%s</code>\nПодписчики: <code>%s</code> \nПодписчики: <code>%s</code>\n\nПроверено: </b> [%s]", 'invalid' => "<b><i>❌Неверное имя пользователя GitHub❌</i></b>"],
        ],
        'in' => [
            'start' => ['day' => "<b><i>🌄 सुप्रभात %s</i>\nनीचे दिए गए बटनों में से कोई एक दबाएं</b>", 'afternoon' => "<b><i>🌆 शुभ दोपहर %s</i>\nनीचे दिए गए बटनों में से कोई एक दबाएं</b>", 'afternoon' => "<b><i>🌃 शुभ रात्रि %s</i>\nनीचे दिए गए बटनों में से कोई एक दबाएं</b>"],
            'info' => "<b>♻️ <u> उपयोगकर्ता जानकारी: </u> \n◈ आईडी: <code>%s</code> \n◈ नाम:</b> <i>%s</i> [<b><i>%s</i></b>]\n<b>◈ उपयोगकर्ता: </b> %s \n<b> ◈ क्रेडिट:</b> <code>%s </code> \n<b> ◈ चेतावनियां:</b> <code>%s </code> \n<b>◈ स्थिति:</b> <i>%s </i>",
            'me' => "<b>♻️ <u> उपयोगकर्ता जानकारी: </u> \n◈ आईडी: <code>%s </code> \n◈ नाम:%s [<i>%s</i>] \n◈ स्थिति:</b> <i>%s | %s </i> \n<b>◈ उपयोगकर्ता:</b> %s \n<b>◈ क्रेडिट:</b> <code>%s</code>\n<b>◈ में समाप्त हो:</b> <code>%s</code> \n<b>◈ चेतावनियां:</b> <code>%s </code> \n<b>◈ अधिकृत:</b> <i>%s</i> | <b>एंटीस्पैम:</b> <i>%s</i> \n<b>◈ अंतिम जांच:</b> <i>%s</i> \n<b>◈ भाषा: </b> <code>%s</code> \n<b>◈ जीवन बचाएं:</b> <i>%s</i> | <b>संदर्भित उपयोगकर्ता:</b> <i>%s </i>",
            'muted' => '<b>आप %s तक मौन हैं - %s\n%s सेकंड प्रतीक्षा करें</b>',
            'banned' => "आपको इस बॉट को एक्सेस करने से ब्लॉक कर दिया गया है ❌",
            'extrap' => "<b>एक्सट्रपलेशन</b>\n\n<b>सीसी मूल</b> <code>%s</code>\n<b>बेसिक एक्सट्रपलेशन:</b> <code>%s</code>\n<b>सामान्य एक्सट्रपलेशन:</b> <code>%s</code>\n<b>उन्नत एक्सट्रपलेशन:</b> <code>%s</code>",
            'br_cep' => "<b>सीईपी उत्पन्न</b>\n\n<b>सीईपी:</b> <code>%s</code>\n<b>प्रकार:</b> <code>%s</code>\n<b>गली:</b> <code>%s</code>\n<b>अड़ोस - पड़ोस:</b> <code>%s</code>\n<b>शहर:</b> <code>%s</code>\n<b>राज्य:</b> <code>%s</code>",
            'bin' => ['valid' => "<b>λ मान्य बिन (</b><b><i>%s</i>) ✅\n❖ कार्ड-ब्रांड:</b> <code>%s\n</code><b>❖ कार्ड-प्रकार:</b> <code>%s\n</code><b>❖ कार्ड-स्तर:</b> <code>%s\n</code><b>❖ बैंक:</b> <code>%s</code> <i>- ️ </i><code>%s\n</code><b>❖ देश:</b> <code>%s[%s](</code>%s<code>)</code> - 💱 <code>%s\n</code><b>❖ द्वारा चेक किया गया:</b> %s <b>[%s]</b>", 'invalid' => "<b>λ अमान्य बिन ➜ (<i>%s</i>) ❌</b>"],
            'gate' => [
                'wait' => "<b>♻️ <i>%s</i> | %s | <i>%s</i>\nकार्ड:</b> <code>%s</code>",
                'final' => "<b>λ <u>%s</u> %s</b>\n⌧ CC: <code>%s</code>\n⌧ स्थिति: <b>%s</b>\n⌧ प्रतिसाद: <b>%s</b>%s\n\n⌧ बिन: <code>%s</code> <b>%s %s</b>\n⌧ विवरण: <b>%s - %s - %s</b>\n⌧ बैंक: <b>%s</b>\n\n⌧ लिया: <b>%s</b>\n⌧ द्वारा चेक किया गया: %s [<b>%s</b>]\n⌧ बॉट द्वारा: <i>@kirarichk</i>",
                "error" => [
                    'trie' => "<b><i>अनुरोध में गेट त्रुटि [%s], प्रयास (%s/3) ⚠️</i></b>",
                    'max' => "<b><i>अनुरोध में गेट त्रुटि [%s], अधिकतम प्रयास (3/3), कृपया पुन: प्रयास करें ⚠️</i></b>",
                ],
                'iban' => "",
            ],
            'expvpn' => ['valid' => "<b>Express VPN</b>\n<b>चाभी:</b> <code>%s</code>\n<b>स्थिति:</b> <code>%s</code>\n<b>प्रतिक्रिया:</b> <code>%s</code>\n<b>समाप्ति तिथि:</b> <code>%s</code>\n<b>बिलिंग चक्र:</b> <code>%s</code>\n<b>योजना प्रकार:</b> <code>%s</code>", 'invalid' => "<b>Express VPN</b>\n<b>चाभी:</b> <code>%s</code>\n<b>स्थिति:</b> <code>%s</code>\n<b>प्रतिक्रिया:</b> <code>%s</code>"],
            'github' => ['valid' => "<b>नोम्ब्रे डी उसुआरियो:</b> <i>%s</i> [<code>%s</code>]\n<b>जैव: </b> <i>%s</i>\n<b>साइटियो वेब: </b>%s\n<b>एम्प्रेसा: </b>%s\n<b>ट्विटर: </b> <i>%s</i>\n<b> रिपोजेस / गिट्स: <code>%s/%s</code>\nसमर्थकs: <code>%s</code>\nसमर्थक: <code>%s</code>\n\nकॉम्प्रोबैडो पोर: </b> %s [%s]", 'invalid' => "<b><i>अमान्य GitHub उपयोगकर्ता नाम❌</i></b>"],
        ],
        'it' => [
            'start' => ['day' => "<b><i>🌄 Buon giorno %s</i>\nPremi uno dei pulsanti qui sotto</b>", 'afternoon' => "<b><i>🌆 Buone tarde %s</i>\nPremi uno dei pulsanti qui sotto</b>", 'night' => "<b><i>🌃 Buona serata %s</i>\nPremi uno dei pulsanti qui sotto</b"],
            'info' => "<b> ♻️ <u> Informazioni utente: </u> \n◈ Id: <code>%s </code> \n◈ Nome: </b> <i>%s</i> [<b><i>%s</i></b>]\n<b>◈ Utente:</b> %s \n<b>◈ Crediti:</b> <code>%s </code> \n<b>◈ Avvisi: </b> <code>%s </code> \n<b>◈ Stato:</b> <i>%s </i>",
            'me' => "<b> ♻️ <u> Informazioni utente: </u> \n◈ ID: <code>%s </code> \n◈ Nome:%s [<i>%s </i>] \n◈ Stato:</b> <i>%s | %s </i> \n<b>◈ Utente:</b> %s \n<b>◈ Crediti:</b> <code>%s </code>\n<b>◈ Scade tra:</b> <code>%s </code> \n<b>◈ Avvisi:</b> <code>%s </code> \n<b>◈ Autorizzato:</b> <i>%s </i> | <b>Antispam:</b> <i>%s </i> \n<b>◈ Ultimo controllo:</b> <i>%s</i> \n<b>◈ Lingua:</b> <code>%s </code> \n<b>◈ Salva vite:</b> <i>%s </i> | <b>Utente segnalato:</b> <i>%s </i>",
            'muted' => '<b>Sei disattivato fino a %s - %s \naspettare %s secondi </b>',
            'banned' => "Sei stato bloccato dall'accesso a questo bot. ❌",
            'extrap' => "<b>Estrapolazione</b>\n\n<b>CC originale</b> <code>%s</code>\n<b>Estrapolazione di base:</b> <code>%s</code>\n<b>Estrapolazione normale:</b> <code>%s</code>\n<b>Estrapolazione avanzata:</b> <code>%s</code>",
            'br_cep' => "<b>CEP Generato</b>\n\n<b>CEP:</b> <code>%s</code>\n<b>Tipo:</b> <code>%s</code>\n<b>Strada:</b> <code>%s</code>\n<b>Quartiere:</b> <code>%s</code>\n<b>Cittadina:</b> <code>%s</code>\n<b>Stato:</b> <code>%s</code>",
            'bin' => ['valid' => "<b>λ Bin valido (</b><b><i>%s</i>) ✅\n❖ Card-brand:</b> <code>%s\n</code><b>❖ Card-type:</b> <code>%s\n</code><b>❖ Card-level:</b> <code>%s\n</code><b>❖ Bank:</b> <code>%s</code> <i>- ☎️ </i><code>%s\n</code><b>❖ Paese:</b> <code>%s[%s](</code>%s<code>)</code> - 💱 <code>%s\n</code><b>❖ Checkato da:</b> %s <b>[%s]</b>", 'invalid' => "<b>λ Invalid bin ➜ (<i>%s</i>) ❌</b>"],
            'gate' => [
                'wait' => "<b>♻️ <i>%s</i> | %s | <i>%s</i>\nCard:</b> <code>%s</code>",
                'final' => "<b>λ <u>%s</u> %s</b>\n⌧ CC: <code>%s</code>\n⌧ Stato: <b>%s</b>\n⌧ Risposta: <b>%s</b>%s\n\n⌧ Bin: <code>%s</code> <b>%s %s</b>\n⌧ Details: <b>%s - %s - %s</b>\n⌧ Bank: <b>%s</b>\n\n⌧ Took: <b>%s</b>\n⌧ Checkato da: %s [<b>%s</b>]\n⌧ Bot di: <i>@kirarichk</i>",
                "error" => [
                    'trie' => "<b><i>Errore di gate nella richiesta [%s], tentativi (%s/3) ⚠️</i></b>",
                    'max' => "<b><i>Errore di gate nella richiesta [%s], numero massimo di tentativi raggiunto (3/3), per favore riprova ⚠️</i></b>",
                ],
                'iban' => "",
            ],
            'expvpn' => ['valid' => "<b>Express VPN</b>\n<b>Chiave:</b> <code>%s</code>\n<b>Stato:</b> <code>%s</code>\n<b>Risposta:</b> <code>%s</code>\n<b>Data di scadenza:</b> <code>%s</code>\n<b>Ciclo di fatturazione:</b> <code>%s</code>\n<b>Tipo di piano:</b> <code>%s</code>", 'invalid' => "<b>Express VPN</b>\n<b>Chiave:</b> <code>%s</code>\n<b>Stato:</b> <code>%s</code>\n<b>Risposta:</b> <code>%s</code>"],
            'github' => ['valid' => "<b>Nombre de Usuario:</b> <i>%s</i> [<code>%s</code>]\n<b>bio: </b> <i >%s</i>\n<b>Siteio Web: </b>%s\n<b>Empressa: </b>%s\n<b>Twitter: </b> <i>%s </i>\n<b> repos/gits: <code>%s/%s</code>\npros: <code>%s</code>\npro: <code>%s</code>\n\ncomprobado por: </b> %s [%s]", 'invalid' => "<b><i>Nome utente GitHub non valido❌</i></b>"],
        ],
        /*'fr' => [
            'start' => ['day' => "<b><i>🌄 Bonne jours %s</i>\nAppuyez sur lun des boutons ci-dessous</b>", 'afternoon' => "<b><i> 🌆 bon après-midi %s </i>\nAppuyez sur l'un des boutons ci-dessous</b>", 'night' => "<b><i>🌃 Bonne nuit %s</i>\nAppuyez sur l'un des boutons ci-dessous</b>"],
            'info' => "<b>♻️ <u>Informations utilisateur:</u>\n◈ Id: <code>%s</code>\n◈ Nom:</b> <i>%s</i> [<b> <i>%s</i></b>]\n<b>◈ Nom d'utilisateur:</b> %s \n<b>◈ Crédits:</b> <code>%s</code>\n<b>◈ Avertissements:</b> <code>%s</code>\n<b>◈ Statut:</b> <i>%s</i>",
            'me' => "<b>♻️ <u>Informations utilisateur:</u>\n◈ ID: <code>%s</code>\n◈ Nom: %s [<i>%s</i>]\n◈ Statut:</b> <i>%s | %s</i>\n<b>◈ Nom d'utilisateur:</b> %s\n<b>◈ Crédits:</b> <code>%s</code>\n<b>◈ Expiré dans: </b> <code>%s</code>\n<b>◈ Avertissements:</b> <code>%s</code>\n<b>◈ Auth:</b> <i>% </i> | <b>Antispam:</b> <i>%s</i>\n<b>◈ Dernière vérification:</b> <i>%s</i>\n<b>◈ Lang-code: </b> <code>%s</code>\n<b>◈ Enregistrer en direct:</b> <i>%s</i> | <b>Référence utilisateur:</b> <i>%s</i>",
            'muted' => "<b>Vous êtes coupé jusqu'à %s - %s\nAttendez %s secondes</b>",
            'banned' => "Vous avez été bloqué pour accéder à ce bot. ❌",
            'extrap' => "<b>Extrapolation</b>\n\n<b>CC d'origine</b> <code>%s</code>\n<b>extrapolation de base:</b> <code>%s</code>\n<b>extrapolation normale:</b> <code>%s</code>\n<b>Extrapolation avancée:</b> <code>%s</code>",
            'br_cep' => "<b>CEP généré</b>\n\n<b>CEP:</b> <code>%s</code>\n<b>Type:</b> <code>%s</code>\n<b>Rue:</b> <code>%s</code>\n<b>Quartier:</b> <code>%s</code>\n<b>Ville:</b> <code>%s</code>\n<b>État:</b> <code>%s</code>",
            'bin' => ['valid' => "<b>λ Bin valide (</b><b><i>%s</i>) ✅\n❖ Carte-marque:</b> <code>%s\n</code><b>❖ Type de carte:</b> <code>%s\n</code><b>❖ Niveau carte:</b> <code>%s\n</code><b>❖ Banque:</b> <code>%s</code> <i>- ☎️ </i><code>%s\n</code><b>❖ Pays:</b> <code>%s[%s](</code>%s<code>)</code> - 💱 <code>%s\n</code><b>❖ Vérifié par:</b> %s <b>[%s]</b>", 'invalid' => "<b>λ Bin non valide ➜ (<i>%s</i>) ❌</b>"],
            'gate' => [
                'wait' => "<b>♻️ <i>%s</i> | %s | <i>%s</i>\nCarte:</b> <code>%s</code>",
                'final' => "<b>λ <u>%s</u> %s</b>\n⌧ CC: <code>%s</code>\n⌧ Statut: <b>%s</b>\n⌧ Réponse: <b>%s</b>%s\n\n⌧ Bin: <code>%s</code> <b>%s %s</b>\n⌧ Des détails: <b>%s - %s - %s</b>\n⌧ Banque: <b>%s</b>\n\n⌧ A pris: <b>%s</b>\n⌧ Vérifié par: %s [<b>%s</b>]\n⌧ Bot par: <i>@kirarichk</i>",
                "error" => [
                    'trie' => "<b><i>Erreur de porte dans la demande [%s], essais (%s/3) ⚠️</i></b>",
                    'max' => "<b><i>Erreur de porte dans la demande [%s], nombre maximal d'essais atteint (3/3), veuillez réessayer ⚠️</i></b>",
                ],
                'iban' => "",
            ],
            'expvpn' => ['valid' => "<b>Express VPN</b>\n<b>Clé:</b> <code>%s</code>\n<b>Statut:</b> <code>%s</code>\n<b>Réponse:</b> <code>%s</code>\n<b>Date d'expiration:</b> <code>%s</code>\n<b>Cycle de facturation:</b> <code>%s</code>\n<b>Type de régime:</b> <code>%s</code>", 'invalid' => "<b>Express VPN</b>\n<b>Clé:</b> <code>%s</code>\n<b>Statut:</b> <code>%s</code>\n<b>Réponse:</b> <code>%s</code>"],
            'github' => ['valid' => "<b>Nom d'utilisateur:</b> <i>%s</i> [<code>%s</code>]\n<b>Biographie:</b> <i>%s</i>\n<b>Site Internet:</b> %s\n<b>Société:</b> %s\n<b>Twitter:</b> <i>%s</i>\n<b>RDépôts/Gits: <code>%s / %s</code>\nSuiveurs: <code>%s</code>\nSuivant: <code>%s</code>\n\nVérifié par:</b> %s [%s]", 'invalid' => "<b><i>Nom d'utilisateur GitHub invalide❌</i></b>"],
        ],*/
    );

    final public static function GetLangs()
    {

        return [
            'count' => count(self::$langs),
            'data' => self::$langs,
        ];
    }
}
