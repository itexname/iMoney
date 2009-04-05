<?php
/*
Plugin Name: iMoney 
Version: 0.17 (05-04-2009) Nirvana Edition.
Plugin URI: http://itex.name/imoney
Description: Adsense, <a href="http://itex.name/go.php?http://www.sape.ru/r.a5a429f57e.php">Sape.ru</a>, <a href="http://itex.name/go.php?http://www.tnx.net/?p=119596309">tnx.net/xap.ru</a>, <a href="http://itex.name/go.php?http://referal.begun.ru/partner.php?oid=114115214">Begun.ru</a>, <a href="http://itex.name/go.php?http://www.mainlink.ru/?partnerid=42851">mainlink.ru</a>, <a href="http://itex.name/go.php?http://www.linkfeed.ru/reg/38317">linkfeed.ru</a> and html inserts helper.
Author: Itex
Author URI: http://itex.name/
*/

/*
Copyright 2007-2008  Itex (web : http://itex.name/)

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
Wordpress 2.3-2.6.3
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
По желанию создать автоматом папку Сапы, совпадающей с вашим Tnx Uid.
Разрешить работу Tnx links, указать сколько ссылок использовать до текста, после текста, в виджете и футере.
По мере надобности включить Check - проверочный код.

Html - Введите ваш html код в нужные места.

Для активации виджетов нужно зайти в дизайн->виджеты, активировать виджет и указать его заголовок.
Если define ('WPLANG', 'ru_RU'); в wp-config.php, то будет русский язык.

*/
class itex_money
{
	var $version = '0.17';
	var $full = 0;
	var $error = '';
	//var $force_show_code = true;
	var $sape;
	var $sapecontext;
	var $links = array();
	var $tnx;
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
	//var $replacecontent = 0;
	
	/**
   	* constructor, function __construct()  in php4 not working
   	*
   	*/
	function itex_money()
	{
		if (substr(phpversion(),0,1) == 4) $this->php4(); //fix php4 bugs
		add_action('widgets_init', array(&$this, 'itex_m_init'));
		add_action("widgets_init", array(&$this, 'itex_m_widget_init'));
		add_action('admin_menu', array(&$this, 'itex_m_menu'));
		add_action('wp_footer', array(&$this, 'itex_m_footer'));
		$this->document_root = ($_SERVER['DOCUMENT_ROOT'] != str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]))?(str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"])):($_SERVER['DOCUMENT_ROOT']);
		
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
		global $l10n;
		$locale = get_locale();
		if ($locale == 'ru_RU')
		{
			$domain = 'iMoney';
			if (isset($l10n[$domain])) return;
			///ru_RU lang .mo file
			$input = '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';
			$input = gzuncompress(base64_decode($input));
			$inputReader = new StringReader($input);
			$l10n[$domain] = new gettext_reader($inputReader);
			$this->itex_debug('Used Ru language');
		}
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
		if (get_option('itex_m_global_masking')){
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
		if (strlen($this->footer)) add_action('wp_footer', array(&$this, 'itex_m_footer'));

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
		return 1;
	}

	/**
   	* sape init
   	*
   	* @return  bool
   	*/
	function itex_init_sape()
	{
		if (!get_option('itex_m_sape_enable')) return 0;
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
		if (get_option('itex_m_global_debugenable'))
		{
			$o['force_show_code'] = 1;
		}
		$o['multi_site'] = true;
//		if (get_option('itex_m_sape_masking'))
//		{
//			$this->itex_m_safe_url();
//			$o['request_uri'] = $this->safeurl;
//		}
		if (get_option('itex_m_sape_enable'))
		{
			$this->sape = new SAPE_client($o);
			
			
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
					
					$this->aftercontent .= '<div>'.$css.$this->itex_init_sape_get_links(intval(get_option('itex_sape_links_aftercontent'))).'</div>';
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
			$q = $this->sape->return_links(1);
			if (empty($q) || !strlen($q))
			{
				break;
			}
			$q .= $this->sape->_links_delimiter;
			
			if (strlen($q)) $this->links['a_only'][] = $q;
			
			//!!!!!!!!!!check it, tk ne vozvrashaet pustuu stroku
			if ($i > 30) break;
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
							$this->sidebar['imoney_adsense_'.$block] = '<div style="clear:right;">'.$script.'</div>';
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
					if (eregi($w[0],$_SERVER["REQUEST_URI"])) $this->sidebar['iMoney_ilinks']  .= $w[1];
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
					if (eregi($w[0],$_SERVER["REQUEST_URI"])) $this->footer .= $w[1];
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
					if (eregi($w[0],$_SERVER["REQUEST_URI"])) $this->beforecontent .= $w[1];
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
					if (eregi($w[0],$_SERVER["REQUEST_URI"])) $this->aftercontent .= $w[1];
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
		if (eregi('1251', get_option('blog_charset'))) $mlcfg['charset'] = 'win';
		else $mlcfg['charset'] = 'utf';
		
		if (get_option('itex_m_global_debugenable'))
		{
			$mlcfg['debugmode'] = 1;
		}
		
		$mlcfg['is_mod_rewrite'] = 1;  //проверить че за нах
		$mlcfg['redirect'] = 0;

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
			//if (($url) || !get_option('itex_mainlink_pages_enable')) 
			//{
				if (get_option('itex_m_mainlink_links_beforecontent') == '0')
				{
					//$this->beforecontent = '';
				}
				else
				{
					$this->beforecontent .= '<div>'.$ml->Get_Links(intval(get_option('itex_mainlink_links_beforecontent'))).'</div>';
				}
					
				if (get_option('itex_m_mainlink_links_aftercontent') == '0')
				{
					//$this->aftercontent = '';
				}
				else
				{
					$this->aftercontent .= '<div>'.$ml->Get_Links(intval(get_option('itex_mainlink_links_aftercontent'))).'</div>';
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
			$o['verbose'] = 1;
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
			//if (($url) || !get_option('itex_linkfeed_pages_enable')) 
			//{
				if (get_option('itex_m_linkfeed_links_beforecontent') == '0')
				{
					//$this->beforecontent = '';
				}
				else
				{
					$this->beforecontent .= '<div>'.$linkfeed->return_links(intval(get_option('itex_linkfeed_links_beforecontent'))).'</div>';
				}
					
				if (get_option('itex_m_linkfeed_links_aftercontent') == '0')
				{
					//$this->aftercontent = '';
				}
				else
				{
					$this->aftercontent .= '<div>'.$linkfeed->return_links(intval(get_option('itex_linkfeed_links_aftercontent'))).'</div>';
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
   	* Footer output
   	*
   	*/
	function itex_m_footer()
	{
		echo $this->footer;
		if (get_option('itex_m_global_debugenable')){
			
			echo '<!--- iMoneyDebugLogStart'.$this->debuglog.' iMoneyDebugLogEnd --->';
			echo '<!--- iMoneyDebugErrorsStart'.$this->error.' iMoneyDebugErrorsEnd --->';
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
		if (count($this->sidebar))
		{
			foreach ($this->sidebar as $k => $v)
			{
				if (function_exists('register_sidebar_widget')) register_sidebar_widget($k, array(&$this, 'itex_m_widget'));
				if (function_exists('register_widget_control')) register_widget_control($k, array(&$this, 'itex_m_widget_control'), 300, 200 );
			}
		}
		if (function_exists('register_sidebar_widget')) register_sidebar_widget('iMoney Links', array(&$this, 'itex_m_widget_links'));
		if (function_exists('register_widget_control')) register_widget_control('iMoney Links', array(&$this, 'itex_m_widget_links_control'), 300, 200 );
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
	}

	/**
   	* Dynamic widget control
   	*
   	*/
	function itex_m_widget_control()
	{
		
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
		$title = empty($title) ?('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>') :$title;
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
		$title = empty($title) ? '<a href="http://itex.name/imoney" title="iMoney">iMoney</a>' :$title;
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
			<?php
			if (strlen($this->error))
			{
				echo '
				<div style="margin:10px auto; border:3px #f00 solid; background-color:#fdd; color:#000; padding:10px; text-align:center;">
					'.$this->error.'
				</div>
			';
			}
			?>		
			
			<h2><?php echo __('iMoney Options', 'iMoney');?></h2>
			
			                       
       			<!-- Main -->
        		
        			<?php 
        			?>
        		<ul style="text-align: center;font-weight: bold;font-size: 14px;">
        			<li style="display: inline;"><a href="#itex_adsense" onclick='document.getElementById("itex_adsense").style.display="";'>Adsense</a></li>
        			<li style="display: inline;"><a href="#itex_html" onclick='document.getElementById("itex_html").style.display="";'>Html</a></li>
        			<li style="display: inline;"><a href="#itex_sape" onclick='document.getElementById("itex_sape").style.display="";'>Sape</a></li>
        			<li style="display: inline;"><a href="#itex_tnx" onclick='document.getElementById("itex_tnx").style.display="";'>Tnx/Xap</a></li>
        			<li style="display: inline;"><a href="#itex_begun" onclick='document.getElementById("itex_begun").style.display="";'>Begun</a></li>
        			<li style="display: inline;"><a href="#itex_mainlink" onclick='document.getElementById("itex_mainlink").style.display="";'>MainLink</a></li>
        			<li style="display: inline;"><a href="#itex_ilinks" onclick='document.getElementById("itex_ilinks").style.display="";'>iLinks</a></li>
        			<li style="display: inline;"><a href="#itex_linkfeed" onclick='document.getElementById("itex_linkfeed").style.display="";'>Linkfeed</a></li>
        		
        		</ul>
        		<p class="submit">
				<input type='submit' name='info_update' value='<?php echo __('Save Changes', 'iMoney'); ?>' />
				</p>
        		<h3><a href="#itex_global" name="itex_global">Global</a></h3>
       	 		<div id="itex_global"><?php $this->itex_m_admin_global(); ?></div>
        		<h3><a href="#itex_adsense" name="itex_adsense" onclick='document.getElementById("itex_adsense").style.display="";'>Adsense</a></h3>
       	 		<div id="itex_adsense" ><?php $this->itex_m_admin_adsense(); ?></div>
       	 		<h3><a href="#itex_html" name="itex_html" onclick='document.getElementById("itex_html").style.display="";'>Html</a></h3>
       	 		<div id="itex_html"><?php $this->itex_m_admin_html(); ?></div>
       	 		<h3><a href="#itex_sape" name="itex_sape" onclick='document.getElementById("itex_sape").style.display="";'>Sape</a></h3>
       	 		<div id="itex_sape"><?php $this->itex_m_admin_sape(); ?></div>
       	 		<h3><a href="#itex_tnx" name="itex_tnx" onclick='document.getElementById("itex_tnx").style.display="";'>Tnx/Xap</a></h3>
       	 		<div id="itex_tnx"><?php $this->itex_m_admin_tnx(); ?></div>
       	 		<h3><a href="#itex_begun" name="itex_begun" onclick='document.getElementById("itex_begun").style.display="";'>Begun</a></h3>
       	 		<div id="itex_begun"><?php $this->itex_m_admin_begun(); ?></div>
       	 		<h3><a href="#itex_mainlink" name="itex_mainlink" onclick='document.getElementById("itex_mainlink").style.display="";'>MainLink</a></h3>
       	 		<div id="itex_mainlink"><?php $this->itex_m_admin_mainlink(); ?></div>
       	 		<h3><a href="#itex_ilinks" name="itex_ilinks" onclick='document.getElementById("itex_ilinks").style.display="";'>iLinks</a></h3>
       	 		<div id="itex_ilinks"><?php $this->itex_m_admin_ilinks(); ?></div>
       	 		<h3><a href="#itex_linkfeed" name="itex_linkfeed" onclick='document.getElementById("itex_linkfeed").style.display="";'>Linkfeed</a></h3>
       	 		<div id="itex_linkfeed"><?php $this->itex_m_admin_linkfeed(); ?></div>
       	 		
       	 		
       	 		<?php 
       	 		if(!get_option('itex_m_global_collapse')){ ?>
       	 		<script type="text/javascript">
       	 			document.getElementById("itex_adsense").style.display="none";
       	 			document.getElementById("itex_html").style.display="none";
       	 			document.getElementById("itex_sape").style.display="none";
       	 			document.getElementById("itex_tnx").style.display="none";
       	 			document.getElementById("itex_begun").style.display="none";
       	 			document.getElementById("itex_mainlink").style.display="none";
       	 			document.getElementById("itex_ilinks").style.display="none";
       	 			document.getElementById("itex_linkfeed").style.display="none";
       	 		</script>	
       	 		<?php } ?>
			</div>
			<p class="submit">
				<input type='submit' name='info_update' value='<?php echo __('Save Changes', 'iMoney'); ?>' />
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

			if (isset($_POST['global_masking']))
			{
				update_option('itex_m_global_masking', intval($_POST['global_masking']));
			}
			
			if (isset($_POST['global_collapse']))
			{
				update_option('itex_m_global_collapse', !intval($_POST['global_collapse']));
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

						echo '<label for="">'.__('Debug log in footer. Dont leave this parameter switched Enabled for a long time, because in this case it will disclose your private data like SAPE UID', 'iMoney').'.</label>';
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
			
			
			if (isset($_POST['sape_widget']))
			{
				$s_w = wp_get_sidebars_widgets();
				$ex = 0;
				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				{
					if ($v == 'imoney-links')
					{
						$ex = 1;
						if (!$_POST['sape_widget']) unset($s_w['sidebar-1'][$k]);
					}
				}
				if (!$ex && $_POST['sape_widget']) $s_w['sidebar-1'][] = 'imoney-links';
				wp_set_sidebars_widgets( $s_w );

			}
			echo "<div class='updated fade'><p><strong>Settings saved.</strong></p></div>";
		}
		if (isset($_POST['sape_sapedir_create']))
		{
			if (get_option('itex_m_sape_sapeuser'))  $this->itex_m_sape_install_file();
		}
		if (get_option('itex_m_tnx_tnxuser'))  
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
						$ws = wp_get_sidebars_widgets();
						echo "<select name='sape_widget' id='sape_widget'>\n";
						echo "<option value='0'";
						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						echo ">".__('Active','iMoney')."</option>\n";

						echo "</select>\n";

						
						echo '<label for="">'.__('Widget Active', 'iMoney').'</label>';
						
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
						<label for=""></label>
					</th>
					<td align="center">
						<br/><br/>
						<a target="_blank" href="http://itex.name/go.php?http://www.sape.ru/r.a5a429f57e.php"><img src="http://www.sape.ru/images/banners/sape_001.gif" border="0" /></a>
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
		//file sape.php from sape.ru v1.0.4 21.07.2008
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
					$s_w = wp_get_sidebars_widgets();
					$ex = 0;
					if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
					{
						if ($v == 'imoney_adsense_'.$block)
						{
							$ex = 1;
							if ($_POST['adsense_b'.$block.'_pos'] != 'sidebar') unset($s_w['sidebar-1'][$k]);
						}
					}
					if (!$ex && ($_POST['adsense_b'.$block.'_pos'] == 'sidebar')) $s_w['sidebar-1'][] = 'imoney_adsense_'.$block;
					wp_set_sidebars_widgets($s_w);
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
					
					$s_w = wp_get_sidebars_widgets();
					$ex = 0;
					if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
					{
						if ($v == 'imoney_begun_'.$block)
						{
							$ex = 1;
							if ($_POST['begun_b'.$block.'_pos'] != 'sidebar') unset($s_w['sidebar-1'][$k]);
						}
					}
					if (!$ex && ($_POST['begun_b'.$block.'_pos'] == 'sidebar')) $s_w['sidebar-1'][] = 'imoney_begun_'.$block;
					wp_set_sidebars_widgets( $s_w );
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
						<a href="http://itex.name/go.php?http://referal.begun.ru/partner.php?oid=114115214">
							<img src="http://promo.begun.ru/my/data/banners/107_04_partner.gif" alt="Покупаем рекламу. Дорого." border="0" height="60" width="468">
						</a>

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
				$s_w = wp_get_sidebars_widgets();
				$ex = 0;
				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				{
					if ($v == 'imoney_html')
					{
						$ex = 1;
						if (!$_POST['html_sidebar_enable']) unset($s_w['sidebar-1'][$k]);
					}
				}
				if (!$ex && ($_POST['html_sidebar_enable'])) $s_w['sidebar-1'][] = 'imoney_html';
				wp_set_sidebars_widgets( $s_w );
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
				$s_w = wp_get_sidebars_widgets();
				$ex = 0;
				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				{
					if ($v == 'imoney_ilinks')
					{
						$ex = 1;
						if (!$_POST['ilinks_sidebar_enable']) unset($s_w['sidebar-1'][$k]);
					}
				}
				if (!$ex && ($_POST['ilinks_sidebar_enable'])) $s_w['sidebar-1'][] = 'imoney_ilinks';
				wp_set_sidebars_widgets( $s_w );
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

			if (isset($_POST['tnx_widget']))
			{
				$s_w = wp_get_sidebars_widgets();
				$ex = 0;
				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				{
					if ($v == 'imoney-links')
					{
						$ex = 1;
						if (!$_POST['tnx_widget']) unset($s_w['sidebar-1'][$k]);
					}
				}
				if (!$ex && $_POST['tnx_widget']) $s_w['sidebar-1'][] = 'imoney-links';
				wp_set_sidebars_widgets( $s_w );

			}
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

						echo "<br/>\n";
						$ws = wp_get_sidebars_widgets();
						echo "<select name='tnx_widget' id='tnx_widget'>\n";
						echo "<option value='0'";
						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						echo ">".__('Active','iMoney')."</option>\n";

						echo "</select>\n";

						echo '<label for="">'.__('Widget Active', 'iMoney').'</label>';
						
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
						<a href="http://itex.name/go.php?http://www.tnx.net/?p=119596309"><img border="0" alt="Sell links on every page of your site to thousands of advertisers!" src="http://us1.tnx.net/tnx_468_60.gif" width="468" height="60"></a>
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
			
			if (isset($_POST['mainlink_widget']))
			{
				$s_w = wp_get_sidebars_widgets();
				$ex = 0;
				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				{
					if ($v == 'imoney-links')
					{
						$ex = 1;
						if (!$_POST['mainlink_widget']) unset($s_w['sidebar-1'][$k]);
					}
				}
				if (!$ex && $_POST['mainlink_widget']) $s_w['sidebar-1'][] = 'imoney-links';
				wp_set_sidebars_widgets( $s_w );

			}
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

						echo "<br/>\n";
						$ws = wp_get_sidebars_widgets();
						echo "<select name='mainlink_widget' id='mainlink_widget'>\n";
						echo "<option value='0'";
						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						echo ">".__('Active','iMoney')."</option>\n";

						echo "</select>\n";

						
						echo '<label for="">'.__('Widget Active', 'iMoney').'</label>';
						
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
						<a target="_blank" href="http://itex.name/go.php?http://www.mainlink.ru/?partnerid=42851"><img src='http://www.mainlink.ru/i/banner/earth.gif' border='0'></a>
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
			
			if (isset($_POST['linkfeed_widget']))
			{
				$s_w = wp_get_sidebars_widgets();
				$ex = 0;
				if (count($s_w['sidebar-1'])) foreach ($s_w['sidebar-1'] as $k => $v)
				{
					if ($v == 'imoney-links')
					{
						$ex = 1;
						if (!$_POST['linkfeed_widget']) unset($s_w['sidebar-1'][$k]);
					}
				}
				if (!$ex && $_POST['linkfeed_widget']) $s_w['sidebar-1'][] = 'imoney-links';
				wp_set_sidebars_widgets( $s_w );

			}
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

						echo "<br/>\n";
						$ws = wp_get_sidebars_widgets();
						echo "<select name='linkfeed_widget' id='linkfeed_widget'>\n";
						echo "<option value='0'";
						if (count($ws['sidebar-1'])) if(!in_array('imoney-links',$ws['sidebar-1'])) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";

						echo "<option value='1'";
						if (count($ws['sidebar-1'])) if (in_array('imoney-links',$ws['sidebar-1'])) echo " selected='selected'";
						echo ">".__('Active','iMoney')."</option>\n";

						echo "</select>\n";

						
						echo '<label for="">'.__('Widget Active', 'iMoney').'</label>';
						
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
						<a target="_blank" href="http://itex.name/go.php?http://www.linkfeed.ru/reg/38317"><img src="http://www.linkfeed.ru/banners/468x60_linkfeed.gif"></a>
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
   	* Url masking
   	*
   	* @return  bool
   	*/
	function itex_m_safe_url()
	{
		$vars=array('p','p2','pg','page_id', 'm', 'cat', 'tag');
		
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
		return 1;
	}
	
	

}

if (function_exists(add_action)) $itex_money = & new itex_money();

?>