<?php
/*
Plugin Name: itexMoney
Version: 0.12 (17-01-2009)
Plugin URI: http://itex.name/imoney
Description: Adsense, <a href="http://www.sape.ru/r.a5a429f57e.php">Sape.ru</a>, tnx.net/xap.ru, <a href="http://referal.begun.ru/partner.php?oid=114115214">Begun.ru</a>, and html inserts helper.
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
	var $version = '0.12';
	var $error = '';
	//var $force_show_code = true;
	var $sape;
	var $sapecontext;
	var $tnx;
	//var $enable = false;
	var $sidebar = array();
	var $sidebar_links = '';
	var $footer = '';
	var $beforecontent = '';
	var $aftercontent = '';
	var $safeurl = '';
	//var $replacecontent = 0;
	
	///function __construct()  in php4 not working
	function itex_money()
	{
		if (substr(phpversion(),0,1) == 4) $this->php4(); //fix php4 bugs
		//add_action('init', array(&$this, 'itex_m_init'));
		add_action("plugins_loaded", array(&$this, 'itex_m_widget_init'));
		add_action('admin_menu', array(&$this, 'itex_m_menu'));
		add_action('wp_footer', array(&$this, 'itex_m_footer'));
		//$this->sidebar['qwe'] = 1;
		$this->itex_m_init();
		
	}
	
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
	}
	
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
		}
	}

	function itex_m_init()
	{
		$this->itex_init_adsense();
		$this->itex_init_html();
		$this->itex_init_sape();
		$this->itex_init_tnx();
		$this->itex_init_begun();
		if (strlen($this->footer)) add_action('wp_footer', array(&$this, 'itex_m_footer'));

		if ((strlen($this->beforecontent)) || (strlen($this->aftercontent)) )
		{
			add_filter('the_content', array(&$this, 'itex_m_replace'));
			add_filter('the_excerpt', array(&$this, 'itex_m_replace'));
		}
		return 1;
	}

	function itex_init_sape()
	{
		if (!get_option('itex_m_sape_enable')) return 0;
		if (!defined('_SAPE_USER')) define('_SAPE_USER', get_option('itex_m_sape_sapeuser'));
		else $this->error .= __('_SAPE_USER already defined<br/>', 'iMoney');

		//FOR MASS INSTALL ONLY, REPLACE if (0) ON if (1)
		//		if (0)
		//		{
		//			update_option('itex_sape_sapeuser', 'abcdarfkwpkgfkhagklhskdgfhqakshgakhdgflhadh'); //sape uid
		//			update_option('itex_sapecontext_enable', 1);
		//			update_option('itex_sape_enable', 1);
		//			update_option('itex_sape_links_footer', 'max');
		//		}

		//echo $_SERVER['SCRIPT_URL'];
		//echo $_SERVER["SCRIPT_FILENAME"].__FILE__._SAPE_USER.'/sape.php';
		$file = $_SERVER['DOCUMENT_ROOT'] . '/' . _SAPE_USER . '/sape.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else
		{
			$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'._SAPE_USER.'/sape.php';
			if (file_exists($file)) require_once($file);
			else return 0;
		}
		$o['charset'] = get_option('blog_charset')?get_option('blog_charset'):'UTF-8';
		//$o['force_show_code'] = $this->force_show_code;
		if (get_option('itex_m_sape_check'))
		{
			$o['force_show_code'] = get_option('itex_m_sape_check');
		}
		$o['multi_site'] = true;
		if (get_option('itex_m_sape_masking'))
		{
			$this->itex_m_safe_url();
			$o['request_uri'] = $this->safeurl;
		}
		//$this->itex_sape_safe_url();
		//$link = $this->itex_sape_safe_url();print_r($link);die();
		if (get_option('itex_m_sape_enable'))
		{
			$this->sape = new SAPE_client($o);

			if (url_to_postid($_SERVER['REQUEST_URI']) || !get_option('itex_sape_pages_enable')) 
			{
				if (get_option('itex_m_sape_links_beforecontent') == '0')
				{
					//$this->beforecontent = '';
				}
				else
				{
					$this->beforecontent .= '<div>'.$this->sape->return_links(intval(get_option('itex_sape_links_beforecontent'))).'</div>';
				}

				if (get_option('itex_m_sape_links_aftercontent') == '0')
				{
					//$this->aftercontent = '';
				}
				else
				{
					$this->aftercontent .= '<div>'.$this->sape->return_links(intval(get_option('itex_sape_links_aftercontent'))).'</div>';
				}
			}
			$countsidebar = get_option('itex_m_sape_links_sidebar');
			$check = get_option('itex_m_sape_check')?'<!---check sidebar '.$countsidebar.'-->':'';
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
				$this->sidebar_links .= '<div>'.$this->sape->return_links(intval($countsidebar)).'</div>';
			}
			$this->sidebar_links = $check.$this->sidebar_links;

			$countfooter = get_option('itex_m_sape_links_footer');
			$check = get_option('itex_m_sape_check')?'<!---check footer '.$countfooter.'-->':'';
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
				$this->footer .= '<div>'.$this->sape->return_links(intval($countfooter)).'</div>';
			}
			$this->footer = $check.$this->footer;

			if (($countsidebar == 'max') && ($countfooter == 'max')) $this->footer .=$this->sape->return_links();
			else
			{
				if  ($countsidebar == 'max') $this->sidebar_links .=$this->sape->return_links();
				else $this->footer .=$this->sape->return_links();
			}


			//			if (strlen($this->sidebar))
			//			echo $before_widget.$before_title . $title . $after_title.
			//    		'<ul><li>'.$check.$ret.'</li></ul>'.$after_widget;

		}

		if (get_option('itex_m_sapecontext_enable'))
		{
			$this->sapecontext = new SAPE_context($o);
			//add_filter('the_content', array(&$this, 'itex_sape_replace'));
			//add_filter('the_excerpt', array(&$this, 'itex_sape_replace'));
		}



		//print_r($o);die();
		//print_r($this->sape->return_links(2));die();
		return 1;
	}

	function itex_init_tnx()
	{
		if (!get_option('itex_m_tnx_enable')) return 0;
		$file = $_SERVER['DOCUMENT_ROOT'] . '/' . 'tnxdir_'.md5(get_option('itex_m_tnx_tnxuser')) . '/tnx.php'; //<< Not working in multihosting.
		if (file_exists($file)) require_once($file);
		else
		{
			$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.'tnxdir_'.md5(get_option('itex_m_tnx_tnxuser')).'/tnx.php';
			//$f = $file.' '.rand(0,999);die($f);
			
			if (file_exists($file)) require_once($file);
			else return 0;
		}
		
		//moget tnx progers ne produmali multihosting bag, mb ya mudag pravda))
		$dir .= '/..';
		for ($i = 0;$i<10;$i++) $dir .= '/..';
		$dir .= dirname($file).'/';
		
		$this->tnx = new TNX_n(get_option('itex_m_tnx_tnxuser'), $dir);
		$this->tnx->_encoding = get_option('blog_charset')?get_option('blog_charset'):'UTF-8';
		
		if (get_option('itex_m_tnx_enable'))
		{
			//$this->tnx = new tnx_client($o);


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
			$check = get_option('itex_m_tnx_check')?'<!---check sidebar tnx'.$countsidebar.'-->':'';
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
			$check = get_option('itex_m_tnx_check')?'<!---check footer tnx'.$countfooter.'-->':'';
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
				$script = '<p><script type="text/javascript"><!--
google_ad_client = "'.get_option('itex_m_adsense_id').'"; google_ad_slot = "'.get_option('itex_m_adsense_b'.$block.'_adslot').'"; google_ad_width = '.$size[0].'; google_ad_height = '.$size[1].';
//--></script><script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script></p>';
				$pos = get_option('itex_m_adsense_b'.$block.'_pos');
				switch ($pos)
				{
					case 'sidebar':
						{
							$this->sidebar['iMoney_Adsense_'.$block] = $script;
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
		//print_r($this->sidebar);die();
		return 1;
	}
	
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
		//print_r($this->sidebar);die();
		return 1;
	}

	function itex_init_html()
	{
		if (!get_option('itex_m_html_enable')) return 0;

		if (get_option('itex_m_html_sidebar_enable')) $this->sidebar['iMoney_html'] = stripslashes(get_option('itex_m_html_sidebar'));
		if (get_option('itex_m_html_footer_enable')) $this->footer .= stripslashes(get_option('itex_m_html_footer'));
		if (get_option('itex_m_html_beforecontent_enable')) $this->beforecontent .= stripslashes(get_option('itex_m_html_beforecontent'));
		if (get_option('itex_m_html_aftercontent_enable')) $this->aftercontent .= stripslashes(get_option('itex_m_html_aftercontent'));
	}

	function itex_m_footer()
	{
		echo $this->footer;
	}

	function itex_m_replace($content)
	{
		if (get_option('itex_m_sapecontext_enable'))
		{
			if (url_to_postid($_SERVER['REQUEST_URI']) || !get_option('itex_sape_pages_enable')) 
			{
				if (defined('_SAPE_USER') || is_object($this->sapecontext)) 
				{
					$content = $this->sapecontext->replace_in_text_segment($content);
					if (get_option('itex_sape_check'))
					{
						$content = '<!---checkcontext_start-->'.$content.'<!---checkcontext_stop-->';
					}
				}
			}
		}
		
		if ((strlen($this->beforecontent)) || (strlen($this->aftercontent)))
		{
			if ( (get_option('itex_m_sape_check')) or get_option('itex_m_tnx_check'))
			{
				$content = '<!---check_beforecontent-->'.$this->beforecontent.$content.'<!---check_aftercontent-->'.$this->aftercontent;
			}
			else $content = $this->beforecontent.$content.$this->aftercontent;
			$this->beforecontent=$this->aftercontent='';
		}
		return $content;
	}

	function itex_m_widget_init()
	{
		//		if (get_option('itex_m_sape_enable'))
		//		{
		//			if (function_exists('register_sidebar_widget')) register_sidebar_widget('imoney-links', array(&$this, 'itex_m_widget_links'));
		//			if (function_exists('register_widget_control')) register_widget_control('imoney-links', array(&$this, 'itex_m_widget_links_control'), 300, 200 );
		//			//if (function_exists('register_sidebar_widget')) register_sidebar_widget('iMoney', array(&$this, 'itex_m_widget'));
		//			//if (function_exists('register_widget_control')) register_widget_control('iMoney', array(&$this, 'itex_m_widget_control'), 300, 200 );
		//
		//		}
		//print_r($this->sidebar);die();
		//$this->sidebar['asd'] = 'asd';

		
		if (count($this->sidebar))
		{
			foreach ($this->sidebar as $k => $v)
			{

				if (function_exists('register_sidebar_widget')) register_sidebar_widget($k, array(&$this, 'itex_m_widget'));
				if (function_exists('register_widget_control')) register_widget_control($k, array(&$this, 'itex_m_widget_control'), 300, 200 );
			
				//if (function_exists('register_sidebar_widget')) register_sidebar_widget($k, array(&$this, 'itex_m_widget_links'));
				//if (function_exists('register_widget_control')) register_widget_control($k, array(&$this, 'itex_m_widget_links_control'), 300, 200 );
			}
			//print_r($this->sidebar);die();
		}
		if (function_exists('register_sidebar_widget')) register_sidebar_widget('iMoney Links', array(&$this, 'itex_m_widget_links'));
		if (function_exists('register_widget_control')) register_widget_control('iMoney Links', array(&$this, 'itex_m_widget_links_control'), 300, 200 );
			
	}

	function itex_m_widget($args)
	{
		extract($args, EXTR_SKIP);
		//print_r($args);
		//$title = get_option("itex_m_widget_title");
		//$title = empty($title) ? urlencode('<a href="http://itex.name" title="iMoney">iMoney</a>') :$title;
		echo $before_widget.$before_title . $title . $after_title.
		'<ul><li>'.$this->sidebar[$widget_name].'</li></ul>'.$after_widget;
	}

	function itex_m_widget_control()
	{
		//$title = get_option("itex_m_widget_title");
		//$title = $asd;
		//$title = empty($title) ? '<a href="http://itex.name" title="iMoney">iMoney</a>' :$title;
//		if ($_POST['itex_m_widget_Submit'])
//		{
//			//$title = htmlspecialchars($_POST['itex_m_widget_title']);
//			$title = stripslashes($_POST['itex_m_widget_title']);
//			update_option("itex_m_widget_title", $title);
//		}
//		echo '
//  			<p>
//    			<label for="itex_m_widget">'.__('Widget Title: ', 'iMoney').'</label>
//    			<textarea name="itex_m_widget_title" id="itex_m_widget" rows="1" cols="20">'.$title.'</textarea>
//    			<input type="hidden" id="" name="itex_m_widget_Submit" value="1" />
//  			</p>';

	}

	function itex_m_widget_links($args)
	{
		extract($args, EXTR_SKIP);
		$title = get_option("itex_m_widget_links_title");
		//$title = empty($title) ? urlencode('<a href="http://itex.name" title="iMoney">iMoney</a>') :$title;
		$title = empty($title) ?('<a href="http://itex.name/imoney" title="iMoney">iMoney</a>') :$title;
		if (strlen($this->sidebar_links) >23) echo $before_widget.$before_title . $title . $after_title.
		'<ul><li>'.$this->sidebar_links.'</li></ul>'.$after_widget;
	}

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

	function itex_m_menu()
	{
		if (is_admin()) add_options_page('iMoney', 'iMoney', 10, basename(__FILE__), array(&$this, 'itex_m_admin'));
	}

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
        		
        			<?php //echo substr(phpversion(),0,1);
			//<p>iMoney</p>
//					$id= 1;
//					$publisher = 'ca-pub-9971280513277476';
//					$blog_key = substr( md5( get_bloginfo('url') ), 0, 16 );
//					$content = "<p><map name='google_ad_map_{$id}_$blog_key'>
//<area shape='rect' href='http://imageads.googleadservices.com/pagead/imgclick/$id?pos=0' coords='1,2,367,28' />
//<area shape='rect' href='http://services.google.com/feedback/abg' coords='384,10,453,23'/></map>
//<img usemap='#google_ad_map_{$id}_$blog_key' border='0' src='http://imageads.googleadservices.com/pagead/ads?format=468x30_aff_img&amp;client=$publisher&amp;channel=&amp;output=png&amp;cuid=$id&amp;url= " . urlencode( get_permalink() ) . "' /></p>";
//					echo $content;
//			
			
			
					?>
				<h3>Adsense</h3>
        		<p><?php $this->itex_m_admin_adsense(); ?></p><br/>
        		<h3>Html</h3>
       	 		<p><?php $this->itex_m_admin_html(); ?></p><br/>
       	 		<h3>Sape</h3>
        		<p><?php $this->itex_m_admin_sape(); ?></p><br/>
       	 		<h3>Tnx/Xap</h3>
       	 		<p><?php $this->itex_m_admin_tnx(); ?></p><br/>
       	 		<h3>Begun</h3>
       	 		<p><?php $this->itex_m_admin_begun(); ?></p><br/>
       	 		
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

	function itex_m_admin_sape()
	{
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['sape_sapeuser']) && !empty($_POST['sape_sapeuser']))
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
			
			if (isset($_POST['sape_check']))
			{
				update_option('itex_m_sape_check', intval($_POST['sape_check']));
			}
			if (isset($_POST['sape_masking']))
			{
				update_option('itex_m_sape_masking', intval($_POST['sape_masking']));
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
			//phpinfo();die();//dir();
		}

		$file = $_SERVER['DOCUMENT_ROOT'] . '/' . _SAPE_USER . '/sape.php'; //<< Not working in multihosting.
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

						if(get_option('itex_m_sape_spages_enable')) echo " selected='selected'";
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

						echo "<select name='sapecontext_pages_enable' id='sape_enable'>\n";
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
						<label for=""><?php echo __('Masking of links', 'iMoney'); ?>:</label>
					</th>
					<td>
						<?php
						echo "<select name='sape_masking' id='sape_masking'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_sape_masking')) echo " selected='selected'";
						echo __(">Enabled</option>\n", 'iSape');

						echo "<option value='0'";
						if(!get_option('itex_m_sape_masking')) echo" selected='selected'";
						echo __(">Disabled</option>\n", 'iSape');
						echo "</select>\n";

						echo '<label for="">'.__('Masking of links', 'iMoney').'.</label>';

						?>
					</td>
				</tr>
				<tr>
					<th width="30%" valign="top" style="padding-top: 10px;">
						<label for=""><?php echo __('Check:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						echo "<select name='sape_check' id='sape_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_sape_check')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_sape_check')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";


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

	function itex_m_sape_install_file()
	{
		//file sape.php from sape.ru v1.0.4 21.07.2008
		$sape_php_content = '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';
		$sape_php_content = gzuncompress(base64_decode($sape_php_content));
		$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.get_option('itex_m_sape_sapeuser').'/sape.php';

		$dir = dirname($file);
		//print_r($file.' '.$dir );die();
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
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.__('Sapedir and sape.php created!', 'iMoney').'
		</div>';
		//die();
		return 1;
	}

	function itex_m_admin_adsense()
	{
		$maxblock = 4; //max  adsense blocks - 1
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['adsense_id']) && !empty($_POST['adsense_id']))
			{
				update_option('itex_m_adsense_id', trim($_POST['adsense_id']));
			}
			//print_r($_POST['adsense_enable']);
			if (isset($_POST['adsense_enable']))
			{
				//print_r($_POST);
				//phpinfo();die();
				//echo get_option('itex_m_adsense_enable');
				update_option('itex_m_adsense_enable', intval($_POST['adsense_enable']));
				//echo get_option('itex_m_adsense_enable');
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
					wp_set_sidebars_widgets( $s_w );
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
	
	function itex_m_admin_begun()
	{
		$maxblock = 4; //max  begun blocks - 1
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['begun_id']) && !empty($_POST['begun_id']))
			{
				update_option('itex_m_begun_id', trim($_POST['begun_id']));
			}
			//print_r($_POST['begun_enable']);
			if (isset($_POST['begun_enable']))
			{
				//print_r($_POST);
				//phpinfo();die();
				//echo get_option('itex_m_begun_enable');
				update_option('itex_m_begun_enable', intval($_POST['begun_enable']));
				//echo get_option('itex_m_begun_enable');
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

	function itex_m_admin_tnx()
	{
		if (isset($_POST['info_update']))
		{
			//phpinfo();die();
			if (isset($_POST['tnx_tnxuser']) && !empty($_POST['tnx_tnxuser']))
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

			if (isset($_POST['tnx_check']))
			{
				update_option('itex_m_tnx_check', intval($_POST['tnx_check']));
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

		$file = $_SERVER['DOCUMENT_ROOT'] . '/' . 'tnxdir_'.md5(get_option('itex_m_tnx_tnxuser')) . '/tnx.php'; //<< Not working in multihosting.
		if (file_exists($file)) {}
		else
		{
			$file = str_replace($_SERVER["SCRIPT_NAME"],'',$_SERVER["SCRIPT_FILENAME"]).'/'.'tnxdir_'.md5(get_option('itex_m_tnx_tnxuser')).'/tnx.php';
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

						if(get_option('itex_m_tnx_spages_enable')) echo " selected='selected'";
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
						<label for=""><?php echo __('Check:', 'iMoney'); ?></label>
					</th>
					<td>
						<?php
						echo "<select name='tnx_check' id='tnx_enable'>\n";
						echo "<option value='1'";

						if(get_option('itex_m_tnx_check')) echo " selected='selected'";
						echo ">".__("Enabled", 'iMoney')."</option>\n";

						echo "<option value='0'";
						if(!get_option('itex_m_tnx_check')) echo" selected='selected'";
						echo ">".__("Disabled", 'iMoney')."</option>\n";
						echo "</select>\n";


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
		//chmod($file, 0777);
		echo '
		<div style="margin:10px auto; border:3px  #55ff00 solid; background-color:#afa; padding:10px; text-align:center;">
				'.__('Dir and xap.php created!', 'iMoney').'
		</div>';
		//die();
		return 1;
	}
	
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
		return;
	}

}

$itex_money = & new itex_money();

?>