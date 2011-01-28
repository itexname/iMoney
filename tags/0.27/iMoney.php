<?php
/*
Plugin Name: iMoney New Year Edition
Version: 0.27.1 (28-12-2010)
Plugin URI: http://itex.name/imoney
Description: Adsense, <a href="http://itex.name/go.php?http://www.sape.ru/r.a5a429f57e.php">Sape.ru</a>, <a href="http://itex.name/go.php?http://www.tnx.net/?p=119596309">tnx.net/xap.ru</a>, <a href="http://itex.name/go.php?http://referal.begun.ru/partner.php?oid=114115214">Begun.ru</a>, <a href="http://itex.name/go.php?http://www.mainlink.ru/?partnerid=42851">mainlink.ru</a>, <a href="http://itex.name/go.php?http://www.linkfeed.ru/reg/38317">linkfeed.ru</a>, <a href="http://itex.name/go.php?http://adskape.ru/unireg.php?ref=17729&d=1">adskape.ru</a>, <a href="http://itex.name/go.php?http://teasernet.com/?owner_id=18516">Teasernet.com</a>, <a href="http://itex.name/go.php?http://trustlink.ru/registration/106535">Trustlink.ru</a>, php exec and html inserts helper.
Author: Itex
Author URI: http://itex.name/
*/

/*
Copyright 2007-2010  Itex (web : http://itex.name/)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/*

EN
Plugin iMoney is meant for monetize your blog using Adsense, sape.ru, tnx.net and other systems.
Features:
Placing Ads or links up to the text of page, after page of text in the widget and footer.
Widget course customizable.
Automatic installation of a plug and the rights to the sape and tnx folder on request.
Adjustment of amount of displayed links depending on the location.

Requirements:
Wordpress 2.3-2.9
PHP5, maybe PHP4
Widget compatible theme, to use the links in widgets.

Installation:
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

RU
Плагин iMoney предназначен для монетизации Вашего блога при помощи Adsense, sape.ru, tnx.net и других систем.
Возможности:
Размещение ссылок или рекламы до текста страницы, после текста страницы, в виджетах и футере.
Автоматическая установка плагина и прав на папки sape.ru и tnx.net по желанию.
Регулировка количества показываемых ссылок в зависимости от места расположения.

Требования:
Wordpress 2.3-2.6.1
ПХП 4-5
Виджет совместимая тема, если использовать ссылки в виджетах.

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
По желанию создать автоматом папку, совпадающей с вашим Tnx Uid.
Разрешить работу Tnx links, указать сколько ссылок использовать до текста, после текста, в виджете и футере.
По мере надобности включить Check - проверочный код.

Html - Введите ваш html код в нужные места.

Для активации виджетов нужно зайти в дизайн->виджеты, активировать виджет и указать его заголовок.
Если define ('WPLANG', 'ru_RU'); в wp-config.php, то будет русский язык.

*/
class itex_money
{
	var $version = '0.27.1';
	var $full = 0;
	var $error = '';
	//var $force_show_code = true;
	var $sape;
	var $sapecontext;
	var $sapearticles;
	var $links = array();
	var $tnx;
	var $setlinks;
	var $setlinkscontext;
	//var $enable = false;
	var $sidebar = array();
	var $sidebar_links = '';
	var $footer = '';
	var $beforecontent = '';
	var $aftercontent = '';
	var $safeurl = '';
	var $document_root = '';
	//var $debug = 1;
	var $debuglog = '';
	var $memory_get_usage = 0; //start memory_get_usage
	var $get_num_queries = 0; //start get_num_queries
	//var $replacecontent = 0;

	/**
   	* constructor, function __construct()  in php4 not working
   	*
   	*/
	function itex_money()
	{
		if (substr(phpversion(),0,1) == 4) $this->php4(); //fix php4 bugs
		add_action('widgets_init', array(&$this, 'itex_m_init'));
		//add_action("widgets_init", array(&$this, 'itex_m_widget_init'));
		add_action('admin_menu', array(&$this, 'itex_m_menu'));
		add_action('wp_footer', array(&$this, 'itex_m_footer'));



		$this->document_root = ($_SERVER['DOCUMENT_ROOT'] != str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]))?(str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"])):($_SERVER['DOCUMENT_ROOT']);

		if (!get_option('itex_m_install_date'))
		{
			update_option('itex_m_install_date',time());
		}
	}

	/**
   	* php4 support
   	*
   	*/
	function php4()
	{
		if (!function_exists('file_put_contents'))
		{
			function file_put_contents($filename, $data)
			{
				$f = @fopen($filename, 'w');
				if (!$f) return false;
				else
				{
					$bytes = fwrite($f, $data);
					fclose($f);
					return $bytes;
				}
			}
		}
		$this->itex_debug('Used php4');
	}

	/**
   	*  Russian lang support
   	*
   	*/
	function lang_ru()
	{
		return ; // тк перешел на .mo файлы
//
//
//		global $l10n;
//		$locale = get_locale();
//		if ($locale == 'ru_RU')
//		{
//			$domain = 'iMoney';
//			if (isset($l10n[$domain])) return;
//			///ru_RU lang .mo file
//			$input = 'eNqdWG1wXFUZPkgR2tKEhpTSpk1OUPmQbJIWSssCwSZpodDYkKSlCBpvdm82l2z27uy9aRNwpE0pqC2EqWVkmGJlRsdRcUzapB9pm/JHRQedu8PoOP7QcaaMOsMffsgw+DE+73nf3b2bbFLSndk8e877ed6P85G/VCx6VeHzVXzX4LvoaqWeA35wjTKff1yr1I3AfwIrgP8FfhZ4w3VKLQGuBJYBbwFWAdcJtsm8cx3LDwHLgYeBlcBjQh8HLgW+DVwGfBd4E/DPwFXAD4GrgUsXM966mOmbgSuAuxezP6nF7P8gEC6qIzL/OvAJ4Jsy/vdi9vsz+APVahlwHHgTcAPwHeBK4P+Aa2kezt0MvHsp87ctZf27gLcAvwa8DbgfGAX+BKiBlwSvuZ79uhVYDWwBfh7YI/ii4FuC2es5fh8Ba4AVyxjXAzGlOpax/e5lHK+E4CD+3AA8AEQK1VHhf20Zx/dHMh4X/mmZf3cZr/NPQv8IiBCpq5GcOyk+wC8A7y1jue4yjsOA4J4yjutzQn+hjPNytIzz/tMyzvM0/iwH/q6M/f9rGfv7d6F/LONry3l8cznX222C0XLW31bO8XhS+J4t53r6Tjn7f7yc6+atcq63XwnfH2X8vuC/yrkOroHRgatg+waOwzeXc/yPLWe5M8t5/tfL2b/3gXdQnAR1Bef3EeDtlI8Krs9XKrg+flzB/vy2guvqkvD/B7gRuOpGrpvHgPdRfwi+A7yV+rGS439nJcfvsUqmxyrZn+OV7OcY8CzwYiXnY3gFr2/fCs7TIWAj1nkU+A2Mf3kT22+GUw8AnwFuovWu5Hh/uJL1L0Lx3wtcIbgD2A78NvAe6lPB5auY/jDwfuDIKl7XRcFPBDesZkyvZns/W83ylwSrqjg+HVVcn24V99GzVbJvAGupjqvYv/equM4uVXHcP67ifi1fw+Pb1/B6HlzD/nWs4XgeFvoJ4NPA3wC/Qn2+lu2NruU6GVvLdff2Wtbz+7VcH38Dfo72w7XsT20157ulmvu4t5r9O1TNcsdk/AsZv13N+Xyvmtf1vuAnwldew3nWNTx+CthIfVfD+f5+De87P6/hdfyhhvfHD2R8rWas1mxnA/Aqxbq28tauPqO4RrZR3hTHhWJJfb9FsVzu82XFdUU5ofxSD3cpjkWHYl/XhPjLBGkvaFbsG8WVYkr99KUQb70g9S/tkY8rXttDMk/xpNjWyvhJfBvk9yLFedslY8rxJjnPnpK5FupzfLcr3ttyH9pHHpTf60LzbfjWKa5H+mwM0XZSD8rv9YLU9zvwjeB7l+L8rhQa9Rb1P+3Ju2WuU/HeQZ9Wxf0U/mxWXHNUD7QHUJ09EqI/Ktgo+EUlZ5Ti3mpSfOZR31MN0Lmmmlodz+pJ2vH7G9y077ippiWqaUtq5tTmmO/ssdXmuPaSrq+dOH56dsqzdXPSjfXr/HBbXKfAELd7nRQ09GQamojWb6XnoPX6dka3uCnfTvlRGcZ4qJNOqt9TzXavm7ELPDKewWTcSLueQx7L0HOesbVqsVJf93UsY1v+zFEnuRV3MrXF012poYbdVroEhYz12na8BGnAclJELkHyYKY+3ZeeMT1kpWW2z471R1WLm0xaaQSxz7biUGV72rN930klPCJiuUO+ajGyAtpKxY1hH19t6XRyMIEfvtUPV13/Nk+7vdp3Bux6va1XD7uD2k497Q5rv8/xhLlOx11ItropiyJXr1o8Tzc1GXAGErmfafrRavcMJqA4oWGk13UpV8iFtpLJOr23z9Vu2ob1PqzY8WETSpEf29pji0UrYw3YJOXtdfxYH+IopcZqoDqVMP7W6R47Zg0iFrQcko1ZNPD1XieZRIi9WNLFBJaU0emMs4eCEbd8qHCw9s7N7Vv0zm2tpTyu11thy7PBb4gwktEDg56vM3bC8cChWp2MiWxbkvIj6YrX5udzVVCaKmkNE7jFlCwWSDEwvpu+iaE3WvMr7XGH6mewmPahmM7H12wnBlEEg76LQMdncOrbe4jcTeRukO8oEs3FKyxRezmGIg19/kByTqJjenROcr6p5vNgLqYiTfkenE/TXExFmiiBc9H81NC8BkrQ69VWbhferXgQVQ8l3R4ryYUYVQ9zDFGPPhq+zfL60frUwSzUZg2pduOWcLS7e+0MItIzrJXZyXY53qCVjPIgxhuGjIwK/h2XOs3tSoVC7aRObemzUgnbU502tavvZlRnn7u3eLvVbio5jD+63QKr0dbuer5XH+Id8ufhcrBkKxcNGUXVLjvjYQ/CD7MQ9bgTT9i+lsNHRq3DKWvAic2Y3W7cKp7rcvykHdUyDG+mj7sZiq16It+CdHS1RnkiV+wytHLHV27CdFJhGK5MmQqXmExJUURVN6nv3tm5pQP7JiIfHy4+EXPm5GAtycMeCIe4U+JwdbZL30nBOG1uyh7WO8yp7qm841Icea9lTC7Lz/aM+7Qd8yPb4pFckvSSDjvtZvxIm5dw4pHmwYQX6XIx3b6jK2KOJ3BFWlFZUb2+sfHeSOPdkbsa9bp7ohvW39m4obERjJEOe4/jlebbGG3cyHzbLc+PdGWslJekeoziGLCHMJtKDKKwIl22NQCzbdvathScW1ffuERuDJGu4TR0U0U2pJNY43061mdlUA0P7OzaGtlU4CMTvXYmsiUVc+Ooj6je1OP4S3ZH2l10jR951B7e62bi3nYcE1Hd3V2gNON0Slt+X1Q39LkDdkO/nekZ9hrWNTgDFPICY6dtZWJ97WCNNM7FrJqCI9lDwVRwLvty9sVgMrgQTIevZ8GROWnBK8FUdiQ4E5wgggpeA0wQF01mnwdhKhjD7+nsvsKdLRgPzgXTwVT4Ege5SZ09kN0P5jHSBY3nSNGsK91lOIPjMLafZjRsTxtP2J+xqArehNghEKeCMzq4OCenCo4G05eVnyjBY+wHp7H4F/Adza+VKD+Av6eD88EkghGef4M8OI/RyewBDY9IfoLClj08L5Gvkxidye6D/SmOM0Yv184vl7tvYpULFc338BWYzff7FcgWrrTzsuWvuMFxqKXSQLApyiZ3zxtjY6hjKliWgPBYcBKs5wy7SewF0FBeRgOchOzr+SxPEQXKirNkUku6kddp8MGilhID04Tx4hTPXoQlsniGzLD5CxicB05mR2hlVNMnqbZOmCCdN113pl4Hr5pyJQeNqROIG6zDodEitXWawqqNI+MyPW183UfCEJSwj817+0Z1TAbj2QPBSXiis8+j50a4diewG4ySe/sxPlinOY9scCq7jzpEZ18yRkYoQ2PB2ewI/DeZm5bOPUFKiEDt/BIruGh8HDM9MkKWxgrbC7SeN6Zp1fDsXPawidRkPk7ZUbNyyFBbEuT0UrWcMuE1+d/PXnL+j2DiWyZXFB6uC2NtkqxRcsygzpSFMEkPsxHThTvxRJ0rYPXUaCZiJE17znmKDLmizW5pZGhwInvIbCtY5Ckyi20i5+ZpE5pJyrDU5hmp8DHiVCV6eZRKEEWP8CMh8rgoNAyJ1V5erujxsWDp3ONkluCsE0fNPGZoAv1rNosRk2bKVOj6RFE2HXaOqSe4ynEDm1NSLlYLlZz91CmtoMSrp7TC/PumtJ7aKxObbc0UtzYXfXNSTSxMkjK5P3zkfUph9rboCbWwhX4K0bmsFj23Fmb1U4jOFWJ6KC0wwmwz/3pbmKuXEaufcVUJb0fBpAp+mBvgbPuuOfrG0ZlmS4XQ2dC2JM9E2uxl24ZCSB3jfTS/C9HZlq8VutwRB52WtF1C0Xnzlpyl5jVsCifNwZG/x6Hz+WJzBKKnITqW2+vlbRm6c5nTWKbDlRq9/M6Uf47O2ppwtmcPmnPoAp+wmhyRc9icxdnR3G2O4hQ6kfj6N2VuA4fyd4xZPVR8aZw057VZ5BSdVuZe8CYfEMbaC9Bz0NwnjueOz+zB0qZmxuYKVc8sHnOGY7HjfApRjEITUSpSFBMlOztqRjMyx1MTcgiHjnVEoJiWe27Px8PPzJkc3yu6yE3TLSAkZK6Ab4QudmdlcSEWyEU5sXyLMzcyJR0efrbLVOHhXuDJP91lKvR6l5ni97tMFr/gc7KlHvEI6ynqdXOXMLdI89agWJsyDV0Lit9O+WfXgjXw8ZeXb879A+AyTzH5d8Csnp+dBflHQeE/BMW9nA9O8TRFp3jm//hLEEM=';
//			$input = gzuncompress(base64_decode($input));
//			if (file_exists(ABSPATH . WPINC . '/streams.php') && file_exists(ABSPATH . WPINC . '/gettext.php'))
//			{
//				include_once(ABSPATH . WPINC . '/streams.php');
//				include_once(ABSPATH . WPINC . '/gettext.php');
//				//die('2312313');
//				$inputReader = new StringReader($input);
//				$l10n[$domain] = new gettext_reader($inputReader);
//			}
//			else $this->itex_debug('Erorr in Ru language');
//			$this->itex_debug('Used Ru language');
//		}
	}

	/**
   	* Debug collector
   	*
   	*/
	function itex_debug($text='')
	{
		$this->debuglog .= "\r\n".$text."\r\n";
	}

	/**
   	* plugin init function 
   	*
   	* @return  bool	
   	*/
	function itex_m_init()
	{
		if ( function_exists('memory_get_usage') ) $this->memory_get_usage = memory_get_usage();
		if ( function_exists('get_num_queries') ) $this->get_num_queries = get_num_queries();

		//echo $this->get_num_queries;//die();


		if (get_option('itex_m_global_masking')){
			$this->itex_m_safe_url();
			$last_REQUEST_URI = $_SERVER['REQUEST_URI'];
			$_SERVER['REQUEST_URI'] = $this->safeurl;

		}
		$this->itex_debug('REQUEST_URI = '.$_SERVER['REQUEST_URI']);
		//echo '_phpInit_die';die();
		$this->itex_init_adsense();
		$this->itex_init_html();
		$this->itex_init_sape();
		$this->itex_init_tnx();
		$this->itex_init_begun();
		$this->itex_init_ilinks();
		$this->itex_init_mainlink();
		$this->itex_init_linkfeed();
		$this->itex_init_adskape();
		$this->itex_init_php();
		$this->itex_init_setlinks();
		$this->itex_init_teasernet();
		$this->itex_init_trustlink();
		
		//echo '_phpInit_die2';die();
		$this->itex_m_widget_init();
		if (strlen($this->footer)) add_action('wp_footer', array(&$this, 'itex_m_footer'));

		//echo get_num_queries();die();

		if ((strlen($this->beforecontent)) || (strlen($this->aftercontent)) )
		{
			$this->itex_debug('strlenbeforecontent = '.strlen($this->beforecontent));
			$this->itex_debug('strlenaftercontent = '.strlen($this->aftercontent));
			add_filter('the_content', array(&$this, 'itex_m_replace'));
			add_filter('the_excerpt', array(&$this, 'itex_m_replace'));
		}

		if (isset($last_REQUEST_URI)) //privodim REQUEST_URI v poryadok
		{
			$_SERVER['REQUEST_URI'] = $last_REQUEST_URI;
			unset($last_REQUEST_URI);
		}
		//if ( function_exists('memory_get_usage') ) $this->memory_get_usage['stop'] = memory_get_usage();
		if ( function_exists('memory_get_usage') ) $this->itex_debug("memory start/end/dif ".$this->memory_get_usage.'/'.memory_get_usage().'/'.(memory_get_usage()-$this->memory_get_usage));

		//if ( function_exists('get_num_queries') ) $this->itex_debug("get_num_queries start/end/dif ".$this->get_num_queries.'/'.get_num_queries().'/'.get_num_queries()-$this->get_num_queries.'/');
		//if ( function_exists('get_num_queries') ) $this->itex_debug("get_num_queries start/end/dif ".intval($this->get_num_queries).' / '.intval(get_num_queries()).'/'.intval(get_num_queries())-intval($this->get_num_queries).'/');
		//if ( function_exists('get_num_queries') ) $this->itex_debug("get_num_queries start/end/dif ".intval($this->get_num_queries).' / '.intval(get_num_queries()).' / ');
		if ( function_exists('get_num_queries') ) $this->itex_debug("get_num_queries start/end/dif ".intval($this->get_num_queries).'/'.intval(get_num_queries()).'/'.(intval(get_num_queries())-intval($this->get_num_queries)));
		//echo get_num_queries();die();
		return 1;
	}

	/**
   	* sape init
   	*
   	* @return  bool
   	*/
	function itex_init_sape()
	{
		if (!get_option('itex_m_sape_enable') && !get_option('itex_m_sape_sapecontext_enable') && !get_option('itex_m_sape_sapearticles_enable')) return 0;
		
		if (!defined('_SAPE_USER')) define('_SAPE_USER', get_option('itex_m_sape_sapeuser'));
		else $this->error .= '_SAPE_USER '.__('already defined<br/>', 'iMoney');
		$this->itex_debug('SAPE_USER = '.get_option('itex_m_sape_sapeuser'));
		//FOR MASS INSTALL ONLY, REPLACE if (0) ON if (1)
		//		if (0)
		//		{
		//			update_option('itex_sape_sapeuser', 'abcdarfkwpkgfkhagklhskdgfhqakshgakhdgflhadh'); //sape uid
		//			update_option('itex_sapecontext_enable', 1);
		//			update_option('itex_sape_enable', 1);
		//			update_option('itex_sape_links_footer', 'max');
		//		}

		$file = $this->document_root . '/' . _SAPE_USER . '/sape.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else return 0;

		$o['charset'] = get_option('blog_charset')?get_option('blog_charset'):'UTF-8';
		//$o['force_show_code'] = $this->force_show_code;

		//if (get_option('itex_m_global_debugenable'))
		//{
		$o['force_show_code'] = 1; // сделал так, тк новые страницы не добавляются
		//}
		$o['multi_site'] = true;
		//		if (get_option('itex_m_sape_masking'))
		//		{
		//			$this->itex_m_safe_url();
		//			$o['request_uri'] = $this->safeurl;
		//		}
		if (get_option('itex_m_sape_enable'))
		{
			$this->sape = new SAPE_client($o);

			//$this->itex_debug('$this->sape->_links = '.var_export( $this->sape->_links,1));
			//$this->itex_debug('$this->sape->_links_page = '.var_export( $this->sape->_links_page,1));

			//echo 'sape->_links';
			//$this->sape->_is_our_bot = true; //сделал так, тк новые страницы не добавляются

			

			$this->itex_init_sape_links();


			///check it
			if (is_object($GLOBALS['wp_rewrite'])) $url = url_to_postid($_SERVER['REQUEST_URI']);
			else $url = 1;
			if (($url) || !get_option('itex_sape_pages_enable'))
			{
				if (get_option('itex_m_sape_links_beforecontent') == '0')
				{
					//$this->beforecontent = '';
				}
				else
				{
					$this->beforecontent .= '<div>'.$this->itex_init_sape_get_links(intval(get_option('itex_sape_links_beforecontent'))).'</div>';
				}

				if (get_option('itex_m_sape_links_aftercontent') == '0')
				{
					//$this->aftercontent = '';
				}
				else
				{
					
					$this->aftercontent .= '<div>'.$css.$this->itex_init_sape_get_links(intval(get_option('itex_m_sape_links_aftercontent'))).'</div>';
				}
			}
			$countsidebar = get_option('itex_m_sape_links_sidebar');
			$check = get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
			if ($countsidebar == 'max')
			{
				//$this->sidebar = '<div>'.$this->sape->return_links().'</div>';
			}
			elseif ($countsidebar == '0')
			{
				//$this->sidebar = '';
			}
			else
			{
				$this->sidebar_links .= '<div>'.$this->itex_init_sape_get_links(intval($countsidebar)).'</div>';
			}
			$this->sidebar_links = $check.$this->sidebar_links;

			$countfooter = get_option('itex_m_sape_links_footer');
			$check = get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
			$this->footer .= $check;
			if ($countfooter == 'max')
			{
				//$this->footer = '<div>'.$this->sape->return_links().'</div>';
			}
			elseif ($countfooter == '0')
			{
				//$this->footer = '';
			}
			else
			{
				$this->footer .= '<div>'.$this->itex_init_sape_get_links($countfooter).'</div>';
			}
			$this->footer = $check.$this->footer;

			if (($countsidebar == 'max') && ($countfooter == 'max')) $this->footer .= $this->itex_init_sape_get_links();
			else
			{
				if  ($countsidebar == 'max') $this->sidebar_links .= $this->itex_init_sape_get_links();
				else $this->footer .= $this->itex_init_sape_get_links();
			}
			
		}

		if (get_option('itex_m_sape_sapecontext_enable'))
		{
			$this->sapecontext = new SAPE_context($o);
			add_filter('the_content', array(&$this, 'itex_m_replace'));
			add_filter('the_excerpt', array(&$this, 'itex_m_replace'));
		}

		if (get_option('itex_m_sape_sapearticles_enable'))
		{
			//подстраховываемся, если старый файл сапы
			//if (function_exists('SAPE_articles::SAPE_articles()')) $this->sapearticles = new SAPE_articles($o);
			if(is_callable(array('SAPE_articles', 'SAPE_articles')))
			{
				$this->itex_debug('Class SAPE_articles exist');
				$this->sapearticles = new SAPE_articles($o);

				$this->itex_debug('sape articles url template /itex_sape_articles_template.'._SAPE_USER.'.html');

				//для прохождения модераторов
				$isvalidurl = 0;
				$preg = get_option('itex_m_sape_sapearticles_template_url');
				if (strlen($preg) > 4)
				{
					$preg = str_ireplace('\\','\\\\',$preg);
					$preg = str_ireplace('.','\\.',$preg);
					$preg = str_ireplace('?','\\?',$preg);
					$preg = str_ireplace('{date_d}','[0-9]{1,2}',$preg);
					$preg = str_ireplace('{date_m}','[0-9]{1,2}',$preg);
					$preg = str_ireplace('{date_y}','[0-9]{2,4}',$preg);
					$preg = str_ireplace('{name}','([a-z0-9\_\-]+)',$preg);
					$preg = str_ireplace('{id}','([0-9]+)',$preg);
					$preg = '@'.$preg.'@i';
					$this->itex_debug('sapearticles_template_url preg = '.$preg);

					if (preg_match($preg,$_SERVER['REQUEST_URI']))
					{
						$isvalidurl = 1;
					}
				}

				//генерация шаблона
				if (preg_match('@itex_sape_articles_template\.'._SAPE_USER.'@i',$_SERVER['REQUEST_URI']))
				{
					if (!headers_sent())
					{
						header(200);
						
						//на всякий пожарный, если сервер отдаст не ту кодировку
						header('Content-Type: text/html; charset='.$o['charset']);
						$this->itex_debug('header 200 sent');
						echo '';flush(); //чтоб не переопределили хеадер,куки для шаблона не нужны
					}
					//phpinfo();die();
					remove_all_actions('wp');
					remove_all_actions('wp_head');
					add_action('wp', array(&$this, 'itex_init_sape_articles_template'),-999);
					global $wp_query;
				}
				//если есть статьи или адрес соотвествует адресу шаблона, то передаем управление коду сапы
				elseif ((!empty($this->sapearticles->_data['index']) and isset($this->sapearticles->_data['index']['articles'][$this->sapearticles->_request_uri])) ||
				($isvalidurl)||
				(!empty($this->sapearticles->_data['index']) and isset($this->sapearticles->_data['index']['images'][$this->sapearticles->_request_uri])))
				{
					if (!headers_sent())
					{
						header(200);
						
						//на всякий пожарный, если сервер отдаст не ту кодировку
						//надо разобраться, тк могут побиться картинки
						if (!isset($this->sapearticles->_data['index']['images'][$this->sapearticles->_request_uri]))
							header('Content-Type: text/html; charset='.$o['charset']);
						$this->itex_debug('header 200 sent');
					}
					echo $this->sapearticles->process_request();
					die();
				}
//				elseif (($isvalidurl)||
//				($this->sapearticles->_is_our_bot))
//				{
//					if (!headers_sent())
//					{
//						header(200);
//						$this->itex_debug('header 200 sent');
//					}
//					echo $this->sapearticles->process_request();
//					die();
//
//					//возможно надо будет переделать покрасивее
//
//				}

				//анонсы
				///check it
				if (is_object($GLOBALS['wp_rewrite'])) $url = url_to_postid($_SERVER['REQUEST_URI']);
				else $url = 1;
				if (($url) || !get_option('itex_m_sape_sapearticles_pages_enable'))
				{
					$this->itex_debug('sapearticles announcements worked');
					if (get_option('itex_m_sape_sapearticles_beforecontent') == '0')
					{
						//$this->beforecontent = '';
					}
					else
					{
						$this->beforecontent .= '<div>'.$this->sapearticles->return_announcements(intval(get_option('itex_m_sape_sapearticles_beforecontent'))).'</div>';
					}

					if (get_option('itex_m_sape_sapearticles_aftercontent') == '0')
					{
						//$this->aftercontent = '';
					}
					else
					{

						$this->aftercontent .= '<div>'.$this->sapearticles->return_announcements(intval(get_option('itex_m_sape_sapearticles_aftercontent'))).'</div>';
					}
				}
				$countsidebar = get_option('itex_m_sape_sapearticles_sidebar');
				$check = get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
				if ($countsidebar == 'max')
				{
					//$this->sidebar = '<div>'.$this->sape->return_links().'</div>';
				}
				elseif ($countsidebar == '0')
				{
					//$this->sidebar = '';
				}
				else
				{
					$this->sidebar_links .= '<div>'.$this->sapearticles->return_announcements(intval($countsidebar)).'</div>';
				}
				$this->sidebar_links = $check.$this->sidebar_links;

				$countfooter = get_option('itex_m_sape_sapearticles_footer');
				$check = get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
				$this->footer .= $check;
				if ($countfooter == 'max')
				{
					//$this->footer = '<div>'.$this->sape->return_links().'</div>';
				}
				elseif ($countfooter == '0')
				{
					//$this->footer = '';
				}
				else
				{
					$this->footer .= '<div>'.$this->sapearticles->return_announcements($countfooter).'</div>';
				}
				$this->footer = $check.$this->footer;

				if (($countsidebar == 'max') && ($countfooter == 'max')) $this->footer .= $this->sapearticles->return_announcements();
				else
				{
					if  ($countsidebar == 'max') $this->sidebar_links .= $this->sapearticles->return_announcements();
					else $this->footer .= $this->sapearticles->return_announcements();
				}

			}
			else $this->itex_debug('Class SAPE_articles not exist');

		}
		return 1;
	}

	/**
   	* get sape links
   	*
   	* @return  bool
   	*/
	function itex_init_sape_links()
	{
		$i = 1;

		while ($i++)
		{
			$q = trim($this->sape->return_links(1));
			if (empty($q) || !strlen($q))
			{
				break;
			}
			
			$q1 = trim(strip_tags($q)); //если нет текста, то и нечего показывать, значит ссылок больше нет
			if (empty($q1) || !strlen($q1))
			{
				break;
			}

			//убрал, тк сайт не индексируются возможно из-за этого
			//if(!preg_match("/^\<\!\-\-/", $q)) $q .= $this->sape->_links_delimiter; // убираем коммент, не повредит дебагу?



			
			if (strlen($q)) $this->links['a_only'][] = $q.$this->sape->_links_delimiter;

			//!!!!!!!!!!check it, tk ne vozvrashaet pustuu stroku
			if ($i > 30) break;
		}
		if (!count($this->links)) // если нет размещенных ссылок, и включен debugenable добавляем чеккод
		{
			if (get_option('itex_m_global_debugenable'))
			$this->links['a_only'][] = trim($this->sape->return_links());
		}
		$this->itex_debug('sape links:'.var_export($this->links, true));
		return 1;
	}

	/**
   	* get links
   	*
   	* @param   int   $c		count
   	* @param   int   $c		a only if 1
    * @return  string $ret  
   	*/
	function itex_init_sape_get_links($c = 30, $q=1) //$q = a only
	{
		$ret = '';
		for ($i=1;$i<=$c;$i++)
		{
			if ($q)
			{
				if (count($this->links['a_only']))
				foreach ($this->links['a_only'] as $k=>$v)
				{
					$ret .= $v;
					//$ret .= $this;

					unset($this->links['a_only'][$k]);
					break;
				}
			}
			else
			{
				if (count($this->links['a_text']))
				foreach ($this->links['a_text'] as $k=>$v)
				{
					$ret .= $v;
					unset($this->links['a_text'][$k]);
					break;
				}
			}
		}
		return $ret;
	}


	/**
   	* get sape articles
   	*
   	* @return  bool
   	*/
	function itex_init_sape_articles_template()
	{
		$this->itex_debug('itex_init_sape_articles_template worked');
		
		global $wp_query;
		global $post;
		$wp_query = new WP_Query('');
		$this->itex_debug('sapearticles template worked');
		$post = new stdClass();
		$post->ID= -404;
		$post->post_category= array(); //Add some categories. an array()???
		$post->post_status='publish';
		$post->post_type='post'; //page.
		$post->post_content="<h1>{header}</h1>\r\n{body} ".$this->sapearticles->_data['index']['checkCode'];
		$post->post_excerpt= "{description}";
		$post->post_title= "{title}";
		$post->post_author = 1;
		$wp_query->queried_object=$post;
		$wp_query->post=$post;
		$wp_query->posts = array($post);
		$wp_query->found_posts = 1;
		$wp_query->post_count = 1;
		$wp_query->max_num_pages = 1;
		$wp_query->is_single = 1;
		$wp_query->is_404 = false;
		$wp_query->is_posts_page = 1;

		$wp_query->page=false;
		$wp_query->is_post=true;

		remove_all_actions('wp_head');
		remove_all_actions('get_header'); remove_all_actions('template_redirect'); //для плагинов с редиректом
		
		add_action('wp_head', array(&$this, 'itex_init_sape_articles_wp_head'),-999);
		if (!headers_sent())
		{
			header(200);
			$this->itex_debug('header 200 sent');
			echo '';flush(); //чтоб не переопределили хеадер,куки для шаблона не нужны
		}
		
	}

	/**
   	* get sape articles in wp_head()
   	*
   	* @return  bool
   	*/
	function itex_init_sape_articles_wp_head()
	{
		
		echo '<!-- iMoney start-->
<meta http-equiv="content-type" content="text/html; charset={meta_charset}" >
<meta name="description" content="{description}">
<meta name="keywords" content="{keywords}">
<!-- iMoney end-->';
		//phpinfo();
		//die('itex_init_sape_articles_wp_head');
		
		return ;
	}

	/**
   	* tnx init
   	*
    * @return  bool	
   	*/
	function itex_init_tnx()
	{
		if (!get_option('itex_m_tnx_enable')) return 0;
		$file = $this->document_root . '/' . 'tnxdir_'.md5(get_option('itex_m_tnx_tnxuser')) . '/tnx.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else return 0;
		$this->itex_debug('TNX_USER = '.get_option('itex_m_tnx_tnxuser'));

		//moget tnx ne produmali multihosting bag, mb ya mudag pravda)) skorey vsego ta mudag i chtonit kuril, ppc narko kod), pri multi $_SERVER['DOCUMENT_ROOT'] == "/var/www/default/"
		if ($_SERVER['DOCUMENT_ROOT'] != $this->document_root) //nachinaniem izvrasheniya ((
		{
			$last_DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
			$_SERVER['DOCUMENT_ROOT'] = $this->document_root;
		}
		//		$dir .= '/..';
		//		for ($i = 0;$i<10;$i++) $dir .= '/..';
		//		$dir .= dirname($file).'/';
		//
		$dir = '/' . 'tnxdir_'.md5(get_option('itex_m_tnx_tnxuser')).'/';
		$this->tnx = new TNX_n(get_option('itex_m_tnx_tnxuser'), $dir);
		$this->tnx->_encoding = get_option('blog_charset')?get_option('blog_charset'):'UTF-8';//nafiga eto, esli TNX_n idet sverhu konstruktorom, poka ostavlu

		if (isset($last_DOCUMENT_ROOT)) //zakanchivaem izvrashatsa i privodim vse v poryadok
		{
			$_SERVER['DOCUMENT_ROOT'] = $last_DOCUMENT_ROOT;
			unset($last_DOCUMENT_ROOT);
		}


		if (get_option('itex_m_tnx_enable'))
		{
			if (get_option('itex_m_tnx_links_beforecontent') == '0')
			{
				//$this->beforecontent = '';
			}
			else
			{
				$this->beforecontent .= '<div>'.$this->tnx->show_link(intval(get_option('itex_tnx_links_beforecontent'))).'</div>';
			}

			if (get_option('itex_m_tnx_links_aftercontent') == '0')
			{
				//$this->aftercontent = '';
			}
			else
			{
				$this->aftercontent .= '<div>'.$this->tnx->show_link(intval(get_option('itex_tnx_links_aftercontent'))).'</div>';
			}

			$countsidebar = get_option('itex_m_tnx_links_sidebar');
			$check = get_option('itex_m_global_debugenable')?'<!---check sidebar tnx'.$countsidebar.'-->':'';
			if ($countsidebar == 'max')
			{
				//$this->sidebar = '<div>'.$this->tnx->show_link().'</div>';
			}
			elseif ($countsidebar == '0')
			{
				//$this->sidebar = '';
			}
			else
			{
				$this->sidebar_links .= '<div>'.$this->tnx->show_link(intval($countsidebar)).'</div>';
			}
			$this->sidebar_links = $check.$this->sidebar_links;

			$countfooter = get_option('itex_m_tnx_links_footer');
			$check = get_option('itex_m_global_debugenable')?'<!---check footer tnx'.$countfooter.'-->':'';
			$this->footer .= $check;
			if ($countfooter == 'max')
			{
				//$this->footer = '<div>'.$this->tnx->show_link().'</div>';
			}
			elseif ($countfooter == '0')
			{
				//$this->footer = '';
			}
			else
			{
				$this->footer .= '<div>'.$this->tnx->show_link(intval($countfooter)).'</div>';
			}
			$this->footer = $check.$this->footer;

			if (($countsidebar == 'max') && ($countfooter == 'max')) $this->footer .=$this->tnx->show_link();
			else
			{
				if  ($countsidebar == 'max') $this->sidebar_links .=$this->tnx->show_link();
				else $this->footer .=$this->tnx->show_link();
			}
		}
		return 1;
	}

	
	/**
   	* Trustlink init
   	*
   	* @return  bool
   	*/
	function itex_init_trustlink()
	{
		if (!get_option('itex_m_trustlink_enable') ) return 0;
		
		if (!defined('TRUSTLINK_USER')) define('TRUSTLINK_USER', get_option('itex_m_trustlink_user'));
		else $this->error .= 'TRUSTLINK_USER '.__('already defined<br/>', 'iMoney');
		$this->itex_debug('TRUSTLINK_USER = '.get_option('itex_m_trustlink_user'));

		$file = $this->document_root . DIRECTORY_SEPARATOR . TRUSTLINK_USER . DIRECTORY_SEPARATOR . 'trustlink.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else return 0;

		$o['charset'] = get_option('blog_charset')?get_option('blog_charset'):'UTF-8';
		//$o['force_show_code'] = $this->force_show_code;

		//if (get_option('itex_m_global_debugenable'))
		//{
		$o['force_show_code'] = 1; // сделал так, тк новые страницы не добавляются
		//}
		$o['multi_site'] = true;
		//		if (get_option('itex_m_trustlink_masking'))
		//		{
		//			$this->itex_m_safe_url();
		//			$o['request_uri'] = $this->safeurl;
		//		}
		if (get_option('itex_m_trustlink_enable'))
		{
			
			$trustlink = new TrustlinkClient($o);

			if (get_option('itex_m_trustlink_links_beforecontent') == '0')
			{
				//$this->beforecontent = '';
			}
			else
			{
				$this->beforecontent .= '<div>'.$trustlink->build_links().'</div>';
			}

			if (get_option('itex_m_trustlink_links_aftercontent') == '0')
			{
				//$this->aftercontent = '';
			}
			else
			{
				$this->aftercontent .= '<div>'.$trustlink->build_links().'</div>';
			}
			//}
			$countsidebar = get_option('itex_m_trustlink_links_sidebar');
			$check = get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
			if ($countsidebar == 'max')
			{
				//$this->sidebar = '<div>'.$this->mainlink->return_links().'</div>';
				$this->sidebar_links .= '<div>'.$trustlink->build_links().'</div>';
			}
			elseif ($countsidebar == '0')
			{
				//$this->sidebar = '';
			}
//			else
//			{
//				$this->sidebar_links .= '<div>'.$trustlink->build_links().'</div>';
//			}
			$this->sidebar_links = $check.$this->sidebar_links;

			$countfooter = get_option('itex_m_trustlink_links_footer');
			$check = get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
			$this->footer .= $check;
			if ($countfooter == 'max')
			{
				//$this->footer = '<div>'.$this->mainlink->return_links().'</div>';
				$this->footer .= '<div>'.$trustlink->build_links().'</div>';
			}
			elseif ($countfooter == '0')
			{
				//$this->footer = '';
			}
			else
			{
				$this->footer .= '<div>'.$trustlink->build_links().'</div>';
			}
			$this->footer = $check.$this->footer;

//			if (($countsidebar == 'max') && ($countfooter == 'max')) $this->footer .= $trustlink->build_links();
//			else
//			{
//				if  ($countsidebar == 'max') $this->sidebar_links .= $trustlink->build_links();
//				else $this->footer .= $trustlink->build_links();
//			}

			
		}

		
		
		
		return 1;
	}

	/**
   	* Adsense init
   	*
   	* @return  bool
   	*/
	function itex_init_adsense()
	{
		if (!get_option('itex_m_adsense_enable')) return 0;

		if (get_option('itex_m_adsense_id'));
		else $this->error .= __('Adsense Id not defined<br/>', 'iMoney');

		$maxblock = 4; //max  adsense blocks - 1
		for ($block=1;$block<$maxblock;$block++)
		{
			if (get_option('itex_m_adsense_b'.$block.'_enable'))
			{
				$size = get_option('itex_m_adsense_b'.$block.'_size');
				$size = explode('x',$size);

				//$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
				$script = '<script type="text/javascript"><!--
google_ad_client = "'.get_option('itex_m_adsense_id').'"; google_ad_slot = "'.get_option('itex_m_adsense_b'.$block.'_adslot').'"; google_ad_width = '.$size[0].'; google_ad_height = '.$size[1].';
//--></script><script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
				$pos = get_option('itex_m_adsense_b'.$block.'_pos');
				switch ($pos)
				{
					case 'sidebar':
						{
							$this->sidebar['imoney_adsense_'.$block] = '<p>'.$script.'</p>';
							//die('imoney_adsense_'.$block);
							break;
						}
					case 'footer':
						{
							$this->footer .= '<p style="float:left;">'.$script.'</p>';
							break;
						}
					case 'beforecontent':
						{
							$this->beforecontent .= '<p style="float:left;">'.$script.'</p>';
							break;
						}
					case 'aftercontent':
						{
							$this->aftercontent .= '<p style="float:left;">'.$script.'</p>';
							break;
						}
					default: {}
				}

			}
		}
		return 1;
	}

	/**
   	* Teasernet init
   	*
   	* @return  bool
   	*/
	function itex_init_teasernet()
	{
		if (!get_option('itex_m_teasernet_enable')) return 0;

		if (get_option('itex_m_teasernet_padid'));
		else $this->error .= __('Teasernet Id not defined<br/>', 'iMoney');

		$maxblock = 4; //max  teasernet blocks - 1
		for ($block=1;$block<$maxblock;$block++)
		{
			if (get_option('itex_m_teasernet_b'.$block.'_enable'))
			{
				$size = get_option('itex_m_teasernet_b'.$block.'_size');
				$size = explode('x',$size);

				//$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
				$script = '<script type="text/javascript"><!--
teasernet_blockid = '.get_option('itex_m_teasernet_b'.$block.'_blockid').';
teasernet_padid = '.get_option('itex_m_teasernet_padid').';
//--></script><script type="text/javascript" src="http://associeta.com/block.js"></script>';
				$pos = get_option('itex_m_teasernet_b'.$block.'_pos');
				switch ($pos)
				{
					case 'sidebar':
						{
							$this->sidebar['imoney_teasernet_'.$block] = '<p>'.$script.'</p>';
							//die('imoney_teasernet_'.$block);
							break;
						}
					case 'footer':
						{
							$this->footer .= '<p style="float:left;">'.$script.'</p>';
							break;
						}
					case 'beforecontent':
						{
							$this->beforecontent .= '<p style="float:left;">'.$script.'</p>';
							break;
						}
					case 'aftercontent':
						{
							$this->aftercontent .= '<p style="float:left;">'.$script.'</p>';
							break;
						}
					default: {}
				}

			}
		}
		return 1;
	}


	/**
   	* Begun init
   	*
   	* @return  bool
   	*/
	function itex_init_begun()
	{
		if (!get_option('itex_m_begun_enable')) return 0;

		if (get_option('itex_m_begun_id'));
		else $this->error .= __('begun Id not defined<br/>', 'iMoney');

		$maxblock = 4; //max  begun blocks - 1
		for ($block=1;$block<$maxblock;$block++)
		{
			if (get_option('itex_m_begun_b'.$block.'_enable'))
			{
				$script = '<p><script type="text/javascript"><!--
var begun_auto_pad = '.get_option('itex_m_begun_id').';var begun_block_id = '.get_option('itex_m_begun_b'.$block.'_block_id').';
//--></script><script type="text/javascript" src="http://autocontext.begun.ru/autocontext2.js"></script></p>';
				$pos = get_option('itex_m_begun_b'.$block.'_pos');
				switch ($pos)
				{
					case 'sidebar':
						{
							$this->sidebar['iMoney_begun_'.$block] = $script;
							break;
						}
					case 'footer':
						{
							$this->footer .= $script;
							break;
						}
					case 'beforecontent':
						{
							$this->beforecontent .= $script;
							break;
						}
					case 'aftercontent':
						{
							$this->aftercontent .= $script;
							break;
						}
					default: {}
				}

			}
		}
		return 1;
	}

	/**
   	* adskape init
   	*
   	* @return  bool
   	*/
	function itex_init_adskape()
	{
		if (!get_option('itex_m_adskape_enable')) return 0;

		if (get_option('itex_m_adskape_id'));
		else $this->error .= __('Adskape Id not defined<br/>', 'iMoney');

		$maxblock = 4; //max  adskape blocks - 1
		for ($block=1;$block<$maxblock;$block++)
		{
			if (get_option('itex_m_adskape_b'.$block.'_enable'))
			{
				$size = get_option('itex_m_adskape_b'.$block.'_size');
				//$size = explode('x',$size);

				//$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
				$script = '<script type="text/javascript" src="http://p'.get_option('itex_m_adskape_id').'.adskape.ru/adout.js?p='.get_option('itex_m_adskape_id').'&t='.$size.'"></script>';
				$pos = get_option('itex_m_adskape_b'.$block.'_pos');
				switch ($pos)
				{
					case 'sidebar':
						{
							$this->sidebar['imoney_adskape_'.$block] = '<div style="clear:right;">'.$script.'</div>';
							break;
						}
					case 'footer':
						{
							$this->footer .= '<p style="float:left;">'.$script.'</p>';
							break;
						}
					case 'beforecontent':
						{
							$this->beforecontent .= '<p style="float:left;">'.$script.'</p>';
							break;
						}
					case 'aftercontent':
						{
							$this->aftercontent .= '<p style="float:left;">'.$script.'</p>';
							break;
						}
					default: {}
				}

			}
		}
		return 1;
	}


	/**
   	* Html init
   	*
    * @return  bool
   	*/
	function itex_init_html()
	{
		if (!get_option('itex_m_html_enable')) return 0;

		if (get_option('itex_m_html_sidebar_enable')) $this->sidebar['iMoney_html'] = stripslashes(get_option('itex_m_html_sidebar'));
		if (get_option('itex_m_html_footer_enable')) $this->footer .= stripslashes(get_option('itex_m_html_footer'));
		if (get_option('itex_m_html_beforecontent_enable')) $this->beforecontent .= stripslashes(get_option('itex_m_html_beforecontent'));
		if (get_option('itex_m_html_aftercontent_enable')) $this->aftercontent .= stripslashes(get_option('itex_m_html_aftercontent'));
	}

	/**
   	* php init
   	*
    * @return  bool
   	*/
	function itex_init_php()
	{
		//echo '_phpPhp_die';die();
		if (!get_option('itex_m_php_enable')) return 0;
		//if (eregi('/wp-admin/',$_SERVER['PHP_SELF'])) return 0; //можно вернуться в админку и исправить косяки
		if (preg_match('@wp-admin@i',$_SERVER['PHP_SELF'])) return 0; //можно вернуться в админку и исправить косяки
		//echo '_php';die();
		if (get_option('itex_m_php_sidebar_enable'))
		{
			//echo '_php';die();
			ob_start();
			$code = stripslashes(get_option('itex_m_php_sidebar'));
			if (strlen($code)>1) if ($this->itex_m_admin_php_syntax($code)) eval($code);
			$code = ob_get_contents();
			ob_end_clean();
			$this->sidebar['iMoney_php'] = $code;
			//echo '_php'.$code;die();
		}
		if (get_option('itex_m_php_beforecontent_enable'))
		{
			ob_start();
			$code = stripslashes(get_option('itex_m_php_beforecontent'));
			if (strlen($code)>1) if ($this->itex_m_admin_php_syntax($code)) eval($code);
			$code = ob_get_contents();
			ob_end_clean();
			$this->beforecontent .= $code;
		}
		if (get_option('itex_m_php_aftercontent_enable'))
		{
			ob_start();
			$code = stripslashes(get_option('itex_m_php_aftercontent'));
			if (strlen($code)>1) if ($this->itex_m_admin_php_syntax($code)) eval($code);
			$code = ob_get_contents();
			ob_end_clean();
			$this->aftercontent .= $code;
		}
		if (get_option('itex_m_php_footer_enable'))
		{
			ob_start();
			$code = stripslashes(get_option('itex_m_php_footer'));
			//echo '_php'.$code;die();
			if (strlen($code)>1) if ($this->itex_m_admin_php_syntax($code)) if (eval($code)){};
			$code = ob_get_contents();
			ob_end_clean();
			$this->footer .= $code;
		}
	}


	/**
   	* iLinks init
   	*
    * @return  bool
   	*/
	function itex_init_ilinks()
	{
		if (!get_option('itex_m_ilinks_enable')) return 0;
		$separator = trim(get_option('itex_m_ilinks_separator'));
		if (empty($separator)) return 0;
		if (get_option('itex_m_ilinks_sidebar_enable'))
		{
			$l = explode("\n",stripslashes(get_option('itex_m_ilinks_sidebar')));
			foreach ($l as $q)
			{
				$w = explode($separator,trim($q),2);
				if (strtolower($w[0]{0}) == 'r')
				{
					$w[0] = substr($w[0],1,strlen($w[0]));
					//if (eregi($w[0],$_SERVER["REQUEST_URI"])) $this->sidebar['iMoney_ilinks']  .= $w[1];
					if (preg_match("@".$w[0]."@i",$_SERVER["REQUEST_URI"])) $this->sidebar['iMoney_ilinks']  .= $w[1];
				}
				elseif  ($_SERVER["REQUEST_URI"] == $w[0]) $this->sidebar['iMoney_ilinks']  .= $w[1];

			}
		}
		if (get_option('itex_m_ilinks_footer_enable'))
		{
			$l = explode("\n",stripslashes(get_option('itex_m_ilinks_footer')));
			foreach ($l as $q)
			{
				$w = explode($separator,trim($q),2);
				if (strtolower($w[0]{0}) == 'r')
				{
					$w[0] = substr($w[0],1,strlen($w[0]));
					//if (eregi($w[0],$_SERVER["REQUEST_URI"])) $this->footer .= $w[1];
					if (preg_match("@".$w[0]."@i",$_SERVER["REQUEST_URI"])) $this->footer .= $w[1];

				}
				elseif  ($_SERVER["REQUEST_URI"] == $w[0]) $this->footer .= $w[1];
			}
		}
		if (get_option('itex_m_ilinks_beforecontent_enable'))
		{
			$l = explode("\n",stripslashes(get_option('itex_m_ilinks_beforecontent')));
			foreach ($l as $q)
			{
				$w = explode($separator,trim($q),2);
				if (strtolower($w[0]{0}) == 'r')
				{
					$w[0] = substr($w[0],1,strlen($w[0]));
					//if (eregi($w[0],$_SERVER["REQUEST_URI"])) $this->beforecontent .= $w[1];
					if (preg_match("@".$w[0]."@i",$_SERVER["REQUEST_URI"])) $this->beforecontent .= $w[1];

				}
				elseif  ($_SERVER["REQUEST_URI"] == $w[0]) $this->beforecontent .= $w[1];
			}
		}
		if (get_option('itex_m_ilinks_aftercontent_enable'))
		{
			$l = explode("\n",stripslashes(get_option('itex_m_ilinks_aftercontent')));
			foreach ($l as $q)
			{
				$w = explode($separator,trim($q),2);
				if (strtolower($w[0]{0}) == 'r')
				{
					$w[0] = substr($w[0],1,strlen($w[0]));
					//if (eregi($w[0],$_SERVER["REQUEST_URI"])) $this->aftercontent .= $w[1];
					if (preg_match("@".$w[0]."@i",$_SERVER["REQUEST_URI"])) $this->aftercontent .= $w[1];
				}
				elseif  ($_SERVER["REQUEST_URI"] == $w[0]) $this->aftercontent .= $w[1];
			}
		}

	}

	/**
   	* mainlink init
   	*
   	* @return  bool
   	*/
	function itex_init_mainlink()
	{
		if (!get_option('itex_m_mainlink_enable')) return 0;
		if (!get_option('itex_m_mainlink_mainlinkuser')) return 0;
		if (!defined('SECURE_CODE')) define('SECURE_CODE', get_option('itex_m_mainlink_mainlinkuser'));
		else $this->error .= 'SECURE_CODE '.__('already defined<br/>', 'iMoney');
		$this->itex_debug('MAINLINK_USER = '.get_option('itex_m_mainlink_mainlinkuser'));



		$file = $this->document_root . '/mainlink_'.SECURE_CODE.'/ML.php';
		if (file_exists($file))
		{

			require_once($file);
		}
		else return 0;

		$mlcfg=array();
		//if (eregi('1251', get_option('blog_charset'))) $mlcfg['charset'] = 'win';
		if (preg_match('@1251@i', get_option('blog_charset'))) $mlcfg['charset'] = 'win';
		else $mlcfg['charset'] = 'utf';

		if (get_option('itex_m_global_debugenable'))
		{
			$mlcfg['debugmode'] = 1;
		}

		//$mlcfg['is_mod_rewrite'] = 1;  //проверить че за нах
		//$mlcfg['redirect'] = 0;

		$mlcfg['uri'] = $this->safeurl;
		//$mlcfg['is_mod_rewrite'] = 0;

		$ml->Set_Config($mlcfg);

		//		if (get_option('itex_m_mainlink_masking'))
		//		{
		//			$this->itex_m_safe_url();
		//			$last_REQUEST_URI = $_SERVER['REQUEST_URI'];
		//			$_SERVER['REQUEST_URI'] = $this->safeurl;
		//		}
		//

		if (get_option('itex_m_mainlink_enable'))
		{
			//$this->itex_init_mainlink_links();
			//if (is_object($GLOBALS['wp_rewrite'])) $url = url_to_postid($_SERVER['REQUEST_URI']);
			//else $url = 1;
			//if (($url) || !get_option('itex_m_mainlink_pages_enable'))
			//{
			if (get_option('itex_m_mainlink_links_beforecontent') == '0')
			{
				//$this->beforecontent = '';
			}
			else
			{
				$this->beforecontent .= '<div>'.$ml->Get_Links(intval(get_option('itex_m_mainlink_links_beforecontent'))).'</div>';
			}

			if (get_option('itex_m_mainlink_links_aftercontent') == '0')
			{
				//$this->aftercontent = '';
			}
			else
			{
				$this->aftercontent .= '<div>'.$ml->Get_Links(intval(get_option('itex_m_mainlink_links_aftercontent'))).'</div>';
			}
			//}
			$countsidebar = get_option('itex_m_mainlink_links_sidebar');
			$check = get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
			if ($countsidebar == 'max')
			{
				//$this->sidebar = '<div>'.$this->mainlink->return_links().'</div>';
			}
			elseif ($countsidebar == '0')
			{
				//$this->sidebar = '';
			}
			else
			{
				$this->sidebar_links .= '<div>'.$ml->Get_Links(intval($countsidebar)).'</div>';
			}
			$this->sidebar_links = $check.$this->sidebar_links;

			$countfooter = get_option('itex_m_mainlink_links_footer');
			$check = get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
			$this->footer .= $check;
			if ($countfooter == 'max')
			{
				//$this->footer = '<div>'.$this->mainlink->return_links().'</div>';
			}
			elseif ($countfooter == '0')
			{
				//$this->footer = '';
			}
			else
			{
				$this->footer .= '<div>'.$ml->Get_Links($countfooter).'</div>';
			}
			$this->footer = $check.$this->footer;

			if (($countsidebar == 'max') && ($countfooter == 'max')) $this->footer .= $ml->Get_Links();
			else
			{
				if  ($countsidebar == 'max') $this->sidebar_links .= $ml->Get_Links();
				else $this->footer .= $ml->Get_Links();
			}

		}

		return 1;
	}

	/**
   	* linkfeed init
   	*
   	* @return  bool
   	*/
	function itex_init_linkfeed()
	{
		if (!get_option('itex_m_linkfeed_enable')) return 0;
		if (!defined('LINKFEED_USER')) define('LINKFEED_USER', get_option('itex_m_linkfeed_linkfeeduser'));
		else $this->error .= 'LINKFEED_USER '.__('already defined<br/>', 'iMoney');
		$this->itex_debug('LINKFEED_USER = '.get_option('itex_m_linkfeed_linkfeeduser'));



		$file = $this->document_root . '/linkfeed_'.LINKFEED_USER.'/linkfeed.php';
		if (file_exists($file))
		{
			require_once($file);
		}
		else return 0;

		$o['charset'] = get_option('blog_charset')?get_option('blog_charset'):'UTF-8';
		$o['multi_site'] = true;
		if (get_option('itex_m_global_debugenable'))
		{
			$o['force_show_code'] = 1;
			//$o['verbose'] = 1;  //в футере инфу выдаст
		}
		$linkfeed = new LinkfeedClient($o);


		//		if (get_option('itex_m_linkfeed_masking'))
		//		{
		//			$this->itex_m_safe_url();
		//			$last_REQUEST_URI = $_SERVER['REQUEST_URI'];
		//			$_SERVER['REQUEST_URI'] = $this->safeurl;
		//		}
		//

		if (get_option('itex_m_linkfeed_enable'))
		{
			//$this->itex_init_linkfeed_links();
			//if (is_object($GLOBALS['wp_rewrite'])) $url = url_to_postid($_SERVER['REQUEST_URI']);
			//else $url = 1;
			//if (($url) || !get_option('itex_m_linkfeed_pages_enable'))
			//{
			if (get_option('itex_m_linkfeed_links_beforecontent') == '0')
			{
				//$this->beforecontent = '';
			}
			else
			{
				$this->beforecontent .= '<div>'.$linkfeed->return_links(intval(get_option('itex_m_linkfeed_links_beforecontent'))).'</div>';
			}

			if (get_option('itex_m_linkfeed_links_aftercontent') == '0')
			{
				//$this->aftercontent = '';
			}
			else
			{
				$this->aftercontent .= '<div>'.$linkfeed->return_links(intval(get_option('itex_m_linkfeed_links_aftercontent'))).'</div>';
			}
			//}
			$countsidebar = get_option('itex_m_linkfeed_links_sidebar');
			$check = get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
			if ($countsidebar == 'max')
			{
				//$this->sidebar = '<div>'.$this->linkfeed->return_links().'</div>';
			}
			elseif ($countsidebar == '0')
			{
				//$this->sidebar = '';
			}
			else
			{
				$this->sidebar_links .= '<div>'.$linkfeed->return_links(intval($countsidebar)).'</div>';
			}
			$this->sidebar_links = $check.$this->sidebar_links;

			$countfooter = get_option('itex_m_linkfeed_links_footer');
			$check = get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
			$this->footer .= $check;
			if ($countfooter == 'max')
			{
				//$this->footer = '<div>'.$this->linkfeed->return_links().'</div>';
			}
			elseif ($countfooter == '0')
			{
				//$this->footer = '';
			}
			else
			{
				$this->footer .= '<div>'.$linkfeed->return_links($countfooter).'</div>';
			}
			$this->footer = $check.$this->footer;

			if (($countsidebar == 'max') && ($countfooter == 'max')) $this->footer .= $linkfeed->return_links();
			else
			{
				if  ($countsidebar == 'max') $this->sidebar_links .= $linkfeed->return_links();
				else $this->footer .= $linkfeed->return_links();
			}

		}

		return 1;
	}

	/**
   	* setlinks init
   	* Author Zya
   	* 
   	* @return  bool
   	*/
	function itex_init_setlinks()
	{
		if (!get_option('itex_m_setlinks_enable')) return 0;
		if (!get_option('itex_m_setlinks_setlinksuser')) return 0;

		$this->itex_debug('SETLINKS_USER = '.get_option('itex_m_setlinks_setlinksuser'));
		//FOR MASS INSTALL ONLY, REPLACE if (0) ON if (1)
		//		if (0)
		//		{
		//			update_option('itex_setlinks_setlinksuser', 'abcdarfkwpkgfkhagklhskdgfhqakshgakhdgflhadh'); //setlinks uid
		//			update_option('itex_setlinkscontext_enable', 1);
		//			update_option('itex_setlinks_enable', 1);
		//			update_option('itex_setlinks_links_footer', 'max');
		//		}

		$file = $this->document_root . '/setlinks_' . get_option('itex_m_setlinks_setlinksuser') . '/slclient.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else return 0;

		if (get_option('itex_m_setlinks_enable'))
		{
			$this->setlinks = new SLClient();

			$this->setlinks->Config->encoding = get_option('blog_charset')?get_option('blog_charset'):'UTF-8';
			//$this->setlinks->Config->show_comment = (bool)get_option('itex_m_global_debugenable');
			$this->setlinks->Config->show_comment = true;
			$this->setlinks->Config->use_safe_method = (bool)get_option('itex_m_setlinks_masking');

			$this->itex_init_setlinks_links();

			///check it
			if (is_object($GLOBALS['wp_rewrite'])) $url = url_to_postid($_SERVER['REQUEST_URI']);
			else $url = 1;
			if (($url) || !get_option('itex_setlinks_pages_enable'))
			{
				if ((bool)get_option('itex_m_setlinks_links_beforecontent'))
				{
					$this->beforecontent .= '<div>'.$this->itex_init_sape_get_links(intval(get_option('itex_m_setlinks_links_beforecontent'))).'</div>';
				}

				if ((bool)get_option('itex_m_setlinks_links_aftercontent'))
				{
					$this->aftercontent .= '<div>'.$this->itex_init_sape_get_links(intval(get_option('itex_m_setlinks_links_aftercontent'))).'</div>';
				}
			}

			$countsidebar = get_option('itex_m_setlinks_links_sidebar');
			$check = get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
			if ($countsidebar == 'max')
			{
				//$this->sidebar = '<div>'.$this->setlinks->GetLinks().'</div>';
			}
			elseif ($countsidebar == '0')
			{
				//$this->sidebar = '';
			}
			else
			{
				$this->sidebar_links .= '<div>'.$this->itex_init_sape_get_links(intval($countsidebar)).'</div>';
			}
			$this->sidebar_links = $check.$this->sidebar_links;

			//setlinks footer
			$countfooter = get_option('itex_m_setlinks_setlinks_footer');
			$check = get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
			$this->footer .= $check;
			if ($countfooter == 'max')
			{
				//$this->footer = '<div>'.$this->sape->GetLinks().'</div>';
			} elseif ($countfooter == '0') {
				//$this->footer = '';
			} else {
				$this->footer .= '<div>'.$this->itex_init_sape_get_links($countfooter).'</div>';
			}
			$this->footer = $check.$this->footer;

			if (($countsidebar == 'max') && ($countfooter == 'max'))
			{
				$this->footer .= $this->itex_init_sape_get_links();
			} else {
				if ($countsidebar == 'max')
				{
					$this->sidebar_links .= $this->itex_init_sape_get_links();
				} else $this->footer .= $this->itex_init_sape_get_links();
			}
		}

		if (get_option('itex_m_setlinks_setlinkscontext_enable'))
		{
			$this->setlinkscontext = new SLClient();
			add_filter('the_content', array(&$this, 'itex_m_replace'));
			//add_filter('the_excerpt', array(&$this, 'itex_m_replace'));
		}
		return 1;
	}

	/**
   	* get setlinks links
   	* Author Zya
   	*
   	* @return  bool
   	*/
	function itex_init_setlinks_links()
	{
		$i = 1;

		while ($i++)
		{
			$q = $this->setlinks->GetLinks(1);
			if (empty($q) || !strlen($q))
			{
				break;
			}

			if (strlen($q)) $this->links['a_only'][] = $q;

			//!!!!!!!!!!check it, tk ne vozvrashaet pustuu stroku
			if ($i > 30) break;
		}
		$this->itex_debug('setlinks links:'.var_export($this->links, true));
		return 1;
	}

	/**
   	* Footer output
   	*
   	*/
	function itex_m_footer()
	{
		echo $this->footer;
		//		if (get_option('itex_m_php_enable') && get_option('itex_m_php_footer_enable'))
		//		{
		//			$code = get_option('itex_m_php_footer');
		//			if (strlen($code)>1) eval($code);
		//		}

		if (get_option('itex_m_global_debugenable'))
		{
			//echo 'is_user_logged_in'.intval(is_user_logged_in()).'_'.intval(get_option('itex_m_global_debugenable_forall'));//die();
			//echo 'reqweqweqweqweqwe';//die();
			if ((intval(is_user_logged_in())) || intval(get_option('itex_m_global_debugenable_forall')))
			{
				$this->debuglog = str_ireplace('<!--','<! --',$this->debuglog);
				$this->debuglog = str_ireplace('-->','-- >',$this->debuglog);
				echo '<!--- iMoneyDebugLogStart'.$this->debuglog.' iMoneyDebugLogEnd --->';
				echo '<!--- iMoneyDebugErrorsStart'.$this->error.' iMoneyDebugErrorsEnd --->';
			}
		}
	}

	/**
   	* Content links and before-after content links
   	*
   	* @param   string   $content   input text
   	* @return  string	$content   outpu text
   	*/
	function itex_m_replace($content)
	{

		//if (get_option('itex_m_sape_sapearticles_enable'))
		//{
		/*if (strpos($content, "<!-- SAPE_articles -->") !== FALSE)
		{
		//$content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
		$content = str_replace('<!-- SAPE_articles -->', SAPE_articles(), $content);

		}*/
		//		$content = $content.'<p>'.$this->sapearticles->return_announcements().'</p>';
		//		$this->itex_debug('sapearticles worked');
		//	}

		//sape context
		if (get_option('itex_m_sape_sapecontext_enable'))
		{
			if (url_to_postid($_SERVER['REQUEST_URI']) || !get_option('itex_sape_pages_enable'))
			{
				//if (defined('_SAPE_USER') || is_object($this->sapecontext))
				if (is_object($this->sapecontext))
				{
					$content = $this->sapecontext->replace_in_text_segment($content);
					if (get_option('itex_m_global_debugenable'))
					{
						$content = '<!---checkcontext_start-->'.$content.'<!---checkcontext_stop-->';
					}
					$this->itex_debug('sapecontext worked');
				}
				else $this->itex_debug('$this->sapecontext not object');
			}
			else $this->itex_debug('url_to_postid='.url_to_postid($_SERVER['REQUEST_URI']).' itex_sape_pages_enable='.get_option('itex_sape_pages_enable'));
		}
		else $this->itex_debug('sapecontext disabled');


		if ((strlen($this->beforecontent)) || (strlen($this->aftercontent)))
		{
			if (get_option('itex_m_global_debugenable'))
			{

				$content = '<!---check_beforecontent-->'.$this->beforecontent.$content.'<!---check_aftercontent-->'.$this->aftercontent;
			}
			else $content = $this->beforecontent.$content.$this->aftercontent;
			$this->beforecontent=$this->aftercontent='';
			$this->itex_debug('links in content worked');
		}
		else $this->itex_debug('beforecontent and aftercontent is empty');

		return $content;
	}

	/**
   	* 
   	*
   	* @param   string   $domnod   $text
   	* @return  string	$text
   	*/
	function itex_m_widget_init()
	{
		//$this->itex_debug('All possible Widgets '.var_export($this->sidebar, true));
		//		if (count($this->sidebar))
		//		{
		//			foreach ($this->sidebar as $k => $v)
		//			{
		//				if (function_exists('register_sidebar_widget'))
		//				{
		//					//register_sidebar_widget($k, array(&$this, 'itex_m_widget'));
		//					//$newfunc = create_function('$arg', 'extract($args, EXTR_SKIP);
		//		//echo $before_widget.$before_title . $title . $after_title.
		//		//"<ul><li>".$this->sidebar[$widget_name]."</li></ul>".$after_widget;
		//		//$this->itex_debug("!widget init ".$widget_name);');
		//					//register_sidebar_widget($k, $newfunc);
		//
		//				}
		//				if (function_exists('register_widget_control'))
		//				{
		//					//register_widget_control($k, array(&$this, 'itex_m_widget_control'), 300, 200 );
		//					//$newfunc = create_function('$arg', 'echo "<p>Dynamic widget control for '.$k.' </p>";');
		//					//register_widget_control($k, $newfunc, 300, 200 );
		//
		//				}
		//				$this->itex_debug('Widget '.$k.'= '.$v);
		//
		//			}itex_m_widget_dynamic_control
		//		}

		if (function_exists('register_sidebar_widget')) register_sidebar_widget('iMoney Dynamic', array(&$this, 'itex_m_widget_dynamic'));
		if (function_exists('register_widget_control')) register_widget_control('iMoney Dynamic', array(&$this, 'itex_m_widget_dynamic_control'), 300, 200 );

		if (function_exists('register_sidebar_widget')) register_sidebar_widget('iMoney Links', array(&$this, 'itex_m_widget_links'));
		if (function_exists('register_widget_control')) register_widget_control('iMoney Links', array(&$this, 'itex_m_widget_links_control'), 300, 200 );
		//$ws = wp_get_sidebars_widgets();
		//$this->itex_debug('All registered Widgets '.var_export($ws, true));

	}

	/**
   	* Dynamic widget
   	*
   	* @param   array   $args   arguments for widget
    */
	function itex_m_widget_dynamic($args)
	{
		extract($args, EXTR_SKIP);
		$this->itex_debug('All possible Widgets '.var_export($this->sidebar, true));
		$title = get_option("itex_m_widget_dynamic_title");
		//$title = empty($title) ? urlencode('<a href="http://itex.name" title="iMoney">iMoney</a>') :$title;

		if (count($this->sidebar))
		{
			foreach ($this->sidebar as $k => $v)
			{
				echo $before_widget.$before_title .  $title . $after_title.
				'<ul><li>'.$v.'</li></ul>'.$after_widget;
				$this->itex_debug('widget init '.$k);
			}
		}
	}

	/**
   	* Dynamic widget control
   	*
   	*/
	function itex_m_widget_dynamic_control()
	{
		echo '<p>Dynamic widget control for iMoney</p>';
		$title = get_option("itex_m_widget_dynamic_title");
		//$itex = array('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>','<a href="http://itex.name/" title="itex">itex</a>');

		//		$title_links = get_option("itex_m_widget_links_title");
		//		if ((!eregi('itex.name',$title_links)) || empty($title_links)) $itex = array('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>','<a href="http://itex.name/" title="itex">itex</a>');
		//		else $itex = array('','');
		//$title = empty($title) ? $itex[rand(0,count($itex)-1)] :$title;
		if ($_POST['itex_m_widget_dynamic_Submit'])
		{
			//$title = htmlspecialchars($_POST['itex_m_widget_title']);
			$title = stripslashes($_POST['itex_m_widget_dynamic_title']);
			update_option("itex_m_widget_dynamic_title", $title);
		}
		echo '
  			<p>
    			<label for="itex_m_widget_dynamic">'.__('Widget Title: ', 'iMoney').'</label>
    			<textarea name="itex_m_widget_dynamic_title" id="itex_m_widget_dynamic" rows="1" cols="20">'.$title.'</textarea>
    			<input type="hidden" id="" name="itex_m_widget_dynamic_Submit" value="1" />
  			</p>';
	}

	/**
   	* Dynamic widget
   	*
   	* @param   array   $args   arguments for widget
    */
	function itex_m_widget($args)
	{
		extract($args, EXTR_SKIP);
		echo $before_widget.$before_title . $title . $after_title.
		'<ul><li>'.$this->sidebar[$widget_name].'</li></ul>'.$after_widget;
		$this->itex_debug('!widget init '.$widget_name);
	}

	/**
   	* Dynamic widget control
   	*
   	*/
	function itex_m_widget_control()
	{
		echo '<p>Dynamic widget control for iMoney</p>';
	}
	/**
   	* Links widget
   	*
   	* @param   array   $args   arguments for widget
    */
	function itex_m_widget_links($args)
	{
		extract($args, EXTR_SKIP);
		$title = get_option("itex_m_widget_links_title");
		//$title = empty($title) ? urlencode('<a href="http://itex.name" title="iMoney">iMoney</a>') :$title;
		$itex = array('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>','<a href="http://itex.name/" title="itex">itex</a>');
		if (empty($title))
		{
			$title = $itex[rand(0,count($itex)-1)];
			update_option("itex_m_widget_links_title", $title);
		}

		if (strlen($this->sidebar_links) >23) echo $before_widget.$before_title . $title . $after_title.
		'<ul><li>'.$this->sidebar_links.'</li></ul>'.$after_widget;
	}

	/**
   	*  Links widget control
   	*
   	* @param   string   $domnod   $text
   	*/
	function itex_m_widget_links_control()
	{
		$title = get_option("itex_m_widget_links_title");
		$itex = array('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>','<a href="http://itex.name/" title="itex">itex</a>');
		$title = empty($title) ? $itex[rand(0,count($itex)-1)] :$title;
		if ($_POST['itex_m_widget_links_Submit'])
		{
			//$title = htmlspecialchars($_POST['itex_m_widget_title']);
			$title = stripslashes($_POST['itex_m_widget_links_title']);
			update_option("itex_m_widget_links_title", $title);
		}
		echo '
  			<p>
    			<label for="itex_m_widget_links">'.__('Widget Title: ', 'iMoney').'</label>
    			<textarea name="itex_m_widget_links_title" id="itex_m_widget_links" rows="1" cols="20">'.$title.'</textarea>
    			<input type="hidden" id="" name="itex_m_widget_links_Submit" value="1" />
  			</p>';
		//print_r($this->debuglog);//die();
	}

	/**
   	* Add admin menu to options
   	*
   	* @param   string   $domnod   $text
   	* @return  string	$text
   	*/
	function itex_m_menu()
	{
		if (is_admin()) add_options_page('iMoney', 'iMoney', 10, basename(__FILE__), array(&$this, 'itex_m_admin'));
	}

	/**
   	* Admin menu
   	*
   	*/
	function itex_m_admin()
	{
		if (!is_admin()) return 0;
		$this->lang_ru();
		$this->itex_m_admin_css();
		// Output the options page
		?>
		<div class="wrap">
		
			<form method="post">
			<h2><?php echo __('iMoney Options', 'iMoney');?></h2>
			<?php 
			if ( '09_May' == date('d_F')) $this->itex_m_admin_9_may(); 
			if ( '30_December' == date('d_F') || '31_December' == date('d_F') || '01_January' == date('d_F') || '02_January' == date('d_F') || '03_January' == date('d_F')   )  $this->itex_m_admin_new_year();
			?>
			
			<?php
			if (strlen($this->error))
			{
				echo '
				<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
					'.$this->error.'
				</div>';

			}
			if (isset($_POST['info_update']))
			{
				echo '<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				<a href="http://itex.name/go.php?http://itex.name/donation">'.__('Create and maintain a plugin take lot\'s of time. If you enjoy this plugin, do a Donation.', 'iMoney').'</div>';
			}

			?>		
			
			
			
			                       
       			<!-- Main -->
        		
        			<?php 
        			?>
        		<ul style="text-align: center;font-weight: bold;font-size: 14px;">
        			<li style="display: inline;"><a href="#itex_global" onclick='document.getElementById("itex_global").style.display="";'>Global</a></li>
        			<li style="display: inline;"><a href="#itex_adsense" onclick='document.getElementById("itex_adsense").style.display="";'>Adsense</a></li>
        			<li style="display: inline;"><a href="#itex_html" onclick='document.getElementById("itex_html").style.display="";'>Html</a></li>
        			<li style="display: inline;"><a href="#itex_php" onclick='document.getElementById("itex_php").style.display="";'>Php</a></li>
        			<li style="display: inline;"><a href="#itex_sape" onclick='document.getElementById("itex_sape").style.display="";'>Sape</a></li>
        			<li style="display: inline;"><a href="#itex_tnx" onclick='document.getElementById("itex_tnx").style.display="";'>Tnx/Xap</a></li>
        			<li style="display: inline;"><a href="#itex_begun" onclick='document.getElementById("itex_begun").style.display="";'>Begun</a></li>
        			<li style="display: inline;"><a href="#itex_mainlink" onclick='document.getElementById("itex_mainlink").style.display="";'>MainLink</a></li>
        			<li style="display: inline;"><a href="#itex_ilinks" onclick='document.getElementById("itex_ilinks").style.display="";'>iLinks</a></li>
        			<li style="display: inline;"><a href="#itex_linkfeed" onclick='document.getElementById("itex_linkfeed").style.display="";'>Linkfeed</a></li>
        			<li style="display: inline;"><a href="#itex_adskape" onclick='document.getElementById("itex_adskape").style.display="";'>Adskape</a></li>
        			<li style="display: inline;"><a href="#itex_setlinks" onclick='document.getElementById("itex_setlinks").style.display="";'>SetLinks</a></li>
        			<li style="display: inline;"><a href="#itex_teasernet" onclick='document.getElementById("itex_teasernet").style.display="";'>Teasernet</a></li>
        			<li style="display: inline;"><a href="#itex_trustlink" onclick='document.getElementById("itex_trustlink").style.display="";'>Trustlink</a></li>
        
        				
        		</ul>
        		<p class="submit">
				<input type='submit' name='info_update' value='<?php echo __('Save Changes', 'iMoney'); ?>' />
				</p>
				
        		<h3><a href="#itex_global" name="itex_global" onclick='document.getElementById("itex_global").style.display="";'>Global</a></h3>
       	 		<div id="itex_global"><?php $this->itex_m_admin_global(); ?></div>
        		<h3><a href="#itex_adsense" name="itex_adsense" onclick='document.getElementById("itex_adsense").style.display="";'>Adsense</a></h3>
       	 		<div id="itex_adsense" ><?php $this->itex_m_admin_adsense(); ?></div>
       	 		<h3><a href="#itex_begun" name="itex_begun" onclick='document.getElementById("itex_begun").style.display="";'>Begun</a></h3>
       	 		<div id="itex_begun"><?php $this->itex_m_admin_begun(); ?></div>
       	 		<h3><a href="#itex_adskape" name="itex_adskape" onclick='document.getElementById("itex_adskape").style.display="";'>Adskape</a></h3>
       	 		<div id="itex_adskape"><?php $this->itex_m_admin_adskape(); ?></div>
       	 		<h3><a href="#itex_html" name="itex_html" onclick='document.getElementById("itex_html").style.display="";'>Html</a></h3>
       	 		<div id="itex_html"><?php $this->itex_m_admin_html(); ?></div>
       	 		<h3><a href="#itex_php" name="itex_php" onclick='document.getElementById("itex_php").style.display="";'>Php</a></h3>
       	 		<div id="itex_php"><?php $this->itex_m_admin_php(); ?></div>
       	 		
       	 		<h3><a href="#itex_sape" name="itex_sape" onclick='document.getElementById("itex_sape").style.display="";'>Sape</a></h3>
       	 		<div id="itex_sape"><?php $this->itex_m_admin_sape(); ?></div>
       	 		
       	 		<h3><a href="#itex_trustlink" name="itex_trustlink" onclick='document.getElementById("itex_trustlink").style.display="";'>Trustlink</a></h3>
       	 		<div id="itex_trustlink"><?php $this->itex_m_admin_trustlink(); ?></div>
       	 		
       	 		<h3><a href="#itex_tnx" name="itex_tnx" onclick='document.getElementById("itex_tnx").style.display="";'>Tnx/Xap</a></h3>
       	 		<div id="itex_tnx"><?php $this->itex_m_admin_tnx(); ?></div>
       	 		<h3><a href="#itex_mainlink" name="itex_mainlink" onclick='document.getElementById("itex_mainlink").style.display="";'>MainLink</a></h3>
       	 		<div id="itex_mainlink"><?php $this->itex_m_admin_mainlink(); ?></div>
       	 		<h3><a href="#itex_ilinks" name="itex_ilinks" onclick='document.getElementById("itex_ilinks").style.display="";'>iLinks</a></h3>
       	 		<div id="itex_ilinks"><?php $this->itex_m_admin_ilinks(); ?></div>
       	 		<h3><a href="#itex_linkfeed" name="itex_linkfeed" onclick='document.getElementById("itex_linkfeed").style.display="";'>Linkfeed</a></h3>
       	 		<div id="itex_linkfeed"><?php $this->itex_m_admin_linkfeed(); ?></div>
       	 		<h3><a href="#itex_setlinks" name="itex_setlinks" onclick='document.getElementById("itex_setlinks").style.display="";'>SetLinks</a></h3>
       	 		<div id="itex_setlinks"><?php $this->itex_m_admin_setlinks(); ?></div>
       	 		<h3><a href="#itex_teasernet" name="itex_teasernet" onclick='document.getElementById("itex_teasernet").style.display="";'>Teasernet</a></h3>
       	 		<div id="itex_teasernet"><?php $this->itex_m_admin_teasernet(); ?></div>
       	 		<?php 
       	 		if(!get_option('itex_m_global_collapse')){ ?>
       	 		<script type="text/javascript">
       	 		document.getElementById("itex_adsense").style.display="none";
       	 		document.getElementById("itex_html").style.display="none";
       	 		document.getElementById("itex_php").style.display="none";
       	 		document.getElementById("itex_sape").style.display="none";
       	 		document.getElementById("itex_tnx").style.display="none";
       	 		document.getElementById("itex_begun").style.display="none";
       	 		document.getElementById("itex_mainlink").style.display="none";
       	 		document.getElementById("itex_ilinks").style.display="none";
       	 		document.getElementById("itex_linkfeed").style.display="none";
       	 		document.getElementById("itex_adskape").style.display="none";
       	 		document.getElementById("itex_setlinks").style.display="none";
       	 		document.getElementById("itex_teasernet").style.display="none";
       	 		document.getElementById("itex_trustlink").style.display="none";
       	 		document.getElementById("itex_global").style.display="none";
       	 		</script>	
       	 		<?php } ?>
			</div>
			
			<p class="submit">
				<input type='submit' name='info_update' value='<?php echo __('Save Changes', 'iMoney'); ?>' />
			</p>
			
			<ul style="text-align: center;font-weight: bold;font-size: 14px;">
        			<li style="display: inline;"><a href="#itex_global" onclick='document.getElementById("itex_global").style.display="";'>Global</a></li>
        			<li style="display: inline;"><a href="#itex_adsense" onclick='document.getElementById("itex_adsense").style.display="";'>Adsense</a></li>
        			<li style="display: inline;"><a href="#itex_html" onclick='document.getElementById("itex_html").style.display="";'>Html</a></li>
        			<li style="display: inline;"><a href="#itex_php" onclick='document.getElementById("itex_php").style.display="";'>Php</a></li>
        			<li style="display: inline;"><a href="#itex_sape" onclick='document.getElementById("itex_sape").style.display="";'>Sape</a></li>
        			<li style="display: inline;"><a href="#itex_tnx" onclick='document.getElementById("itex_tnx").style.display="";'>Tnx/Xap</a></li>
        			<li style="display: inline;"><a href="#itex_begun" onclick='document.getElementById("itex_begun").style.display="";'>Begun</a></li>
        			<li style="display: inline;"><a href="#itex_mainlink" onclick='document.getElementById("itex_mainlink").style.display="";'>MainLink</a></li>
        			<li style="display: inline;"><a href="#itex_ilinks" onclick='document.getElementById("itex_ilinks").style.display="";'>iLinks</a></li>
        			<li style="display: inline;"><a href="#itex_linkfeed" onclick='document.getElementById("itex_linkfeed").style.display="";'>Linkfeed</a></li>
        			<li style="display: inline;"><a href="#itex_adskape" onclick='document.getElementById("itex_adskape").style.display="";'>Adskape</a></li>
        			<li style="display: inline;"><a href="#itex_setlinks" onclick='document.getElementById("itex_setlinks").style.display="";'>SetLinks</a></li>
        			<li style="display: inline;"><a href="#itex_teasernet" onclick='document.getElementById("itex_teasernet").style.display="";'>Teasernet</a></li>
        			<li style="display: inline;"><a href="#itex_trustlink" onclick='document.getElementById("itex_trustlink").style.display="";'>Trustlink</a></li>
        
        	</ul>
        	<p align="center">
        		<a href="http://itex.name/plugins/faq-po-imoney-i-isape.html">FAQ по iMoney и iSape</a>
			</p>	
			<p align="center">
				<?php echo __("Powered by ",'iMoney')."<a href='http://itex.name' title='iTex iMoney'>iTex iMoney</a> ".__("Version:",'iMoney').$this->version; ?>
			</p>				
			</form>
		
		</div>
		<?php
	}

	/**
   	* Css fo admin menu
   	*
   	*/
	function itex_m_admin_css()
	{
		?>
		<style type='text/css'>
			#edit_tabs li {            
				list-style-type: none;
				float: left;       
				margin: 2px 5px 0 0;           
				padding-left: 15px;  
				text-align: center;
			}                        

			#edit_tabs li a {           
				display: block;                            
				font-size: 85%;                               
				font-family: "Lucida Grande", "Verdana";
				font-weight: bold;                          
				float: left;                                       
				color: #999;
				border-bottom: none;
				padding: 2px 15px 2px 0;	
				width: auto !important;
				width: 50px;        
				min-width: 50px;                                                     
				text-shadow: white 0 1px 0;  
			}               

			#edit_sections .section {
				background: url('images/bg_tab_section.gif') no-repeat top left;
				padding-left: 10px;
				padding-top: 15px;
				height: auto !important;
				height: 200px;       
				min-height: 200px;
				display: none;
			}              

			#edit_sections .section ul {
				padding-left: 10px;
				width: 500px;
			}

			#edit_sections .current {
				display: block;
			}                   

			#edit_sections .section .section_warn {
				background: #FFFFE0;
				border: 1px solid #EBEBA9;
				padding: 8px;
				float: right;
				width: 300px;
				font-size: 11px;
			}       
		</style>
		<?php
	}

	/**
   	* Global section admin menu
   	*
   	*/
	function itex_m_admin_global()
	{
		if (isset($_POST['info_update']))
		{

			if (isset($_POST['global_debugenable']))
			{
				update_option('itex_m_global_debugenable', intval($_POST['global_debugenable']));
			}

			if (isset($_POST['global_debugenable_forall']))
			{
				update_option('itex_m_global_debugenable_forall', intval($_POST['global_debugenable_forall']));
			}

			if (isset($_POST['global_masking']))
			{
				update_option('itex_m_global_masking', intval($_POST['global_masking']));
			}

			if (isset($_POST['global_collapse']))
			{
				update_option('itex_m_global_collapse', !intval($_POST['global_collapse']));
			}

			if ((isset($_POST['global_widget_links'])) || (isset($_POST['global_widget_dynamic'])))
			{
				$s_w = wp_get_sidebars_widgets();
				$ex = 0;
				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				{
					if ($v == 'imoney-links')
					{
						$ex = 1;
						if (!$_POST['global_widget_links']) unset($s_w['sidebar-1'][$k]);
					}
				}
				if (!$ex && $_POST['global_widget_links']) $s_w['sidebar-1'][] = 'imoney-links';
				$ex = 0;
				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				{
					if ($v == 'imoney-dynamic')
					{
						$ex = 1;
						if (!$_POST['global_widget_dynamic']) unset($s_w['sidebar-1'][$k]);
					}
				}
				if (!$ex && $_POST['global_widget_dynamic']) $s_w['sidebar-1'][] = 'imoney-dynamic';
				wp_set_sidebars_widgets( $s_w );
			}


			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}

		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Masking of links', 'iMoney'); ?>:</label>
					</th>
					<td>
						<?php
						echo "<select name='global_masking' id='global_masking'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_global_masking')) echo " selected='selected'";
						echo __(">Enabled</option>\n", 'iSape');

						echo "<option value='0'";
						if(!get_option('itex_m_global_masking')) echo" selected='selected'";
						echo __(">Disabled</option>\n", 'iSape');
						echo "</select>\n";

						echo '<label for="">'.__('Masking of links', 'iMoney').'.</label>';

						?>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Global debug:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						echo "<select name='global_debugenable' id='global_debugenable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_global_debugenable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_global_debugenable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Debug log in footer. For see debug user must register', 'iMoney').'.</label>';

						echo "<br/>";

						echo "<select name='global_debugenable_forall' id='global_debugenable_forall'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_global_debugenable_forall')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_global_debugenable_forall')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Debug log in footer for all, who open the site. Dont leave this parameter switched Enabled for a long time, because in this case it will disclose your private data like SAPE UID', 'iMoney').'.</label>';

						?>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Widgets settings:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						$ws = wp_get_sidebars_widgets();


						echo "<select name='global_widget_links' id='global_widget_links'>\n";
						echo "<option value='0'";
						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						echo ">".__('Active','iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Widget Links Active', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='global_widget_dynamic' id='global_widget_dynamic'>\n";
						echo "<option value='0'";
						if (count($ws['sidebar-1'])) if(!in_array('imoney-dynamic',$ws['sidebar-1'])) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if (count($ws['sidebar-1'])) if (in_array('imoney-dynamic',$ws['sidebar-1'])) echo " selected='selected'";
						echo ">".__('Active','iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Widget Dynamic Active', 'iMoney').'</label>';

						?>
					</td>
				</tr>
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Collapse headlines settings:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						echo "<select name='global_collapse' id='global_collapse'>\n";
						echo "<option value='1'";

						if(!get_option('itex_m_global_collapse')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(get_option('itex_m_global_collapse')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";


						?>
					</td>
				</tr>
				
			</table>
			<?php
	}

	/**
   	* 9 may section admin menu
   	*
   	*/
	function itex_m_admin_9_may()
	{
		if ( '09_May' == date('d_F'))
		echo '<center><h1><a href="http://itex.name/plugins/s-dnem-pobedy.html">С Праздником Победы!</a></h1><p><object width="640" height="505"><param name="movie" value="http://www.youtube-nocookie.com/v/TQrINrPzgmw&hl=ru_RU&fs=1&rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube-nocookie.com/v/TQrINrPzgmw&hl=ru_RU&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="505"></embed></object></p></center>';

	}
	
	/**
   	* New Year section admin menu
   	*
   	*/
	function itex_m_admin_new_year()
	{
		if ( '30_December' == date('d_F') || '31_December' == date('d_F') || '01_January' == date('d_F') || '02_January' == date('d_F') || '03_January' == date('d_F')   )  
		echo '<center><h1><a href="http://itex.name/plugins/s-novym-godom.html">С Новым Годом!</a></h1><p><object width="640" height="505"><param name="movie" value="http://www.youtube-nocookie.com/v/dcLMH8pwusw&hl=ru_RU&fs=1&rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube-nocookie.com/v/dcLMH8pwusw&hl=ru_RU&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="505"></embed></object></p></center>';

	}

	/**
   	* Sape section admin menu
   	*
   	*/
	function itex_m_admin_sape()
	{
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['sape_sapeuser']))
			{
				update_option('itex_m_sape_sapeuser', trim($_POST['sape_sapeuser']));
			}
			if (isset($_POST['sape_enable']))
			{
				update_option('itex_m_sape_enable', intval($_POST['sape_enable']));
			}

			if (isset($_POST['sape_links_beforecontent']))
			{
				update_option('itex_m_sape_links_beforecontent', $_POST['sape_links_beforecontent']);
			}

			if (isset($_POST['sape_links_aftercontent']))
			{
				update_option('itex_m_sape_links_aftercontent', $_POST['sape_links_aftercontent']);
			}

			if (isset($_POST['sape_links_sidebar']))
			{
				update_option('itex_m_sape_links_sidebar', $_POST['sape_links_sidebar']);
			}

			if (isset($_POST['sape_links_footer']))
			{
				update_option('itex_m_sape_links_footer', $_POST['sape_links_footer']);
			}

			

			if (isset($_POST['sape_sapecontext_enable']) )
			{
				update_option('itex_m_sape_sapecontext_enable', intval($_POST['sape_sapecontext_enable']));
			}

			if (isset($_POST['sape_sapecontext_pages_enable']) )
			{
				update_option('itex_m_sape_sapecontext_pages_enable', intval($_POST['sape_sapecontext_pages_enable']));
			}

			if (isset($_POST['sape_pages_enable']) )
			{
				update_option('itex_m_sape_pages_enable', intval($_POST['sape_pages_enable']));
			}


			if (isset($_POST['itex_m_sape_sapearticles_enable']) )
			{
				update_option('itex_m_sape_sapearticles_enable', intval($_POST['itex_m_sape_sapearticles_enable']));
			}
			if (isset($_POST['itex_m_sape_sapearticles_template_url']) )
			{
				update_option('itex_m_sape_sapearticles_template_url', $_POST['itex_m_sape_sapearticles_template_url']);
			}
			if (isset($_POST['itex_m_sape_sapearticles_beforecontent']))
			{
				update_option('itex_m_sape_sapearticles_beforecontent', $_POST['itex_m_sape_sapearticles_beforecontent']);
			}

			if (isset($_POST['itex_m_sape_sapearticles_aftercontent']))
			{
				update_option('itex_m_sape_sapearticles_aftercontent', $_POST['itex_m_sape_sapearticles_aftercontent']);
			}

			if (isset($_POST['itex_m_sape_sapearticles_sidebar']))
			{
				update_option('itex_m_sape_sapearticles_sidebar', $_POST['itex_m_sape_sapearticles_sidebar']);
			}

			if (isset($_POST['itex_m_sape_sapearticles_footer']))
			{
				update_option('itex_m_sape_sapearticles_footer', $_POST['itex_m_sape_sapearticles_footer']);
			}
			if (isset($_POST['itex_m_sape_sapearticles_pages_enable']) )
			{
				update_option('itex_m_sape_sapearticles_pages_enable', intval($_POST['itex_m_sape_sapearticles_pages_enable']));
			}
			//			if ((isset($_POST['sape_widget'])) || (isset($_POST['itex_m_sape_visual_widget'])))
			//			{
			//				$s_w = wp_get_sidebars_widgets();
			//				$ex = 0;
			//				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
			//				{
			//					if ($v == 'imoney-links')
			//					{
			//						$ex = 1;
			//						if (!$_POST['sape_widget']) unset($s_w['sidebar-1'][$k]);
			//					}
			//				}
			//				if (!$ex && $_POST['sape_widget']) $s_w['sidebar-1'][] = 'imoney-links';
			//				wp_set_sidebars_widgets( $s_w );
			//
			//			}
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		if (isset($_POST['sape_sapedir_create']))
		{
			if (get_option('itex_m_sape_sapeuser'))  $this->itex_m_sape_install_file();
		}
		if (get_option('itex_m_sape_sapeuser'))
		{
			$file = $this->document_root . '/' . _SAPE_USER . '/sape.php'; //<< Not working in multihosting.
			if (file_exists($file)) {}
			else
			{
				$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.get_option('itex_m_sape_sapeuser').'/sape.php';
				if (file_exists($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				Sape dir not exist!
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				Create new sapedir and sape.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='sape_sapedir_create' value='<?php echo __('Create', 'iMoney'); ?>' />
				</p>
				<?php
				if (!get_option('itex_m_sape_sapeuser')) echo __('Enter your SAPE UID in this box!', 'iMoney');
				?>
		</div>
		
		<?php }
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your SAPE UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='sape_sapeuser'";
						echo "id='sapeuser' ";
						echo "value='".get_option('itex_m_sape_sapeuser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your SAPE UID in this box.', 'iMoney');?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Sape links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='sape_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_sape_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='sape_links_beforecontent' id='sape_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_links_beforecontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_sape_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_sape_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_sape_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_sape_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_sape_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='sape_links_aftercontent' id='sape_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_links_aftercontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_sape_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_sape_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_sape_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_sape_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_sape_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='sape_links_sidebar' id='sape_links_sidebar'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_links_sidebar')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_sape_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_sape_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_sape_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_sape_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_sape_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_sape_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='sape_links_footer' id='sape_links_footer'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_sape_links_footer')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_sape_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_sape_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_sape_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_sape_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_sape_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_sape_links_footer') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Footer links', 'iMoney').'</label>';

						echo "<br/>\n";
						echo "<select name='sape_pages_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_sape_pages_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_pages_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";
						?>
					</td>
					
					
				</tr>
				<?php 
				?>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Sape context:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						echo "<select name='sape_sapecontext_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_sape_sapecontext_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_sapecontext_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Context', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='sape_sapecontext_pages_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_sape_sapecontext_pages_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_sapecontext_pages_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Show context only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><a href="http://articles.sape.ru/r.a5a429f57e.php"><?php echo __('Sape articles:', 'iMoney'); ?></a></label>
					</th>
					<td>
						<?php
						echo "<select name='itex_m_sape_sapearticles_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_sape_sapearticles_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_sapearticles_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for=""><a href="http://articles.sape.ru/r.a5a429f57e.php">'.__('Articles', 'iMoney').'</a></label>';

						echo "<br/>\n";

						echo "<input type='text' size='100' ";
						echo "name='itex_m_sape_sapearticles_template_url'";
						echo "value='".get_option('itex_m_sape_sapearticles_template_url')."' />\n";
						echo '<label for="">'.__('Sapearticles moderation url', 'iMoney').'</label>';
						echo "<br/>\n";



						echo "<select name='itex_m_sape_sapearticles_beforecontent' id='itex_m_sape_sapearticles_beforecontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_sapearticles_beforecontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_sape_sapearticles_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_sape_sapearticles_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_sape_sapearticles_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_sape_sapearticles_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_sape_sapearticles_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='itex_m_sape_sapearticles_aftercontent' id='itex_m_sape_sapearticles_aftercontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_sapearticles_aftercontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_sape_sapearticles_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_sape_sapearticles_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_sape_sapearticles_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_sape_sapearticles_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_sape_sapearticles_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='itex_m_sape_sapearticles_sidebar' id='itex_m_sape_sapearticles_sidebar'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_sapearticles_sidebar')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_sape_sapearticles_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_sape_sapearticles_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_sape_sapearticles_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_sape_sapearticles_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_sape_sapearticles_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_sape_sapearticles_sidebar') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='itex_m_sape_sapearticles_footer' id='itex_m_sape_sapearticles_footer'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_sape_sapearticles_footer')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_sape_sapearticles_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_sape_sapearticles_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_sape_sapearticles_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_sape_sapearticles_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_sape_sapearticles_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_sape_sapearticles_footer') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Footer links', 'iMoney').'</label>';

						echo "<br/>\n";
						echo "<select name='itex_m_sape_sapearticles_pages_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_sape_sapearticles_pages_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_sapearticles_pages_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";

						//если есть сапеуид, то выводим примерный урл
						if (get_option('itex_m_sape_sapeuser'))
						{
							echo '<label for="">'.__('Sapearticles url template  ', 'iMoney').'</label>';
							echo "<br/>\n";
							echo '<label for=""><a href="/itex_sape_articles_template.'.get_option('itex_m_sape_sapeuser').'.html">/itex_sape_articles_template.'.get_option('itex_m_sape_sapeuser').'.html</a></label>';
							echo "<br/>\n";
						}

						?>
					</td>
				</tr>
				
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" href="http://itex.name/go.php?http://www.sape.ru/r.a5a429f57e.php"><img src="http://img.sape.ru/bn/sape_001.gif" alt="www.sape.ru!" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php
	}

	/**
   	* Sape file installation
   	*
   	* @return  bool
   	*/
	function itex_m_sape_install_file()
	{
		//file sape.php from sape.ru (v1.0.8 02.09.2010) 27.12.2010
		$sape_php_content = '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';
		$sape_php_content = gzuncompress(base64_decode($sape_php_content));
		$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.get_option('itex_m_sape_sapeuser').'/sape.php';

		$dir = dirname($file);
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create Sape dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$sape_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create sape.php!', 'iMoney').'
		</div>';
			return 0;
		}
		//chmod($file, 0777);
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.__('Sapedir and sape.php created!', 'iMoney').'
		</div>';
		//die();
		return 1;
	}

	/**
   	* Trustlink section admin menu
   	*
   	*/
	function itex_m_admin_trustlink()
	{
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['itex_m_trustlink_user']))
			{
				update_option('itex_m_trustlink_user', trim($_POST['itex_m_trustlink_user']));
			}
			if (isset($_POST['itex_m_trustlink_enable']))
			{
				update_option('itex_m_trustlink_enable', intval($_POST['itex_m_trustlink_enable']));
			}

			if (isset($_POST['itex_m_trustlink_links_beforecontent']))
			{
				update_option('itex_m_trustlink_links_beforecontent', $_POST['itex_m_trustlink_links_beforecontent']);
			}

			if (isset($_POST['itex_m_trustlink_links_aftercontent']))
			{
				update_option('itex_m_trustlink_links_aftercontent', $_POST['itex_m_trustlink_links_aftercontent']);
			}

			if (isset($_POST['itex_m_trustlink_links_sidebar']))
			{
				update_option('itex_m_trustlink_links_sidebar', $_POST['itex_m_trustlink_links_sidebar']);
			}

			if (isset($_POST['itex_m_trustlink_links_footer']))
			{
				update_option('itex_m_trustlink_links_footer', $_POST['itex_m_trustlink_links_footer']);
			}
			if (isset($_POST['itex_m_trustlink_pages_enable']) )
			{
				update_option('itex_m_trustlink_pages_enable', intval($_POST['itex_m_trustlink_pages_enable']));
			}

			
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		if (isset($_POST['itex_m_trustlink_dir_create']))
		{
			if (get_option('itex_m_trustlink_user'))  $this->itex_m_trustlink_install_file();
		}
		if (get_option('itex_m_trustlink_user'))
		{
			$file = $this->document_root . '/' . get_option('itex_m_trustlink_user') . '/trustlink.php'; //<< Not working in multihosting.
			if (file_exists($file)) {}
			else
			{
				$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.get_option('itex_m_trustlink_user').'/trustlink.php';
				if (file_exists($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				Trustlink <?php echo __('dir not exist!', 'iMoney');?> 
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				<?php echo __('Create new dir and', 'iMoney');?> trustlink.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='itex_m_trustlink_dir_create' value='<?php echo __('Create', 'iMoney'); ?>' />
				</p>
				<?php
				if (!get_option('itex_m_trustlink_sapeuser')) echo __('Enter your Trustlink UID in this box!', 'iMoney');
				?>
		</div>
		
		<?php }
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your Trustlink UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='itex_m_trustlink_user'";
						echo "id='user' ";
						echo "value='".get_option('itex_m_trustlink_user')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your Trustlink UID in this box.', 'iMoney');?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Trustlink links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='itex_m_trustlink_enable' id='itex_m_trustlink_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_trustlink_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_trustlink_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='itex_m_trustlink_links_beforecontent' id='itex_m_trustlink_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_trustlink_links_beforecontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_trustlink_links_beforecontent') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='itex_m_trustlink_links_aftercontent' id='itex_m_trustlink_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_trustlink_links_aftercontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_trustlink_links_aftercontent') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='itex_m_trustlink_links_sidebar' id='itex_m_trustlink_links_sidebar'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_trustlink_links_sidebar')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_trustlink_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='itex_m_trustlink_links_footer' id='itex_m_trustlink_links_footer'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_trustlink_links_footer')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_trustlink_links_footer') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Footer links', 'iMoney').'</label>';

						echo "<br/>\n";
						echo "<select name='itex_m_trustlink_pages_enable' id='trustlink_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_trustlink_pages_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_trustlink_pages_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";
						?>
					</td>
					
					
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="600" height="90"><param name="movie" value="http://trustlink.ru/banners/secretar_600x90.swf"/><param name="bgcolor" value="#FFFFFF"/><param name="quality" value="high"><param name="allowScriptAccess" value="Always"><param name="FlashVars" value="refLink=http://itex.name/go.php?http://trustlink.ru/registration/106535"><embed type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" width="600" height="90" src="http://trustlink.ru/banners/secretar_600x90.swf" bgcolor="#FFFFFF" quality="high" allowScriptAccess="Always" flashvars="refLink=http://itex.name/go.php?http://trustlink.ru/registration/106535" /></object>
						<br/>
						<a target="_blank" href="http://itex.name/go.php?http://trustlink.ru/registration/106535">www.trustlink.ru</a>
					</td>
				</tr>
			</table>
			<?php
			//<a target="_blank" href="http://itex.name/go.php?http://trustlink.ru/registration/106535"><img src="http://trustlink.ru/banners/secretar_600x90.swf" alt="www.trustlink.ru!" border="0" /></a>
			
	}

	/**
   	* Trustlink file installation
   	*
   	* @return  bool
   	*/
	function itex_m_trustlink_install_file()
	{
		//file trustlink.php from trustlink.ru vT0.4.3 26.12.2010
		$file_php_content = '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';
		$file_php_content = gzuncompress(base64_decode($file_php_content));
		$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.get_option('itex_m_trustlink_user').'/trustlink.php';

		$dir = dirname($file);
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create Trustlink dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$file_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create', 'iMoney').'trustlink.php!
		</div>';
			return 0;
		}
		
		
		//file template.tpl.html from trustlink.ru 26.12.2010
		$file_php_content = 'eNqlk9tygjAQhu99ihSvlYgHKqa8S05AxjXJkDDaMr57Q9SOOL1oh+WGZH/+/chuiPOfIMsZCtHBkstMriuc70UmtpjnAmfvdCfyDRc5xzJj+X5N15tq1TPKj3VrOi0W3IBpCzSvYqA3dbKm9VT7A2KmFTLkVvaCnAEl0Fzi+IxkZyV8U6AM46B7TlgqhNJ1gfBo+0TbWumX3eu/fwKB6kE5v4iHUCBttPy9/PaFy8uLX1BQdYAAWfmJHHbZSCr6yujAor4CympjL4eJrrR/dAaH4Hwq5Igvm85nkTtRgBElxpNN2ZPhbofxAUXus1R144cmt6FqsCbpffZJB4gDde4j+XOdJHzWMzD8eL1dHgLq9hIX9mE49DUpSRgzHZQktc+iksQDCOlhnob0ff0qY0HSGBclrEQ/eZIOVUmfPkhI2kE5+wZPOSsu';
		$file_php_content = gzuncompress(base64_decode($file_php_content));
		
		$file = $dir.DIRECTORY_SEPARATOR.'template.tpl.html';
		if (!file_put_contents($file,$file_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create', 'iMoney').'template.tpl.html !
		</div>';
			return 0;
		}
		
		
		//chmod($file, 0777);
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.__('Trustlink dir and trustlink.php created!', 'iMoney').'
		</div>';
		//die();
		return 1;
	}

	/**
   	* Adsens section admin menu
   	*
   	*/
	function itex_m_admin_adsense()
	{
		$maxblock = 4; //max  adsense blocks - 1
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['adsense_id']))
			{
				update_option('itex_m_adsense_id', trim($_POST['adsense_id']));
			}
			if (isset($_POST['adsense_enable']))
			{
				update_option('itex_m_adsense_enable', intval($_POST['adsense_enable']));
			}
			for ($block=1;$block<$maxblock;$block++)
			{
				if (isset($_POST['adsense_b'.$block.'_enable']))
				{
					update_option('itex_m_adsense_b'.$block.'_enable', trim($_POST['adsense_b'.$block.'_enable']));
				}

				if (isset($_POST['adsense_b'.$block.'_size']) && !empty($_POST['adsense_b'.$block.'_size']))
				{
					update_option('itex_m_adsense_b'.$block.'_size', trim($_POST['adsense_b'.$block.'_size']));
				}

				if (isset($_POST['adsense_b'.$block.'_pos']) && !empty($_POST['adsense_b'.$block.'_pos']))
				{
					update_option('itex_m_adsense_b'.$block.'_pos', trim($_POST['adsense_b'.$block.'_pos']));
					//					$s_w = wp_get_sidebars_widgets();
					//					$ex = 0;
					//					if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
					//					{
					//						if ($v == 'imoney_adsense_'.$block)
					//						{
					//							$ex = 1;
					//							if ($_POST['adsense_b'.$block.'_pos'] != 'sidebar') unset($s_w['sidebar-1'][$k]);
					//						}
					//					}
					//					if (!$ex && ($_POST['adsense_b'.$block.'_pos'] == 'sidebar')) $s_w['sidebar-1'][] = 'imoney_adsense_'.$block;
					//					wp_set_sidebars_widgets($s_w);
				}
				if (isset($_POST['adsense_b'.$block.'_adslot']) && !empty($_POST['adsense_b'.$block.'_adslot']))
				{
					update_option('itex_m_adsense_b'.$block.'_adslot', trim($_POST['adsense_b'.$block.'_adslot']));
				}

			}

			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your Adsense ID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='adsense_id'";
						echo "id='adsense_id' ";
						echo "value='".get_option('itex_m_adsense_id')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your Adsence ID in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='adsense_enable' id='adsense_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_adsense_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_adsense_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				<?php
				for ($block=1;$block<$maxblock;$block++)
				{
					?>
					
					<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Adsense Block ', 'iMoney').$block.': ';?></label>
					</th>
					<td>
						<?php
						echo "<select name='adsense_b".$block."_enable' id='adsense_b".$block."_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_adsense_b'.$block.'_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_adsense_b'.$block.'_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";


						echo "<select name='adsense_b".$block."_size' id='adsense_b".$block."_size'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_adsense_b'.$block.'_size')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						$size = array('728x90', '468x60', '234x60','120x600', '160x600', '120x240', '336x280', '300x250', '250x250', '200x200', '180x150', '125x125');

						foreach ( $size as $k)
						{
							echo "<option value='".$k."'";
							if(get_option('itex_m_adsense_b'.$block.'_size') == $k) echo " selected='selected'";
							echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.__('Block size ', 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='adsense_b".$block."_pos' id='adsense_b".$block."_pos'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_adsense_b'.$block.'_pos')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
						foreach ( $pos as $k)
						{
							echo "<option value='".$k."'";
							if(get_option('itex_m_adsense_b'.$block.'_pos') == $k) echo " selected='selected'";
							echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.__('Block position', 'iMoney').'</label>';
						echo "<br/>\n";


						echo "<input type='text' size='20' ";
						echo "name='adsense_b".$block."_adslot'";
						echo "id='adsense_b".$block."_adslot' ";
						echo "value='".get_option('itex_m_adsense_b'.$block.'_adslot')."' />\n";
						echo '<label for="">'.__('Ad slot id', 'iMoney').'</label>';
						echo "<br/>\n";

						?>
					</td>
					
					
				</tr>
				
					<?php
				}
				?>
				
				
			</table>
			<?php
	}

	/**
   	* Begun section admin menu
   	*
    */
	function itex_m_admin_begun()
	{
		$maxblock = 4; //max  begun blocks - 1
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['begun_id']))
			{
				update_option('itex_m_begun_id', trim($_POST['begun_id']));
			}
			//print_r($_POST['begun_enable']);
			if (isset($_POST['begun_enable']))
			{
				update_option('itex_m_begun_enable', intval($_POST['begun_enable']));
			}
			for ($block=1;$block<$maxblock;$block++)
			{
				if (isset($_POST['begun_b'.$block.'_enable']))
				{
					update_option('itex_m_begun_b'.$block.'_enable', trim($_POST['begun_b'.$block.'_enable']));
				}

				if (isset($_POST['begun_b'.$block.'_pos']) && !empty($_POST['begun_b'.$block.'_pos']))
				{
					update_option('itex_m_begun_b'.$block.'_pos', trim($_POST['begun_b'.$block.'_pos']));

					//					$s_w = wp_get_sidebars_widgets();
					//					$ex = 0;
					//					if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
					//					{
					//						if ($v == 'imoney_begun_'.$block)
					//						{
					//							$ex = 1;
					//							if ($_POST['begun_b'.$block.'_pos'] != 'sidebar') unset($s_w['sidebar-1'][$k]);
					//						}
					//					}
					//					if (!$ex && ($_POST['begun_b'.$block.'_pos'] == 'sidebar')) $s_w['sidebar-1'][] = 'imoney_begun_'.$block;
					//					wp_set_sidebars_widgets( $s_w );
				}
				if (isset($_POST['begun_b'.$block.'_block_id']) && !empty($_POST['begun_b'.$block.'_block_id']))
				{
					update_option('itex_m_begun_b'.$block.'_block_id', trim($_POST['begun_b'.$block.'_block_id']));
				}

			}

			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your begun ID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='begun_id'";
						echo "id='begun_id' ";
						echo "value='".get_option('itex_m_begun_id')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your Begun auto pad ID in this box (begun_auto_pad).', 'iMoney');?></p>
						
						<?php
						echo "<select name='begun_enable' id='begun_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_begun_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_begun_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				<?php
				for ($block=1;$block<$maxblock;$block++)
				{
					?>
					
					<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('begun Block ', 'iMoney').$block.': ';?></label>
					</th>
					<td>
						<?php
						echo "<select name='begun_b".$block."_enable' id='begun_b".$block."_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_begun_b'.$block.'_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_begun_b'.$block.'_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='begun_b".$block."_pos' id='begun_b".$block."_pos'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_begun_b'.$block.'_pos')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
						foreach ( $pos as $k)
						{
							echo "<option value='".$k."'";
							if(get_option('itex_m_begun_b'.$block.'_pos') == $k) echo " selected='selected'";
							echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.__('Block position', 'iMoney').'</label>';
						echo "<br/>\n";


						echo "<input type='text' size='20' ";
						echo "name='begun_b".$block."_block_id'";
						echo "id='begun_b".$block."_block_id' ";
						echo "value='".get_option('itex_m_begun_b'.$block.'_block_id')."' />\n";
						echo '<label for="">'.__('Ad slot id', 'iMoney').' (begun_block_id)</label>';
						echo "<br/>\n";

						?>
					</td>
					
					
				</tr>
				
					<?php
				}
				?>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" href="http://itex.name/go.php?http://referal.begun.ru/partner.php?oid=114115214">
							<img src="http://promo.begun.ru/my/data/banners/107_04_partner.gif" alt="Покупаем рекламу. Дорого." border="0" height="60" width="468">
						</a>

					</td>
				</tr>
				
			</table>
			<?php
	}

	/**
   	* Adskape section admin menu
   	*
   	*/
	function itex_m_admin_adskape()
	{
		$maxblock = 4; //max  adskape blocks - 1
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['adskape_id']))
			{
				update_option('itex_m_adskape_id', trim($_POST['adskape_id']));
			}
			if (isset($_POST['adskape_enable']))
			{
				update_option('itex_m_adskape_enable', intval($_POST['adskape_enable']));
			}
			for ($block=1;$block<$maxblock;$block++)
			{
				if (isset($_POST['adskape_b'.$block.'_enable']))
				{
					update_option('itex_m_adskape_b'.$block.'_enable', trim($_POST['adskape_b'.$block.'_enable']));
				}

				if (isset($_POST['adskape_b'.$block.'_size']) && !empty($_POST['adskape_b'.$block.'_size']))
				{
					update_option('itex_m_adskape_b'.$block.'_size', trim($_POST['adskape_b'.$block.'_size']));
				}

				if (isset($_POST['adskape_b'.$block.'_pos']) && !empty($_POST['adskape_b'.$block.'_pos']))
				{
					update_option('itex_m_adskape_b'.$block.'_pos', trim($_POST['adskape_b'.$block.'_pos']));
					//					$s_w = wp_get_sidebars_widgets();
					//					$ex = 0;
					//					if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
					//					{
					//						if ($v == 'imoney_adskape_'.$block)
					//						{
					//							$ex = 1;
					//							if ($_POST['adskape_b'.$block.'_pos'] != 'sidebar') unset($s_w['sidebar-1'][$k]);
					//						}
					//					}
					//					if (!$ex && ($_POST['adskape_b'.$block.'_pos'] == 'sidebar')) $s_w['sidebar-1'][] = 'imoney_adskape_'.$block;
					//					wp_set_sidebars_widgets($s_w);
				}
				if (isset($_POST['adskape_b'.$block.'_adslot']) && !empty($_POST['adskape_b'.$block.'_adslot']))
				{
					update_option('itex_m_adskape_b'.$block.'_adslot', trim($_POST['adskape_b'.$block.'_adslot']));
				}

			}

			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your adskape ID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='adskape_id'";
						echo "id='adskape_id' ";
						echo "value='".get_option('itex_m_adskape_id')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your Adskape site ID in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='adskape_enable' id='adskape_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_adskape_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_adskape_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				<?php
				for ($block=1;$block<$maxblock;$block++)
				{
					?>
					
					<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('adskape Block ', 'iMoney').$block.': ';?></label>
					</th>
					<td>
						<?php
						echo "<select name='adskape_b".$block."_enable' id='adskape_b".$block."_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_adskape_b'.$block.'_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_adskape_b'.$block.'_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";


						echo "<select name='adskape_b".$block."_size' id='adskape_b".$block."_size'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_adskape_b'.$block.'_size')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						//$size = array('728x90', '468x60', '234x60','120x600', '160x600', '120x240', '336x280', '300x250', '250x250', '200x200', '180x150', '125x125');
						$size = array('1'=> '468×60', '2'=> '100×100', '3'=> 'RICH', '4'=> 'Topline', '5'=> '600×90', '6'=> '120×600', '7'=> '240×400',);
						foreach ( $size as $k=>$v)
						{
							echo "<option value='".$k."'";
							if(get_option('itex_m_adskape_b'.$block.'_size') == $k) echo " selected='selected'";
							echo ">".$size[$k]."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.__('Block size ', 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='adskape_b".$block."_pos' id='adskape_b".$block."_pos'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_adskape_b'.$block.'_pos')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
						foreach ( $pos as $k)
						{
							echo "<option value='".$k."'";
							if(get_option('itex_m_adskape_b'.$block.'_pos') == $k) echo " selected='selected'";
							echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.__('Block position', 'iMoney').'</label>';
						echo "<br/>\n";



						?>
					</td>
					
					
				</tr>
				
					<?php
				}
				?>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" href="http://itex.name/go.php?http://adskape.ru/unireg.php?ref=17729&d=1">
							<img src="http://adskape.ru/Banners/pr2-1.gif" alt="www.adskape.ru!">
						</a>

					</td>
				</tr>
				
			</table>
			<?php
	}

	/**
   	* teasernet section admin menu
   	*
   	*/
	function itex_m_admin_teasernet()
	{
		$maxblock = 4; //max  teasernet blocks - 1
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['teasernet_id']))
			{
				update_option('itex_m_teasernet_padid', trim($_POST['teasernet_padid']));
			}
			if (isset($_POST['teasernet_enable']))
			{
				update_option('itex_m_teasernet_enable', intval($_POST['teasernet_enable']));
			}
			for ($block=1;$block<$maxblock;$block++)
			{
				if (isset($_POST['teasernet_b'.$block.'_enable']))
				{
					update_option('itex_m_teasernet_b'.$block.'_enable', trim($_POST['teasernet_b'.$block.'_enable']));
				}

				if (isset($_POST['teasernet_b'.$block.'_blockid']) && !empty($_POST['teasernet_b'.$block.'_blockid']))
				{
					update_option('itex_m_teasernet_b'.$block.'_blockid', trim($_POST['teasernet_b'.$block.'_blockid']));
				}

				if (isset($_POST['teasernet_b'.$block.'_pos']) && !empty($_POST['teasernet_b'.$block.'_pos']))
				{
					update_option('itex_m_teasernet_b'.$block.'_pos', trim($_POST['teasernet_b'.$block.'_pos']));
					//					$s_w = wp_get_sidebars_widgets();
					//					$ex = 0;
					//					if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
					//					{
					//						if ($v == 'imoney_teasernet_'.$block)
					//						{
					//							$ex = 1;
					//							if ($_POST['teasernet_b'.$block.'_pos'] != 'sidebar') unset($s_w['sidebar-1'][$k]);
					//						}
					//					}
					//					if (!$ex && ($_POST['teasernet_b'.$block.'_pos'] == 'sidebar')) $s_w['sidebar-1'][] = 'imoney_teasernet_'.$block;
					//					wp_set_sidebars_widgets($s_w);
				}
				/*if (isset($_POST['teasernet_b'.$block.'_adslot']) && !empty($_POST['teasernet_b'.$block.'_adslot']))
				{
				update_option('itex_m_teasernet_b'.$block.'_adslot', trim($_POST['teasernet_b'.$block.'_adslot']));
				}*/

			}

			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your teasernet padid:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='teasernet_id'";
						echo "id='teasernet_id' ";
						echo "value='".get_option('itex_m_teasernet_padid')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your teasernet site padid in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='teasernet_enable' id='teasernet_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_teasernet_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_teasernet_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				<?php
				for ($block=1;$block<$maxblock;$block++)
				{
					?>
					
					<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('teasernet Block ', 'iMoney').$block.': ';?></label>
					</th>
					<td>
						<?php
						echo "<select name='teasernet_b".$block."_enable' id='teasernet_b".$block."_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_teasernet_b'.$block.'_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_teasernet_b'.$block.'_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						/*
						echo "<select name='teasernet_b".$block."_size' id='teasernet_b".$block."_size'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_teasernet_b'.$block.'_size')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						//$size = array('728x90', '468x60', '234x60','120x600', '160x600', '120x240', '336x280', '300x250', '250x250', '200x200', '180x150', '125x125');
						$size = array('1'=> '468×60', '2'=> '100×100', '3'=> 'RICH', '4'=> 'Topline', '5'=> '600×90', '6'=> '120×600', '7'=> '240×400',);
						foreach ( $size as $k=>$v)
						{
						echo "<option value='".$k."'";
						if(get_option('itex_m_teasernet_b'.$block.'_size') == $k) echo " selected='selected'";
						echo ">".$size[$k]."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.__('Block size ', 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='teasernet_b".$block."_pos' id='teasernet_b".$block."_pos'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_teasernet_b'.$block.'_pos')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
						foreach ( $pos as $k)
						{
						echo "<option value='".$k."'";
						if(get_option('itex_m_teasernet_b'.$block.'_pos') == $k) echo " selected='selected'";
						echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.__('Block position', 'iMoney').'</label>';
						echo "<br/>\n";*/

						echo "<input type='text' size='20' ";
						echo "name='teasernet_b".$block."_blockid'";
						echo "id='teasernet_b".$block."_blockid' ";
						echo "value='".get_option('itex_m_teasernet_b'.$block.'_blockid')."' />\n";
						echo '<label for="">'.__('Teasernet blockid', 'iMoney').'</label>';
						echo "<br/>\n";


						?>
					</td>
					
					
				</tr>
				
					<?php
				}
				?>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" href="http://itex.name/go.php?http://teasernet.com/?owner_id=18516">
						<img src="http://pic5.teasernet.com/tz/2-468_60.gif"></a>
						

					</td>
				</tr>
				
			</table>
			<?php
	}

	/**
   	* teasernet section admin menu
   	*
   	*/
	function itex_m_admin_teasernet_old()
	{
		$maxblock = 4; //max  teasernet blocks - 1
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['teasernet_id']))
			{
				update_option('itex_m_teasernet_id', trim($_POST['teasernet_id']));
			}
			if (isset($_POST['teasernet_enable']))
			{
				update_option('itex_m_teasernet_enable', intval($_POST['teasernet_enable']));
			}
			for ($block=1;$block<$maxblock;$block++)
			{
				if (isset($_POST['teasernet_b'.$block.'_enable']))
				{
					update_option('itex_m_teasernet_b'.$block.'_enable', trim($_POST['teasernet_b'.$block.'_enable']));
				}

				if (isset($_POST['teasernet_b'.$block.'_size']) && !empty($_POST['teasernet_b'.$block.'_size']))
				{
					update_option('itex_m_teasernet_b'.$block.'_size', trim($_POST['teasernet_b'.$block.'_size']));
				}

				if (isset($_POST['teasernet_b'.$block.'_pos']) && !empty($_POST['teasernet_b'.$block.'_pos']))
				{
					update_option('itex_m_teasernet_b'.$block.'_pos', trim($_POST['teasernet_b'.$block.'_pos']));
					//					$s_w = wp_get_sidebars_widgets();
					//					$ex = 0;
					//					if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
					//					{
					//						if ($v == 'imoney_teasernet_'.$block)
					//						{
					//							$ex = 1;
					//							if ($_POST['teasernet_b'.$block.'_pos'] != 'sidebar') unset($s_w['sidebar-1'][$k]);
					//						}
					//					}
					//					if (!$ex && ($_POST['teasernet_b'.$block.'_pos'] == 'sidebar')) $s_w['sidebar-1'][] = 'imoney_teasernet_'.$block;
					//					wp_set_sidebars_widgets($s_w);
				}
				if (isset($_POST['teasernet_b'.$block.'_adslot']) && !empty($_POST['teasernet_b'.$block.'_adslot']))
				{
					update_option('itex_m_teasernet_b'.$block.'_adslot', trim($_POST['teasernet_b'.$block.'_adslot']));
				}

			}

			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your teasernet ID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='teasernet_id'";
						echo "id='teasernet_id' ";
						echo "value='".get_option('itex_m_teasernet_id')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your teasernet site ID in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='teasernet_enable' id='teasernet_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_teasernet_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_teasernet_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				<?php
				for ($block=1;$block<$maxblock;$block++)
				{
					?>
					
					<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('teasernet Block ', 'iMoney').$block.': ';?></label>
					</th>
					<td>
						<?php
						echo "<select name='teasernet_b".$block."_enable' id='teasernet_b".$block."_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_teasernet_b'.$block.'_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_teasernet_b'.$block.'_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";


						echo "<select name='teasernet_b".$block."_size' id='teasernet_b".$block."_size'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_teasernet_b'.$block.'_size')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						//$size = array('728x90', '468x60', '234x60','120x600', '160x600', '120x240', '336x280', '300x250', '250x250', '200x200', '180x150', '125x125');
						$size = array('1'=> '468×60', '2'=> '100×100', '3'=> 'RICH', '4'=> 'Topline', '5'=> '600×90', '6'=> '120×600', '7'=> '240×400',);
						foreach ( $size as $k=>$v)
						{
							echo "<option value='".$k."'";
							if(get_option('itex_m_teasernet_b'.$block.'_size') == $k) echo " selected='selected'";
							echo ">".$size[$k]."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.__('Block size ', 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='teasernet_b".$block."_pos' id='teasernet_b".$block."_pos'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_teasernet_b'.$block.'_pos')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
						foreach ( $pos as $k)
						{
							echo "<option value='".$k."'";
							if(get_option('itex_m_teasernet_b'.$block.'_pos') == $k) echo " selected='selected'";
							echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.__('Block position', 'iMoney').'</label>';
						echo "<br/>\n";



						?>
					</td>
					
					
				</tr>
				
					<?php
				}
				?>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" href="http://itex.name/go.php?http://teasernet.ru/?owner_id=18516">
						<img src="http://pic5.teasernet.ru/tz/2-468_60.gif"></a>
						

					</td>
				</tr>
				
			</table>
			<?php
	}


	/**
   	* Html section admin menu
   	*
   	*/
	function itex_m_admin_html()
	{
		if (isset($_POST['info_update']))
		{
			if (isset($_POST['html_enable']))
			{
				update_option('itex_m_html_enable', intval($_POST['html_enable']));
			}
			if (isset($_POST['html_footer']))
			{
				update_option('itex_m_html_footer', $_POST['html_footer']);
			}
			if (isset($_POST['html_footer_enable']))
			{
				update_option('itex_m_html_footer_enable', $_POST['html_footer_enable']);
			}
			if (isset($_POST['html_beforecontent']))
			{
				update_option('itex_m_html_beforecontent', $_POST['html_beforecontent']);
			}
			if (isset($_POST['html_beforecontent_enable']))
			{
				update_option('itex_m_html_beforecontent_enable', $_POST['html_beforecontent_enable']);
			}
			if (isset($_POST['html_aftercontent']))
			{
				update_option('itex_m_html_aftercontent', $_POST['html_aftercontent']);
			}
			if (isset($_POST['html_aftercontent_enable']))
			{
				update_option('itex_m_html_aftercontent_enable', $_POST['html_aftercontent_enable']);
			}

			if (isset($_POST['html_sidebar']))
			{
				update_option('itex_m_html_sidebar', $_POST['html_sidebar']);
			}
			if (isset($_POST['html_sidebar_enable']))
			{
				update_option('itex_m_html_sidebar_enable', $_POST['html_sidebar_enable']);
				//				$s_w = wp_get_sidebars_widgets();
				//				$ex = 0;
				//				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				//				{
				//					if ($v == 'imoney_html')
				//					{
				//						$ex = 1;
				//						if (!$_POST['html_sidebar_enable']) unset($s_w['sidebar-1'][$k]);
				//					}
				//				}
				//				if (!$ex && ($_POST['html_sidebar_enable'])) $s_w['sidebar-1'][] = 'imoney_html';
				//				wp_set_sidebars_widgets( $s_w );
			}
			wp_cache_flush();
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Html inserts:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='html_enable' id='html_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_html_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_html_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Footer:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='html_footer'";
						echo "id='html_footer'>";
						echo stripslashes(get_option('itex_m_html_footer'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your html in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='html_footer_enable' id='html_footer_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_html_footer_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_html_footer_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Before Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='html_beforecontent'";
						echo "id='html_beforecontent'>";
						echo stripslashes(get_option('itex_m_html_beforecontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your html in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='html_beforecontent_enable' id='html_beforecontent_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_html_beforecontent_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_html_beforecontent_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('After Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='html_aftercontent'";
						echo "id='html_aftercontent'>";
						echo stripslashes(get_option('itex_m_html_aftercontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your html in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='html_aftercontent_enable' id='html_aftercontent_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_html_aftercontent_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_html_aftercontent_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Sidebar:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='html_sidebar'";
						echo "id='html_sidebar'>";
						echo stripslashes(get_option('itex_m_html_sidebar'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your html in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='html_sidebar_enable' id='html_sidebar_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_html_sidebar_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_html_sidebar_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
			</table>
			<?php
	}

	/**
   	* php section admin menu
   	*
   	*/
	function itex_m_admin_php()
	{
		if (isset($_POST['info_update']))
		{
			if (isset($_POST['php_enable']))
			{
				update_option('itex_m_php_enable', intval($_POST['php_enable']));
			}
			if (isset($_POST['php_footer']))
			{
				update_option('itex_m_php_footer', $_POST['php_footer']);
				//print_r(get_option('itex_m_php_footer'));
				if (!$this->itex_m_admin_php_syntax(stripslashes(get_option('itex_m_php_footer'))))
				echo '<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">php_footer wrong syntax!</div>';

			}
			if (isset($_POST['php_footer_enable']))
			{
				update_option('itex_m_php_footer_enable', $_POST['php_footer_enable']);
			}
			if (isset($_POST['php_beforecontent']))
			{
				update_option('itex_m_php_beforecontent', $_POST['php_beforecontent']);
				if (!$this->itex_m_admin_php_syntax(stripslashes(get_option('itex_m_php_beforecontent'))))
				echo '<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">php_beforecontent wrong syntax!</div>';

			}
			if (isset($_POST['php_beforecontent_enable']))
			{
				update_option('itex_m_php_beforecontent_enable', $_POST['php_beforecontent_enable']);
			}
			if (isset($_POST['php_aftercontent']))
			{
				update_option('itex_m_php_aftercontent', $_POST['php_aftercontent']);
				if (!$this->itex_m_admin_php_syntax(stripslashes(get_option('itex_m_php_aftercontent'))))
				echo '<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">php_aftercontent wrong syntax!</div>';

			}
			if (isset($_POST['php_aftercontent_enable']))
			{
				update_option('itex_m_php_aftercontent_enable', $_POST['php_aftercontent_enable']);
			}

			if (isset($_POST['php_sidebar']))
			{
				update_option('itex_m_php_sidebar', $_POST['php_sidebar']);
				if (!$this->itex_m_admin_php_syntax(stripslashes(get_option('itex_m_php_sidebar'))))
				echo '<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">php_sidebar wrong syntax!</div>';

			}
			if (isset($_POST['php_sidebar_enable']))
			{
				update_option('itex_m_php_sidebar_enable', $_POST['php_sidebar_enable']);
				//				$s_w = wp_get_sidebars_widgets();
				//				$ex = 0;
				//				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				//				{
				//					if ($v == 'imoney_php')
				//					{
				//						$ex = 1;
				//						if (!$_POST['php_sidebar_enable']) unset($s_w['sidebar-1'][$k]);
				//					}
				//				}
				//				if (!$ex && ($_POST['php_sidebar_enable'])) $s_w['sidebar-1'][] = 'imoney_php';
				//				wp_set_sidebars_widgets( $s_w );
			}



			wp_cache_flush();
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Php inserts:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='php_enable' id='php_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_php_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_php_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Footer:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='php_footer'";
						echo "id='php_footer'>";
						echo stripslashes(get_option('itex_m_php_footer'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your php in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='php_footer_enable' id='php_footer_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_php_footer_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_php_footer_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Before Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='php_beforecontent'";
						echo "id='php_beforecontent'>";
						echo stripslashes(get_option('itex_m_php_beforecontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your php in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='php_beforecontent_enable' id='php_beforecontent_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_php_beforecontent_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_php_beforecontent_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('After Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='php_aftercontent'";
						echo "id='php_aftercontent'>";
						echo stripslashes(get_option('itex_m_php_aftercontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your php in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='php_aftercontent_enable' id='php_aftercontent_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_php_aftercontent_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_php_aftercontent_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Sidebar:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='php_sidebar'";
						echo "id='php_sidebar'>";
						echo stripslashes(get_option('itex_m_php_sidebar'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your php in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='php_sidebar_enable' id='php_sidebar_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_php_sidebar_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_php_sidebar_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
			</table>
			<?php
	}

	/**
   	* php section check syntax
   	*
   	*/
	function itex_m_admin_php_syntax($code)
	{
		$braces = 0;
		$inString = 0;
		//echo "<b>1111111111111111111-</br>".$code."-2222</br>";die();
		// We need to know if braces are correctly balanced.
		// This is not trivial due to variable interpolation
		// which occurs in heredoc, backticked and double quoted strings
		foreach (token_get_all('<?php ' . $code) as $token)
		{
			if (is_array($token))
			{
				switch ($token[0])
				{
					case T_CURLY_OPEN:
					case T_DOLLAR_OPEN_CURLY_BRACES:
					case T_START_HEREDOC: ++$inString; break;
					case T_END_HEREDOC:   --$inString; break;
				}
			}
			else if ($inString & 1)
			{
				switch ($token)
				{
					case '`':
					case '"': --$inString; break;
				}
			}
			else
			{
				switch ($token)
				{
					case '`':
					case '"': ++$inString; break;

					case '{': ++$braces; break;
					case '}':
						if ($inString) --$inString;
						else
						{
							--$braces;
							if ($braces < 0) return false;
						}

						break;
				}
			}
		}

		if ($braces) return false; // Unbalanced braces would break the eval below
		else
		{
			ob_start(); // Catch potential parse error messages
			//echo "<b>1111111111111111111-</br>";
			$code = 'if(0){' . $code . '}';
			$code = eval($code); // Put $code in a dead code sandbox to prevent its execution
			ob_end_clean();
			//print_r($code);
			//echo "<b>1111111111111111111-</br>".$code."-2222</br>";die();
			return false !== $code;
		}
	}

	/**
   	* iLinks section admin menu
   	*
   	*/
	function itex_m_admin_ilinks()
	{
		if (isset($_POST['info_update']))
		{
			if (isset($_POST['ilinks_enable']))
			{
				update_option('itex_m_ilinks_enable', intval($_POST['ilinks_enable']));
			}
			if (isset($_POST['ilinks_separator']))
			{
				$separator = trim($_POST['ilinks_separator']);

				if (!empty($separator))
				update_option('itex_m_ilinks_separator', $separator);
			}
			if (isset($_POST['ilinks_footer']))
			{
				update_option('itex_m_ilinks_footer', $_POST['ilinks_footer']);
			}
			if (isset($_POST['ilinks_footer_enable']))
			{
				update_option('itex_m_ilinks_footer_enable', $_POST['ilinks_footer_enable']);
			}
			if (isset($_POST['ilinks_beforecontent']))
			{
				update_option('itex_m_ilinks_beforecontent', $_POST['ilinks_beforecontent']);
			}
			if (isset($_POST['ilinks_beforecontent_enable']))
			{
				update_option('itex_m_ilinks_beforecontent_enable', $_POST['ilinks_beforecontent_enable']);
			}
			if (isset($_POST['ilinks_aftercontent']))
			{
				update_option('itex_m_ilinks_aftercontent', $_POST['ilinks_aftercontent']);
			}
			if (isset($_POST['ilinks_aftercontent_enable']))
			{
				update_option('itex_m_ilinks_aftercontent_enable', $_POST['ilinks_aftercontent_enable']);
			}

			if (isset($_POST['ilinks_sidebar']))
			{
				update_option('itex_m_ilinks_sidebar', $_POST['ilinks_sidebar']);
			}
			if (isset($_POST['ilinks_sidebar_enable']))
			{
				update_option('itex_m_ilinks_sidebar_enable', $_POST['ilinks_sidebar_enable']);
				//				$s_w = wp_get_sidebars_widgets();
				//				$ex = 0;
				//				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				//				{
				//					if ($v == 'imoney_ilinks')
				//					{
				//						$ex = 1;
				//						if (!$_POST['ilinks_sidebar_enable']) unset($s_w['sidebar-1'][$k]);
				//					}
				//				}
				//				if (!$ex && ($_POST['ilinks_sidebar_enable'])) $s_w['sidebar-1'][] = 'imoney_ilinks';
				//				wp_set_sidebars_widgets( $s_w );
			}
			wp_cache_flush();
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('iLinks inserts:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='ilinks_enable' id='ilinks_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_ilinks_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_ilinks_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<input type='text' size='2' ";
						echo "name='ilinks_separator'";
						echo "id='ilinks_separator' ";
						$separator = (get_option('itex_m_ilinks_separator')?(get_option('itex_m_ilinks_separator')):':');
						echo "value='".$separator."' />\n";
						echo '<label for="">'.__('Separator', 'iMoney').'</label>';
						echo "<br/>\n";

						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Footer:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='ilinks_footer'";
						echo "id='ilinks_footer'>";
						echo stripslashes(get_option('itex_m_ilinks_footer'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your ilinks in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='ilinks_footer_enable' id='ilinks_footer_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_ilinks_footer_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_ilinks_footer_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Before Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='ilinks_beforecontent'";
						echo "id='ilinks_beforecontent'>";
						echo stripslashes(get_option('itex_m_ilinks_beforecontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your ilinks in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='ilinks_beforecontent_enable' id='ilinks_beforecontent_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_ilinks_beforecontent_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_ilinks_beforecontent_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('After Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='ilinks_aftercontent'";
						echo "id='ilinks_aftercontent'>";
						echo stripslashes(get_option('itex_m_ilinks_aftercontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your ilinks in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='ilinks_aftercontent_enable' id='ilinks_aftercontent_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_ilinks_aftercontent_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_ilinks_aftercontent_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Sidebar:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='ilinks_sidebar'";
						echo "id='ilinks_sidebar'>";
						echo stripslashes(get_option('itex_m_ilinks_sidebar'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your ilinks in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='ilinks_sidebar_enable' id='ilinks_sidebar_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_ilinks_sidebar_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_ilinks_sidebar_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
			</table>
			<?php
	}

	/**
   	* Tnx/Xap section admin menu
   	*
   	*/
	function itex_m_admin_tnx()
	{
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['tnx_tnxuser']))
			{
				update_option('itex_m_tnx_tnxuser', trim($_POST['tnx_tnxuser']));
			}
			if (isset($_POST['tnx_enable']))
			{
				update_option('itex_m_tnx_enable', intval($_POST['tnx_enable']));
			}

			if (isset($_POST['tnx_links_beforecontent']))
			{
				update_option('itex_m_tnx_links_beforecontent', $_POST['tnx_links_beforecontent']);
			}

			if (isset($_POST['tnx_links_aftercontent']))
			{
				update_option('itex_m_tnx_links_aftercontent', $_POST['tnx_links_aftercontent']);
			}

			if (isset($_POST['tnx_links_sidebar']))
			{
				update_option('itex_m_tnx_links_sidebar', $_POST['tnx_links_sidebar']);
			}

			if (isset($_POST['tnx_links_footer']))
			{
				update_option('itex_m_tnx_links_footer', $_POST['tnx_links_footer']);
			}

			if (isset($_POST['tnx_pages_enable']) )
			{
				update_option('itex_m_tnx_pages_enable', intval($_POST['tnx_pages_enable']));
			}

			if (isset($_POST['tnx_tnxcontext_enable']) )
			{
				update_option('itex_m_tnx_tnxcontext_enable', intval($_POST['tnx_tnxcontext_enable']));
			}

			if (isset($_POST['tnx_tnxcontext_pages_enable']) )
			{
				update_option('itex_m_tnx_tnxcontext_pages_enable', intval($_POST['tnx_tnxcontext_pages_enable']));
			}

			//			if (isset($_POST['tnx_widget']))
			//			{
			//				$s_w = wp_get_sidebars_widgets();
			//				$ex = 0;
			//				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
			//				{
			//					if ($v == 'imoney-links')
			//					{
			//						$ex = 1;
			//						if (!$_POST['tnx_widget']) unset($s_w['sidebar-1'][$k]);
			//					}
			//				}
			//				if (!$ex && $_POST['tnx_widget']) $s_w['sidebar-1'][] = 'imoney-links';
			//				wp_set_sidebars_widgets( $s_w );
			//
			//			}
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		if (isset($_POST['tnx_tnxdir_create']))
		{
			if (get_option('itex_m_tnx_tnxuser'))  $this->itex_m_tnx_install_file();
			//phpinfo();die();//dir();
		}
		if (get_option('itex_m_tnx_tnxuser'))
		{
			$file = $this->document_root . '/' . 'tnxdir_'.md5(get_option('itex_m_tnx_tnxuser')) . '/tnx.php'; //<< Not working in multihosting.
			if (file_exists($file)) {}
				else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				tnx dir not exist!
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				Create new tnxdir and tnx.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='tnx_tnxdir_create' value='<?php echo __('Create', 'iMoney'); ?>' />
				</p>
				<?php
				if (!get_option('itex_m_tnx_tnxuser')) echo __('Enter your tnx UID in this box!', 'iMoney');
				?>
		</div>
		
		<?php }
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your tnx UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='tnx_tnxuser'";
						echo "id='tnxuser' ";
						echo "value='".get_option('itex_m_tnx_tnxuser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your tnx UID in this box.', 'iMoney');?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('tnx links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='tnx_enable' id='tnx_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_tnx_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_tnx_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='tnx_links_beforecontent' id='tnx_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_tnx_links_beforecontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_tnx_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_tnx_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_tnx_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_tnx_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_tnx_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='tnx_links_aftercontent' id='tnx_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_tnx_links_aftercontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_tnx_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_tnx_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_tnx_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_tnx_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_tnx_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='tnx_links_sidebar' id='tnx_links_sidebar'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_tnx_links_sidebar')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_tnx_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_tnx_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_tnx_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_tnx_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_tnx_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_tnx_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='tnx_links_footer' id='tnx_links_footer'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_tnx_links_footer')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_tnx_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_tnx_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_tnx_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_tnx_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_tnx_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_tnx_links_footer') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Footer links', 'iMoney').'</label>';

						//						echo "<br/>\n";
						//						$ws = wp_get_sidebars_widgets();
						//						echo "<select name='tnx_widget' id='tnx_widget'>\n";
						//						echo "<option value='0'";
						//						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						//						echo ">".__("Disabled", 'iMoney')."</option>\n";
						//
						//						echo "<option value='1'";
						//						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						//						echo ">".__('Active','iMoney')."</option>\n";
						//
						//						echo "</select>\n";
						//
						//						echo '<label for="">'.__('Widget Active', 'iMoney').'</label>';

						echo "<br/>\n";
						echo "<select name='tnx_pages_enable' id='tnx_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_tnx_pages_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_tnx_pages_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";
						?>
					</td>
					
					
				</tr>
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" href="http://itex.name/go.php?http://www.tnx.net/?p=119596309"><img border="0" alt="Sell links on every page of your site to thousands of advertisers!" src="http://us1.tnx.net/tnx_468_60.gif" width="468" height="60"></a>
					</td>
				</tr>
			</table>
			<?php
	}

	/**
   	* Tnx file installation
   	*
   	* @return  bool
   	*/
	function itex_m_tnx_install_file()
	{
		//file tnx.php 0.2c 24.09.2008
		$tnx_php_content = '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';
		$tnx_php_content = gzuncompress(base64_decode($tnx_php_content));
		$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.'tnxdir_'.md5(get_option('itex_m_tnx_tnxuser')).'/tnx.php';

		$dir = dirname($file);
		//print_r($file.' '.$dir );die();
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create Tnx/Xap dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$tnx_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create xap.php!', 'iMoney').'
		</div>';
			return 0;
		}
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		//chmod($file, 0777);
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.__('Dir and xap.php created!', 'iMoney').'
		</div>';
		//die();
		return 1;
	}

	/**
   	* mainlink section admin menu
   	*
   	*/
	function itex_m_admin_mainlink()
	{
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['mainlink_mainlinkuser']))
			{
				update_option('itex_m_mainlink_mainlinkuser', trim($_POST['mainlink_mainlinkuser']));
			}
			if (isset($_POST['mainlink_enable']))
			{
				update_option('itex_m_mainlink_enable', intval($_POST['mainlink_enable']));
			}

			if (isset($_POST['mainlink_links_beforecontent']))
			{
				update_option('itex_m_mainlink_links_beforecontent', $_POST['mainlink_links_beforecontent']);
			}

			if (isset($_POST['mainlink_links_aftercontent']))
			{
				update_option('itex_m_mainlink_links_aftercontent', $_POST['mainlink_links_aftercontent']);
			}

			if (isset($_POST['mainlink_links_sidebar']))
			{
				update_option('itex_m_mainlink_links_sidebar', $_POST['mainlink_links_sidebar']);
			}

			if (isset($_POST['mainlink_links_footer']))
			{
				update_option('itex_m_mainlink_links_footer', $_POST['mainlink_links_footer']);
			}

			if (isset($_POST['mainlink_pages_enable']) )
			{
				update_option('itex_m_mainlink_pages_enable', intval($_POST['mainlink_pages_enable']));
			}

			//			if (isset($_POST['mainlink_widget']))
			//			{
			//				$s_w = wp_get_sidebars_widgets();
			//				$ex = 0;
			//				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
			//				{
			//					if ($v == 'imoney-links')
			//					{
			//						$ex = 1;
			//						if (!$_POST['mainlink_widget']) unset($s_w['sidebar-1'][$k]);
			//					}
			//				}
			//				if (!$ex && $_POST['mainlink_widget']) $s_w['sidebar-1'][] = 'imoney-links';
			//				wp_set_sidebars_widgets( $s_w );
			//
			//			}
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		if (isset($_POST['mainlink_mainlinkdir_create']))
		{
			if (get_option('itex_m_mainlink_mainlinkuser'))  $this->itex_m_mainlink_install_file();
		}

		$file = $this->document_root . '/mainlink_'.get_option('itex_m_mainlink_mainlinkuser').'/ML.php';
		if (get_option('itex_m_mainlink_mainlinkuser'))
		{
			if (file_exists($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				mainlink dir not exist!
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				Create new mainlinkdir and ML.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='mainlink_mainlinkdir_create' value='<?php echo __('Create', 'iMoney'); ?>' />
				</p>
				<?php
				if (!get_option('itex_m_mainlink_mainlinkuser')) echo __('Enter your mainlink UID in this box!', 'iMoney');
				?>
		</div>
		
		<?php 
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your mainlink UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='mainlink_mainlinkuser'";
						echo "id='mainlinkuser' ";
						echo "value='".get_option('itex_m_mainlink_mainlinkuser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your mainlink UID in this box.', 'iMoney');?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('mainlink links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='mainlink_enable' id='mainlink_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_mainlink_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_mainlink_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='mainlink_links_beforecontent' id='mainlink_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_mainlink_links_beforecontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_mainlink_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_mainlink_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_mainlink_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_mainlink_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_mainlink_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='mainlink_links_aftercontent' id='mainlink_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_mainlink_links_aftercontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_mainlink_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_mainlink_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_mainlink_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_mainlink_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_mainlink_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='mainlink_links_sidebar' id='mainlink_links_sidebar'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_mainlink_links_sidebar')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_mainlink_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_mainlink_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_mainlink_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_mainlink_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_mainlink_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_mainlink_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='mainlink_links_footer' id='mainlink_links_footer'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_mainlink_links_footer')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_mainlink_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_mainlink_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_mainlink_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_mainlink_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_mainlink_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_mainlink_links_footer') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Footer links', 'iMoney').'</label>';

						//						echo "<br/>\n";
						//						$ws = wp_get_sidebars_widgets();
						//						echo "<select name='mainlink_widget' id='mainlink_widget'>\n";
						//						echo "<option value='0'";
						//						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						//						echo ">".__("Disabled", 'iMoney')."</option>\n";
						//
						//						echo "<option value='1'";
						//						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						//						echo ">".__('Active','iMoney')."</option>\n";
						//
						//						echo "</select>\n";
						//
						//
						//						echo '<label for="">'.__('Widget Active', 'iMoney').'</label>';
						//
						//						echo "<br/>\n";
						?>
					</td>
					
					
				</tr>
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" target="_blank" href="http://itex.name/go.php?http://www.mainlink.ru/?partnerid=42851"><img src='http://www.mainlink.ru/i/banner/partners/468x1.gif' alt="www.mainlink.ru!" border='0'></a>
					</td>
				</tr>
			</table>
			<?php
	}

	/**
   	* mainlink file installation
   	*
   	* @return  bool
   	*/
	function itex_m_mainlink_install_file()
	{
		//if (!defined('SECURE_CODE')) return 0;
		if (!get_option('itex_m_mainlink_mainlinkuser')) return 0;
		//file ML.php 4.003 2009-03-05
		$mainlink_php_content = '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';
		$mainlink_php_content = gzuncompress(base64_decode($mainlink_php_content));
		$file = $this->document_root . '/mainlink_'.get_option('itex_m_mainlink_mainlinkuser').'/ML.php';
		$dir = dirname($file);
		//print_r($file.' '.$dir );die();
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create mainlink dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$mainlink_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create ', 'iMoney').'ML.php!
		</div>';
			return 0;
		}
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		file_put_contents($dir.'/'.get_option('itex_m_mainlink_mainlinkuser').'.sec',get_option('itex_m_mainlink_mainlinkuser')."\r\n");
		//chmod($file, 0777);
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.__('Dir and Ml.php created!', 'iMoney').'
		</div>';
		//die();
		return 1;
	}

	/**
   	* linkfeed section admin menu
   	*
   	*/
	function itex_m_admin_linkfeed()
	{
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['linkfeed_linkfeeduser']) && !empty($_POST['linkfeed_linkfeeduser']))
			{
				update_option('itex_m_linkfeed_linkfeeduser', trim($_POST['linkfeed_linkfeeduser']));
			}
			if (isset($_POST['linkfeed_enable']))
			{
				update_option('itex_m_linkfeed_enable', intval($_POST['linkfeed_enable']));
			}

			if (isset($_POST['linkfeed_links_beforecontent']))
			{
				update_option('itex_m_linkfeed_links_beforecontent', $_POST['linkfeed_links_beforecontent']);
			}

			if (isset($_POST['linkfeed_links_aftercontent']))
			{
				update_option('itex_m_linkfeed_links_aftercontent', $_POST['linkfeed_links_aftercontent']);
			}

			if (isset($_POST['linkfeed_links_sidebar']))
			{
				update_option('itex_m_linkfeed_links_sidebar', $_POST['linkfeed_links_sidebar']);
			}

			if (isset($_POST['linkfeed_links_footer']))
			{
				update_option('itex_m_linkfeed_links_footer', $_POST['linkfeed_links_footer']);
			}

			if (isset($_POST['linkfeed_pages_enable']) )
			{
				update_option('itex_m_linkfeed_pages_enable', intval($_POST['linkfeed_pages_enable']));
			}

			//			if (isset($_POST['linkfeed_widget']))
			//			{
			//				$s_w = wp_get_sidebars_widgets();
			//				$ex = 0;
			//				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
			//				{
			//					if ($v == 'imoney-links')
			//					{
			//						$ex = 1;
			//						if (!$_POST['linkfeed_widget']) unset($s_w['sidebar-1'][$k]);
			//					}
			//				}
			//				if (!$ex && $_POST['linkfeed_widget']) $s_w['sidebar-1'][] = 'imoney-links';
			//				wp_set_sidebars_widgets( $s_w );
			//
			//			}
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		if (isset($_POST['linkfeed_linkfeeddir_create']))
		{
			if (get_option('itex_m_linkfeed_linkfeeduser'))  $this->itex_m_linkfeed_install_file();
		}

		$file = $this->document_root . '/linkfeed_'.get_option('itex_m_linkfeed_linkfeeduser').'/linkfeed.php';
		if (get_option('itex_m_linkfeed_linkfeeduser'))
		{
			if (file_exists($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				linkfeed dir not exist!
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				Create new linkfeeddir and linkfeed.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='linkfeed_linkfeeddir_create' value='<?php echo __('Create', 'iMoney'); ?>' />
				</p>
				<?php
				if (!get_option('itex_m_linkfeed_linkfeeduser')) echo __('Enter your linkfeed UID in this box!', 'iMoney');
				?>
		</div>
		
		<?php 
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your linkfeed UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='linkfeed_linkfeeduser'";
						echo "id='linkfeeduser' ";
						echo "value='".get_option('itex_m_linkfeed_linkfeeduser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your linkfeed UID in this box.', 'iMoney');?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('linkfeed links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='linkfeed_enable' id='linkfeed_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_linkfeed_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_linkfeed_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='linkfeed_links_beforecontent' id='linkfeed_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_linkfeed_links_beforecontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_linkfeed_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_linkfeed_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_linkfeed_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_linkfeed_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_linkfeed_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='linkfeed_links_aftercontent' id='linkfeed_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_linkfeed_links_aftercontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_linkfeed_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_linkfeed_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_linkfeed_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_linkfeed_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_linkfeed_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='linkfeed_links_sidebar' id='linkfeed_links_sidebar'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_linkfeed_links_sidebar')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_linkfeed_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_linkfeed_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_linkfeed_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_linkfeed_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_linkfeed_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_linkfeed_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='linkfeed_links_footer' id='linkfeed_links_footer'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_linkfeed_links_footer')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_linkfeed_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_linkfeed_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_linkfeed_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_linkfeed_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_linkfeed_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_linkfeed_links_footer') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Footer links', 'iMoney').'</label>';

						//						echo "<br/>\n";
						//						$ws = wp_get_sidebars_widgets();
						//						echo "<select name='linkfeed_widget' id='linkfeed_widget'>\n";
						//						echo "<option value='0'";
						//						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						//						echo ">".__("Disabled", 'iMoney')."</option>\n";
						//
						//						echo "<option value='1'";
						//						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						//						echo ">".__('Active','iMoney')."</option>\n";
						//
						//						echo "</select>\n";
						//
						//
						//						echo '<label for="">'.__('Widget Active', 'iMoney').'</label>';
						//
						//						echo "<br/>\n";
						?>
					</td>
					
					
				</tr>
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" target="_blank" href="http://itex.name/go.php?http://www.linkfeed.ru/reg/38317"><img src="http://www.linkfeed.ru/banners/468x60_linkfeed.gif" alt="www.linkfeed.ru!"></a>
					</td>
				</tr>
			</table>
			<?php
	}

	/**
   	* linkfeed file installation
   	*
   	* @return  bool
   	*/
	function itex_m_linkfeed_install_file()
	{
		//if (!defined('SECURE_CODE')) return 0;
		if (!get_option('itex_m_linkfeed_linkfeeduser')) return 0;
		//file linkfeed.php 4.003 2009-04-05
		$linkfeed_php_content = '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';
		$linkfeed_php_content = gzuncompress(base64_decode($linkfeed_php_content));
		$file = $this->document_root . '/linkfeed_'.get_option('itex_m_linkfeed_linkfeeduser').'/linkfeed.php';
		$dir = dirname($file);
		//print_r($file.' '.$dir );die();
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create linkfeed dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$linkfeed_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.__('Can`t create ', 'iMoney').'linkfeed.php!
		</div>';
			return 0;
		}
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.__('Dir and linkfeed.php created!', 'iMoney').'
		</div>';
		//die();
		return 1;
	}



	/**
   	* SetLinks section admin menu
   	* Author Zya
   	*
   	*/
	function itex_m_admin_setlinks()
	{
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['setlinks_setlinksuser']))
			{
				update_option('itex_m_setlinks_setlinksuser', trim($_POST['setlinks_setlinksuser']));
			}
			if (isset($_POST['setlinks_enable']))
			{
				update_option('itex_m_setlinks_enable', intval($_POST['setlinks_enable']));
			}

			if (isset($_POST['setlinks_links_beforecontent']))
			{
				update_option('itex_m_setlinks_links_beforecontent', $_POST['setlinks_links_beforecontent']);
			}

			if (isset($_POST['setlinks_links_aftercontent']))
			{
				update_option('itex_m_setlinks_links_aftercontent', $_POST['setlinks_links_aftercontent']);
			}

			if (isset($_POST['setlinks_links_sidebar']))
			{
				update_option('itex_m_setlinks_links_sidebar', $_POST['setlinks_links_sidebar']);
			}

			if (isset($_POST['setlinks_links_footer']))
			{
				update_option('itex_m_setlinks_links_footer', $_POST['setlinks_links_footer']);
			}



			if (isset($_POST['setlinks_setlinkscontext_enable']) )
			{
				update_option('itex_m_setlinks_setlinkscontext_enable', intval($_POST['setlinks_setlinkscontext_enable']));
			}

			if (isset($_POST['setlinks_setlinkscontext_pages_enable']) )
			{
				update_option('itex_m_setlinks_setlinkscontext_pages_enable', intval($_POST['setlinks_setlinkscontext_pages_enable']));
			}

			if (isset($_POST['setlinks_pages_enable']) )
			{
				update_option('itex_m_setlinks_pages_enable', intval($_POST['setlinks_pages_enable']));
			}


			//			if ((isset($_POST['setlinks_widget'])) || (isset($_POST['itex_m_setlinks_visual_widget'])))
			//			{
			//				$s_w = wp_get_sidebars_widgets();
			//				$ex = 0;
			//				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
			//				{
			//					if ($v == 'imoney-links')
			//					{
			//						$ex = 1;
			//						if (!$_POST['setlinks_widget']) unset($s_w['sidebar-1'][$k]);
			//					}
			//				}
			//				if (!$ex && $_POST['setlinks_widget']) $s_w['sidebar-1'][] = 'imoney-links';
			//				wp_set_sidebars_widgets( $s_w );
			//
			//			}
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}

		if (get_option('itex_m_setlinks_setlinksuser'))
		{
			$file = $this->document_root . '/setlinks_' . _setlinks_USER . '/slsimple.php'; //<< Not working in multihosting.
			if (file_exists($file)) {}
			else
			{
				$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/setlinks_'.get_option('itex_m_setlinks_setlinksuser').'/';
				if (is_dir($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				SetLinks dir not exist!
		</div>

		<?php }
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Your SETLINKS UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='setlinks_setlinksuser'";
						echo "id='setlinksuser' ";
						echo "value='".get_option('itex_m_setlinks_setlinksuser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo __('Enter your SETLINKS UID in this box.', 'iMoney');?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('SETLINKS links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='setlinks_enable' id='setlinks_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_setlinks_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_setlinks_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='setlinks_links_beforecontent' id='setlinks_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_setlinks_links_beforecontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_setlinks_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_setlinks_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_setlinks_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_setlinks_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_setlinks_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='setlinks_links_aftercontent' id='setlinks_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_setlinks_links_aftercontent')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_setlinks_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_setlinks_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_setlinks_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_setlinks_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_setlinks_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='setlinks_links_sidebar' id='setlinks_links_sidebar'>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_setlinks_links_sidebar')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_setlinks_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_setlinks_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_setlinks_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_setlinks_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_setlinks_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_setlinks_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='setlinks_links_footer' id='setlinks_links_footer'>\n";
						echo "<option value='0'";
						if(!get_option('itex_m_setlinks_links_footer')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if(get_option('itex_m_setlinks_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if(get_option('itex_m_setlinks_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if(get_option('itex_m_setlinks_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if(get_option('itex_m_setlinks_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if(get_option('itex_m_setlinks_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if(get_option('itex_m_setlinks_links_footer') == 'max') echo " selected='selected'";
						echo ">".__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Footer links', 'iMoney').'</label>';

						echo "<br/>\n";
						echo "<select name='setlinks_pages_enable' id='setlinks_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_setlinks_pages_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_setlinks_pages_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";
						?>
					</td>
					
					
				</tr>
				<?php 
				?>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('SETLINKS context:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						echo "<select name='setlinks_setlinkscontext_enable' id='setlinks_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_setlinks_setlinkscontext_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_setlinks_setlinkscontext_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Context', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='setlinks_setlinkscontext_pages_enable' id='setlinks_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_setlinks_setlinkscontext_pages_enable')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_setlinks_setlinkscontext_pages_enable')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.__('Show context only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" href="http://itex.name/go.php?http://www.setlinks.ru/?pid=72567"><img src="http://vip.setlinks.ru/images/38.gif" alt="www.setlinks.ru!" border="0" /></a> 
					</td>
				</tr>
			</table>
			<?php

	}

	/**
   	* Url masking
   	*
   	* @return  bool
   	*/
	function itex_m_safe_url()
	{
		$vars=array('p','p2','pg','page_id', 'm', 'cat', 'tag', 'paged');

		//для шаблона сеп артиклес
		if (get_option('itex_m_sape_sapeuser')) $vars[] = 'itex_sape_articles_template.'.get_option('itex_m_sape_sapeuser').'.html';
		if (get_option('itex_m_sape_sapeuser')) $vars[] = 'itex_sape_articles_template.'.get_option('itex_m_sape_sapeuser');

		$url=explode("?",strtolower($_SERVER['REQUEST_URI']));
		if(isset($url[1]))
		{
			$count = preg_match_all("/(.*)=(.*)\&/Uis",$url[1]."&",$get);
			for($i=0; $i < $count; $i++)
			if (in_array($get[1][$i],$vars) && !empty($get[2][$i]))
			$ret[] = $get[1][$i]."=".$get[2][$i];
			if (count($ret))
			{
				$ret = '?'.implode("&",$ret);
				//print_r($ret);die();
			}
			else $ret = '';
		}
		else $ret = '';
		$this->safeurl = $url[0].$ret;

		$this->itex_debug('safe_url '.$this->safeurl);

		return 1;
	}

	
}

if (function_exists(add_action)) $itex_money = & new itex_money();

?>