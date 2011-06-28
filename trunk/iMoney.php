<?php
/*
Plugin Name: iMoney
Version: 0.30 (16-06-2011)(rev 2, test submit)
Plugin URI: http://itex.name/imoney
Description: Adsense, <a href="http://itex.name/go.php?http://www.sape.ru/r.a5a429f57e.php">Sape.ru</a>, <a href="http://itex.name/go.php?http://www.tnx.net/?p=119596309">tnx.net/xap.ru</a>, <a href="http://itex.name/go.php?http://referal.begun.ru/partner.php?oid=114115214">Begun.ru</a>, <a href="http://itex.name/go.php?http://www.mainlink.ru/?partnerid=42851">mainlink.ru</a>, <a href="http://itex.name/go.php?http://www.linkfeed.ru/reg/38317">linkfeed.ru</a>, <a href="http://itex.name/go.php?http://adskape.ru/unireg.php?ref=17729&d=1">adskape.ru</a>, <a href="http://itex.name/go.php?http://teasernet.com/?owner_id=18516">Teasernet.com</a>, <a href="http://itex.name/go.php?http://trustlink.ru/registration/106535">Trustlink.ru</a>, php exec and html inserts helper.
Author: Itex
Author URI: http://itex.name/
*/

/*
Copyright 2007-2011  Itex (web : http://itex.name/)

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

//
//joomla header
/**
* @version 1.5
* @package iMoney ?
* @copyright © 2011 iTex
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
//if (!defined('_VALID_MOS') && !defined('_JEXEC'))
//{
//	echo 'Restricted access';
//	return;
//}
//
//
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
	var $version = '0.30';
	var $full = 0;
	var $error = '';
	//var $force_show_code = true;
	var $sape;
	var $sapecontext;
	var $sapearticles;
	var $zilla;
	var $tnx;
	var $setlinks;
	var $setlinkscontext;
	//var $enable = false;
	var $links = array();
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
	var $encoding = 'UTF-8';

	var $wordpress = 1;
	var $drupal = 0;
	var $joomla = 0;
	var $bitrix = 0;
	var $isape_converted = 1;

	/**
   	* constructor, function __construct()  in php4 not working
   	*
   	*/
	function itex_money()
	{
		if (substr(phpversion(),0,1) == 4) $this->php4(); //fix php4 bugs

		$this->document_root = ($_SERVER['DOCUMENT_ROOT'] != str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]))?(str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"])):($_SERVER['DOCUMENT_ROOT']);

		if (!$this->get_option('itex_m_install_date'))
		{
			$this->update_option('itex_m_install_date',time());
		}


		if ($this->wordpress)
		{
			if (!function_exists(add_action)) return 0;

			//if (!get_option('itex_m_isape_converted')) $this->isape_converted = 0; //для совместимомти с isape, через несколько месяцев надо удалить
			//else $this->isape_converted = 0;

			add_action('widgets_init', array(&$this, 'itex_m_init'));
			//add_action("widgets_init", array(&$this, 'itex_m_widget_init'));
			add_action('admin_menu', array(&$this, 'itex_m_menu'));
			add_action('wp_footer', array(&$this, 'itex_m_footer'));


			//			if (!$this->get_option('itex_m_install_date'))
			//			{
			//				$this->update_option('itex_m_install_date',time());
			//			}

			$this->encoding = $this->get_option('blog_charset')?$this->get_option('blog_charset'):'UTF-8';

		}
		if ($this->joomla)
		{
			if (!defined('_VALID_MOS') && !defined('_JEXEC')) return 0;
			if (!isset($GLOBALS['_MAMBOTS'])) return 0;

			$GLOBALS['_MAMBOTS']->registerFunction('onAfterStart', array(&$this, 'itex_m_init'));
		}
		if ($this->bitrix)
		{

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
   	* deprecated
   	*
   	*/
	function lang_ru()
	{
		return ; // тк перешел на .mo файлы

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
   	* Get option
   	*
   	*/
	function get_option($option)
	{
		if ($this->wordpress)
		{
			//if (!$this->isape_converted) //для совместимомти с isape, через несколько месяцев надо удалить
			//{
			//	$option  = str_ireplace('itex_m_','itex_s_',$option);
			//}
			return get_option($option);
		}
		if ($this->joomla)
		{
			return $GLOBALS['params']->get($option);
		}

		if ($this->bitrix)
		{
			return COption::GetOptionString("imoney", $option, false);
		}

		return false;
	}

	/**
   	* Update option
   	*
   	*/
	function update_option($option,$value)
	{
		if ($this->wordpress)
		{
			return update_option($option,$value);
		}

		if ($this->bitrix)
		{
			return COption::SetOptionString("imoney", $option, $value);
		}

		return false;
	}

	/**
   	* Translate api
   	*
   	*/
	function __($text, $context = 'iMoney')
	{
		if ($this->wordpress)
		{
			return __($text, $context);
		}
		if ($this->joomla)
		{
			return JText::_($text);
		}
		if ($this->bitrix)
		{
			$text2 = GetMessage($text);
			if (!empty($text2))
			return $text2;
		}
		return $text;

	}

	/**
   	* Url masking
   	*
   	* @return  bool
   	*/
	function itex_m_safe_url()
	{
		$vars=array('p','p2','pg','page_id', 'm', 'cat', 'tag', 'paged');

		//для шаблона сейп артиклес
		if ($this->get_option('itex_m_sape_sapeuser')) $vars[] = 'itex_sape_articles_template.'.$this->get_option('itex_m_sape_sapeuser').'.html';
		if ($this->get_option('itex_m_sape_sapeuser')) $vars[] = 'itex_sape_articles_template.'.$this->get_option('itex_m_sape_sapeuser');

		$url=explode("?",strtolower($_SERVER['REQUEST_URI']));
		if(isset($url[1]))
		{
			//$count = preg_match_all("/(.*)=(.*)\&/Uis",$url[1]."&",$get);
			$count = preg_match_all("/(.*)=(.*)&/Uis",$url[1]."&",$get);
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

	

	/**
   	* get links
   	*
   	* @param   int   $c		count
   	* @param   int   $c		a only if 1
    * @return  string $ret  
   	*/
	function itex_m_get_links($c = 30, $q=1) //$q = a only
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
   	* plugin init function 
   	*
   	* @return  bool	
   	*/
	function itex_m_init()
	{
		if ( function_exists('memory_get_usage') ) $this->memory_get_usage = memory_get_usage();
		if ( function_exists('get_num_queries') ) $this->get_num_queries = get_num_queries();

		if ($this->get_option('itex_m_global_masking'))
		{
			$this->itex_m_safe_url();
			$last_REQUEST_URI = $_SERVER['REQUEST_URI'];
			$_SERVER['REQUEST_URI'] = $this->safeurl;
		}
		$this->itex_debug('REQUEST_URI = '.$_SERVER['REQUEST_URI']);

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
		$this->itex_init_zilla();
		
		$this->itex_m_widget_init();
		if (strlen($this->footer))
		{
			if ($this->wordpress) add_action('wp_footer', array(&$this, 'itex_m_footer'));
		}

		if ((strlen($this->beforecontent)) || (strlen($this->aftercontent)) )
		{
			$this->itex_debug('strlenbeforecontent = '.strlen($this->beforecontent));
			$this->itex_debug('strlenaftercontent = '.strlen($this->aftercontent));

			if ($this->wordpress)
			{
				add_filter('the_content', array(&$this, 'itex_m_replace'));
				add_filter('the_excerpt', array(&$this, 'itex_m_replace'));
			}
			if ($this->joomla)
			{
				$GLOBALS['_MAMBOTS']->registerFunction( 'onPrepareContent', array(&$this, 'itex_m_replace') );
			}

		}

		if (isset($last_REQUEST_URI)) //privodim REQUEST_URI v poryadok
		{
			$_SERVER['REQUEST_URI'] = $last_REQUEST_URI;
			unset($last_REQUEST_URI);
		}

		if ( function_exists('memory_get_usage') ) $this->itex_debug("memory start/end/dif ".$this->memory_get_usage.'/'.memory_get_usage().'/'.(memory_get_usage()-$this->memory_get_usage));
		if ( function_exists('get_num_queries') ) $this->itex_debug("get_num_queries start/end/dif ".intval($this->get_num_queries).'/'.intval(get_num_queries()).'/'.(intval(get_num_queries())-intval($this->get_num_queries)));

		return 1;
	}

	/**
   	* sape init
   	*
   	* @return  bool
   	*/
	function itex_init_sape()
	{
		if (!$this->get_option('itex_m_sape_enable') && !$this->get_option('itex_m_sape_sapecontext_enable') && !$this->get_option('itex_m_sape_sapearticles_enable')) return 0;

		if (!defined('_SAPE_USER')) define('_SAPE_USER', $this->get_option('itex_m_sape_sapeuser'));
		else $this->error .= '_SAPE_USER '.$this->__('already defined<br/>', 'iMoney');
		$this->itex_debug('SAPE_USER = '.$this->get_option('itex_m_sape_sapeuser'));

		//FOR MASS INSTALL ONLY, REPLACE if (0) ON if (1)
		//		if (0)
		//		{
		//			$this->update_option('itex_sape_sapeuser', 'abcdarfkwpkgfkhagklhskdgfhqakshgakhdgflhadh'); //sape uid
		//			$this->update_option('itex_sapecontext_enable', 1);
		//			$this->update_option('itex_sape_enable', 1);
		//			$this->update_option('itex_sape_links_footer', 'max');
		//		}

		$file = $this->document_root . '/' . _SAPE_USER . '/sape.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else return 0;

		$o['charset'] = $this->encoding;
		//$o['force_show_code'] = $this->force_show_code;
		$o['force_show_code'] = 1; // сделал так, тк новые страницы не добавляются
		$o['multi_site'] = true;
		if ($this->get_option('itex_m_sape_enable'))
		{
			$this->sape = new SAPE_client($o);

			


			//добавляем ссылки в линкс
			$i = 1;
			while ($i++)
			{
				$q = trim($this->sape->return_links(1));
				if (empty($q) || !strlen($q))
				{
					break;
				}



				//убрал, тк сайт не индексируются возможно из-за этого
				//if(!preg_match("/^\<\!\-\-/", $q)) $q .= $this->sape->_links_delimiter; // убираем коммент, не повредит дебагу?

				if (strlen($q)) $this->links['a_only'][] = $q.$this->sape->_links_delimiter;

				$q1 = trim(strip_tags($q)); //если нет текста, то и нечего показывать, значит ссылок больше нет
				if (empty($q1) || !strlen($q1))
				{
					break;
				}

				//!!!!!!!!!!check it, tk ne vozvrashaet pustuu stroku
				if ($i > 30) break;
			}
			if (!count($this->links)) // если нет размещенных ссылок, и включен debugenable добавляем чеккод
			{
				if ($this->get_option('itex_m_global_debugenable'))
				$this->links['a_only'][] = trim($this->sape->return_links());
			}
			$this->itex_debug('sape links:'.var_export($this->links, true));


			//$this->itex_init_sape_links();





			///check it
			$url = 1;
			if ($this->wordpress) if (is_object($GLOBALS['wp_rewrite'])) $url = url_to_postid($_SERVER['REQUEST_URI']);

			if (($url) || !$this->get_option('itex_sape_pages_enable'))
			{
				if ($this->get_option('itex_m_sape_links_beforecontent') == '0')
				{
					//$this->beforecontent = '';
				}
				else
				{
					$this->beforecontent .= '<div>'.$this->itex_m_get_links(intval($this->get_option('itex_sape_links_beforecontent'))).'</div>';
				}

				if ($this->get_option('itex_m_sape_links_aftercontent') == '0')
				{
					//$this->aftercontent = '';
				}
				else
				{
					
					$this->aftercontent .= '<div>'.$css.$this->itex_m_get_links(intval($this->get_option('itex_m_sape_links_aftercontent'))).'</div>';
				}
			}
			$countsidebar = $this->get_option('itex_m_sape_links_sidebar');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
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
				$this->sidebar_links .= '<div>'.$this->itex_m_get_links(intval($countsidebar)).'</div>';
			}
			$this->sidebar_links = $check.$this->sidebar_links;

			$countfooter = $this->get_option('itex_m_sape_links_footer');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
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
				$this->footer .= '<div>'.$this->itex_m_get_links($countfooter).'</div>';
			}
			$this->footer = $check.$this->footer;

			if (($countsidebar == 'max') && ($countfooter == 'max')) $this->footer .= $this->itex_m_get_links();
			else
			{
				if  ($countsidebar == 'max') $this->sidebar_links .= $this->itex_m_get_links();
				else $this->footer .= $this->itex_m_get_links();
			}
			
			
			if (strlen($this->sape->_error))$this->itex_debug('sape error:'.var_export($this->sape->_error, true));
		}

		if ($this->get_option('itex_m_sape_sapecontext_enable'))
		{
			$this->sapecontext = new SAPE_context($o);
			if ($this->wordpress)
			{
				add_filter('the_content', array(&$this, 'itex_m_replace'));
				add_filter('the_excerpt', array(&$this, 'itex_m_replace'));
			}

		}

		if ($this->get_option('itex_m_sape_sapearticles_enable'))
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
				$preg = $this->get_option('itex_m_sape_sapearticles_template_url');
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
					if ($this->wordpress)
					{
						remove_all_actions('wp');
						remove_all_actions('wp_head');
						add_action('wp', array(&$this, 'itex_init_sape_articles_template'),-999);
						global $wp_query;
					}

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

				//анонсы
				///check it
				$url = 1;
				if ($this->wordpress) if (is_object($GLOBALS['wp_rewrite'])) $url = url_to_postid($_SERVER['REQUEST_URI']);

				if (($url) || !$this->get_option('itex_m_sape_sapearticles_pages_enable'))
				{
					$this->itex_debug('sapearticles announcements worked');
					if ($this->get_option('itex_m_sape_sapearticles_beforecontent') == '0')
					{
						//$this->beforecontent = '';
					}
					else
					{
						$this->beforecontent .= '<div>'.$this->sapearticles->return_announcements(intval($this->get_option('itex_m_sape_sapearticles_beforecontent'))).'</div>';
					}

					if ($this->get_option('itex_m_sape_sapearticles_aftercontent') == '0')
					{
						//$this->aftercontent = '';
					}
					else
					{

						$this->aftercontent .= '<div>'.$this->sapearticles->return_announcements(intval($this->get_option('itex_m_sape_sapearticles_aftercontent'))).'</div>';
					}
				}
				$countsidebar = $this->get_option('itex_m_sape_sapearticles_sidebar');
				$check = $this->get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
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

				$countfooter = $this->get_option('itex_m_sape_sapearticles_footer');
				$check = $this->get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
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
	function itex_init_sape_links_del()
	{
		$i = 1;

		while ($i++)
		{
			$q = trim($this->sape->return_links(1));
			if (empty($q) || !strlen($q))
			{
				break;
			}



			//убрал, тк сайт не индексируются возможно из-за этого
			//if(!preg_match("/^\<\!\-\-/", $q)) $q .= $this->sape->_links_delimiter; // убираем коммент, не повредит дебагу?

			
			if (strlen($q)) $this->links['a_only'][] = $q.$this->sape->_links_delimiter;

			$q1 = trim(strip_tags($q)); //если нет текста, то и нечего показывать, значит ссылок больше нет
			if (empty($q1) || !strlen($q1))
			{
				break;
			}

			//!!!!!!!!!!check it, tk ne vozvrashaet pustuu stroku
			if ($i > 30) break;
		}
		if (!count($this->links)) // если нет размещенных ссылок, и включен debugenable добавляем чеккод
		{
			if ($this->get_option('itex_m_global_debugenable'))
			$this->links['a_only'][] = trim($this->sape->return_links());
		}
		$this->itex_debug('sape links:'.var_export($this->links, true));
		return 1;
	}



	/**
   	* get sape articles
   	*
   	* @return  bool
   	*/
	function itex_init_sape_articles_template()
	{
		$this->itex_debug('itex_init_sape_articles_template worked');

		if ($this->wordpress)
		{
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
		}
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
   	* zilla init
   	*
   	* @return  bool
   	*/
	function itex_init_zilla()
	{
		if (!$this->get_option('itex_m_zilla_enable') ) return 0;

		if (!defined('_zilla_USER')) define('_ZILLA_USER', $this->get_option('itex_m_zilla_user'));
		else $this->error .= '_ZILLA_USER '.$this->__('already defined<br/>', 'iMoney');
		$this->itex_debug('_ZILLA_USER = '.$this->get_option('itex_m_zilla_user'));

		//FOR MASS INSTALL ONLY, REPLACE if (0) ON if (1)
		//		if (0)
		//		{
		//			$this->update_option('itex_zilla_user', 'abcdarfkwpkgfkhagklhskdgfhqakshgakhdgflhadh'); //zilla uid
		//			$this->update_option('itex_zillacontext_enable', 1);
		//			$this->update_option('itex_zilla_enable', 1);
		//			$this->update_option('itex_zilla_links_footer', 'max');
		//		}

		$file = $this->document_root . '/' . $this->get_option('itex_m_zilla_user') . '/zilla.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else return 0;
		$this->itex_debug('zilla file:'.$file);
		$o['charset'] = $this->encoding;
		//$o['force_show_code'] = $this->force_show_code;
		$o['force_show_code'] = 1; // сделал так, тк новые страницы не добавляются
		$o['multi_site'] = true;
		if ($this->get_option('itex_m_zilla_enable'))
		{
			$this->zilla = new ZILLA_client($o);


			$i = 1;

			while ($i++)
			{
				$q = trim($this->zilla->return_links(1));
				if (empty($q) || !strlen($q))
				{
					break;
				}



				//убрал, тк сайт не индексируются возможно из-за этого
				//if(!preg_match("/^\<\!\-\-/", $q)) $q .= $this->zilla->_links_delimiter; // убираем коммент, не повредит дебагу?

				if (strlen($q)) $this->links['a_only'][] = $q.$this->zilla->_links_delimiter;

				$q1 = trim(strip_tags($q)); //если нет текста, то и нечего показывать, значит ссылок больше нет, но если что показали чеккод
				if (empty($q1) || !strlen($q1))
				{
					break;
				}

				//!!!!!!!!!!check it, tk ne vozvrashaet pustuu stroku
				if ($i > 30) break;
			}
			if (!count($this->links)) // если нет размещенных ссылок, и включен debugenable добавляем чеккод
			{
				if ($this->get_option('itex_m_global_debugenable'))
				$this->links['a_only'][] = trim($this->zilla->return_links());
			}
			$this->itex_debug('zilla links:'.var_export($this->links, true));

			//$this->itex_init_zilla_links();

			///check it
			$url = 1;
			if ($this->wordpress) if (is_object($GLOBALS['wp_rewrite'])) $url = url_to_postid($_SERVER['REQUEST_URI']);

			if (($url) || !$this->get_option('itex_zilla_pages_enable'))
			{
				if ($this->get_option('itex_m_zilla_links_beforecontent') == '0')
				{
					//$this->beforecontent = '';
				}
				else
				{
					$this->beforecontent .= '<div>'.$this->itex_m_get_links(intval($this->get_option('itex_zilla_links_beforecontent'))).'</div>';
				}

				if ($this->get_option('itex_m_zilla_links_aftercontent') == '0')
				{
					//$this->aftercontent = '';
				}
				else
				{
					
					$this->aftercontent .= '<div>'.$css.$this->itex_m_get_links(intval($this->get_option('itex_m_zilla_links_aftercontent'))).'</div>';
				}
			}
			$countsidebar = $this->get_option('itex_m_zilla_links_sidebar');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
			if ($countsidebar == 'max')
			{
				//$this->sidebar = '<div>'.$this->zilla->return_links().'</div>';
			}
			elseif ($countsidebar == '0')
			{
				//$this->sidebar = '';
			}
			else
			{
				$this->sidebar_links .= '<div>'.$this->itex_m_get_links(intval($countsidebar)).'</div>';
			}
			$this->sidebar_links = $check.$this->sidebar_links;

			$countfooter = $this->get_option('itex_m_zilla_links_footer');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
			$this->footer .= $check;
			if ($countfooter == 'max')
			{
				//$this->footer = '<div>'.$this->zilla->return_links().'</div>';
			}
			elseif ($countfooter == '0')
			{
				//$this->footer = '';
			}
			else
			{
				$this->footer .= '<div>'.$this->itex_m_get_links($countfooter).'</div>';
			}
			$this->footer = $check.$this->footer;

			if (($countsidebar == 'max') && ($countfooter == 'max')) $this->footer .= $this->itex_m_get_links();
			else
			{
				if  ($countsidebar == 'max') $this->sidebar_links .= $this->itex_m_get_links();
				else $this->footer .= $this->itex_m_get_links();
			}
			if (strlen($this->zilla->_error))$this->itex_debug('zilla error:'.var_export($this->zilla->_error, true));
		}




		return 1;
	}

	/**
   	* tnx init
   	*
    * @return  bool	
   	*/
	function itex_init_tnx()
	{
		if (!$this->get_option('itex_m_tnx_enable')) return 0;
		$file = $this->document_root . '/' . 'tnxdir_'.md5($this->get_option('itex_m_tnx_tnxuser')) . '/tnx.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else return 0;
		$this->itex_debug('TNX_USER = '.$this->get_option('itex_m_tnx_tnxuser'));

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
		$dir = '/' . 'tnxdir_'.md5($this->get_option('itex_m_tnx_tnxuser')).'/';
		$this->tnx = new TNX_n($this->get_option('itex_m_tnx_tnxuser'), $dir);
		$this->tnx->_encoding = $this->encoding;
		if (isset($last_DOCUMENT_ROOT)) //zakanchivaem izvrashatsa i privodim vse v poryadok
		{
			$_SERVER['DOCUMENT_ROOT'] = $last_DOCUMENT_ROOT;
			unset($last_DOCUMENT_ROOT);
		}


		if ($this->get_option('itex_m_tnx_enable'))
		{
			if ($this->get_option('itex_m_tnx_links_beforecontent') == '0')
			{
				//$this->beforecontent = '';
			}
			else
			{
				$this->beforecontent .= '<div>'.$this->tnx->show_link(intval($this->get_option('itex_tnx_links_beforecontent'))).'</div>';
			}

			if ($this->get_option('itex_m_tnx_links_aftercontent') == '0')
			{
				//$this->aftercontent = '';
			}
			else
			{
				$this->aftercontent .= '<div>'.$this->tnx->show_link(intval($this->get_option('itex_tnx_links_aftercontent'))).'</div>';
			}

			$countsidebar = $this->get_option('itex_m_tnx_links_sidebar');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check sidebar tnx'.$countsidebar.'-->':'';
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

			$countfooter = $this->get_option('itex_m_tnx_links_footer');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check footer tnx'.$countfooter.'-->':'';
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
		if (!$this->get_option('itex_m_trustlink_enable') ) return 0;

		if (!defined('TRUSTLINK_USER')) define('TRUSTLINK_USER', $this->get_option('itex_m_trustlink_user'));
		else $this->error .= 'TRUSTLINK_USER '.$this->__('already defined<br/>', 'iMoney');
		$this->itex_debug('TRUSTLINK_USER = '.$this->get_option('itex_m_trustlink_user'));

		$file = $this->document_root . DIRECTORY_SEPARATOR . TRUSTLINK_USER . DIRECTORY_SEPARATOR . 'trustlink.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else return 0;

		$o['charset'] = $this->encoding;
		$o['force_show_code'] = 1; // сделал так, тк новые страницы не добавляются
		$o['multi_site'] = true;
		$o['use_cache'] = true; //кеширование, только для нового кода
		if ($this->get_option('itex_m_trustlink_enable'))
		{
			$trustlink = new TrustlinkClient($o);

			if ($this->get_option('itex_m_trustlink_links_beforecontent') == '0')
			{
				//$this->beforecontent = '';
			}
			else
			{
				$this->beforecontent .= '<div>'.$trustlink->build_links().'</div>';
			}

			if ($this->get_option('itex_m_trustlink_links_aftercontent') == '0')
			{
				//$this->aftercontent = '';
			}
			else
			{
				$this->aftercontent .= '<div>'.$trustlink->build_links().'</div>';
			}

			$countsidebar = $this->get_option('itex_m_trustlink_links_sidebar');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
			if ($countsidebar == 'max')
			{
				$this->sidebar_links .= '<div>'.$trustlink->build_links().'</div>';
			}
			elseif ($countsidebar == '0')
			{
				//$this->sidebar = '';
			}

			$this->sidebar_links = $check.$this->sidebar_links;

			$countfooter = $this->get_option('itex_m_trustlink_links_footer');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
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
		if (!$this->get_option('itex_m_adsense_enable')) return 0;

		if ($this->get_option('itex_m_adsense_id'));
		else $this->error .= $this->__('Adsense Id not defined<br/>', 'iMoney');

		$maxblock = 4; //max  adsense blocks - 1
		for ($block=1;$block<$maxblock;$block++)
		{
			if ($this->get_option('itex_m_adsense_b'.$block.'_enable'))
			{
				$size = $this->get_option('itex_m_adsense_b'.$block.'_size');
				$size = explode('x',$size);

				//$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
				$script = '<script type="text/javascript"><!--
google_ad_client = "'.$this->get_option('itex_m_adsense_id').'"; google_ad_slot = "'.$this->get_option('itex_m_adsense_b'.$block.'_adslot').'"; google_ad_width = '.$size[0].'; google_ad_height = '.$size[1].';
//--></script><script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
				$pos = $this->get_option('itex_m_adsense_b'.$block.'_pos');
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
		if (!$this->get_option('itex_m_teasernet_enable')) return 0;

		if ($this->get_option('itex_m_teasernet_padid'));
		else $this->error .= $this->__('Teasernet Id not defined<br/>', 'iMoney');

		$maxblock = 4; //max  teasernet blocks - 1
		for ($block=1;$block<$maxblock;$block++)
		{
			if ($this->get_option('itex_m_teasernet_b'.$block.'_enable'))
			{
				$size = $this->get_option('itex_m_teasernet_b'.$block.'_size');
				$size = explode('x',$size);

				//$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
				$script = '<script type="text/javascript"><!--
teasernet_blockid = '.$this->get_option('itex_m_teasernet_b'.$block.'_blockid').';
teasernet_padid = '.$this->get_option('itex_m_teasernet_padid').';
//--></script><script type="text/javascript" src="http://associeta.com/block.js"></script>';
				$pos = $this->get_option('itex_m_teasernet_b'.$block.'_pos');
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
		if (!$this->get_option('itex_m_begun_enable')) return 0;

		if ($this->get_option('itex_m_begun_id'));
		else $this->error .= $this->__('begun Id not defined<br/>', 'iMoney');

		$maxblock = 4; //max  begun blocks - 1
		for ($block=1;$block<$maxblock;$block++)
		{
			if ($this->get_option('itex_m_begun_b'.$block.'_enable'))
			{
				$script = '<p><script type="text/javascript"><!--
var begun_auto_pad = '.$this->get_option('itex_m_begun_id').';var begun_block_id = '.$this->get_option('itex_m_begun_b'.$block.'_block_id').';
//--></script><script type="text/javascript" src="http://autocontext.begun.ru/autocontext2.js"></script></p>';
				$pos = $this->get_option('itex_m_begun_b'.$block.'_pos');
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
		if (!$this->get_option('itex_m_adskape_enable')) return 0;

		if ($this->get_option('itex_m_adskape_id'));
		else $this->error .= $this->__('Adskape Id not defined<br/>', 'iMoney');

		$maxblock = 4; //max  adskape blocks - 1
		for ($block=1;$block<$maxblock;$block++)
		{
			if ($this->get_option('itex_m_adskape_b'.$block.'_enable'))
			{
				$size = $this->get_option('itex_m_adskape_b'.$block.'_size');
				//$size = explode('x',$size);

				//$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
				$script = '<script type="text/javascript" src="http://p'.$this->get_option('itex_m_adskape_id').'.adskape.ru/adout.js?p='.$this->get_option('itex_m_adskape_id').'&t='.$size.'"></script>';
				$pos = $this->get_option('itex_m_adskape_b'.$block.'_pos');
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
		if (!$this->get_option('itex_m_html_enable')) return 0;

		if ($this->get_option('itex_m_html_sidebar_enable')) $this->sidebar['iMoney_html'] = stripslashes($this->get_option('itex_m_html_sidebar'));
		if ($this->get_option('itex_m_html_footer_enable')) $this->footer .= stripslashes($this->get_option('itex_m_html_footer'));
		if ($this->get_option('itex_m_html_beforecontent_enable')) $this->beforecontent .= stripslashes($this->get_option('itex_m_html_beforecontent'));
		if ($this->get_option('itex_m_html_aftercontent_enable')) $this->aftercontent .= stripslashes($this->get_option('itex_m_html_aftercontent'));
	}

	/**
   	* php init
   	*
    * @return  bool
   	*/
	function itex_init_php()
	{
		if (!$this->get_option('itex_m_php_enable')) return 0;
		if (preg_match('@wp-admin@i',$_SERVER['PHP_SELF'])) return 0; //можно вернуться в админку и исправить косяки
		if ($this->get_option('itex_m_php_sidebar_enable'))
		{
			ob_start();
			$code = stripslashes($this->get_option('itex_m_php_sidebar'));
			if (strlen($code)>1) if ($this->itex_m_admin_php_syntax($code)) eval($code);
			$code = ob_get_contents();
			ob_end_clean();
			$this->sidebar['iMoney_php'] = $code;
		}
		if ($this->get_option('itex_m_php_beforecontent_enable'))
		{
			ob_start();
			$code = stripslashes($this->get_option('itex_m_php_beforecontent'));
			if (strlen($code)>1) if ($this->itex_m_admin_php_syntax($code)) eval($code);
			$code = ob_get_contents();
			ob_end_clean();
			$this->beforecontent .= $code;
		}
		if ($this->get_option('itex_m_php_aftercontent_enable'))
		{
			ob_start();
			$code = stripslashes($this->get_option('itex_m_php_aftercontent'));
			if (strlen($code)>1) if ($this->itex_m_admin_php_syntax($code)) eval($code);
			$code = ob_get_contents();
			ob_end_clean();
			$this->aftercontent .= $code;
		}
		if ($this->get_option('itex_m_php_footer_enable'))
		{
			ob_start();
			$code = stripslashes($this->get_option('itex_m_php_footer'));
			//echo '_php'.$code;die();
			if (strlen($code)>1) if ($this->itex_m_admin_php_syntax($code)) if (eval($code)){};
			$code = ob_get_contents();
			ob_end_clean();
			$this->footer .= $code;
		}
		return true;
	}


	/**
   	* iLinks init
   	*
    * @return  bool
   	*/
	function itex_init_ilinks()
	{
		if (!$this->get_option('itex_m_ilinks_enable')) return 0;
		$separator = trim($this->get_option('itex_m_ilinks_separator'));
		if (empty($separator)) return 0;
		if ($this->get_option('itex_m_ilinks_sidebar_enable'))
		{
			$l = explode("\n",stripslashes($this->get_option('itex_m_ilinks_sidebar')));
			foreach ($l as $q)
			{
				$w = explode($separator,trim($q),2);
				if (strtolower($w[0]{0}) == 'r')
				{
					$w[0] = substr($w[0],1,strlen($w[0]));
					if (preg_match("@".$w[0]."@i",$_SERVER["REQUEST_URI"])) $this->sidebar['iMoney_ilinks']  .= $w[1];
				}
				elseif  ($_SERVER["REQUEST_URI"] == $w[0]) $this->sidebar['iMoney_ilinks']  .= $w[1];

			}
		}
		if ($this->get_option('itex_m_ilinks_footer_enable'))
		{
			$l = explode("\n",stripslashes($this->get_option('itex_m_ilinks_footer')));
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
		if ($this->get_option('itex_m_ilinks_beforecontent_enable'))
		{
			$l = explode("\n",stripslashes($this->get_option('itex_m_ilinks_beforecontent')));
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
		if ($this->get_option('itex_m_ilinks_aftercontent_enable'))
		{
			$l = explode("\n",stripslashes($this->get_option('itex_m_ilinks_aftercontent')));
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
		return true;
	}

	/**
   	* mainlink init
   	*
   	* @return  bool
   	*/
	function itex_init_mainlink()
	{
		if (!$this->get_option('itex_m_mainlink_enable')) return 0;
		if (!$this->get_option('itex_m_mainlink_mainlinkuser')) return 0;
		if (!defined('SECURE_CODE')) define('SECURE_CODE', $this->get_option('itex_m_mainlink_mainlinkuser'));
		else $this->error .= 'SECURE_CODE '.$this->__('already defined<br/>', 'iMoney');
		$this->itex_debug('MAINLINK_USER = '.$this->get_option('itex_m_mainlink_mainlinkuser'));



		$file = $this->document_root . '/mainlink_'.SECURE_CODE.'/ML.php';
		if (file_exists($file))
		{

			require_once($file);
		}
		else return 0;

		$mlcfg=array();
		if (preg_match('@1251@i', $this->encoding)) $mlcfg['charset'] = 'win';
		else $mlcfg['charset'] = 'utf';

		if ($this->get_option('itex_m_global_debugenable'))
		{
			$mlcfg['debugmode'] = 1;
		}

		//$mlcfg['is_mod_rewrite'] = 1;  //проверить че за нах
		//$mlcfg['redirect'] = 0;

		$mlcfg['uri'] = $this->safeurl;
		$ml->Set_Config($mlcfg);
		if ($this->get_option('itex_m_mainlink_enable'))
		{
			if ($this->get_option('itex_m_mainlink_links_beforecontent') == '0')
			{
				//$this->beforecontent = '';
			}
			else
			{
				$this->beforecontent .= '<div>'.$ml->Get_Links(intval($this->get_option('itex_m_mainlink_links_beforecontent'))).'</div>';
			}

			if ($this->get_option('itex_m_mainlink_links_aftercontent') == '0')
			{
				//$this->aftercontent = '';
			}
			else
			{
				$this->aftercontent .= '<div>'.$ml->Get_Links(intval($this->get_option('itex_m_mainlink_links_aftercontent'))).'</div>';
			}
			//}
			$countsidebar = $this->get_option('itex_m_mainlink_links_sidebar');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
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

			$countfooter = $this->get_option('itex_m_mainlink_links_footer');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
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
		if (!$this->get_option('itex_m_linkfeed_enable')) return 0;
		if (!defined('LINKFEED_USER')) define('LINKFEED_USER', $this->get_option('itex_m_linkfeed_linkfeeduser'));
		else $this->error .= 'LINKFEED_USER '.$this->__('already defined<br/>', 'iMoney');
		$this->itex_debug('LINKFEED_USER = '.$this->get_option('itex_m_linkfeed_linkfeeduser'));



		$file = $this->document_root . '/linkfeed_'.LINKFEED_USER.'/linkfeed.php';
		if (file_exists($file))
		{
			require_once($file);
		}
		else return 0;

		$o['charset'] = $this->encoding;
		$o['multi_site'] = true;
		if ($this->get_option('itex_m_global_debugenable'))
		{
			$o['force_show_code'] = 1;
			//$o['verbose'] = 1;  //в футере инфу выдаст
		}
		$linkfeed = new LinkfeedClient($o);

		if ($this->get_option('itex_m_linkfeed_enable'))
		{
			if ($this->get_option('itex_m_linkfeed_links_beforecontent') == '0')
			{
				//$this->beforecontent = '';
			}
			else
			{
				$this->beforecontent .= '<div>'.$linkfeed->return_links(intval($this->get_option('itex_m_linkfeed_links_beforecontent'))).'</div>';
			}

			if ($this->get_option('itex_m_linkfeed_links_aftercontent') == '0')
			{
				//$this->aftercontent = '';
			}
			else
			{
				$this->aftercontent .= '<div>'.$linkfeed->return_links(intval($this->get_option('itex_m_linkfeed_links_aftercontent'))).'</div>';
			}
			//}
			$countsidebar = $this->get_option('itex_m_linkfeed_links_sidebar');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
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

			$countfooter = $this->get_option('itex_m_linkfeed_links_footer');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
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
		if (!$this->get_option('itex_m_setlinks_enable')) return 0;
		if (!$this->get_option('itex_m_setlinks_setlinksuser')) return 0;

		$this->itex_debug('SETLINKS_USER = '.$this->get_option('itex_m_setlinks_setlinksuser'));
		$file = $this->document_root . '/setlinks_' . $this->get_option('itex_m_setlinks_setlinksuser') . '/slclient.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else return 0;

		if ($this->get_option('itex_m_setlinks_enable'))
		{
			$this->setlinks = new SLClient();

			$this->setlinks->Config->encoding = $this->encoding;
			//$this->setlinks->Config->show_comment = (bool)$this->get_option('itex_m_global_debugenable');
			$this->setlinks->Config->show_comment = true;
			$this->setlinks->Config->use_safe_method = (bool)$this->get_option('itex_m_setlinks_masking');

			$this->itex_init_setlinks_links();

			///check it
			$url = 1;
			if ($this->wordpress) if (is_object($GLOBALS['wp_rewrite'])) $url = url_to_postid($_SERVER['REQUEST_URI']);

			if (($url) || !$this->get_option('itex_setlinks_pages_enable'))
			{
				if ((bool)$this->get_option('itex_m_setlinks_links_beforecontent'))
				{
					$this->beforecontent .= '<div>'.$this->itex_m_get_links(intval($this->get_option('itex_m_setlinks_links_beforecontent'))).'</div>';
				}

				if ((bool)$this->get_option('itex_m_setlinks_links_aftercontent'))
				{
					$this->aftercontent .= '<div>'.$this->itex_m_get_links(intval($this->get_option('itex_m_setlinks_links_aftercontent'))).'</div>';
				}
			}

			$countsidebar = $this->get_option('itex_m_setlinks_links_sidebar');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check sidebar '.$countsidebar.'-->':'';
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
				$this->sidebar_links .= '<div>'.$this->itex_m_get_links(intval($countsidebar)).'</div>';
			}
			$this->sidebar_links = $check.$this->sidebar_links;

			//setlinks footer
			$countfooter = $this->get_option('itex_m_setlinks_setlinks_footer');
			$check = $this->get_option('itex_m_global_debugenable')?'<!---check footer '.$countfooter.'-->':'';
			$this->footer .= $check;
			if ($countfooter == 'max')
			{
				//$this->footer = '<div>'.$this->sape->GetLinks().'</div>';
			} elseif ($countfooter == '0') {
				//$this->footer = '';
			} else {
				$this->footer .= '<div>'.$this->itex_m_get_links($countfooter).'</div>';
			}
			$this->footer = $check.$this->footer;

			if (($countsidebar == 'max') && ($countfooter == 'max'))
			{
				$this->footer .= $this->itex_m_get_links();
			} else {
				if ($countsidebar == 'max')
				{
					$this->sidebar_links .= $this->itex_m_get_links();
				} else $this->footer .= $this->itex_m_get_links();
			}
		}

		if ($this->get_option('itex_m_setlinks_setlinkscontext_enable'))
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

	/** Output Functions  **/

	/**
   	* Footer output
   	*
   	*/
	function itex_m_footer()
	{
		echo $this->footer;
		//		if ($this->get_option('itex_m_php_enable') && $this->get_option('itex_m_php_footer_enable'))
		//		{
		//			$code = $this->get_option('itex_m_php_footer');
		//			if (strlen($code)>1) eval($code);
		//		}

		if ($this->get_option('itex_m_global_debugenable'))
		{
			//echo 'is_user_logged_in'.intval(is_user_logged_in()).'_'.intval($this->get_option('itex_m_global_debugenable_forall'));//die();
			//echo 'reqweqweqweqweqwe';//die();
			if ((intval(is_user_logged_in())) || intval($this->get_option('itex_m_global_debugenable_forall')))
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

		//if ($this->get_option('itex_m_sape_sapearticles_enable'))
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
		if ($this->get_option('itex_m_sape_sapecontext_enable'))
		{
			if (url_to_postid($_SERVER['REQUEST_URI']) || !$this->get_option('itex_sape_pages_enable'))
			{
				//if (defined('_SAPE_USER') || is_object($this->sapecontext))
				if (is_object($this->sapecontext))
				{
					$content = $this->sapecontext->replace_in_text_segment($content);
					if ($this->get_option('itex_m_global_debugenable'))
					{
						$content = '<!---checkcontext_start-->'.$content.'<!---checkcontext_stop-->';
					}
					$this->itex_debug('sapecontext worked');
				}
				else $this->itex_debug('$this->sapecontext not object');
			}
			else $this->itex_debug('url_to_postid='.url_to_postid($_SERVER['REQUEST_URI']).' itex_sape_pages_enable='.$this->get_option('itex_sape_pages_enable'));
		}
		else $this->itex_debug('sapecontext disabled');


		if ((strlen($this->beforecontent)) || (strlen($this->aftercontent)))
		{
			if ($this->get_option('itex_m_global_debugenable'))
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
		$title = $this->get_option("itex_m_widget_dynamic_title");
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
		$title = $this->get_option("itex_m_widget_dynamic_title");
		//$itex = array('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>','<a href="http://itex.name/" title="itex">itex</a>');

		//		$title_links = $this->get_option("itex_m_widget_links_title");
		//		if ((!eregi('itex.name',$title_links)) || empty($title_links)) $itex = array('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>','<a href="http://itex.name/" title="itex">itex</a>');
		//		else $itex = array('','');
		//$title = empty($title) ? $itex[rand(0,count($itex)-1)] :$title;
		if ($_POST['itex_m_widget_dynamic_Submit'])
		{
			//$title = htmlspecialchars($_POST['itex_m_widget_title']);
			$title = stripslashes($_POST['itex_m_widget_dynamic_title']);
			$this->update_option("itex_m_widget_dynamic_title", $title);
		}
		echo '
  			<p>
    			<label for="itex_m_widget_dynamic">'.$this->__('Widget Title: ', 'iMoney').'</label>
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
		$title = $this->get_option("itex_m_widget_links_title");
		//$title = empty($title) ? urlencode('<a href="http://itex.name" title="iMoney">iMoney</a>') :$title;
		$itex = array('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>','<a href="http://itex.name/" title="itex">itex</a>');
		if (empty($title))
		{
			$title = $itex[rand(0,count($itex)-1)];
			$this->update_option("itex_m_widget_links_title", $title);
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
		$title = $this->get_option("itex_m_widget_links_title");
		$itex = array('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>','<a href="http://itex.name/" title="itex">itex</a>');
		$title = empty($title) ? $itex[rand(0,count($itex)-1)] :$title;
		if ($_POST['itex_m_widget_links_Submit'])
		{
			//$title = htmlspecialchars($_POST['itex_m_widget_title']);
			$title = stripslashes($_POST['itex_m_widget_links_title']);
			$this->update_option("itex_m_widget_links_title", $title);
		}
		echo '
  			<p>
    			<label for="itex_m_widget_links">'.$this->__('Widget Title: ', 'iMoney').'</label>
    			<textarea name="itex_m_widget_links_title" id="itex_m_widget_links" rows="1" cols="20">'.$title.'</textarea>
    			<input type="hidden" id="" name="itex_m_widget_links_Submit" value="1" />
  			</p>';
		//print_r($this->debuglog);//die();
	}

	/** Admin Functions  **/


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
		if ($this->wordpress)
		{
			if (!is_admin()) return 0;
		}

		//$this->lang_ru();
		$this->itex_m_admin_css();
		// Output the options page
		?>
		<div class="wrap">
		
			<form method="post">
			<h2><?php echo $this->__('iMoney Options', 'iMoney');?></h2>
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
				<a href="http://itex.name/go.php?http://itex.name/donation">'.$this->__('Create and maintain a plugin take lot\'s of time. If you enjoy this plugin, do a Donation.', 'iMoney').'</div>';
			}

			?>		
			
			
			
			                       
       			<!-- Main -->
        		
        			<?php 
        			?>
        		<ul style="text-align: center;font-weight: bold;font-size: 14px;">
        			<li style="display: inline;"><a href="#itex_global" onclick='document.getElementById("itex_global").style.display="";'>Global</a></li>
        			<li style="display: inline;"><a href="#itex_adsense" onclick='document.getElementById("itex_adsense").style.display="";'>Adsense</a></li>
        			<li style="display: inline;"><a href="#itex_begun" onclick='document.getElementById("itex_begun").style.display="";'>Begun</a></li>
        			<li style="display: inline;"><a href="#itex_html" onclick='document.getElementById("itex_html").style.display="";'>Html</a></li>
        			<li style="display: inline;"><a href="#itex_ilinks" onclick='document.getElementById("itex_ilinks").style.display="";'>iLinks</a></li>
        			<li style="display: inline;"><a href="#itex_php" onclick='document.getElementById("itex_php").style.display="";'>Php</a></li>
        			<li style="display: inline;"><a href="#itex_sape" onclick='document.getElementById("itex_sape").style.display="";'>Sape</a></li>
        			<li style="display: inline;"><a href="#itex_trustlink" onclick='document.getElementById("itex_trustlink").style.display="";'>Trustlink</a></li>
        			<li style="display: inline;"><a href="#itex_tnx" onclick='document.getElementById("itex_tnx").style.display="";'>Tnx/Xap</a></li>
        			<li style="display: inline;"><a href="#itex_mainlink" onclick='document.getElementById("itex_mainlink").style.display="";'>MainLink</a></li>
        			<li style="display: inline;"><a href="#itex_linkfeed" onclick='document.getElementById("itex_linkfeed").style.display="";'>Linkfeed</a></li>
        			<li style="display: inline;"><a href="#itex_adskape" onclick='document.getElementById("itex_adskape").style.display="";'>Adskape</a></li>
        			<li style="display: inline;"><a href="#itex_setlinks" onclick='document.getElementById("itex_setlinks").style.display="";'>SetLinks</a></li>
        			<li style="display: inline;"><a href="#itex_teasernet" onclick='document.getElementById("itex_teasernet").style.display="";'>Teasernet</a></li>
        			<li style="display: inline;"><a href="#itex_zilla" onclick='document.getElementById("itex_zilla").style.display="";'>Serpzilla</a></li>
        				
        		</ul>
        		<p class="submit">
				<input type='submit' name='info_update' value='<?php echo $this->__('Save Changes', 'iMoney'); ?>' />
				</p>
				
        		<h3><a href="#itex_global" name="itex_global" onclick='document.getElementById("itex_global").style.display="";'>Global</a></h3>
       	 		<div id="itex_global"><?php $this->itex_m_admin_global(); ?></div>
       	 		
        		<h3><a href="#itex_adsense" name="itex_adsense" onclick='document.getElementById("itex_adsense").style.display="";'>Adsense</a></h3>
       	 		<div id="itex_adsense" ><?php $this->itex_m_admin_adsense(); ?></div>
       	 		
       	 		<h3><a href="#itex_begun" name="itex_begun" onclick='document.getElementById("itex_begun").style.display="";'>Begun</a></h3>
       	 		<div id="itex_begun"><?php $this->itex_m_admin_begun(); ?></div>
       	 		
       	 		<h3><a href="#itex_html" name="itex_html" onclick='document.getElementById("itex_html").style.display="";'>Html</a></h3>
       	 		<div id="itex_html"><?php $this->itex_m_admin_html(); ?></div>
       	 		
       	 		<h3><a href="#itex_ilinks" name="itex_ilinks" onclick='document.getElementById("itex_ilinks").style.display="";'>iLinks</a></h3>
       	 		<div id="itex_ilinks"><?php $this->itex_m_admin_ilinks(); ?></div>
       	 		
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
       	 		
       	 		<h3><a href="#itex_linkfeed" name="itex_linkfeed" onclick='document.getElementById("itex_linkfeed").style.display="";'>Linkfeed</a></h3>
       	 		<div id="itex_linkfeed"><?php $this->itex_m_admin_linkfeed(); ?></div>
       	 		
       	 		<h3><a href="#itex_adskape" name="itex_adskape" onclick='document.getElementById("itex_adskape").style.display="";'>Adskape</a></h3>
       	 		<div id="itex_adskape"><?php $this->itex_m_admin_adskape(); ?></div>
       	 		
       	 		<h3><a href="#itex_setlinks" name="itex_setlinks" onclick='document.getElementById("itex_setlinks").style.display="";'>SetLinks</a></h3>
       	 		<div id="itex_setlinks"><?php $this->itex_m_admin_setlinks(); ?></div>
       	 		
       	 		<h3><a href="#itex_teasernet" name="itex_teasernet" onclick='document.getElementById("itex_teasernet").style.display="";'>Teasernet</a></h3>
       	 		<div id="itex_teasernet"><?php $this->itex_m_admin_teasernet(); ?></div>
       	 		
       	 		<h3><a href="#itex_zilla" name="itex_zilla" onclick='document.getElementById("itex_zilla").style.display="";'>Serpzilla</a></h3>
       	 		<div id="itex_zilla"><?php $this->itex_m_admin_zilla(); ?></div>
       	 		
       	 		<?php 
       	 		if(!$this->get_option('itex_m_global_collapse')){ ?>
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
       	 		document.getElementById("itex_zilla").style.display="none";
       	 		document.getElementById("itex_global").style.display="none";
       	 		</script>	
       	 		<?php } ?>
			</div>
			
			<p class="submit">
				<input type='submit' name='info_update' value='<?php echo $this->__('Save Changes', 'iMoney'); ?>' />
			</p>
			
			<ul style="text-align: center;font-weight: bold;font-size: 14px;">
        			<li style="display: inline;"><a href="#itex_global" onclick='document.getElementById("itex_global").style.display="";'>Global</a></li>
        			<li style="display: inline;"><a href="#itex_adsense" onclick='document.getElementById("itex_adsense").style.display="";'>Adsense</a></li>
        			<li style="display: inline;"><a href="#itex_begun" onclick='document.getElementById("itex_begun").style.display="";'>Begun</a></li>
        			<li style="display: inline;"><a href="#itex_html" onclick='document.getElementById("itex_html").style.display="";'>Html</a></li>
        			<li style="display: inline;"><a href="#itex_ilinks" onclick='document.getElementById("itex_ilinks").style.display="";'>iLinks</a></li>
        			<li style="display: inline;"><a href="#itex_php" onclick='document.getElementById("itex_php").style.display="";'>Php</a></li>
        			<li style="display: inline;"><a href="#itex_sape" onclick='document.getElementById("itex_sape").style.display="";'>Sape</a></li>
        			<li style="display: inline;"><a href="#itex_trustlink" onclick='document.getElementById("itex_trustlink").style.display="";'>Trustlink</a></li>
        			<li style="display: inline;"><a href="#itex_tnx" onclick='document.getElementById("itex_tnx").style.display="";'>Tnx/Xap</a></li>
        			<li style="display: inline;"><a href="#itex_mainlink" onclick='document.getElementById("itex_mainlink").style.display="";'>MainLink</a></li>
        			<li style="display: inline;"><a href="#itex_linkfeed" onclick='document.getElementById("itex_linkfeed").style.display="";'>Linkfeed</a></li>
        			<li style="display: inline;"><a href="#itex_adskape" onclick='document.getElementById("itex_adskape").style.display="";'>Adskape</a></li>
        			<li style="display: inline;"><a href="#itex_setlinks" onclick='document.getElementById("itex_setlinks").style.display="";'>SetLinks</a></li>
        			<li style="display: inline;"><a href="#itex_teasernet" onclick='document.getElementById("itex_teasernet").style.display="";'>Teasernet</a></li>
        			<li style="display: inline;"><a href="#itex_zilla" onclick='document.getElementById("itex_zilla").style.display="";'>Serpzilla</a></li>
        		
        	</ul>
        	<p align="center">
        		<a href="http://itex.name/plugins/faq-po-imoney-i-isape.html">FAQ по iMoney и iSape</a>
			</p>	
			<p align="center">
				<?php echo $this->__("Powered by ",'iMoney')."<a href='http://itex.name' title='iTex iMoney'>iTex iMoney</a> ".$this->__("Version:",'iMoney').$this->version; ?>
			</p>				
			</form>
		
		</div>
		<?php
		//phpinfo();
		return true;
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
   	* Admin menu input
   	*
   	*/
	function itex_m_admin_input($name,$description)
	{
		//if (!is_admin()) return 0;
		if (isset($_POST['info_update']))
		{
			if (isset($_POST[$name]))
			{
				$this->update_option($name, $_POST[$name]);
			}
		}
		echo '<input type="text" size="50" ';
		echo 'name="'.$name.'" ';
		echo 'id="'.$name.'" ';
		echo 'value="'.$this->get_option($name).'" />'."\n";
		echo '<p style="margin: 5px 10px;">'.$description.'</p>';

	}

	/**
   	* Admin menu input
   	*
   	*/
	function itex_m_admin_select($name,$options,$description)
	{
		//if (!is_admin()) return 0;
		if (isset($_POST['info_update']))
		{
			if (isset($_POST[$name]))
			{
				$this->update_option($name, $_POST[$name]);
			}
		}

		echo '<select name="'.$name.'" id="'.$name.'">'."\n";

		foreach ($options as $k=>$v)
		{
			echo '<option value="'.$k.'"';
			if($this->get_option($name) == $k) echo ' selected="selected"';
			echo ">".$v."</option>\n";
		}
		echo "</select>\n";

		echo '<label for="">'.$description.'.</label>';

		echo "<br/>";
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
				$this->update_option('itex_m_global_debugenable', intval($_POST['global_debugenable']));
			}

			if (isset($_POST['global_debugenable_forall']))
			{
				$this->update_option('itex_m_global_debugenable_forall', intval($_POST['global_debugenable_forall']));
			}

			if (isset($_POST['global_masking']))
			{
				$this->update_option('itex_m_global_masking', intval($_POST['global_masking']));
			}

			if (isset($_POST['global_collapse']))
			{
				$this->update_option('itex_m_global_collapse', !intval($_POST['global_collapse']));
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
						<label for=""><?php echo $this->__('Masking of links', 'iMoney'); ?>:</label>
					</th>
					<td>
						<?php




						$o= array('1' => $this->__('Enabled', 'iMoney'),'0' => $this->__('Disabled', 'iMoney'),);
						$d = $this->__('Masking of links', 'iMoney');
						$this->itex_m_admin_select('itex_m_global_masking', $o, $d);
						/*
						echo "<select name='global_masking' id='global_masking'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_global_masking')) echo " selected='selected'";
						echo $this->__(">Enabled</option>\n", 'iSape');

						echo "<option value='0'";
						if(!$this->get_option('itex_m_global_masking')) echo" selected='selected'";
						echo $this->__(">Disabled</option>\n", 'iSape');
						echo "</select>\n";

						echo '<label for="">'.$this->__('Masking of links', 'iMoney').'.</label>';*/

						?>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Global debug:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						$o= array('1' => $this->__('Enabled', 'iMoney'),'0' => $this->__('Disabled', 'iMoney'),);
						$d = $this->__('Debug log in footer. For see debug user must register', 'iMoney');
						$this->itex_m_admin_select('itex_m_global_debugenable', $o, $d);

						/*echo "<select name='global_debugenable' id='global_debugenable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_global_debugenable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_global_debugenable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Debug log in footer. For see debug user must register', 'iMoney').'.</label>';

						echo "<br/>";*/

						$o= array('1' => $this->__('Enabled', 'iMoney'),'0' => $this->__('Disabled', 'iMoney'),);
						$d = $this->__('Debug log in footer for all, who open the site. Dont leave this parameter switched Enabled for a long time, because in this case it will disclose your private data like SAPE UID', 'iMoney');
						$this->itex_m_admin_select('itex_m_global_debugenable_forall', $o, $d);

						/*	echo "<select name='global_debugenable_forall' id='global_debugenable_forall'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_global_debugenable_forall')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_global_debugenable_forall')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Debug log in footer for all, who open the site. Dont leave this parameter switched Enabled for a long time, because in this case it will disclose your private data like SAPE UID', 'iMoney').'.</label>';
						*/
						?>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Widgets settings:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						if ($this->wordpress)
						{
							$ws = wp_get_sidebars_widgets();

							//вывод селектов не через функцию
							echo "<select name='global_widget_links' id='global_widget_links'>\n";
							echo "<option value='0'";
							if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
							echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

							echo "<option value='1'";
							if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
							echo ">".$this->__('Active','iMoney')."</option>\n";

							echo "</select>\n";

							echo '<label for="">'.$this->__('Widget Links Active', 'iMoney').'</label>';

							echo "<br/>\n";

							echo "<select name='global_widget_dynamic' id='global_widget_dynamic'>\n";
							echo "<option value='0'";
							if (count($ws['sidebar-1'])) if(!in_array('imoney-dynamic',$ws['sidebar-1'])) echo" selected='selected'";
							echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

							echo "<option value='1'";
							if (count($ws['sidebar-1'])) if (in_array('imoney-dynamic',$ws['sidebar-1'])) echo " selected='selected'";
							echo ">".$this->__('Active','iMoney')."</option>\n";

							echo "</select>\n";

							echo '<label for="">'.$this->__('Widget Dynamic Active', 'iMoney').'</label>';
						}
						?>
					</td>
				</tr>
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Collapse headlines settings:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						$o= array('1' => $this->__('Enabled', 'iMoney'),'0' => $this->__('Disabled', 'iMoney'),);
						$d = '';
						$this->itex_m_admin_select('itex_m_global_collapse', $o, $d);

						/*echo "<select name='global_collapse' id='global_collapse'>\n";
						echo "<option value='1'";

						if(!$this->get_option('itex_m_global_collapse')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if($this->get_option('itex_m_global_collapse')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";*/


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
			//if (!$this->isape_converted) //для совместимомти с isape, через несколько месяцев надо удалить
			//{
			//	$this->update_option('itex_m_isape_converted', 1);
			//}


			//phpinfo();die();
			if (isset($_POST['sape_sapeuser']))
			{
				$this->update_option('itex_m_sape_sapeuser', trim($_POST['sape_sapeuser']));
			}
			if (isset($_POST['sape_enable']))
			{
				$this->update_option('itex_m_sape_enable', intval($_POST['sape_enable']));
			}

			if (isset($_POST['sape_links_beforecontent']))
			{
				$this->update_option('itex_m_sape_links_beforecontent', $_POST['sape_links_beforecontent']);
			}

			if (isset($_POST['sape_links_aftercontent']))
			{
				$this->update_option('itex_m_sape_links_aftercontent', $_POST['sape_links_aftercontent']);
			}

			if (isset($_POST['sape_links_sidebar']))
			{
				$this->update_option('itex_m_sape_links_sidebar', $_POST['sape_links_sidebar']);
			}

			if (isset($_POST['sape_links_footer']))
			{
				$this->update_option('itex_m_sape_links_footer', $_POST['sape_links_footer']);
			}

			

			if (isset($_POST['sape_sapecontext_enable']) )
			{
				$this->update_option('itex_m_sape_sapecontext_enable', intval($_POST['sape_sapecontext_enable']));
			}

			if (isset($_POST['sape_sapecontext_pages_enable']) )
			{
				$this->update_option('itex_m_sape_sapecontext_pages_enable', intval($_POST['sape_sapecontext_pages_enable']));
			}

			if (isset($_POST['sape_pages_enable']) )
			{
				$this->update_option('itex_m_sape_pages_enable', intval($_POST['sape_pages_enable']));
			}


			if (isset($_POST['itex_m_sape_sapearticles_enable']) )
			{
				$this->update_option('itex_m_sape_sapearticles_enable', intval($_POST['itex_m_sape_sapearticles_enable']));
			}
			if (isset($_POST['itex_m_sape_sapearticles_template_url']) )
			{
				$this->update_option('itex_m_sape_sapearticles_template_url', $_POST['itex_m_sape_sapearticles_template_url']);
			}
			if (isset($_POST['itex_m_sape_sapearticles_beforecontent']))
			{
				$this->update_option('itex_m_sape_sapearticles_beforecontent', $_POST['itex_m_sape_sapearticles_beforecontent']);
			}

			if (isset($_POST['itex_m_sape_sapearticles_aftercontent']))
			{
				$this->update_option('itex_m_sape_sapearticles_aftercontent', $_POST['itex_m_sape_sapearticles_aftercontent']);
			}

			if (isset($_POST['itex_m_sape_sapearticles_sidebar']))
			{
				$this->update_option('itex_m_sape_sapearticles_sidebar', $_POST['itex_m_sape_sapearticles_sidebar']);
			}

			if (isset($_POST['itex_m_sape_sapearticles_footer']))
			{
				$this->update_option('itex_m_sape_sapearticles_footer', $_POST['itex_m_sape_sapearticles_footer']);
			}
			if (isset($_POST['itex_m_sape_sapearticles_pages_enable']) )
			{
				$this->update_option('itex_m_sape_sapearticles_pages_enable', intval($_POST['itex_m_sape_sapearticles_pages_enable']));
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
			if ($this->get_option('itex_m_sape_sapeuser'))  $this->itex_m_sape_install_file();
		}
		if ($this->get_option('itex_m_sape_sapeuser'))
		{
			$file = $this->document_root . '/' . _SAPE_USER . '/sape.php'; //<< Not working in multihosting.
			if (file_exists($file)) {}
			else
			{
				$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.$this->get_option('itex_m_sape_sapeuser').'/sape.php';
				if (file_exists($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				Sape dir not exist!
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				Create new sapedir and sape.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='sape_sapedir_create' value='<?php echo $this->__('Create', 'iMoney'); ?>' />
				</p>
				<?php
				//if (!$this->get_option('itex_m_sape_sapeuser')) echo $this->__('Enter your SAPE UID in this box!', 'iMoney');
				if (!$this->get_option('itex_m_sape_sapeuser')) echo '<a target="_blank" href="http://itex.name/go.php?http://www.sape.ru/r.a5a429f57e.php">'.$this->__('Enter your SAPE UID in this box.', 'iMoney').'</a>';

				?>
		</div>
		
		<?php }
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your SAPE UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='sape_sapeuser'";
						echo "id='sapeuser' ";
						echo "value='".$this->get_option('itex_m_sape_sapeuser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php 
						//echo $this->__('Enter your SAPE UID in this box.', 'iMoney');
						echo '<a target="_blank" href="http://itex.name/go.php?http://www.sape.ru/r.a5a429f57e.php">'.$this->__('Enter your SAPE UID in this box!', 'iMoney').'</a>';

						?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Sape links:', 'iMoney');?></label>
					</th>
					<td>
						<?php

						$o= array('1' => $this->__('Enabled', 'iMoney'),'0' => $this->__('Disabled', 'iMoney'),);
						$d = $this->__("Working", 'iMoney');
						$this->itex_m_admin_select('itex_m_sape_enable', $o, $d);

						/*echo "<select name='sape_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_sape_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";*/

						$o = array('0' => $this->__('Disabled', 'iMoney'),'1' => '1','2' => '2','3' => '3','4' => '4','5' => '5',);
						$d = $this->__('Before content links', 'iMoney');
						$this->itex_m_admin_select('itex_m_sape_links_beforecontent', $o, $d);

						/*echo "<select name='sape_links_beforecontent' id='sape_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_links_beforecontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_sape_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_sape_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_sape_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_sape_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_sape_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";
						*/

						$o = array('0' => $this->__('Disabled', 'iMoney'),'1' => '1','2' => '2','3' => '3','4' => '4','5' => '5',);
						$d = $this->__('After content links', 'iMoney');
						$this->itex_m_admin_select('itex_m_sape_links_aftercontent', $o, $d);
						/*

						echo "<select name='sape_links_aftercontent' id='sape_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_links_aftercontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_sape_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_sape_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_sape_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_sape_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_sape_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";*/

						$o = array('0' => $this->__('Disabled', 'iMoney'),'1' => '1','2' => '2','3' => '3','4' => '4','5' => '5','max' => $this->__('Max', 'iMoney'),);
						$d = $this->__('Sidebar links', 'iMoney');
						$this->itex_m_admin_select('itex_m_sape_links_sidebar', $o, $d);

						/*echo "<select name='sape_links_sidebar' id='sape_links_sidebar'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_links_sidebar')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_sape_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_sape_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_sape_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_sape_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_sape_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_sape_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";*/

						$o = array('0' => $this->__('Disabled', 'iMoney'),'1' => '1','2' => '2','3' => '3','4' => '4','5' => '5','max' => $this->__('Max', 'iMoney'),);
						$d = $this->__('Footer links', 'iMoney');
						$this->itex_m_admin_select('itex_m_sape_links_footer', $o, $d);

						/*echo "<select name='sape_links_footer' id='sape_links_footer'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_links_footer')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_sape_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_sape_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_sape_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_sape_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_sape_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_sape_links_footer') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Footer links', 'iMoney').'</label>';

						echo "<br/>\n";*/

						$o= array('1' => $this->__('Enabled', 'iMoney'),'0' => $this->__('Disabled', 'iMoney'),);
						$d = $this->__('Show content links only on Pages and Posts.', 'iMoney');
						$this->itex_m_admin_select('itex_m_sape_pages_enable', $o, $d);

						/*echo "<select name='sape_pages_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_sape_pages_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_pages_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";*/
						?>
					</td>
					
					
				</tr>
				<?php 
				?>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Sape context:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						echo "<select name='sape_sapecontext_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_sape_sapecontext_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_sapecontext_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Context', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='sape_sapecontext_pages_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_sape_sapecontext_pages_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_sapecontext_pages_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Show context only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><a href="http://articles.sape.ru/r.a5a429f57e.php"><?php echo $this->__('Sape articles:', 'iMoney'); ?></a></label>
					</th>
					<td>
						<?php
						echo "<select name='itex_m_sape_sapearticles_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_sape_sapearticles_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_sapearticles_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for=""><a href="http://articles.sape.ru/r.a5a429f57e.php">'.$this->__('Articles', 'iMoney').'</a></label>';

						echo "<br/>\n";

						echo "<input type='text' size='100' ";
						echo "name='itex_m_sape_sapearticles_template_url'";
						echo "value='".$this->get_option('itex_m_sape_sapearticles_template_url')."' />\n";
						echo '<label for="">'.$this->__('Sapearticles moderation url', 'iMoney').'</label>';
						echo "<br/>\n";



						echo "<select name='itex_m_sape_sapearticles_beforecontent' id='itex_m_sape_sapearticles_beforecontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_sapearticles_beforecontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_sape_sapearticles_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_sape_sapearticles_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_sape_sapearticles_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_sape_sapearticles_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_sape_sapearticles_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='itex_m_sape_sapearticles_aftercontent' id='itex_m_sape_sapearticles_aftercontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_sapearticles_aftercontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_sape_sapearticles_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_sape_sapearticles_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_sape_sapearticles_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_sape_sapearticles_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_sape_sapearticles_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='itex_m_sape_sapearticles_sidebar' id='itex_m_sape_sapearticles_sidebar'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_sapearticles_sidebar')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_sape_sapearticles_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_sape_sapearticles_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_sape_sapearticles_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_sape_sapearticles_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_sape_sapearticles_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_sape_sapearticles_sidebar') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='itex_m_sape_sapearticles_footer' id='itex_m_sape_sapearticles_footer'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_sapearticles_footer')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_sape_sapearticles_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_sape_sapearticles_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_sape_sapearticles_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_sape_sapearticles_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_sape_sapearticles_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_sape_sapearticles_footer') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Footer links', 'iMoney').'</label>';

						echo "<br/>\n";
						echo "<select name='itex_m_sape_sapearticles_pages_enable' id='sape_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_sape_sapearticles_pages_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_sape_sapearticles_pages_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";

						//если есть сапеуид, то выводим примерный урл
						if ($this->get_option('itex_m_sape_sapeuser'))
						{
							echo '<label for="">'.$this->__('Sapearticles url template  ', 'iMoney').'</label>';
							echo "<br/>\n";
							echo '<label for=""><a href="/itex_sape_articles_template.'.$this->get_option('itex_m_sape_sapeuser').'.html">/itex_sape_articles_template.'.$this->get_option('itex_m_sape_sapeuser').'.html</a></label>';
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
						<a target="_blank" href="http://itex.name/go.php?http://www.sape.ru/r.a5a429f57e.php">www.sape.ru</a>
						<br/>
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
		$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.$this->get_option('itex_m_sape_sapeuser').'/sape.php';

		$dir = dirname($file);
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create Sape dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$sape_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create sape.php!', 'iMoney').'
		</div>';
			return 0;
		}
		//chmod($file, 0777);
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.$this->__('Sapedir and sape.php created!', 'iMoney').'
		</div>';
		//die();
		return 1;
	}

	/**
   	* Serpzilla section admin menu
   	*
   	*/
	function itex_m_admin_zilla()
	{
		if (isset($_POST['info_update']))
		{
			if (isset($_POST['itex_m_zilla_user']))
			{
				$this->update_option('itex_m_zilla_user', trim($_POST['itex_m_zilla_user']));
			}
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}

		////////////////////////////////////////////////////////////////////////////////////////

		if (isset($_POST['itex_m_zilla_dir_create']))
		{
			if ($this->get_option('itex_m_zilla_user'))  $this->itex_m_zilla_install_file();
		}

		if ($this->get_option('itex_m_zilla_user'))
		{
			$file = $this->document_root . '/' . _ZILLA_USER . '/zilla.php'; //<< Not working in multihosting.
			if (file_exists($file)) {}
			else
			{
				$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.$this->get_option('itex_m_zilla_user').'/zilla.php';
				if (file_exists($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				Serpzilla <?php echo $this->__('dir not exist!', 'iMoney'); ?>
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				<?php echo $this->__('Create new dir and', 'iMoney'); ?> zilla.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='itex_m_zilla_dir_create' value='<?php echo $this->__('Create', 'iMoney'); ?>' />
				</p>
				<?php
				if (!$this->get_option('itex_m_zilla_user')) echo '<a target="_blank" href="http://itex.name/go.php?http://beta.serpzilla.com/r/mbaJymKyWl/">'.$this->__('Enter your Serpzilla UID in this box.', 'iMoney').'</a>';

				?>
		</div>
		
		<?php }
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your Serpzilla UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='itex_m_zilla_user'";
						echo "id='itex_m_zilla_user' ";
						echo "value='".$this->get_option('itex_m_zilla_user')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php 

						echo '<a target="_blank" href="http://itex.name/go.php?http://beta.serpzilla.com/r/mbaJymKyWl/">'.$this->__('Enter your Serpzilla UID in this box!', 'iMoney').'</a>';

						?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Serpzilla links:', 'iMoney');?></label>
					</th>
					<td>
						<?php

						$o= array('1' => $this->__('Enabled', 'iMoney'),'0' => $this->__('Disabled', 'iMoney'),);
						$d = $this->__("Working", 'iMoney');
						$this->itex_m_admin_select('itex_m_zilla_enable', $o, $d);

						$o = array('0' => $this->__('Disabled', 'iMoney'),'1' => '1','2' => '2','3' => '3','4' => '4','5' => '5',);
						$d = $this->__('Before content links', 'iMoney');
						$this->itex_m_admin_select('itex_m_zilla_links_beforecontent', $o, $d);



						$o = array('0' => $this->__('Disabled', 'iMoney'),'1' => '1','2' => '2','3' => '3','4' => '4','5' => '5',);
						$d = $this->__('After content links', 'iMoney');
						$this->itex_m_admin_select('itex_m_zilla_links_aftercontent', $o, $d);


						$o = array('0' => $this->__('Disabled', 'iMoney'),'1' => '1','2' => '2','3' => '3','4' => '4','5' => '5','max' => $this->__('Max', 'iMoney'),);
						$d = $this->__('Sidebar links', 'iMoney');
						$this->itex_m_admin_select('itex_m_zilla_links_sidebar', $o, $d);


						$o = array('0' => $this->__('Disabled', 'iMoney'),'1' => '1','2' => '2','3' => '3','4' => '4','5' => '5','max' => $this->__('Max', 'iMoney'),);
						$d = $this->__('Footer links', 'iMoney');
						$this->itex_m_admin_select('itex_m_zilla_links_footer', $o, $d);


						$o= array('1' => $this->__('Enabled', 'iMoney'),'0' => $this->__('Disabled', 'iMoney'),);
						$d = $this->__('Show content links only on Pages and Posts.', 'iMoney');
						$this->itex_m_admin_select('itex_m_zilla_pages_enable', $o, $d);

						?>
					</td>
					
					
				</tr>
								
				
				
				
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" href="http://itex.name/go.php?http://beta.serpzilla.com/r/mbaJymKyWl/">www.serpzilla.com</a>
						<br/>
						<a target="_blank" href="http://itex.name/go.php?http://beta.serpzilla.com/r/mbaJymKyWl/"><img src="http://img.sape.ru/bn/sape_001.gif" alt="www.sape.ru!" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php
	}

	/**
   	* Serpzilla file installation
   	*
   	* @return  bool
   	*/
	function itex_m_zilla_install_file()
	{
		//file zilla.php from beta.serpzilla.com (v 0.2, 22.04.2011) 19.05.2011
		$sape_php_content = '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';
		$sape_php_content = gzuncompress(base64_decode($sape_php_content));
		$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.$this->get_option('itex_m_zilla_user').'/zilla.php';

		$dir = dirname($file);
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create Serpzilla dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$sape_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create', 'iMoney').' zilla.php!
		</div>';
			return 0;
		}
		//chmod($file, 0777);
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.$this->__('Serpzilla dir and zilla.php created!', 'iMoney').'
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
				$this->update_option('itex_m_trustlink_user', trim($_POST['itex_m_trustlink_user']));
			}
			if (isset($_POST['itex_m_trustlink_enable']))
			{
				$this->update_option('itex_m_trustlink_enable', intval($_POST['itex_m_trustlink_enable']));
			}

			if (isset($_POST['itex_m_trustlink_links_beforecontent']))
			{
				$this->update_option('itex_m_trustlink_links_beforecontent', $_POST['itex_m_trustlink_links_beforecontent']);
			}

			if (isset($_POST['itex_m_trustlink_links_aftercontent']))
			{
				$this->update_option('itex_m_trustlink_links_aftercontent', $_POST['itex_m_trustlink_links_aftercontent']);
			}

			if (isset($_POST['itex_m_trustlink_links_sidebar']))
			{
				$this->update_option('itex_m_trustlink_links_sidebar', $_POST['itex_m_trustlink_links_sidebar']);
			}

			if (isset($_POST['itex_m_trustlink_links_footer']))
			{
				$this->update_option('itex_m_trustlink_links_footer', $_POST['itex_m_trustlink_links_footer']);
			}
			if (isset($_POST['itex_m_trustlink_pages_enable']) )
			{
				$this->update_option('itex_m_trustlink_pages_enable', intval($_POST['itex_m_trustlink_pages_enable']));
			}


			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		if (isset($_POST['itex_m_trustlink_dir_create']))
		{
			if ($this->get_option('itex_m_trustlink_user'))  $this->itex_m_trustlink_install_file();
		}
		if ($this->get_option('itex_m_trustlink_user'))
		{
			$file = $this->document_root . '/' . $this->get_option('itex_m_trustlink_user') . '/trustlink.php'; //<< Not working in multihosting.
			if (file_exists($file))
			{
				?>
				<div style="margin:10px auto; padding:10px; text-align:center;">
				<?php echo $this->__('Update from plagin', 'iMoney');?> trustlink.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='itex_m_trustlink_dir_create' value='<?php echo $this->__('Update', 'iMoney'); ?>' />
				</p>
				</div>
				<?php 
			}
			else
			{
				$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.$this->get_option('itex_m_trustlink_user').'/trustlink.php';
				if (file_exists($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				Trustlink <?php echo $this->__('dir not exist!', 'iMoney');?> 
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				<?php echo $this->__('Create new dir and', 'iMoney');?> trustlink.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='itex_m_trustlink_dir_create' value='<?php echo $this->__('Create', 'iMoney'); ?>' />
				</p>
				<?php
				//if (!$this->get_option('itex_m_trustlink_sapeuser')) echo $this->__('Enter your Trustlink UID in this box!', 'iMoney');
				if (!$this->get_option('itex_m_trustlink_sapeuser')) echo '<a target="_blank" href="http://itex.name/go.php?http://trustlink.ru/registration/106535">'.$this->__('Enter your Trustlink UID in this box!', 'iMoney').'</a>';


				?>
		</div>
		
		<?php }
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your Trustlink UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='itex_m_trustlink_user'";
						echo "id='user' ";
						echo "value='".$this->get_option('itex_m_trustlink_user')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php 
						//echo $this->__('Enter your Trustlink UID in this box.', 'iMoney');
						echo '<a target="_blank" href="http://itex.name/go.php?http://trustlink.ru/registration/106535">'.$this->__('Enter your Trustlink UID in this box.', 'iMoney').'</a>';

						?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Trustlink links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='itex_m_trustlink_enable' id='itex_m_trustlink_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_trustlink_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_trustlink_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='itex_m_trustlink_links_beforecontent' id='itex_m_trustlink_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_trustlink_links_beforecontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_trustlink_links_beforecontent') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='itex_m_trustlink_links_aftercontent' id='itex_m_trustlink_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_trustlink_links_aftercontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_trustlink_links_aftercontent') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='itex_m_trustlink_links_sidebar' id='itex_m_trustlink_links_sidebar'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_trustlink_links_sidebar')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_trustlink_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='itex_m_trustlink_links_footer' id='itex_m_trustlink_links_footer'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_trustlink_links_footer')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_trustlink_links_footer') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Footer links', 'iMoney').'</label>';

						echo "<br/>\n";
						echo "<select name='itex_m_trustlink_pages_enable' id='trustlink_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_trustlink_pages_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_trustlink_pages_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

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
		//http://www.trustlink.ru/user/get_php_code?orientation=0&block_color=ffffff&border_color=e0e0e0e&anchor_color=0000cc&text_color=000000&url_color=006600

		//file trustlink.php from trustlink.ru T0.4.5 31.03.2011
		$file_php_content = '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';
		$file_php_content = gzuncompress(base64_decode($file_php_content));
		$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.$this->get_option('itex_m_trustlink_user').'/trustlink.php';

		$dir = dirname($file);
		if (!is_dir($dir) && !@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create Trustlink dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$file_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create', 'iMoney').'trustlink.php!
		</div>';
			return 0;
		}


		//file template.tpl.html from trustlink.ru 31.03.2011
		$file_php_content = 'eNqtUttygyAQffcrqHk22GSah8TmVzoIqEwQHKDTpI7/XtZLFDvNdDpdH1h2zx7OATPrbpKfI0dyybeU7/i+QG3UEMaEKo8oRU+ibrRxRLlTVBNTCrWuFlq5xIpPfkTPu+Ya9HJtGDe+4etWS8HQhqf9F8IIvZRGvyuWUC21H9gUfQSoLpTp2FLpy+pkx68uIVKUXq/khVsxTSTEc0xHpj4o/e7tg4uyckektKmJfGx4Zt6CghV7+vubuxvb+0Y4JoXiSRWI+klDpW2o4XBI0z/Y+hc1/q7RHI84uwyPP2bWPzmiklj7Gg9E8TlCKHO5Zrc+a3Op6aWDHOpmSCBlUwobIPKEbcUJextHAA2wrPU2YI9hg6Ha4iUwGpGTEnjc2INgXY6tcfAAgIM1xOFR0CQWT2qHPvjCszFfHPze574A6Hwz+g==';
		$file_php_content = gzuncompress(base64_decode($file_php_content));

		$file = $dir.DIRECTORY_SEPARATOR.'template.tpl.html';
		if (!file_put_contents($file,$file_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create', 'iMoney').'template.tpl.html !
		</div>';
			return 0;
		}


		//chmod($file, 0777);
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.$this->__('Trustlink dir and trustlink.php created!', 'iMoney').'
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
				$this->update_option('itex_m_adsense_id', trim($_POST['adsense_id']));
			}
			if (isset($_POST['adsense_enable']))
			{
				$this->update_option('itex_m_adsense_enable', intval($_POST['adsense_enable']));
			}
			for ($block=1;$block<$maxblock;$block++)
			{
				if (isset($_POST['adsense_b'.$block.'_enable']))
				{
					$this->update_option('itex_m_adsense_b'.$block.'_enable', trim($_POST['adsense_b'.$block.'_enable']));
				}

				if (isset($_POST['adsense_b'.$block.'_size']) && !empty($_POST['adsense_b'.$block.'_size']))
				{
					$this->update_option('itex_m_adsense_b'.$block.'_size', trim($_POST['adsense_b'.$block.'_size']));
				}

				if (isset($_POST['adsense_b'.$block.'_pos']) && !empty($_POST['adsense_b'.$block.'_pos']))
				{
					$this->update_option('itex_m_adsense_b'.$block.'_pos', trim($_POST['adsense_b'.$block.'_pos']));
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
					$this->update_option('itex_m_adsense_b'.$block.'_adslot', trim($_POST['adsense_b'.$block.'_adslot']));
				}

			}

			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your Adsense ID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='adsense_id'";
						echo "id='adsense_id' ";
						echo "value='".$this->get_option('itex_m_adsense_id')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your Adsence ID in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='adsense_enable' id='adsense_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_adsense_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_adsense_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
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
						<label for=""><?php echo $this->__('Adsense Block ', 'iMoney').$block.': ';?></label>
					</th>
					<td>
						<?php
						echo "<select name='adsense_b".$block."_enable' id='adsense_b".$block."_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_adsense_b'.$block.'_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_adsense_b'.$block.'_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";


						echo "<select name='adsense_b".$block."_size' id='adsense_b".$block."_size'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_adsense_b'.$block.'_size')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						$size = array('728x90', '468x60', '234x60','120x600', '160x600', '120x240', '336x280', '300x250', '250x250', '200x200', '180x150', '125x125');

						foreach ( $size as $k)
						{
							echo "<option value='".$k."'";
							if($this->get_option('itex_m_adsense_b'.$block.'_size') == $k) echo " selected='selected'";
							echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.$this->__('Block size ', 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='adsense_b".$block."_pos' id='adsense_b".$block."_pos'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_adsense_b'.$block.'_pos')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
						foreach ( $pos as $k)
						{
							echo "<option value='".$k."'";
							if($this->get_option('itex_m_adsense_b'.$block.'_pos') == $k) echo " selected='selected'";
							echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.$this->__('Block position', 'iMoney').'</label>';
						echo "<br/>\n";


						echo "<input type='text' size='20' ";
						echo "name='adsense_b".$block."_adslot'";
						echo "id='adsense_b".$block."_adslot' ";
						echo "value='".$this->get_option('itex_m_adsense_b'.$block.'_adslot')."' />\n";
						echo '<label for="">'.$this->__('Ad slot id', 'iMoney').'</label>';
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
				$this->update_option('itex_m_begun_id', trim($_POST['begun_id']));
			}
			//print_r($_POST['begun_enable']);
			if (isset($_POST['begun_enable']))
			{
				$this->update_option('itex_m_begun_enable', intval($_POST['begun_enable']));
			}
			for ($block=1;$block<$maxblock;$block++)
			{
				if (isset($_POST['begun_b'.$block.'_enable']))
				{
					$this->update_option('itex_m_begun_b'.$block.'_enable', trim($_POST['begun_b'.$block.'_enable']));
				}

				if (isset($_POST['begun_b'.$block.'_pos']) && !empty($_POST['begun_b'.$block.'_pos']))
				{
					$this->update_option('itex_m_begun_b'.$block.'_pos', trim($_POST['begun_b'.$block.'_pos']));

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
					$this->update_option('itex_m_begun_b'.$block.'_block_id', trim($_POST['begun_b'.$block.'_block_id']));
				}

			}

			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your begun ID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='begun_id'";
						echo "id='begun_id' ";
						echo "value='".$this->get_option('itex_m_begun_id')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php 
						//echo $this->__('Enter your Begun auto pad ID in this box (begun_auto_pad).', 'iMoney');
						echo '<a target="_blank" href="http://itex.name/go.php?http://referal.begun.ru/partner.php?oid=114115214">'.$this->__('Enter your Begun auto pad ID in this box (begun_auto_pad).', 'iMoney').'</a>';


						?></p>
						
						<?php
						echo "<select name='begun_enable' id='begun_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_begun_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_begun_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
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
						<label for=""><?php echo $this->__('begun Block ', 'iMoney').$block.': ';?></label>
					</th>
					<td>
						<?php
						echo "<select name='begun_b".$block."_enable' id='begun_b".$block."_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_begun_b'.$block.'_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_begun_b'.$block.'_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='begun_b".$block."_pos' id='begun_b".$block."_pos'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_begun_b'.$block.'_pos')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
						foreach ( $pos as $k)
						{
							echo "<option value='".$k."'";
							if($this->get_option('itex_m_begun_b'.$block.'_pos') == $k) echo " selected='selected'";
							echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.$this->__('Block position', 'iMoney').'</label>';
						echo "<br/>\n";


						echo "<input type='text' size='20' ";
						echo "name='begun_b".$block."_block_id'";
						echo "id='begun_b".$block."_block_id' ";
						echo "value='".$this->get_option('itex_m_begun_b'.$block.'_block_id')."' />\n";
						echo '<label for="">'.$this->__('Ad slot id', 'iMoney').' (begun_block_id)</label>';
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
						<a target="_blank" href="http://itex.name/go.php?http://referal.begun.ru/partner.php?oid=114115214">begun.ru</a>
						<br/>
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
				$this->update_option('itex_m_adskape_id', trim($_POST['adskape_id']));
			}
			if (isset($_POST['adskape_enable']))
			{
				$this->update_option('itex_m_adskape_enable', intval($_POST['adskape_enable']));
			}
			for ($block=1;$block<$maxblock;$block++)
			{
				if (isset($_POST['adskape_b'.$block.'_enable']))
				{
					$this->update_option('itex_m_adskape_b'.$block.'_enable', trim($_POST['adskape_b'.$block.'_enable']));
				}

				if (isset($_POST['adskape_b'.$block.'_size']) && !empty($_POST['adskape_b'.$block.'_size']))
				{
					$this->update_option('itex_m_adskape_b'.$block.'_size', trim($_POST['adskape_b'.$block.'_size']));
				}

				if (isset($_POST['adskape_b'.$block.'_pos']) && !empty($_POST['adskape_b'.$block.'_pos']))
				{
					$this->update_option('itex_m_adskape_b'.$block.'_pos', trim($_POST['adskape_b'.$block.'_pos']));
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
					$this->update_option('itex_m_adskape_b'.$block.'_adslot', trim($_POST['adskape_b'.$block.'_adslot']));
				}

			}

			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your adskape ID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='adskape_id'";
						echo "id='adskape_id' ";
						echo "value='".$this->get_option('itex_m_adskape_id')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php 
						echo '<a target="_blank" href="http://itex.name/go.php?http://adskape.ru/unireg.php?ref=17729&d=1">'.$this->__('Enter your Adskape site ID in this box.', 'iMoney').'</a>';

						?></p>
						
						<?php
						echo "<select name='adskape_enable' id='adskape_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_adskape_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_adskape_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
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
						<label for=""><?php echo $this->__('adskape Block ', 'iMoney').$block.': ';?></label>
					</th>
					<td>
						<?php
						echo "<select name='adskape_b".$block."_enable' id='adskape_b".$block."_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_adskape_b'.$block.'_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_adskape_b'.$block.'_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";


						echo "<select name='adskape_b".$block."_size' id='adskape_b".$block."_size'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_adskape_b'.$block.'_size')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						//$size = array('728x90', '468x60', '234x60','120x600', '160x600', '120x240', '336x280', '300x250', '250x250', '200x200', '180x150', '125x125');
						$size = array('1'=> '468×60', '2'=> '100×100', '3'=> 'RICH', '4'=> 'Topline', '5'=> '600×90', '6'=> '120×600', '7'=> '240×400',);
						foreach ( $size as $k=>$v)
						{
							echo "<option value='".$k."'";
							if($this->get_option('itex_m_adskape_b'.$block.'_size') == $k) echo " selected='selected'";
							echo ">".$size[$k]."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.$this->__('Block size ', 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='adskape_b".$block."_pos' id='adskape_b".$block."_pos'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_adskape_b'.$block.'_pos')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						$pos = array('sidebar', 'footer', 'beforecontent','aftercontent');
						foreach ( $pos as $k)
						{
							echo "<option value='".$k."'";
							if($this->get_option('itex_m_adskape_b'.$block.'_pos') == $k) echo " selected='selected'";
							echo ">".$k."</option>\n";
						}
						echo "</select>\n";
						echo '<label for="">'.$this->__('Block position', 'iMoney').'</label>';
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
						<a target="_blank" href="http://itex.name/go.php?http://adskape.ru/unireg.php?ref=17729&d=1">adskape.ru</a>
						<br/>
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
				$this->update_option('itex_m_teasernet_padid', trim($_POST['teasernet_padid']));
			}
			if (isset($_POST['teasernet_enable']))
			{
				$this->update_option('itex_m_teasernet_enable', intval($_POST['teasernet_enable']));
			}
			for ($block=1;$block<$maxblock;$block++)
			{
				if (isset($_POST['teasernet_b'.$block.'_enable']))
				{
					$this->update_option('itex_m_teasernet_b'.$block.'_enable', trim($_POST['teasernet_b'.$block.'_enable']));
				}

				if (isset($_POST['teasernet_b'.$block.'_blockid']) && !empty($_POST['teasernet_b'.$block.'_blockid']))
				{
					$this->update_option('itex_m_teasernet_b'.$block.'_blockid', trim($_POST['teasernet_b'.$block.'_blockid']));
				}

				if (isset($_POST['teasernet_b'.$block.'_pos']) && !empty($_POST['teasernet_b'.$block.'_pos']))
				{
					$this->update_option('itex_m_teasernet_b'.$block.'_pos', trim($_POST['teasernet_b'.$block.'_pos']));
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
				$this->update_option('itex_m_teasernet_b'.$block.'_adslot', trim($_POST['teasernet_b'.$block.'_adslot']));
				}*/

			}

			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your teasernet padid:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='teasernet_id'";
						echo "id='teasernet_id' ";
						echo "value='".$this->get_option('itex_m_teasernet_padid')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php
						echo '<a target="_blank" href="http://itex.name/go.php?http://teasernet.com/?owner_id=18516">'.$this->__('Enter your teasernet site padid in this box.', 'iMoney').'</a>';
						 ?></p>
						
						<?php
						echo "<select name='teasernet_enable' id='teasernet_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_teasernet_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_teasernet_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
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
						<label for=""><?php echo $this->__('teasernet Block ', 'iMoney').$block.': ';?></label>
					</th>
					<td>
						<?php
						echo "<select name='teasernet_b".$block."_enable' id='teasernet_b".$block."_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_teasernet_b'.$block.'_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_teasernet_b'.$block.'_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<input type='text' size='20' ";
						echo "name='teasernet_b".$block."_blockid'";
						echo "id='teasernet_b".$block."_blockid' ";
						echo "value='".$this->get_option('itex_m_teasernet_b'.$block.'_blockid')."' />\n";
						echo '<label for="">'.$this->__('Teasernet blockid', 'iMoney').'</label>';
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
						<a target="_blank" href="http://itex.name/go.php?http://teasernet.com/?owner_id=18516">teasernet.com</a>
						<br/>
						<a target="_blank" href="http://itex.name/go.php?http://teasernet.com/?owner_id=18516">
						<img src="http://pic5.teasernet.com/tz/2-468_60.gif"></a>
						

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
				$this->update_option('itex_m_html_enable', intval($_POST['html_enable']));
			}
			if (isset($_POST['html_footer']))
			{
				$this->update_option('itex_m_html_footer', $_POST['html_footer']);
			}
			if (isset($_POST['html_footer_enable']))
			{
				$this->update_option('itex_m_html_footer_enable', $_POST['html_footer_enable']);
			}
			if (isset($_POST['html_beforecontent']))
			{
				$this->update_option('itex_m_html_beforecontent', $_POST['html_beforecontent']);
			}
			if (isset($_POST['html_beforecontent_enable']))
			{
				$this->update_option('itex_m_html_beforecontent_enable', $_POST['html_beforecontent_enable']);
			}
			if (isset($_POST['html_aftercontent']))
			{
				$this->update_option('itex_m_html_aftercontent', $_POST['html_aftercontent']);
			}
			if (isset($_POST['html_aftercontent_enable']))
			{
				$this->update_option('itex_m_html_aftercontent_enable', $_POST['html_aftercontent_enable']);
			}

			if (isset($_POST['html_sidebar']))
			{
				$this->update_option('itex_m_html_sidebar', $_POST['html_sidebar']);
			}
			if (isset($_POST['html_sidebar_enable']))
			{
				$this->update_option('itex_m_html_sidebar_enable', $_POST['html_sidebar_enable']);
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
			//wp_cache_flush();
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Html inserts:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='html_enable' id='html_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_html_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_html_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Footer:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='html_footer'";
						echo "id='html_footer'>";
						echo stripslashes($this->get_option('itex_m_html_footer'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your html in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='html_footer_enable' id='html_footer_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_html_footer_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_html_footer_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Before Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='html_beforecontent'";
						echo "id='html_beforecontent'>";
						echo stripslashes($this->get_option('itex_m_html_beforecontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your html in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='html_beforecontent_enable' id='html_beforecontent_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_html_beforecontent_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_html_beforecontent_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('After Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='html_aftercontent'";
						echo "id='html_aftercontent'>";
						echo stripslashes($this->get_option('itex_m_html_aftercontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your html in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='html_aftercontent_enable' id='html_aftercontent_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_html_aftercontent_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_html_aftercontent_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Sidebar:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='html_sidebar'";
						echo "id='html_sidebar'>";
						echo stripslashes($this->get_option('itex_m_html_sidebar'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your html in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='html_sidebar_enable' id='html_sidebar_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_html_sidebar_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_html_sidebar_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
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
				$this->update_option('itex_m_php_enable', intval($_POST['php_enable']));
			}
			if (isset($_POST['php_footer']))
			{
				$this->update_option('itex_m_php_footer', $_POST['php_footer']);
				//print_r($this->get_option('itex_m_php_footer'));
				if (!$this->itex_m_admin_php_syntax(stripslashes($this->get_option('itex_m_php_footer'))))
				echo '<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">php_footer wrong syntax!</div>';

			}
			if (isset($_POST['php_footer_enable']))
			{
				$this->update_option('itex_m_php_footer_enable', $_POST['php_footer_enable']);
			}
			if (isset($_POST['php_beforecontent']))
			{
				$this->update_option('itex_m_php_beforecontent', $_POST['php_beforecontent']);
				if (!$this->itex_m_admin_php_syntax(stripslashes($this->get_option('itex_m_php_beforecontent'))))
				echo '<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">php_beforecontent wrong syntax!</div>';

			}
			if (isset($_POST['php_beforecontent_enable']))
			{
				$this->update_option('itex_m_php_beforecontent_enable', $_POST['php_beforecontent_enable']);
			}
			if (isset($_POST['php_aftercontent']))
			{
				$this->update_option('itex_m_php_aftercontent', $_POST['php_aftercontent']);
				if (!$this->itex_m_admin_php_syntax(stripslashes($this->get_option('itex_m_php_aftercontent'))))
				echo '<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">php_aftercontent wrong syntax!</div>';

			}
			if (isset($_POST['php_aftercontent_enable']))
			{
				$this->update_option('itex_m_php_aftercontent_enable', $_POST['php_aftercontent_enable']);
			}

			if (isset($_POST['php_sidebar']))
			{
				$this->update_option('itex_m_php_sidebar', $_POST['php_sidebar']);
				if (!$this->itex_m_admin_php_syntax(stripslashes($this->get_option('itex_m_php_sidebar'))))
				echo '<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">php_sidebar wrong syntax!</div>';

			}
			if (isset($_POST['php_sidebar_enable']))
			{
				$this->update_option('itex_m_php_sidebar_enable', $_POST['php_sidebar_enable']);
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



			//wp_cache_flush();
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Php inserts:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='php_enable' id='php_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_php_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_php_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Footer:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='php_footer'";
						echo "id='php_footer'>";
						echo stripslashes($this->get_option('itex_m_php_footer'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your php in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='php_footer_enable' id='php_footer_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_php_footer_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_php_footer_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Before Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='php_beforecontent'";
						echo "id='php_beforecontent'>";
						echo stripslashes($this->get_option('itex_m_php_beforecontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your php in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='php_beforecontent_enable' id='php_beforecontent_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_php_beforecontent_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_php_beforecontent_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('After Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='php_aftercontent'";
						echo "id='php_aftercontent'>";
						echo stripslashes($this->get_option('itex_m_php_aftercontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your php in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='php_aftercontent_enable' id='php_aftercontent_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_php_aftercontent_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_php_aftercontent_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Sidebar:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='php_sidebar'";
						echo "id='php_sidebar'>";
						echo stripslashes($this->get_option('itex_m_php_sidebar'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your php in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='php_sidebar_enable' id='php_sidebar_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_php_sidebar_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_php_sidebar_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
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
		if (function_exists('token_get_all')) foreach (token_get_all('<?php ' . $code) as $token)
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
				$this->update_option('itex_m_ilinks_enable', intval($_POST['ilinks_enable']));
			}
			if (isset($_POST['ilinks_separator']))
			{
				$separator = trim($_POST['ilinks_separator']);

				if (!empty($separator))
				$this->update_option('itex_m_ilinks_separator', $separator);
			}
			if (isset($_POST['ilinks_footer']))
			{
				$this->update_option('itex_m_ilinks_footer', $_POST['ilinks_footer']);
			}
			if (isset($_POST['ilinks_footer_enable']))
			{
				$this->update_option('itex_m_ilinks_footer_enable', $_POST['ilinks_footer_enable']);
			}
			if (isset($_POST['ilinks_beforecontent']))
			{
				$this->update_option('itex_m_ilinks_beforecontent', $_POST['ilinks_beforecontent']);
			}
			if (isset($_POST['ilinks_beforecontent_enable']))
			{
				$this->update_option('itex_m_ilinks_beforecontent_enable', $_POST['ilinks_beforecontent_enable']);
			}
			if (isset($_POST['ilinks_aftercontent']))
			{
				$this->update_option('itex_m_ilinks_aftercontent', $_POST['ilinks_aftercontent']);
			}
			if (isset($_POST['ilinks_aftercontent_enable']))
			{
				$this->update_option('itex_m_ilinks_aftercontent_enable', $_POST['ilinks_aftercontent_enable']);
			}

			if (isset($_POST['ilinks_sidebar']))
			{
				$this->update_option('itex_m_ilinks_sidebar', $_POST['ilinks_sidebar']);
			}
			if (isset($_POST['ilinks_sidebar_enable']))
			{
				$this->update_option('itex_m_ilinks_sidebar_enable', $_POST['ilinks_sidebar_enable']);
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
			//wp_cache_flush();
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('iLinks inserts:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='ilinks_enable' id='ilinks_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_ilinks_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_ilinks_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<input type='text' size='2' ";
						echo "name='ilinks_separator'";
						echo "id='ilinks_separator' ";
						$separator = ($this->get_option('itex_m_ilinks_separator')?($this->get_option('itex_m_ilinks_separator')):':');
						echo "value='".$separator."' />\n";
						echo '<label for="">'.$this->__('Separator', 'iMoney').'</label>';
						echo "<br/>\n";

						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Footer:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='ilinks_footer'";
						echo "id='ilinks_footer'>";
						echo stripslashes($this->get_option('itex_m_ilinks_footer'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your ilinks in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='ilinks_footer_enable' id='ilinks_footer_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_ilinks_footer_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_ilinks_footer_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Before Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='ilinks_beforecontent'";
						echo "id='ilinks_beforecontent'>";
						echo stripslashes($this->get_option('itex_m_ilinks_beforecontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your ilinks in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='ilinks_beforecontent_enable' id='ilinks_beforecontent_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_ilinks_beforecontent_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_ilinks_beforecontent_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('After Content:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='ilinks_aftercontent'";
						echo "id='ilinks_aftercontent'>";
						echo stripslashes($this->get_option('itex_m_ilinks_aftercontent'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your ilinks in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='ilinks_aftercontent_enable' id='ilinks_aftercontent_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_ilinks_aftercontent_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_ilinks_aftercontent_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";
						?>
					</td>
				</tr>
				
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Sidebar:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<textarea rows='5' cols='80'";
						echo "name='ilinks_sidebar'";
						echo "id='ilinks_sidebar'>";
						echo stripslashes($this->get_option('itex_m_ilinks_sidebar'))."</textarea>\n";
						?>
						<p style="margin: 5px 10px;"><?php echo $this->__('Enter your ilinks in this box.', 'iMoney');?></p>
						
						<?php
						echo "<select name='ilinks_sidebar_enable' id='ilinks_sidebar_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_ilinks_sidebar_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_ilinks_sidebar_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
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
				$this->update_option('itex_m_tnx_tnxuser', trim($_POST['tnx_tnxuser']));
			}
			if (isset($_POST['tnx_enable']))
			{
				$this->update_option('itex_m_tnx_enable', intval($_POST['tnx_enable']));
			}

			if (isset($_POST['tnx_links_beforecontent']))
			{
				$this->update_option('itex_m_tnx_links_beforecontent', $_POST['tnx_links_beforecontent']);
			}

			if (isset($_POST['tnx_links_aftercontent']))
			{
				$this->update_option('itex_m_tnx_links_aftercontent', $_POST['tnx_links_aftercontent']);
			}

			if (isset($_POST['tnx_links_sidebar']))
			{
				$this->update_option('itex_m_tnx_links_sidebar', $_POST['tnx_links_sidebar']);
			}

			if (isset($_POST['tnx_links_footer']))
			{
				$this->update_option('itex_m_tnx_links_footer', $_POST['tnx_links_footer']);
			}

			if (isset($_POST['tnx_pages_enable']) )
			{
				$this->update_option('itex_m_tnx_pages_enable', intval($_POST['tnx_pages_enable']));
			}

			if (isset($_POST['tnx_tnxcontext_enable']) )
			{
				$this->update_option('itex_m_tnx_tnxcontext_enable', intval($_POST['tnx_tnxcontext_enable']));
			}

			if (isset($_POST['tnx_tnxcontext_pages_enable']) )
			{
				$this->update_option('itex_m_tnx_tnxcontext_pages_enable', intval($_POST['tnx_tnxcontext_pages_enable']));
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
			if ($this->get_option('itex_m_tnx_tnxuser'))  $this->itex_m_tnx_install_file();
			//phpinfo();die();//dir();
		}
		if ($this->get_option('itex_m_tnx_tnxuser'))
		{
			$file = $this->document_root . '/' . 'tnxdir_'.md5($this->get_option('itex_m_tnx_tnxuser')) . '/tnx.php'; //<< Not working in multihosting.
			if (file_exists($file)) {}
				else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
		tnx dir not exist!
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				Create new tnxdir and tnx.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='tnx_tnxdir_create' value='<?php echo $this->__('Create', 'iMoney'); ?>' />
				</p>
				<?php
				if (!$this->get_option('itex_m_tnx_tnxuser')) echo $this->__('Enter your tnx UID in this box!', 'iMoney');
				?>
		</div>
		
		<?php }
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your tnx UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='tnx_tnxuser'";
						echo "id='tnxuser' ";
						echo "value='".$this->get_option('itex_m_tnx_tnxuser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php 
						echo '<a target="_blank" href="http://itex.name/go.php?http://www.tnx.net/?p=119596309">'.$this->__('Enter your tnx UID in this box.', 'iMoney').'</a>';
						?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('tnx links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='tnx_enable' id='tnx_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_tnx_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_tnx_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='tnx_links_beforecontent' id='tnx_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_tnx_links_beforecontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_tnx_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_tnx_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_tnx_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_tnx_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_tnx_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='tnx_links_aftercontent' id='tnx_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_tnx_links_aftercontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_tnx_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_tnx_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_tnx_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_tnx_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_tnx_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='tnx_links_sidebar' id='tnx_links_sidebar'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_tnx_links_sidebar')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_tnx_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_tnx_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_tnx_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_tnx_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_tnx_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_tnx_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='tnx_links_footer' id='tnx_links_footer'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_tnx_links_footer')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_tnx_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_tnx_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_tnx_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_tnx_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_tnx_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_tnx_links_footer') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Footer links', 'iMoney').'</label>';

						//						echo "<br/>\n";
						//						$ws = wp_get_sidebars_widgets();
						//						echo "<select name='tnx_widget' id='tnx_widget'>\n";
						//						echo "<option value='0'";
						//						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						//						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						//
						//						echo "<option value='1'";
						//						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						//						echo ">".$this->__('Active','iMoney')."</option>\n";
						//
						//						echo "</select>\n";
						//
						//						echo '<label for="">'.$this->__('Widget Active', 'iMoney').'</label>';

						echo "<br/>\n";
						echo "<select name='tnx_pages_enable' id='tnx_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_tnx_pages_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_tnx_pages_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

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
						<a target="_blank" href="http://itex.name/go.php?http://www.tnx.net/?p=119596309">www.tnx.net</a>
						<br/>
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
		$tnx_php_content = 'eNrtXG1v28gR/h4g/2HtGpB0kWXZvrveOXGuQeK7BG3t1C9Fi8tVkCUqFk6WBEk+p73mzxXox7ZAvxegGdGiJZESycvJgYy4M7tLipRIipTla1rUuBdb4g5nZ559ZnZ2yAdfVI+qd++srBBZ7yhENc9VjWiGdtYXz0XjimiXyllbIcukL+ptrduVVUPpaxJ8tXH3jlCrVWqZmlCt1BrF8st4OnH/7h0Q9hHZ3/4d+Wjl7p1cKVuv41+Z8t0739+9Q/jPykej33tyXwa56lAmPY2YXa0zEFXl/egCFDQaGPLHMea7bI0sZRrFY6Fy0sjksrkjgWyS9U/T6fsEJo6/wAQl0OKaNDvXRDtTNakjq8o1acuXYtKlFrtcl9um2kwSIyWnyCoZiLrf7fKV03Lg3XqaZGh9VXsDdgerv2P3JY3yqySRiN4xByIYRmzSz3W5L8l9L5XC6pKhTgONPmX6dMW2rnTFzpWqyUyrJFVLUQ24l9gRSVc+b5pEP9Ouuwrp9eFfDZQCdRSi68OO1ia6pZevzSvlspBrwF0/oTc1xIuuaBqkramq3DYmxvHrMyd1gBWMihXqldy3MTpW72m6dmYPBVvmTmologB66VUTso6E3LeWGwrZUl2gYnqAYrl/bVwliSoTsyd2SAen1mxqAEaiK7ohd4cp8ldcFvTrZbwQXNXVWgqsjJb4pm+22mAZow9e+JGoIvcqn93ErI4ax6VMXigVj4sNAV0Qe3BYe8hm1RdbTbmjGHLnik7FkNu6YZkerNwWu8q4PKGcq+S5gZgUaXim9cE0TVyjsGwl8VIGXOnihSGmyD9M3dBgGqfF8vLq2ierJO5EUSJF/im2zwEEWqurnavDDfLLnWefLR8kycH+l8ufkbgqa2dvQXaXdLWmCYoWwU/f4bzfarqhqG/kxISKr3JCtVGslOuo5POnz/e29vaePWHawoz1K4L30kBIT9GRcAbABi30zpncQSwbCiwDuOv1OwVUI2a/M6T4bIm9vswWi/IW0NoEg4k/Iiap57QLXD1GapAiSovUKoeVRj3VeNVIkX+BDVAK9XsTFDd7jHoUIDhJAUMnqQfgW918J+uGZL7He3M3AyT+oekd2XlLuBQwA1hKjc+/UKkdFvN5oTzykaU43tSSmXRNO4nW6Ctduc/5mA4xEHRHjUZ1Y2Xl9PQ0VQcQpWonK8VyXniVAhYnPeVS7pLY6JMYASClminyN9G6lfiWGEpPDBT0RTG/uQosdWY2YY2OgoF+zaAIHhnAh0Oct/VtRwFXLhMFVmfnqmVeGDIZ+X42+vaOFk2xI8tEVQYIbNvw3sGC+eA7oVYHLdAD6dRaLnZ//IKa0DiplTPVSrGMFJWeuIDyZr2RbZzUPb+HZdAQ6NhY7L5T8cJJOYcWYBEwvlSqvCyWk2SJxqBMvlhzLBhHdLTnbdMU+JUT3nDysmIhvtQ4KtaXH44Tp82c5NH2E7JgqQPLslhv1OPsy0pVKMcSiUm5HhpZP/x+1RqYjEWUeOzvmCpAaLKFonuQUOX+uSKJsqFfY9yCGenAc5QzIGQQqd15P0BsS6p8qcJCsyZKVyG9/ozi6fHB7q9iifv+SjE/co6fvOx1RMthWPEzHH6XKZaLjXkaDifoazNmA2rb1PytsCAcVxt/tI1hRZaE9/QXKfEvznHqPJKMz33eM4UFBagTOxqQlQ5x0RD7mHdJYl8RVUOkIaGliu+BcQcyxAHgXklp0vDU1FJeliPxeqNWEmBtZ/a2dn+7tft1bHfrNwdbe/uZg91nsW8S5CFZ/SwdzVLTJ+atio8OFM2xiM7yEwXxJRZepwlg2TEhKnhcmYTwqlqq5IV4jMSSxEN2AGggIoOhipuQ/S4VH9SLfxIqQALOsfD5vXsJfwkBWjp5xd8Xjrt9vVQEiEzxt5d0twjq4RVGVtWa8DJznG3kjuKLP/vDCxbWX6RenH6/mvzk9dLPFpN+zk3MognAv1qp+003OTnZhU2ehoe+2+uZ4WanXzA1WPtrq6n056n0z6Mhz5nDeQJvdJfIuHMMvX3Y2TeLhLqw1mfJDdgIENGolCqnQo0nPF5msWx3VKlj3sQHp0gsBRvfVFlouBOpkTOKJdy8H2brwqcfszgl+HKv131P6kItA2ukgJqeHIKydloGe+i1IF2P85/AIPhvnKrheSldbQ7Ro6Ej+R7DMAdnpsNySimbA4hhbg4oi8WcC/bp/v7zzNOdvX02PX9lq9nGEWVrnHAduCHlnHuK0kXKYXf2J90L8D98prCaIEFXrOIkRwKpv6hbX/m5lI/GTTzoyzcmdLATIynXzLwlZQ/rldIJteTIYk92Hh/8emt7P7O7swNWQ0F2+h3eGZZa3B94iaf/vcZSL2acw/ytwFTjKB9NCCzIvrG9hB+xvxjkHDb2k023MV6i6Rcuyf7ucu7FrB9I30XYoeiQW2nXmMI7bvWDeNGBxAp2t2bnyhANSK1U2AB0YXfu3FdNCu3KhtYEksrmWfFG0lpSX3wHeeHG5MVYUsNdsqYPSZvWO0wsqfTlS1n12DFhXSqegDGYARq0bCOrsK21RLAPVLrBDBDj3Gt6bSnsytNMifLYtpN/ahskngid89qbyKRd0pANLHehc2iN0zuYFuvUh/FJcEbM3kCHtjigGKEFBFZm7fXlptxBO1/YlZDpVhlttvknL4WG9WE8KAK7N3t4+c2irddKGP+hRXU+Z142HSaJoU0fieDUWk20GfWSkxkUxyJS5TdaMoQ4G/RUql3bDjWSequv8No/ug/rxfIFLS6OquXTZXktGB8/n9aAiqwCctybNGfxCCuScV/QGhzzjoT2cFp5uigJN4cyWcTA92cLUy9qL8qLt2AJqlggvl+HpQMKSnvpOyhh8moBcsNoKz3ABTxMKC0XmHtyXzLfIwFobTPJS+gukKb8RaoiK0jzgwsguku5eSmDV0kX6/iG6BblLynIIUsIQyAcO2w4uTgcRN0szMq64AW6eLD4BcpNYS5U4aHNgq7TrBvy2BzIeW4kPRNZR5hsFKqYA4nbXA6ONjvX8yNzN6ePn1hGETE3co9CbVPJPrQfV/wYfUYlpvNsALkGbpDDQI9CjRn9mrECpqCMLrAcfg65tb22eB3FXxo9EWZ5tGv9EeAhgCMbTuxjXFp+BSvCjRDeG7ORpU1WD7zJiuzskmK9LjQmFviNaYyWyQELKuT/uFTJW/nSJHTf7qC2lgjxYE60RiNAeMhgUn27tMaju1Mvl7ejrSxuTx3jA8CRG1HH5oTIy+vmMeFGsWEGY84SK+YXM9wJq/KWZajRx0eh4xsyYghmDEeeIY9yBso7TFuQJa3awzUNsJo0OSBXErI13E2P5jPtQJDCdVSvnmkTz8VksrVa9o/OCjLt/UiOXxe9hOx1n7lUkz0ls9MG0qgVj+O+FyRuUE52/QFO/stQohn+eFC3j9brR5XTTKlY/ja+VD45JpPOmnawDpufK8zFu6KuK5IVDE2IIrpfWcQjenHD3/5B3xLOtT7Za+Ccm9bUYbM1lOjq0DrKADd4mjU1iU9Vjjw9+OsEA/X3Ad9i9TMQmsHn8K5mjIebJEiPOdvaL5hKHIKSblcLMBcz22ILEwl50sRJcqZ1ri5lMmDUrcI2VIQNKcEtlff0KXYtqsEciX4yTwNw+hjFX5etkTEcKZvH3ebCKQy8qc0AdnEU/l0Nc9FIZZzFXLi6F2jWcOiIXhqx4DSCkQn5/NmQQQy22yxFAGqS27TS3SV98UwzzFA1TfcEOXwioieCJ8OfHt4UkTiRe75XfLiIDESCKcnAGQpl6J6mqNhnpw9krFdRBpkB0GCncMjlrvNt+kmQL1hDTnzxtFjOV07rtF100dFqwS9NcvMlyAb/7b5/JP/BVNs/Ktd2+/D1xFTtmO7aGQRHco/cnIX2tgiBrimasKvFVJw2KGPtkR5IOU6ovA+T+PW4/gbKReSjH+fRzcImidj/E7ThGOUtvM04yVhlFI1YBVWljXSwl9f0q4B6kKFZXIQDaBlw5m3/eHnUZYUHmxPlAJ+TsVshIb+vhMA9cbiyA7W/bexRqc9xCqr47KVDZ+G4eyn7n/tFbdZABgLAsAxRl7QLgr0BJPsSVhzr7sXySUd7I3bpIQe2ybcBKwp+R49JxUvao+fXYUElYZJKO1/J86fPifNIn/fkeh+FV2Gwf35LG92mNG1C+hRwDeuTCuzpjHy8abm3JZ71HaWSttnvaAEraikHE7VvHHf0QgR5mQ6AJL1ShSE51ji683w/83hne3vr8f7+s19v7RzsJyfrb8wUs4h+uvXoydZukm+uZhCwu7V/sLu9v/toe+9LFNSoncwk5zYmd7C3tfvoq61tlDpCb5AkC6NUovBKyIG88AdANAXsUE647GjkTUdstrWkXXwldukIO1D79OGcIbbaS7IxJGvpNCzDj9MfB3IxU4w22YJmdEHQjyCyFsuFij39Z9tf7mRoU9HjnSdb2J1HYnAHtkRCjwBtYvQmVjcgmidJnP3lgXWUCHxLdcqVKnVhqsnHKdRuxwhVzLp5bJlQNeSuIkQ/f8Ra1OFJoWAxqu9FhSpc8gvbZXFn+1WSfJbGXs5arVxh/wdPz7QGKX0XqjcDQaF6AowNYpJk8autfbI41h4Gfy4SxOjKaipNT+TDeNwp9SlMesMll3ehLc4k7gBYZfkRsgoX6giSs8p8zIwNIWyDPEaUoRRb0nRZ4EEhe4x8mDksgdPxCU4qeRo1ewiwju7o+BlQYYMQqYb1z6Fo3AccC41sJp9tZClsQs3s9Ahzrnh8ocCabKsJ9iBDfIHK/zqGmuUzoBs2Pc/1AIYtNdhNFkB37qmP059/GqV8HsYIcyjBFzg1hbUqXbmT9hsnyhBO5sHTKoUv2sBNMvuFQgoXQv//9eo34U7f4gvu9njGES9SL/IYV2lzvNXUioqwhtc1Dh//sRD//MfSwMioc2EzPYcoOQssZwqBEUPhPM922J4Wa/DeqY7jyQNuRbiMbFca5MvKSTkfm60QHwv9aAsfQG8eUPPgLU+uHqeJ7liPAoijyzOw/IFrcqJN0xY/2wNaIbeaHudpU6ybDn3EQVORgisLsScFka92uJjw3xt6JhdBdXEMfoypf7Xz+JeZvaeBmX+hlMUnruNF2CE4SH51NfDobuweB9uBV7uYeYpVqUKRCn9eD+L9TSZd7Y1J8NwI96/YIgF7DqtetuHavY8A5gd9G8gjMIFnYMUSdzHs++jOPz28d5ve3/pdoGfokThPc3A6YZK3W3Q+pmofrO/d7ZGRnT7qkftPL3k+hw9q1XOdflrnOx4A8A16HyFCnJViGw+snSREVJtGAdkPhQJ4xft/iQRa1os4OBAkioMADoiOA3s49glMgwJeg2CwLg/koQi5iWUKFOqPZTo+AMxzYrfT/wP6PwpoX14LjwSGNCs7ZBQ1JXWfaDXbnK3VbKYuoimQpBP5MNIsx9O3KRL7s8tv3HD/x2sEvDp7g/97k7JCXRC+DZOE8WKgoxZ4o9Izq1DR13fZeWCoWgp9V4ijPiTUaIVofS1BH84foTxMM3OULuZowJ9xJfgtjfEZr6+HkvJ6pgOXW1ziEdoGf8Jke7TNdhT2pkWdhZs+nzxDJ6VHQ4vdIT/55IlHSw9tgpecpTP+oOCZdh2uO8fV025Xt8LpKvHHtkZ3Z89sGfo1WbceH0ddZAlfk2c2xYE6fGu/z/ECn0mnDUVmwqMXp60ZWh+fW2IW0K/AGHpHbuJrNmV8MWOSfUDoO8+oJnB7pSvKBln/nJyJF0bSrwvqmjYRtvBdcmO1xuBOJrt/YixZx47U9c/n187E6rysDVIjRh/7kJj5EBK9odFWgh+bcByq268Rtd5dOeQvUARbKcFdTcHn9ta5PO8QZy+10Am+uEzsKmR1eZ3EGRzb4nkT3yiFsEwEFRHZWxh8yrYhngFYdb9Gho6aRzckSuI9/rTWwRr9rU8TN+h4lIYDRad9UXpfbqqy1ahmOUuTuLfWl/m6DnIarX/Y7zKNcxXXv1lmv6x9kyD3SNz6g3+6iq84WiFr0xo1GDW5tARkYT93U+uZuqF0tQvamTEkcY+XqyaCEcsW10h9n844LuvWX1Ew9mSqq2eNsy4+lsrsMF1cS/xBaev0HcESt93Yy2vn+nC847CC7V0Tt9IHOIaNcwsW0jgiZN7BjY8jWQ9yUhumf5pWv+A0wZmMYPk6OFcQckcVks/CRmzx98vHy3ny1UZxo75I3+5Dllmuwmvg+DAT3YG5MxX454uH/wZ0FQRN';
		$tnx_php_content = gzuncompress(base64_decode($tnx_php_content));
		$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.'tnxdir_'.md5($this->get_option('itex_m_tnx_tnxuser')).'/tnx.php';

		$dir = dirname($file);
		//print_r($file.' '.$dir );die();
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create Tnx/Xap dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$tnx_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create xap.php!', 'iMoney').'
		</div>';
			return 0;
		}
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		//chmod($file, 0777);
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.$this->__('Dir and xap.php created!', 'iMoney').'
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
				$this->update_option('itex_m_mainlink_mainlinkuser', trim($_POST['mainlink_mainlinkuser']));
			}
			if (isset($_POST['mainlink_enable']))
			{
				$this->update_option('itex_m_mainlink_enable', intval($_POST['mainlink_enable']));
			}

			if (isset($_POST['mainlink_links_beforecontent']))
			{
				$this->update_option('itex_m_mainlink_links_beforecontent', $_POST['mainlink_links_beforecontent']);
			}

			if (isset($_POST['mainlink_links_aftercontent']))
			{
				$this->update_option('itex_m_mainlink_links_aftercontent', $_POST['mainlink_links_aftercontent']);
			}

			if (isset($_POST['mainlink_links_sidebar']))
			{
				$this->update_option('itex_m_mainlink_links_sidebar', $_POST['mainlink_links_sidebar']);
			}

			if (isset($_POST['mainlink_links_footer']))
			{
				$this->update_option('itex_m_mainlink_links_footer', $_POST['mainlink_links_footer']);
			}

			if (isset($_POST['mainlink_pages_enable']) )
			{
				$this->update_option('itex_m_mainlink_pages_enable', intval($_POST['mainlink_pages_enable']));
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
			if ($this->get_option('itex_m_mainlink_mainlinkuser'))  $this->itex_m_mainlink_install_file();
		}

		$file = $this->document_root . '/mainlink_'.$this->get_option('itex_m_mainlink_mainlinkuser').'/ML.php';
		if ($this->get_option('itex_m_mainlink_mainlinkuser'))
		{
			if (file_exists($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				mainlink dir not exist!
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				Create new mainlinkdir and ML.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='mainlink_mainlinkdir_create' value='<?php echo $this->__('Create', 'iMoney'); ?>' />
				</p>
				<?php
				if (!$this->get_option('itex_m_mainlink_mainlinkuser')) echo $this->__('Enter your mainlink UID in this box!', 'iMoney');
				?>
		</div>
		
		<?php 
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your mainlink UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='mainlink_mainlinkuser'";
						echo "id='mainlinkuser' ";
						echo "value='".$this->get_option('itex_m_mainlink_mainlinkuser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php 
						echo '<a target="_blank" target="_blank" href="http://itex.name/go.php?http://www.mainlink.ru/?partnerid=42851">'.$this->__('Enter your mainlink UID in this box.', 'iMoney').'</a>';

						?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('mainlink links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='mainlink_enable' id='mainlink_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_mainlink_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_mainlink_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='mainlink_links_beforecontent' id='mainlink_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_mainlink_links_beforecontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_mainlink_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_mainlink_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_mainlink_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_mainlink_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_mainlink_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='mainlink_links_aftercontent' id='mainlink_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_mainlink_links_aftercontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_mainlink_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_mainlink_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_mainlink_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_mainlink_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_mainlink_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='mainlink_links_sidebar' id='mainlink_links_sidebar'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_mainlink_links_sidebar')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_mainlink_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_mainlink_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_mainlink_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_mainlink_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_mainlink_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_mainlink_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='mainlink_links_footer' id='mainlink_links_footer'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_mainlink_links_footer')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_mainlink_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_mainlink_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_mainlink_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_mainlink_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_mainlink_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_mainlink_links_footer') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Footer links', 'iMoney').'</label>';

						//						echo "<br/>\n";
						//						$ws = wp_get_sidebars_widgets();
						//						echo "<select name='mainlink_widget' id='mainlink_widget'>\n";
						//						echo "<option value='0'";
						//						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						//						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						//
						//						echo "<option value='1'";
						//						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						//						echo ">".$this->__('Active','iMoney')."</option>\n";
						//
						//						echo "</select>\n";
						//
						//
						//						echo '<label for="">'.$this->__('Widget Active', 'iMoney').'</label>';
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
						<a target="_blank" target="_blank" href="http://itex.name/go.php?http://www.mainlink.ru/?partnerid=42851">www.mainlink.ru</a>
						<br/>
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
		if (!$this->get_option('itex_m_mainlink_mainlinkuser')) return 0;
		//file ML.php 4.003 2009-03-05
		$mainlink_php_content = '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';
		$mainlink_php_content = gzuncompress(base64_decode($mainlink_php_content));
		$file = $this->document_root . '/mainlink_'.$this->get_option('itex_m_mainlink_mainlinkuser').'/ML.php';
		$dir = dirname($file);
		//print_r($file.' '.$dir );die();
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create mainlink dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$mainlink_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create ', 'iMoney').'ML.php!
		</div>';
			return 0;
		}
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		file_put_contents($dir.'/'.$this->get_option('itex_m_mainlink_mainlinkuser').'.sec',$this->get_option('itex_m_mainlink_mainlinkuser')."\r\n");
		//chmod($file, 0777);
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.$this->__('Dir and Ml.php created!', 'iMoney').'
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
				$this->update_option('itex_m_linkfeed_linkfeeduser', trim($_POST['linkfeed_linkfeeduser']));
			}
			if (isset($_POST['linkfeed_enable']))
			{
				$this->update_option('itex_m_linkfeed_enable', intval($_POST['linkfeed_enable']));
			}

			if (isset($_POST['linkfeed_links_beforecontent']))
			{
				$this->update_option('itex_m_linkfeed_links_beforecontent', $_POST['linkfeed_links_beforecontent']);
			}

			if (isset($_POST['linkfeed_links_aftercontent']))
			{
				$this->update_option('itex_m_linkfeed_links_aftercontent', $_POST['linkfeed_links_aftercontent']);
			}

			if (isset($_POST['linkfeed_links_sidebar']))
			{
				$this->update_option('itex_m_linkfeed_links_sidebar', $_POST['linkfeed_links_sidebar']);
			}

			if (isset($_POST['linkfeed_links_footer']))
			{
				$this->update_option('itex_m_linkfeed_links_footer', $_POST['linkfeed_links_footer']);
			}

			if (isset($_POST['linkfeed_pages_enable']) )
			{
				$this->update_option('itex_m_linkfeed_pages_enable', intval($_POST['linkfeed_pages_enable']));
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
			if ($this->get_option('itex_m_linkfeed_linkfeeduser'))  $this->itex_m_linkfeed_install_file();
		}

		$file = $this->document_root . '/linkfeed_'.$this->get_option('itex_m_linkfeed_linkfeeduser').'/linkfeed.php';
		if ($this->get_option('itex_m_linkfeed_linkfeeduser'))
		{
			if (file_exists($file)) {}
			else {?>
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				linkfeed dir not exist!
		</div>
		<div style="margin:10px auto; border:3px #f00 solid; padding:10px; text-align:center;">
				Create new linkfeeddir and linkfeed.php? (<?php echo $file;?>)
				<p class="submit">
				<input type='submit' name='linkfeed_linkfeeddir_create' value='<?php echo $this->__('Create', 'iMoney'); ?>' />
				</p>
				<?php
				if (!$this->get_option('itex_m_linkfeed_linkfeeduser')) echo $this->__('Enter your linkfeed UID in this box!', 'iMoney');
				?>
		</div>
		
		<?php 
			}
		}
		?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('Your linkfeed UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='linkfeed_linkfeeduser'";
						echo "id='linkfeeduser' ";
						echo "value='".$this->get_option('itex_m_linkfeed_linkfeeduser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php 
						echo '<a target="_blank" target="_blank" href="http://itex.name/go.php?http://www.linkfeed.ru/reg/38317">'.$this->__('Enter your linkfeed UID in this box.', 'iMoney').'</a>';
						?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('linkfeed links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='linkfeed_enable' id='linkfeed_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_linkfeed_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_linkfeed_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='linkfeed_links_beforecontent' id='linkfeed_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_linkfeed_links_beforecontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_linkfeed_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_linkfeed_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_linkfeed_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_linkfeed_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_linkfeed_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='linkfeed_links_aftercontent' id='linkfeed_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_linkfeed_links_aftercontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_linkfeed_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_linkfeed_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_linkfeed_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_linkfeed_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_linkfeed_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='linkfeed_links_sidebar' id='linkfeed_links_sidebar'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_linkfeed_links_sidebar')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_linkfeed_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_linkfeed_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_linkfeed_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_linkfeed_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_linkfeed_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_linkfeed_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='linkfeed_links_footer' id='linkfeed_links_footer'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_linkfeed_links_footer')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_linkfeed_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_linkfeed_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_linkfeed_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_linkfeed_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_linkfeed_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_linkfeed_links_footer') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Footer links', 'iMoney').'</label>';

						//						echo "<br/>\n";
						//						$ws = wp_get_sidebars_widgets();
						//						echo "<select name='linkfeed_widget' id='linkfeed_widget'>\n";
						//						echo "<option value='0'";
						//						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						//						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						//
						//						echo "<option value='1'";
						//						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						//						echo ">".$this->__('Active','iMoney')."</option>\n";
						//
						//						echo "</select>\n";
						//
						//
						//						echo '<label for="">'.$this->__('Widget Active', 'iMoney').'</label>';
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
						<a target="_blank" target="_blank" href="http://itex.name/go.php?http://www.linkfeed.ru/reg/38317">www.linkfeed.ru</a>
						<br/>
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
		if (!$this->get_option('itex_m_linkfeed_linkfeeduser')) return 0;
		//file linkfeed.php 4.003 2009-04-05
		$linkfeed_php_content = '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';
		$linkfeed_php_content = gzuncompress(base64_decode($linkfeed_php_content));
		$file = $this->document_root . '/linkfeed_'.$this->get_option('itex_m_linkfeed_linkfeeduser').'/linkfeed.php';
		$dir = dirname($file);
		//print_r($file.' '.$dir );die();
		if (!@mkdir($dir, 0777))
		{
			echo '

		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create linkfeed dir!', 'iMoney').'
		</div>';
			return 0;
		}
		chmod($dir, 0777);  //byli gluki s mkdir($dir, 0777)
		if (!file_put_contents($file,$linkfeed_php_content))
		{
			echo '
		<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
				'.$this->__('Can`t create ', 'iMoney').'linkfeed.php!
		</div>';
			return 0;
		}
		file_put_contents($dir.'/.htaccess',"deny from all\r\n");
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.$this->__('Dir and linkfeed.php created!', 'iMoney').'
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
				$this->update_option('itex_m_setlinks_setlinksuser', trim($_POST['setlinks_setlinksuser']));
			}
			if (isset($_POST['setlinks_enable']))
			{
				$this->update_option('itex_m_setlinks_enable', intval($_POST['setlinks_enable']));
			}

			if (isset($_POST['setlinks_links_beforecontent']))
			{
				$this->update_option('itex_m_setlinks_links_beforecontent', $_POST['setlinks_links_beforecontent']);
			}

			if (isset($_POST['setlinks_links_aftercontent']))
			{
				$this->update_option('itex_m_setlinks_links_aftercontent', $_POST['setlinks_links_aftercontent']);
			}

			if (isset($_POST['setlinks_links_sidebar']))
			{
				$this->update_option('itex_m_setlinks_links_sidebar', $_POST['setlinks_links_sidebar']);
			}

			if (isset($_POST['setlinks_links_footer']))
			{
				$this->update_option('itex_m_setlinks_links_footer', $_POST['setlinks_links_footer']);
			}



			if (isset($_POST['setlinks_setlinkscontext_enable']) )
			{
				$this->update_option('itex_m_setlinks_setlinkscontext_enable', intval($_POST['setlinks_setlinkscontext_enable']));
			}

			if (isset($_POST['setlinks_setlinkscontext_pages_enable']) )
			{
				$this->update_option('itex_m_setlinks_setlinkscontext_pages_enable', intval($_POST['setlinks_setlinkscontext_pages_enable']));
			}

			if (isset($_POST['setlinks_pages_enable']) )
			{
				$this->update_option('itex_m_setlinks_pages_enable', intval($_POST['setlinks_pages_enable']));
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

		if ($this->get_option('itex_m_setlinks_setlinksuser'))
		{
			$file = $this->document_root . '/setlinks_' . _setlinks_USER . '/slsimple.php'; //<< Not working in multihosting.
			if (file_exists($file)) {}
			else
			{
				$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/setlinks_'.$this->get_option('itex_m_setlinks_setlinksuser').'/';
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
						<label for=""><?php echo $this->__('Your SETLINKS UID:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<input type='text' size='50' ";
						echo "name='setlinks_setlinksuser'";
						echo "id='setlinksuser' ";
						echo "value='".$this->get_option('itex_m_setlinks_setlinksuser')."' />\n";
						?>
						<p style="margin: 5px 10px;"><?php 
						echo '<a target="_blank" href="http://itex.name/go.php?http://www.setlinks.ru/?pid=72567">'.$this->__('Enter your SETLINKS UID in this box.', 'iMoney').'</a>';

						?></p>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('SETLINKS links:', 'iMoney');?></label>
					</th>
					<td>
						<?php
						echo "<select name='setlinks_enable' id='setlinks_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_setlinks_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_setlinks_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__("Working", 'iMoney').'</label>';
						echo "<br/>\n";

						echo "<select name='setlinks_links_beforecontent' id='setlinks_links_beforecontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_setlinks_links_beforecontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_setlinks_links_beforecontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_setlinks_links_beforecontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_setlinks_links_beforecontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_setlinks_links_beforecontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_setlinks_links_beforecontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Before content links', 'iMoney').'</label>';

						echo "<br/>\n";



						echo "<select name='setlinks_links_aftercontent' id='setlinks_links_aftercontent'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_setlinks_links_aftercontent')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_setlinks_links_aftercontent') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_setlinks_links_aftercontent') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_setlinks_links_aftercontent') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_setlinks_links_aftercontent') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_setlinks_links_aftercontent') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('After content links', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='setlinks_links_sidebar' id='setlinks_links_sidebar'>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_setlinks_links_sidebar')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_setlinks_links_sidebar') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_setlinks_links_sidebar') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_setlinks_links_sidebar') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_setlinks_links_sidebar') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_setlinks_links_sidebar') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_setlinks_links_sidebar') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Sidebar links', 'iMoney').'</label>';

						echo "<br/>\n";


						echo "<select name='setlinks_links_footer' id='setlinks_links_footer'>\n";
						echo "<option value='0'";
						if(!$this->get_option('itex_m_setlinks_links_footer')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if($this->get_option('itex_m_setlinks_links_footer') == 1) echo " selected='selected'";
						echo ">1</option>\n";

						echo "<option value='2'";
						if($this->get_option('itex_m_setlinks_links_footer') == 2) echo " selected='selected'";
						echo ">2</option>\n";

						echo "<option value='3'";
						if($this->get_option('itex_m_setlinks_links_footer') == 3) echo " selected='selected'";
						echo ">3</option>\n";

						echo "<option value='4'";
						if($this->get_option('itex_m_setlinks_links_footer') == 4) echo " selected='selected'";
						echo ">4</option>\n";

						echo "<option value='5'";
						if($this->get_option('itex_m_setlinks_links_footer') == 5) echo " selected='selected'";
						echo ">5</option>\n";

						echo "<option value='max'";
						if($this->get_option('itex_m_setlinks_links_footer') == 'max') echo " selected='selected'";
						echo ">".$this->__('Max', 'iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.$this->__('Footer links', 'iMoney').'</label>';

						echo "<br/>\n";
						echo "<select name='setlinks_pages_enable' id='setlinks_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_setlinks_pages_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_setlinks_pages_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Show content links only on Pages and Posts.', 'iMoney').'</label>';

						echo "<br/>\n";
						?>
					</td>
					
					
				</tr>
				<?php 
				?>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo $this->__('SETLINKS context:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						echo "<select name='setlinks_setlinkscontext_enable' id='setlinks_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_setlinks_setlinkscontext_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_setlinks_setlinkscontext_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Context', 'iMoney').'</label>';

						echo "<br/>\n";

						echo "<select name='setlinks_setlinkscontext_pages_enable' id='setlinks_enable'>\n";
						echo "<option value='1'";

						if($this->get_option('itex_m_setlinks_setlinkscontext_pages_enable')) echo " selected='selected'";
						echo ">".$this->__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!$this->get_option('itex_m_setlinks_setlinkscontext_pages_enable')) echo" selected='selected'";
						echo ">".$this->__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";

						echo '<label for="">'.$this->__('Show context only on Pages and Posts.', 'iMoney').'</label>';

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
						<a target="_blank" href="http://itex.name/go.php?http://www.setlinks.ru/?pid=72567">www.setlinks.ru</a> 
						<br/>
						<a target="_blank" href="http://itex.name/go.php?http://www.setlinks.ru/?pid=72567"><img src="http://vip.setlinks.ru/images/38.gif" alt="www.setlinks.ru!" border="0" /></a> 
					</td>
				</tr>
			</table>
			<?php

	}


}

if (function_exists(add_action)) $itex_money = & new itex_money();
//if (isset($_GET['debug123']))
//{
//	phpinfo();die();
//}
?>