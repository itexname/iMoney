=== Plugin Name ===
Contributors: itex
Donate link: http://itex.name/donation/
Author link: http://itex.name/
Tags: automatic, link, links, seo, widget, sidebar, plugin, google, adsense, tnx, sape, html, php, linkfeed, xap, mainlink, txt, begun, adskape
Requires at least: 2.3
Tested up to: 3
Stable tag: 0.25

== Description ==
en
Plugin iMoney is meant for monetize your blog using Adsense, sape.ru, tnx.net and other systems.
Features:
Placing Ads or links up to the text of page, after page of text in the widget and footer.
Widget course customizable.
Automatic installation of a plug and the rights to the sape and tnx folder on request.
Adjustment of amount of displayed links depending on the location.

ru
Плагин iMoney предназначен для монетизации Вашего блога при помощи Adsense, sape.ru, tnx.net и других систем.
Возможности:
Размещение ссылок или рекламы до текста страницы, после текста страницы, в виджетах и футере.
Автоматическая установка плагина и прав на папки sape.ru и tnx.net по желанию.
Регулировка количества показываемых ссылок в зависимости от места расположения.


== Installation ==
Requirements:
Wordpress 2.3-2.9
PHP5, PHP4
Widget compatible theme, to use the links in widgets.

en
Copy the file iMoney.php in wp-content/plugins .
In Plugins activate iMoney.
In settings-> iMoney.

Adsense - enter your Adsense id.
Customize the size, position and channel ads blocks as you want.

Sape - enter your Sape Uid.
If you want to create a Sape folder automatically, coinciding with your Sape Uid.
Allow work Sape links, to specify how many references to the use of text after text, widget and footer.
Allow Sape context.
If you are adding content frequently , then content links of main page, tags and categories can return error.
If you frequently add content, the content of the main links, tags, categories can fly out in error.
For preventation of it switch on the option "Show context only on Pages and Posts".
As required switch on Check - a verification code.

Tnx/xap - enter your Tnx Uid.
If you want to create a Tnx folder automatically, coinciding with your Tnx Uid.
Allow work Tnx links, to specify how many references to the use of text after text, widget and footer.
If you are adding content frequently , then content links of main page, tags and categories can return error.
As required switch on Check - a verification code.

Html - Enter your html code in the right place

For activating widget you shall go to a design-> widgets, activate the widget and point its title.
If define ('WPLANG', 'ru_RU'); in wp-config.php then russian language;

ru
Установка:
Скопировать файл iMoney.php в wp-content/plugins/ вордпресса.
В плагинах активировать iMoney.
В настройках->iMoney.

Adsense - ввести ваш Adsense id.
Настройтие размер, позицию и канал блоков рекламы как вы хотите.

Sape - ввести ваш Sape Uid.
По желанию создать автоматом папку Сапы, совпадающей с вашим Sape Uid.
Разрешить работу Sape links, указать сколько ссылок использовать до текста, после текста, в виджете и футере.
Разрешить Sape context.
Если часто добавляете контент, то контентные ссылки в главной,тегах,категориях могут вылетать в эррор.
Для предотвращения включите опцию "Show context only on Pages and Posts".
По мере надобности включить Check - проверочный код.

Tnx/xap - ввести ваш Tnx Uid.
По желанию создать автоматом папку Сапы, совпадающей с вашим Tnx Uid.
Разрешить работу Tnx links, указать сколько ссылок использовать до текста, после текста, в виджете и футере.
По мере надобности включить Check - проверочный код.

Html - Введите ваш html код в нужные места.

Для активации виджетов нужно зайти в дизайн->виджеты, активировать виджет и указать его заголовок.
Если define ('WPLANG', 'ru_RU'); в wp-config.php, то будет русский язык.

== Frequently Asked Questions ==
-
Ru:
http://itex.name/plugins/faq-po-imoney-i-isape.html
Мне нужно менять шаблон, чтоб использовать систему ссылок?
Он специально и делался, чтобы в шаблон ничего не вставлять. 

У меня при апгрейде плагина выводит ошибки:
Permission denied in /home/public_html/sait.ru/wp-content/plugins//sape.php 
Нет прав на директорию Sape или Tnx, для решения установите права на нужную директорию. Также, если не указан индентификатор сервиса ссылок, то нужно указать и его, тк плагин создает директорию в корне сайта с именем индентификатора.

Если часто добавляете контент, то контентные ссылки в главной, тегах, категориях, архивах возможно могут вылетать в эррор, тк сменяется контент страницы.
Для предотвращения включите опцию "Show context only on Pages and Posts". После этого контекст будет работать только в Постах и Страницах.

Как мне сделать русский интерфейс?
Русский интерфейс, работает если указать русскую локаль в конфиге Вордпресса [ define ('WPLANG', 'ru_RU'); ].
 
 Почему в плагине имеется зашифрованный код?
 Код зашифрован для более компактного размера. В зашифрованном base64 коде руссификация или файл сапы, обычно сверху ставлю коммент, что это например "file sape.php from sape.ru v1.0.4 21.07.2008", это означает, что закодирован файл сапы с одноименного сайта с датой, когда он был оттуда слит. Он нужен только тем, кто не хочет вручную создавать папку и после процесса инсталяции не используется. Для успокоения нервов, вы можете сами его распаковать и посмотреть -
 (echo gzuncompress(base64_decode($sape_php_content)) или подобный код. Вы можете удалить этот код, на основной функционал не повлияет.
 
 У меня не работает контекст. Сапа пишет не найдены страницы. Нужно ли что-либо дополнительно прописывать помимо установки самого плагина и sapeID ?
 Контекст тоже нужно включить в настройках плагина. Помимо этого ничего настраивать не надо. Также возможно у вас не выводятся контектсные ссылки на главной, это сделано для того, что при смене контента на главной, ссылки в эррор не вылетали, управляется параметром "Show context only on Pages and Posts.". Ссылки добавляются автоматом, как сапа их сама отдаст. Включите Чеккод и смотрите есть ссылки на страницах. И еще, если в сапе пишет ОК, то значит робот нашел ссылку, соотвественно и на сайте наверно она была во время посещения бота. Поищите в сорсе страницы, на которой точно должна быть ссылка.
 
 я вот на одном своём сайте разместил в виджете, виджет появился. В настройках так же поставил что-бы после контента ссылки отображались, мне никаких дополнительных кодов в исходники ставить не надо, что-бы ссылки там отображались?
 Нет, ничего добавлять в темы не надо, если тема виджетсовместимая, то в виджетах будет ссылки, а в футере будут, если в теме вызывается wp_footer(), сейчас подавляющее большинство тем такие.
 
 Не добавляется сайт в систему. В чем может быть причина?
 В настройках плагина включили отображение чеккода для проверки вывода ссылок? Помимо проверочного кода самой сапы, еще в сорсе страницы появляются теги вида "<!---checkcontext_start-->", "<!---check footer -->". Если нет, то тема не поддерживает стандартные вордпрессовские евенты, типа wp_footer(), и не содержит поддержку виджетов. Также нужно проверить не закешировалась ли страница, скажем если используется плагин WpSuperCache, то сбросьте его кеш в настройках. В корневой папке появилась вложенная папка с вашим sape id? Если не появилась, то проверьте права на запись. 
 
 Появилась проблема с недописанными файлами links.db.
 За этот файл отвечает уже сам код сапы, возможно проблема в нестабильном соединении у хостинга.
 
 в каком порядке распределяются ссылки по блокам и можно ли как то это регулировать?
 Сначала добавляются до контента, потом после, потом сайдбар, потом футер, причем если есть параметр "Max" в футере или сайдбаре,то в этом месте выводятся все возможные ссылки, рандомной расстановки нету, тк ссылки будут скакать по странице и это возможно вызовет подозрения у поисковика.
 Также есть функция массива своих ссылок, только нужно в самом плагине прописать в var $footer = ''; свои ссылки, эти ссылки будут видны на всех страницах, перед ссылками сапы.
 
 Подскажите пожалуйста в коде ><!---check sidebar 4--><div><!--17164320--> что значит второе значение <!--17164320-->? Заранее спасибо.
 Это чеккод самой сапы.
 
 Каким образом можно дописать в Шаблон функцию wp_footer()? В шаблоне Чекается и контекст и Сайдбар, а вот футера нет
 Ну в текстовом редакторе добавляете в файл footer.php в то место где хотите видеть ссылки в футере "wp_footer();" и все.
 
 Как мне настроить кодировку ссылок?
 Кодировка ссылок автоматом настраивается под кодировку блога, вручную ничего настраивать не надо.

== Screenshots ==

1. screenshot-1.png

Thanks http://mywordpress.ru/ for the screenshot.

== Arbitrary section ==

-

== A brief Markdown Example ==

-

