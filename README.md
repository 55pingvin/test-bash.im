Сделать аналог https://bash.im/

Обязательные пункты:
--
- список постов с пагинацией
- отдельная страница добавления\администрирования постов
- повышение\понижение рейтинга постов. Лимит для одного IP один пост одно действие
- жалоба на пост
- топ 10 постов по рейтингу
Перенести бизнес логику в сервис классы
Дописать пхпдок коменты и ретурн типы
В аякс методе добавить параметры в сам урл
Добавить проверку входных параметров там где это надо
Добавить логирование процессов (просто в тхт файлы file put content)

Технические требования:
--
- Отдельные докер контейнеры для всех сервисов
- Первая страница постов должна обязательно кэшироваться (желательно через Redis)
- страница Топ10 должна кэшироваться
- Access логи веб сервера должны сохраняться в папку var/log в корне проекта

Необязательные пункты:
--
- Добавить очереди для “тяжелых” действий 
- Фильтр по рейтингу
- Поиск постов по тексту
- Добавить возможность указывать alias для отдельных постов
- Консольные команды для добавления поста/сброса кеша
