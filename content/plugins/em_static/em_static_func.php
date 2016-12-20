<?php defined('EMLOG_ROOT') or die('access denied!');
function em_static_add_datatable() {
	global $tables;
	$tables[] = 'emstatic_cronjob';
}

function em_static_template($file_name) {
	$file_name = preg_replace('/[^A-Z_a-z]/', '', $file_name);
	$file = EM_STATIC_ROOT."/templates/{$file_name}.php";
	return $file;
}

function em_static_write_file($file, $content) {
	$fp = fopen($file, 'w+');
	fwrite($fp, $content);
	fclose($fp);
}

function em_static_tag_to_url($tag) {
	$pinyin = EMStatic_Pinyin::get_instance();
	$tag = $pinyin->cover($tag);
	$tag = str_replace(' ', '', $tag);
	$tag = strtolower($tag);
	$tag = preg_replace('/[^\w-_]/', '', $tag);
	return $tag;
}

function em_static_update_post($post_id) {
	em_static_create_cron_job_by_post_id($post_id);
}

function em_static_delete_post($post_id) {
	em_static_create_cron_job_by_post_id($post_id);
}

function em_static_get_default_config() {
	return array(
		'enable_auto_create' => '0',
		'auto_create_performance_value' => '3',
		'enable_click_trace' => '1',
		'enable_debug_model' => '0',
	);
}

function em_static_write_config_data($config_data = '') {
	if (empty($config_data))
		$config_data = em_static_get_default_config();
	$config_content = "<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!');\nreturn array(\n";
	foreach ($config_data as $index => $value) {
		$config_content .= "\t '{$index}' => '{$value}', \n";
	}
	$config_content .= ");";
	file_put_contents(EM_STATIC_CONFIG_DATA_FILE, $config_content);		
}

function em_static_update_config() {
	if (is_file(EM_STATIC_CONFIG_DATA_FILE)) {
		$old_config = include EM_STATIC_CONFIG_DATA_FILE;
		if ( ! is_array($old_config))
			$old_config = array();		
		$default_config = em_static_get_default_config();
		if (count($default_config) != count($old_config)) {
			$new_config = array_merge($default_config, $old_config);
			em_static_write_config_data($new_config);
		}
	}
}

function em_static_get_default_url_config() {
	return array(
		 'post_path' => 'post/', 
		 'post_format' => '{%日志id%}.html', 
		 'post_alias_path' => 'post/', 
		 'post_alias_format' => '{%日志别名%}.html', 
		 'post_comment_page_path' => 'post/{%日志id%}/comments/p/', 
		 'post_comment_page_format' => '{%页码%}.html', 
		 'post_comment_alias_page_path' => 'post/{%日志别名%}/comments/', 
		 'post_comment_alias_page_format' => '{%页码%}.html',
		 'single_page_path' => '', 
		 'single_page_format' => '{%页面id%}.html', 
		 'single_page_alias_path' => '', 
		 'single_page_alias_format' => '{%页面别名%}.html', 
		 'single_page_comment_page_path' => '', 
		 'single_page_comment_page_format' => '{%页面id%}-comment-{%页码%}.html', 
		 'single_page_comment_alias_page_path' => '', 
		 'single_page_comment_alias_page_format' => '{%页面别名%}-comment-{%页码%}.html',		 
		 'page_path' => 'page/', 
		 'page_format' => '{%页码%}.html', 
		 'sort_path' => 'sort/{%分类id%}/', 
		 'sort_format' => 'index.html', 
		 'sort_alias_path' => 'sort/{%分类别名%}/', 
		 'sort_alias_format' => 'index.html', 
		 'sort_page_path' => 'sort/{%分类id%}/', 
		 'sort_page_format' => '{%页码%}.html', 
		 'sort_page_alias_path' => 'sort/{%分类别名%}/', 
		 'sort_page_alias_format' => '{%页码%}.html', 
		 'tag_path' => 'tag/{%标签别名%}/', 
		 'tag_format' => 'index.html', 
		 'tag_page_path' => 'tag/{%标签别名%}/page/', 
		 'tag_page_format' => '{%页码%}.html', 
		 'record_path' => 'record/{%日期%}/', 
		 'record_format' => 'index.html', 
		 'record_page_path' => 'record/{%日期%}/page/', 
		 'record_page_format' => '{%页码%}.html', 
		 'author_path' => 'author/{%用户id%}/', 
		 'author_format' => 'index.html', 
		 'author_page_path' => 'author/{%用户id%}/page/', 
		 'author_page_format' => '{%页码%}.html', 
	);
}

function em_static_write_url_config_data($config_data = '') {
	if (empty($config_data))
		$config_data = em_static_get_default_url_config();
	$config_content = "<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!');\nreturn array(\n";
	foreach ($config_data as $index => $value) {
		$config_content .= "\t '{$index}' => '{$value}', \n";
	}
	$config_content .= ");";
	file_put_contents(EM_STATIC_CONFIG_FILE, $config_content);		
}

function em_static_update_url_config() {
	if (is_file(EM_STATIC_CONFIG_FILE)) {
		$old_config = include EM_STATIC_CONFIG_FILE;
		if ( ! is_array($old_config))
			$old_config = array();
		$default_config = em_static_get_default_url_config();
		if (count($default_config) != count($old_config)) {
			$new_config = array_merge($default_config, $old_config);
			em_static_write_url_config_data($new_config);
		}
	}
}

function em_static_recreate_tag_cache() {
	$db = Mysql::getInstance();
	$tag_cache = Cache::getInstance()->readCache('logtags');
	$em_tag_cache = array();
	// 重新生成tag别名缓存
	if (is_file(EM_STATIC_TAG_CACHE_FILE)) {
		$em_tag_cache = include EM_STATIC_TAG_CACHE_FILE;
	}
	$pinyin = EMStatic_Pinyin::get_instance();
	
	$file_content = '<?php defined(\'EMLOG_ROOT\') or die(\'本页面禁止直接访问!\');'.chr(10);
	$file_content .= 'return array('.chr(10);
	$query = $db->query('SELECT * FROM '.DB_PREFIX.'tag');
	
	while ($row = $db->fetch_array($query)) {
		if ( ! isset($em_tag_cache[$row['tid']]) ) {
			$alias = $pinyin->cover($row['tagname']);
			$alias = preg_replace('/[^\w-_]+/', '', $alias);
			$em_tag_cache[$row['tid']] = $alias;
			$em_tag_cache[$row['tagname']] = $alias;
		}
	}
	
	
	foreach ($em_tag_cache as $index => $value) {
		if (is_int($index)) {
			$file_content .= '	'.$index.' => "'.$value.'", '.chr(10);
		} else {
			$file_content .= '	"'.$index.'" => "'.$value.'", '.chr(10);
		}
	}
	$file_content .= ');';
	file_put_contents(EM_STATIC_TAG_CACHE_FILE, $file_content);
}

function em_static_update_comment() {
	if ($GLOBALS['em_static_config_data']['enable_auto_create'] == 0)
		return;
	
	$name = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
	$content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
	$mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
	$url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
	$imgcode = isset($_POST['imgcode']) ? strtoupper(trim($_POST['imgcode'])) : '';
	$blogId = isset($_POST['gid']) ? intval($_POST['gid']) : -1;
	$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
	if ( ! $blogId ) {
		return;
	}
	$Comment_Model = new Comment_Model();
	$create = 1;
	if($Comment_Model->isLogCanComment($blogId) === false){
		$create = 0;
	} elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true){
		$create = 0;
	} elseif (empty($name)){
		$create = 0;
	} elseif (strlen($name) > 20){
		$create = 0;
	} elseif ($mail != '' && !checkMail($mail)) {
		$create = 0;
	} elseif (ISLOGIN == false && $Comment_Model->isNameAndMailValid($name, $mail) === false){
		$create = 0;
	} elseif (!empty($url) && preg_match("/^(http|https)\:\/\/[^<>'\"]*$/", $url) == false) {
		$create = 0;
	} elseif (empty($content)) {
		$create = 0;
	} elseif (strlen($content) > 8000) {
		$create = 0;
	} 
	if ($create == 1) {
		$db = Mysql::getInstance();
		$sql = 'SELECT alias FROM '.DB_PREFIX.'blog WHERE gid = '.$blogId;
		$post_info = $db->once_fetch_array($sql);
		em_static_add_cron_job('post', $blogId.','.$post_info['alias'], 1);
	}
}

function em_static_create_cron_job_by_post_id($post_id) {
	$db = Mysql::getInstance();
		
	if ($GLOBALS['em_static_config_data']['enable_auto_create'] == 0)
		return;
	
	$index_lognum = Option::get('index_lognum');
	
	$sql = 'SELECT sortid, author, date, alias, hide FROM '.DB_PREFIX.'blog WHERE gid = '.$post_id;
	$post_info = $db->once_fetch_array($sql);
	// 如果是草稿我们不加入任务
	if ($post_info['hide'] == 'y')
		return;
	
	em_static_add_cron_job('index', '', '', 1);
	em_static_add_cron_job('post', $post_id.','.$post_info['alias'], 1);
	
	// 增加分页生成任务
	$count = $db->once_fetch_array("SELECT COUNT(*) AS total FROM ".DB_PREFIX."blog WHERE type = 'blog'");
	$pages = @ceil($count['total'] / $index_lognum);
	for ($page = 1; $page <= $pages; $page++) {
		if ($page == 1) {
			em_static_add_cron_job('page', '', $page, 1);
		} else {
			em_static_add_cron_job('page', '', $page);
		}
	}
	
	// 增加作者页面生成任务
	$count = $db->once_fetch_array("SELECT COUNT(*) AS total FROM ".DB_PREFIX."blog WHERE type = 'blog' AND author = ".$post_info['author']);
	$pages = @ceil($count['total'] / $index_lognum);
	for ($page = 1; $page <= $pages; $page++) {
		if ($page == 1) {
			em_static_add_cron_job('author', $post_info['author'], $page, 1);
		} else {
			em_static_add_cron_job('author', $post_info['author'], $page);
		}
	}
	
	// 增加分类生成任务
	if (isset($post_info['sortid']) && $post_info['sortid'] != '-1') {
		$count = $db->once_fetch_array("SELECT COUNT(*) AS total FROM ".DB_PREFIX."blog WHERE type = 'blog' AND sortid = ".$post_info['sortid']);
		$pages = @ceil($count['total'] / $index_lognum);
		$sort_info = $db->once_fetch_array("SELECT alias FROM ".DB_PREFIX."sort WHERE sid = ".$post_info['sortid']);
		$alias = $sort_info ? $sort_info['alias'] : '';
		for ($page = 1; $page <= $pages; $page++) {
			if ($page == 1) {
				em_static_add_cron_job('sort', $post_info['sortid'].','.$alias, $page, 1);
			} else {
				em_static_add_cron_job('sort', $post_info['sortid'].','.$alias, $page);
			}
		}
	}
	
	// 增加标签生成任务
	if (isset($tag_cache[$post_id]) && !empty($tag_cache[$post_id])) {
		$tags = $tag_cache[$post_id];
		foreach ($tags as $tag) {
			$row = $db->once_fetch_array("SELECT tid, tagname, gid FROM ".DB_PREFIX."tag WHERE tagname = '{$tag['tagname']}'");
			$post_ids  = substr(trim($row['gid']), 1, -1);
			if ($row) {
				$count = $db->once_fetch_array("SELECT COUNT(*) AS total FROM ".DB_PREFIX."blog WHERE type = 'blog' AND gid IN ($post_ids)");
				$pages = @ceil($count['total'] / $index_lognum);
				for ($page = 1; $page <= $pages; $page++) {
					em_static_add_cron_job('tag', $row['tid'].','.$row['tagname'].','.$em_tag_cache[$row['tid']], $page);
				}
			}
		}
	}
	
	// 增加归档生成任务
	$record = gmdate('Ym', $post_info['date']);
	if (preg_match("/^([\d]{4})([\d]{2})$/", $record, $match)) {
		$days = getMonthDayNum($match[2], $match[1]);
		$record_stime = emStrtotime($record . '01');
		$record_etime = $record_stime + 3600 * 24 * $days;
	} else {
		$record_stime = emStrtotime($record);
		$record_etime = $record_stime + 3600 * 24;
	}
	$sql = "SELECT COUNT(*) AS total FROM ".DB_PREFIX."blog WHERE type = 'blog' AND date >= $record_stime AND date < $record_etime ORDER BY top DESC, date DESC";
	$count = $db->once_fetch_array($sql);
	$pages = @ceil($count['total'] / $index_lognum);
	for ($page = 1; $page <= $pages; $page++) {
		em_static_add_cron_job('record', $record, $page);
	}	
}

function em_static_print_cront_js() {
	$url = BLOG_URL.'content/plugins/em_static/em_static_cron.php';
	echo "
		<script>
		(function() {
		     var s = document.createElement('script');
		     s.type = 'text/javascript';
		     s.async = true;
		     s.src = '$url?t='+ new Date().getTime();
		     var x = document.getElementsByTagName('script')[0];
		     x.parentNode.insertBefore(s, x);
		 })();
		 </script>		
	";
}

function em_static_print_click_trace_js($data) {
	$url = BLOG_URL.'content/plugins/em_static/em_static_trace.php';
	echo "
		<script>
		(function() {
		     var s = document.createElement('script');
		     s.type = 'text/javascript';
		     s.async = true;
		     s.src = '$url?logid=".$data['logid']."&t='+ new Date().getTime();
		     var x = document.getElementsByTagName('script')[0];
		     x.parentNode.insertBefore(s, x);
		 })();
		 </script>		
	";
}



function em_static_add_cron_job($type, $data = '', $page = 0, $prior = 0) {
	$sql = "INSERT INTO ".DB_PREFIX."emstatic_cronjob (`id`, `piror`, `locked`, `type`, `data`, `page`) VALUES (NULL, %d, 0, '%s', '%s', %d)";
	$sql = sprintf($sql, $prior, $type, $data, $page);
	$db = Mysql::getInstance();
	$db->query($sql);
}

class EMStatic { 
	protected static $_instance;
	protected static $_sort_cache;
	protected static $_single_page_cache;
	protected $_config;
	protected $_blog_url;
	protected $_tagcache;
	
	protected function __construct() {
		$this->_config = include EM_STATIC_ROOT.'/em_static_config.php';
		if (is_file(EM_STATIC_TAG_CACHE_FILE))
			$this->_tagcache = include EM_STATIC_TAG_CACHE_FILE;
	}
	
	/**
	 * 
	 * @return EMStatic
	 */
	public static function get_instance() {
		if ( ! self::$_instance) {
			self::$_instance = new EMStatic();
		}
		if ( self::$_sort_cache === null) {
			$db = Mysql::getInstance();
			$sql = 'SELECT b.gid, s.alias FROM '.DB_PREFIX.'blog b INNER JOIN '.DB_PREFIX.'sort s WHERE b.sortid = s.sid;';
			$query = $db->query($sql);
			if ($db->num_rows($query) > 0) {
				while ($row = $db->fetch_array($query)) {
					self::$_sort_cache[$row['gid']] = $row['alias'];
				}
			} else {
				self::$_sort_cache = array();
			}
		}
		if ( self::$_single_page_cache === null) {
			$db = Mysql::getInstance();
			$sql = 'SELECT gid, alias FROM '.DB_PREFIX.'blog WHERE type = \'page\'';
			$query = $db->query($sql);
			if ($db->num_rows($query) > 0) {
				while ($row = $db->fetch_array($query)) {
					self::$_single_page_cache[$row['gid']] = $row['alias'];
				}
			} else {
				self::$_single_page_cache = array();
			}
		}
		
		return self::$_instance;
	}

	public function get_config()
	{
		return $this->_config;
	}
	
	public function create_index_page() {
		$content = $this->fetch_page('');
		$content = $this->page_link_replace($content);
		em_static_write_file(EMLOG_ROOT.'/index.html', $content);
	}

	public function create_post_pages($limit_start, $limit) {
		$this->_create_path_folders($this->_config['page_path']);
		$db = Mysql::getInstance();
		$sql = 'SELECT gid, alias FROM '.DB_PREFIX.'blog WHERE hide = \'n\' AND type = \'blog\' LIMIT '.$limit_start.','.$limit;
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0 ) {
			while ($post = $db->fetch_array($query)) {
				$sort_alias = isset(self::$_sort_cache[$post['gid']]) ? self::$_sort_cache[$post['gid']] : '';
				$this->create_post_page($post['gid'], $post['alias'], $sort_alias);
			}
			return true;
		}
		return false;
	}

	public function create_post_page($gid, $alias = '') {
		$url = '?post='.$gid;
		$content = $this->fetch_page($url);
		$content = $this->page_link_replace($content);
		
		$sort_alias = isset(self::$_sort_cache[$gid]) ? self::$_sort_cache[$gid] : '';
		if (empty($alias))
			$file = $this->get_post_path_with_id($gid, $sort_alias);
		else
			$file = $this->get_post_path_with_alias($alias, $sort_alias);
		em_static_write_file(EMLOG_ROOT.'/'.$file, $content);
		$db = MySQL::getInstance();
		$sql = 'SELECT COUNT(*) AS total FROM '.DB_PREFIX.'comment WHERE gid = '.$gid;
		$query = $db->once_fetch_array($sql);		
		$comments_count = $query['total'];
		$options_cache = Cache::getInstance()->readCache('options');
		$pages = @ceil($comments_count / $options_cache['comment_pnum']);
		if ($pages > 1) {
			for ($i = 2; $i <= $pages; $i++ ) {
				if (empty($alias))
					$file = $this->get_post_comment_page_path_with_id($gid, $i, $sort_alias);
				else
					$file = $this->get_post_comment_page_path_with_alias($alias, $i, $sort_alias);
				$url = '?post='.$gid.'&comment-page='.$i;				
				$content = $this->fetch_page($url);
				$content = $this->page_link_replace($content);
				em_static_write_file(EMLOG_ROOT.'/'.$file, $content);
			}			
		}
	}
	
	public function create_single_pages($limit_start, $limit) {
		$db = Mysql::getInstance();
		$sql = 'SELECT gid, alias FROM '.DB_PREFIX.'blog WHERE hide = \'n\' AND type = \'page\' LIMIT '.$limit_start.','.$limit;
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0 ) {
			while ($post = $db->fetch_array($query)) {
				$this->create_single_page($post['gid'], $post['alias']);
			}
			return true;
		}
		return false;
	}

	public function create_single_page($gid, $alias = '') {
		$url = '?post='.$gid;
		$content = $this->fetch_page($url);
		$content = $this->page_link_replace($content);
		if (empty($alias))
			$file = $this->get_single_page_path_with_id($gid);
		else
			$file = $this->get_single_page_path_with_alias($alias);
		em_static_write_file(EMLOG_ROOT.'/'.$file, $content);
		$db = MySQL::getInstance();
		$sql = 'SELECT COUNT(*) AS total FROM '.DB_PREFIX.'comment WHERE gid = '.$gid;
		$query = $db->once_fetch_array($sql);		
		$comments_count = $query['total'];
		$options_cache = Cache::getInstance()->readCache('options');
		$pages = @ceil($comments_count / $options_cache['comment_pnum']);
		if ($pages > 1) {
			for ($i = 2; $i <= $pages; $i++ ) {
				if (empty($alias))
					$file = $this->get_single_page_comment_page_path_with_id($gid, $i);
				else
					$file = $this->get_single_page_comment_page_path_with_alias($alias, $i);
				$url = '?post='.$gid.'&comment-page='.$i;				
				$content = $this->fetch_page($url);
				$content = $this->page_link_replace($content);
				em_static_write_file(EMLOG_ROOT.'/'.$file, $content);
			}			
		}
	}	
	
	
	public function create_sort_pages($sort_id, $alias, $limit_start, $limit) {
		$db = Mysql::getInstance();
		$sql = 'SELECT COUNT(*) AS total FROM '.DB_PREFIX.'blog WHERE sortid = '.$sort_id;
		$query = $db->once_fetch_array($sql);
		$options_cache = Cache::getInstance()->readCache('options');
		$pages = @ceil($query['total'] / $options_cache['index_lognum']);
		if ($pages == 1 || $limit_start == 2) {
			$this->create_sort_index_page($sort_id, $alias);
		}
				
		if ($pages > 1) {
			if ($pages < $limit_start)
				return false;
			$end = $limit_start + $limit;
			if ($end > $pages)
				$end = $pages;
			for ($i = $limit_start; $i <= $end; $i++ ) {
				$this->create_sort_page($sort_id, $alias, $i);
			}
			return true;			
		}
		return false;
	}
	
	public function create_sort_index_page($sort_id, $alias = '') {
		if (empty($alias)) {
			$file = $this->get_sort_path_with_id($sort_id);
		} else {
			$file = $this->get_sort_path_with_alias($alias);
		}
		$url = '?sort='.$sort_id;
		$content = $this->fetch_page($url);
		$content = $this->page_link_replace($content);
		em_static_write_file(EMLOG_ROOT.'/'.$file, $content);		
	}
	
	public function create_sort_page($sort_id, $alias = '', $page = 0) {
		if (empty($alias)) {
			$file = $this->get_sort_page_path_with_id($sort_id, $page);
		} else {
			$file = $this->get_sort_page_path_with_alias($alias, $page);
		}
		$url = '?sort='.$sort_id.'&page='.$page;
		$content = $this->fetch_page($url);
		$content = $this->page_link_replace($content);
		em_static_write_file(EMLOG_ROOT.'/'.$file, $content);		
	}

	public function create_static_pages() {
		$db = Mysql::getInstance();
		$sql = 'SELECT gid,alias FROM '.DB_PREFIX.'blog WHERE type=\'page\'';
		$query = $db->query($sql);
		while ($log = $db->fetch_array($query)) {
			$this->create_post_page($log['gid'], empty($log['alias']) ? '' : $log['alias']);
		}
	}
	
	public function create_pagination_pages($limit_start, $limit) {
		$options_cache = Cache::getInstance()->readCache('options');
		$log_model = new Log_Model();
		$total_posts = $log_model->getLogNum();
		$pages = @ceil($total_posts / $options_cache['index_lognum']);

		if ($pages > 1) {
			if ($pages < $limit_start)
				return false;
			$end = $limit_start + $limit;
			if ($end > $pages)
				$end = $pages;
			for ($i = $limit_start; $i <= $end; $i++ ) {
				$this->create_pagination_page($i);
			}
			return true;
		}
		return false;
	}
	
	public function create_pagination_page($page_num) {
		$file = $this->get_page_path($page_num);
		$url = '?page='.$page_num;
		$content = $this->fetch_page($url);
		$content = $this->page_link_replace($content);
		em_static_write_file(EMLOG_ROOT.'/'.$file, $content);
	}
	
	public function create_tag_pages($tag_name, $tag_alias, $gids, $limit_start, $limit) {
		$options_cache = Cache::getInstance()->readCache('options');
		$log_model = new Log_Model();
		$gids = substr(trim($gids), 1, -1);
		$sqlSegment = "and gid IN ({$gids}) order by date desc";
		$total_tags = $log_model->getLogNum('n', $sqlSegment);
		$pages = @ceil($total_tags / $options_cache['index_lognum']);

		if ($pages == 1 || $limit_start == 2) {
			// create index page
			$this->create_tag_index_page($tag_name, $tag_alias);
		}
		
		if ($pages > 1) {
			if ($pages < $limit_start)
				return false;
			$end = $limit_start + $limit;
			if ($end > $pages)
				$end = $pages;
			for ($i = $limit_start; $i <= $end; $i++ ) {
				$this->create_tag_page($tag_name, $tag_alias, $i);
			}
			return true;
		}
		return false;
	}
	
	public function create_tag_index_page($tag_name, $tag_alias) {
		$url = '?tag='.rawurlencode($tag_name);
		$content = $this->fetch_page($url);
		$file = EMLOG_ROOT.'/'.$this->get_tag_path($tag_alias);
		$content = $this->page_link_replace($content);
		em_static_write_file($file, $content);		
	}
	
	public function create_tag_page($tag_name, $tag_alias, $page = 0) {
		$url = '?tag='.rawurlencode($tag_name).'&page='.$page;
		$file = EMLOG_ROOT.'/'.$this->get_tag_page_path($tag_alias, $page);
		$content = $this->fetch_page($url);
		$content = $this->page_link_replace($content);
		em_static_write_file($file, $content);		
	}
	
	public function create_author_pages($uid, $limit_start, $limit)
	{
		$cache = Cache::getInstance();
		$options_cache = $cache->readCache('options');
		$sta_cache = $cache->readCache('sta');

		$total_posts = $sta_cache[$uid]['lognum'];
		$pages = @ceil($total_posts / $options_cache['index_lognum']);
		if ($pages == 1 || $limit_start == 2) {
			$this->create_author_index_page($uid);
		}
		
		if ($pages > 1) {
			if ($pages < $limit_start)
				return false;
			$end = $limit_start + $limit;
			if ($end > $pages)
				$end = $pages;
			for ($i = $limit_start; $i <= $end; $i++ ) {
				$this->create_author_page($uid, $i);
			}
			return true;
		}
		return false;
	}
	
	public function create_author_index_page($author_id) {
		$url = '?author='.$author_id;
		$content = $this->fetch_page($url);
		$file = EMLOG_ROOT.'/'.$this->get_author_path($author_id);
		$content = $this->page_link_replace($content);
		em_static_write_file($file, $content);		
	}
	
	public function create_author_page($author_id, $page) {
		$url = '?author='.$author_id.'&page='.$page;
		$file = EMLOG_ROOT.'/'.$this->get_author_page_path($author_id, $page);
		$content = $this->fetch_page($url);
		$content = $this->page_link_replace($content);
		em_static_write_file($file, $content);		
	}
	
	public function create_record_pages($date, $lognum, $limit_start, $limit)
	{
		$cache = Cache::getInstance();
		$options_cache = $cache->readCache('options');
		$pages = @ceil($lognum / $options_cache['index_lognum']);
		if ($pages == 1 OR $limit_start == 2) {
			$this->create_record_index_page($date);
		}
		// create list pages
		if ($pages > 1) {
			if ($pages < $limit_start)
				return false;
			$end = $limit_start + $limit;
			if ($end > $pages)
				$end = $pages;
			for ($i = $limit_start; $i <= $end; $i++ ) {
				$this->create_record_page($date, $i); 
			}
			return true;
		}
		return false;
	}
	
	public function create_record_index_page($date) {
		$url = '?record='.$date;
		$content = $this->fetch_page($url);
		$file = EMLOG_ROOT.'/'.$this->get_record_path($date);
		$content = $this->page_link_replace($content);
		em_static_write_file($file, $content);		
	}
	
	public function create_record_page($date, $page) {
		$url = '?record='.$date.'&page='.$page;
		$file = EMLOG_ROOT.'/'.$this->get_record_page_path($date, $page);
		$content = $this->fetch_page($url);
		$content = $this->page_link_replace($content);
		em_static_write_file($file, $content);		
	}
	

	public function page_link_replace($content) {
		$blog_url = str_replace('/', '\\/', BLOG_URL);
		// post comment
		$content = preg_replace_callback('/('.$blog_url.')\?post=(\d+)&comment-page=(\d+)/', array($this, 'page_comment_page_url_replace_callback'), $content);		
		// post
		$content = preg_replace_callback('/('.$blog_url.')\?post=(\d+)/', array($this, 'post_url_replace_callback'), $content);	
		// page
		$content = preg_replace_callback('/('.$blog_url.')\?page=(\d+)/', array($this, 'page_url_replace_callback'), $content);
		// sort page
		$content = preg_replace_callback('/('.$blog_url.')\?sort=(\d+)&page=(\d+)/', array($this, 'sort_page_url_replace_callback'), $content);		
		// sort
		$content = preg_replace_callback('/('.$blog_url.')\?sort=(\d+)/', array($this, 'sort_url_replace_callback'), $content);
		// tag page
		$content = preg_replace_callback('/('.$blog_url.')\?tag=([\w%\\+-]+)&page=(\d+)/', array($this, 'tag_page_url_replace_callback'), $content);
		// tag
		$content = preg_replace_callback('/('.$blog_url.')\?tag=([\w%\\+-]+)/', array($this, 'tag_url_replace_callback'), $content);
		// record page
		$content = preg_replace_callback('/('.$blog_url.')\?record=(\d+)&page=(\d+)/', array($this, 'record_page_url_replace_callback'), $content);		
		// record
		$content = preg_replace_callback('/('.$blog_url.')\?record=(\d+)/', array($this, 'record_url_replace_callback'), $content);
		// author page
		$content = preg_replace_callback('/('.$blog_url.')\?author=(\d+)&page=(\d+)/', array($this, 'author_page_url_replace_callback'), $content);			
		// author
		$content = preg_replace_callback('/('.$blog_url.')\?author=(\d+)/', array($this, 'author_url_replace_callback'), $content);	
		// make sure other dynamic links still uses index.php
		$content = preg_replace('/('.$blog_url.')\?(.+)/', '$1index.php?$2', $content);		
		return $content;
	}
	
	public function post_url_replace_callback($matchs) {
		$logalias_cache = Cache::getInstance()->readCache('logalias');
		$base_url = $matchs[1];
		$gid = $matchs[2];
		$sort_alias = isset(self::$_sort_cache[$gid]) ? self::$_sort_cache[$gid] : '';
		if ( ! array_key_exists($gid, self::$_single_page_cache) && ! empty($logalias_cache[$gid])) {
			return $base_url.$this->get_post_path_with_alias($logalias_cache[$gid], $sort_alias);
		} elseif (array_key_exists($gid, self::$_single_page_cache)) {
			if (empty(self::$_single_page_cache[$gid])) {
				return $base_url.$this->get_single_page_path_with_id($gid);
			} else {
				return $base_url.$this->get_single_page_path_with_alias(self::$_single_page_cache[$gid]);
			}
		} else {
			return $base_url.$this->get_post_path_with_id($gid, $sort_alias);
		}
	}

	public function get_post_path_with_id($post_id, $sort_alias) {
		$file = str_replace('{%日志id%}', $post_id, $this->_config['post_format']);
		$file = str_replace('{%分类别名%}', $sort_alias, $file);
		$path = str_replace('{%日志id%}', $post_id, $this->_config['post_path']);
		$path = str_replace('{%分类别名%}', $sort_alias, $path);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}
	
	public function get_post_path_with_alias($alias, $sort_alias) {
		$file = str_replace('{%日志别名%}', $alias, $this->_config['post_alias_format']);
		$file = str_replace('{%分类别名%}', $sort_alias, $file);
		$path = str_replace('{%日志别名%}', $alias, $this->_config['post_alias_path']);
		$path = str_replace('{%分类别名%}', $sort_alias, $path);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);		
		return $path.$file;
	}
	
	public function get_single_page_path_with_id($post_id) {
		$file = str_replace('{%页面id%}', $post_id, $this->_config['single_page_format']);
		$path = str_replace('{%页面id%}', $post_id, $this->_config['single_page_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}
	
	public function get_single_page_path_with_alias($alias) {
		$file = str_replace('{%页面别名%}', $alias, $this->_config['single_page_alias_format']);
		$path = str_replace('{%页面别名%}', $alias, $this->_config['single_page_alias_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);		
		return $path.$file;
	}	

	public function page_comment_page_url_replace_callback($matchs) {
		$logalias_cache = Cache::getInstance()->readCache('logalias');
		$base_url = $matchs[1];
		$gid = $matchs[2];
		$page = $matchs[3];
		$sort_alias = isset(self::$_sort_cache[$gid]) ? self::$_sort_cache[$gid] : '';		
		if ( ! empty($logalias_cache[$gid])) {
			$url = $base_url.$this->get_post_comment_page_path_with_alias($logalias_cache[$gid], $page, $sort_alias);
			return $url;
		} else {
			$url = $base_url.$this->get_post_comment_page_path_with_id($gid, $page, $sort_alias);
			return $url;
		}
	}	

	public function get_post_comment_page_path($post_id, $page, $sort_alias) {
		$file = str_replace('{%日志id%}', $post_id, $this->_config['post_comment_page_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$file = str_replace('{%分类别名%}', $sort_alias, $file);
		$path = str_replace('{%日志id%}', $post_id, $this->_config['post_comment_page_path']);
		$path = str_replace('{%分类别名%}', $sort_alias, $path);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}	
	
	public function page_url_replace_callback($matchs) {
		$url = $matchs[1].$this->get_page_path($matchs[2]);
		return $url;
	}
	
	public function get_page_path($page) {
		$file = str_replace('{%页码%}', $page, $this->_config['page_format']);
		$path = $this->_clean_path($this->_config['page_path']);
		$this->_create_path_folders($path);
		return $path.$file;
	}

	public function sort_url_replace_callback($matchs) {
		$CACHE = Cache::getInstance();
		$sort_cache = $CACHE->readCache('sort');
		if ( isset($sort_cache[$matchs[2]]['alias']) && ! empty($sort_cache[$matchs[2]]['alias'])) {
			return $matchs[1].$this->get_sort_path_with_alias($sort_cache[$matchs[2]]['alias']);
		} else {
			return $matchs[1].$this->get_sort_path_with_id($matchs[2]);
		}
	}
	
	public function get_sort_path_with_id($sort_id) {
		$file = str_replace('{%分类id%}', $sort_id, $this->_config['sort_format']);
		$path = str_replace('{%分类id%}', $sort_id, $this->_config['sort_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}
	
	public function get_sort_path_with_alias($alias) {
		$file = str_replace('{%分类别名%}', $alias, $this->_config['sort_alias_format']);
		$path = str_replace('{%分类别名%}', $alias, $this->_config['sort_alias_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}
	
	public function get_post_comment_page_path_with_id($post_id, $page, $sort_alias) {
		$file = str_replace('{%日志id%}', $post_id, $this->_config['post_comment_page_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$file = str_replace('{%分类别名%}', $sort_alias, $file);
		$path = str_replace('{%日志id%}', $post_id, $this->_config['post_comment_page_path']);
		$path = str_replace('{%分类别名%}', $sort_alias, $path);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}	
	
	public function get_post_comment_page_path_with_alias($alias, $page, $sort_alias) {
		$file = str_replace('{%日志别名%}', $alias, $this->_config['post_comment_alias_page_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$file = str_replace('{%分类别名%}', $sort_alias, $file);
		$path = str_replace('{%日志别名%}', $alias, $this->_config['post_comment_alias_page_path']);
		$path = str_replace('{%分类别名%}', $sort_alias, $path);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}	
	
	public function get_single_page_comment_page_path_with_id($post_id, $page) {
		$file = str_replace('{%页面id%}', $post_id, $this->_config['single_page_comment_page_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$path = str_replace('{%日志id%}', $post_id, $this->_config['single_page_comment_page_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}	
	
	public function get_single_page_comment_page_path_with_alias($alias, $page) {
		$file = str_replace('{%页面别名%}', $alias, $this->_config['single_page_comment_alias_page_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$path = str_replace('{%页面别名%}', $alias, $this->_config['single_page_comment_alias_page_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}	
	

	public function sort_page_url_replace_callback($matchs) {
		$CACHE = Cache::getInstance();
		$sort_cache = $CACHE->readCache('sort');
		if ( isset($sort_cache[$matchs[2]]['alias']) && ! empty($sort_cache[$matchs[2]]['alias'])) {
			return $matchs[1].$this->get_sort_page_path_with_alias($sort_cache[$matchs[2]]['alias'], $matchs[3]);
		} else {
			return $matchs[1].$this->get_sort_page_path_with_id($matchs[2], $matchs[3]);
		}		
	}
	
	public function get_sort_page_path_with_id($sort_id, $page) {
		$file = str_replace('{%分类id%}', $sort_id, $this->_config['sort_page_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$path = str_replace('{%分类id%}', $sort_id, $this->_config['sort_page_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}
	
	public function get_sort_page_path_with_alias($alias, $page) {
		$file = str_replace('{%分类别名%}', $alias, $this->_config['sort_page_alias_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$path = str_replace('{%分类别名%}', $alias, $this->_config['sort_page_alias_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}	
	
	public function tag_url_replace_callback($matchs) {
		$tag = $matchs[2];
		$tag = str_replace('+', ' ', rawurldecode($tag));
		return $matchs[1].$this->get_tag_path($tag);
	}
	
	public function get_tag_path($tag) {
		if (isset($this->_tagcache[$tag]))
			$tag = $this->_tagcache[$tag];
		else
			$tag = urlencode($tag);		
		$file = str_replace('{%标签别名%}', $tag, $this->_config['tag_format']);
		$path = str_replace('{%标签别名%}', $tag, $this->_config['tag_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}

	public function tag_page_url_replace_callback($matchs) {
		$tag = $matchs[2];
		$tag = str_replace('+', ' ', rawurldecode($tag));
		return $matchs[1].$this->get_tag_page_path($tag, $matchs[3]);
	}
	
	public function get_tag_page_path($tag, $page) {
		if (isset($this->_tagcache[$tag]))
			$tag = $this->_tagcache[$tag];
		else
			$tag = urlencode($tag);
		$file = str_replace('{%标签别名%}', $tag, $this->_config['tag_page_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$path = str_replace('{%标签别名%}', $tag, $this->_config['tag_page_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}	
	
	public function record_url_replace_callback($matchs) {
		return $matchs[1].$this->get_record_path($matchs[2]);
	}
	
	public function get_record_path($time) {
		$file = str_replace('{%日期%}', $time, $this->_config['record_format']);
		$path = str_replace('{%日期%}', $time, $this->_config['record_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}

	public function record_page_url_replace_callback($matchs) {
		return $matchs[1].$this->get_record_page_path($matchs[2], $matchs[3]);
	}
	
	public function get_record_page_path($time, $page) {
		$file = str_replace('{%日期%}', $time, $this->_config['record_page_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$path = str_replace('{%日期%}', $time, $this->_config['record_page_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;		
	}

	public function author_url_replace_callback($matchs) {
		return $matchs[1].$this->get_author_path($matchs[2]);
	}
	
	public function get_author_path($author_id) {
		$file = str_replace('{%用户id%}', $author_id, $this->_config['author_format']);
		$path = str_replace('{%用户id%}', $author_id, $this->_config['author_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}

	public function author_page_url_replace_callback($matchs) {		
		return $matchs[1].$this->get_author_page_path($matchs[2], $matchs[3]);
	}
	
	public function get_author_page_path($author_id, $page) {
		$file = str_replace('{%用户id%}', $author_id, $this->_config['author_page_format']);
		$file = str_replace('{%页码%}', $page, $file);
		$path = str_replace('{%用户id%}', $author_id, $this->_config['author_page_path']);
		$path = $this->_clean_path($path);
		$this->_create_path_folders($path);
		return $path.$file;
	}

	protected function fetch_page($url) {
//		// 5.x 处理
//		if (preg_match('/^5\./', Option::EMLOG_VERSION)) {
//			$url = '/'.$url;
//			define('TEMPLATE_PATH', TPLS_PATH.Option::get('nonce_templet').'/');
//			$routing_table = Option::getRoutingTable();
//			
//			$call_back_controller = $call_back_method = $params = '';
//			foreach ($routing_table as $route) {
//				if (preg_match($route['reg_0'], $url, $matches)) {
//					$call_back_controller = $route['model'];
//					$call_back_method = $route['method'];
//					$params = $matches;
//					break;
//				}
//			}
//						
//			$controller = new $call_back_controller();
//			ob_start();
//			$controller->$call_back_method($params);
//			$content = ob_get_clean();
//			return $content;
//		}
		
		// 4.x 处理
//		if (preg_match('/^4\./', Option::EMLOG_VERSION)) {
			$url = BLOG_URL.'index.php'.$url;
			$http = EmStatic_Http::factory($url);
			$content = $http->send();
			return $content;			
//		}
	}
	
	protected function _create_path_folders($path) {
		if (empty($path)) 
			return;
		if (is_dir(EMLOG_ROOT.'/'.$path)) 
			return;
		$folders = explode('/', $path);
		$f = EMLOG_ROOT;
		foreach ($folders as $folder) {
			$f .= '/'.$folder;
			if ( ! is_dir($f)) {
				@mkdir($f);
			}
		}
	}
	
	protected function _clean_path($path)
	{
		return $path == '/' ? '' : $path;
	}
	
	protected function _debug($var)
	{
		$fp = fopen('./debug.txt', 'a');
		fwrite($fp, var_export($var.chr(10), true));
		fclose($fp);
	}
}

class EmStatic_Http {  
	/** 
	 * @var 使用 CURL 
	 */  
	const TYPE_CURL   = 1;  
	/** 
	 * @var 使用 Socket 
	 */   
	const TYPE_SOCK   = 2;  
	/** 
	 * @var 使用 Stream 
	 */   
	const TYPE_STREAM  = 3;  
	/**
	 * http 静态实例
	 */
	protected static $_instance = null;

	/** 
	 * 保证对象不被clone 
	 */  
	protected function __clone() {}  

	/** 
	 * 构造函数 
	 */  
	protected function __construct() {}  
   
   
	/** 
	 * HTTP工厂操作方法 
	 * 
	 * @param string $url 需要访问的URL 
	 * @param int $type 需要使用的HTTP类 
	 * @return object 
	 */  
	public static function factory($url = '', $type = self::TYPE_CURL) {  
		if (self::$_instance instanceof Http_Basic) {
			return self::$_instance;
		}
		if ($type == '') {  
			$type = self::TYPE_SOCK;  
		}
		switch($type) {  
			case self::TYPE_CURL :  
				if (!function_exists('curl_init')) {  
					throw new Exception(__CLASS__ . " PHP CURL extension not install");  
				}  
				self::$_instance = new EmStatic_Http_Curl($url);  
				break;  
			case self::TYPE_SOCK :  
				if (!function_exists('fsockopen')) {  
					throw new Exception(__CLASS__ . " PHP function fsockopen() not support");  
				}      
				self::$_instance = new EmStatic_Http_Sock($url);  
				break;  
			case self::TYPE_STREAM :  
				if (!function_exists('stream_context_create')) {  
					throw new Exception(__CLASS__ . " PHP Stream extension not install");  
				}      
				self::$_instance = new EmStatic_Http_Stream($url);  
				break;  
				default:  
				throw new Exception("http access type $type not support");  
		}  
		return self::$_instance;
	}  
	
	
	/** 
	 * 生成一个供Cookie或HTTP GET Query的字符串 
	 * 
	 * @param array $data 需要生产的数据数组，必须是 Name => Value 结构 
	 * @param string $sep 两个变量值之间分割的字符，缺省是 &  
	 * @return string 返回生成好的Cookie 查询字符串 
	 */  
	public static function makeQuery($data, $sep = '&'){  
		$encoded = '';  
		while (list($k,$v) = each($data)) {   
			$encoded .= ($encoded ? "$sep" : "");  
			$encoded .= rawurlencode($k) ."=". rawurlencode($v);   
		}   
		return $encoded;
	}
}  
   
abstract class EmStatic_Http_Basic {
	/** 
	 * @var object 对象单例 
	 */  
	static $_instance = NULL;  

	/** 
	 * @var string 需要发送的cookie信息 
	 */  
	protected $cookies = '';  
	/** 
	 * @var array 需要发送的头信息 
	 */  
	protected $header = array();  
	/** 
	 * @var string 需要访问的URL地址 
	 */   
	protected $uri = '';  
	/** 
	 * @var array 需要发送的数据 
	 */  
	protected $vars = array(); 
	/** 
	 * 保证对象不被clone 
	 */  
	protected function __clone() {}
	
	/** 
	 * 构造函数 
	 * 
	 * @param string $configFile 配置文件路径 
	 */  
	public function __construct($url) {  
		$this->uri = $url;  
	}  

	/** 
	 * 设置需要发送的HTTP头信息 
	 *  
	 * @param array/string 需要设置的头信息，可以是一个 类似 array('Host: example.com', 'Accept-Language: zh-cn') 的头信息数组 
	 *       或单一的一条类似于 'Host: example.com' 头信息字符串 
	 * @return void 
	 */  
	public function setHeader($header) {  
		if (empty($header)) {  
			return;  
		}
		if (is_array($header)) {  
			foreach ($header as $k => $v){  
				$this->header[] = is_numeric($k) ? trim($v) : (trim($k) .": ". trim($v));      
			}  
		} elseif (is_string($header)) {  
			$this->header[] = $header;  
		}  
	}  
	
	/** 
	* 设置Cookie头信息 
	*  
	* 注意：本函数只能调用一次，下次调用会覆盖上一次的设置 
	* 
	* @param string/array 需要设置的 Cookie信息，一个类似于 'name1=value1&name2=value2' 的Cookie字符串信息， 
	*         或者是一个 array('name1'=& gt;'value1', 'name2'=>'value2') 的一维数组 
	* @return void 
	*/  
	public function setCookie($cookie){  
		if (empty($cookie)) {  
			return;  
		}  
		if (is_array($cookie)) {  
			$this->cookies = Http::makeQuery($cookie, ';');  
		} elseif (is_string($cookie)) {  
			$this->cookies = $cookie;  
		}  
	}  
	
	/** 
	 * 设置要发送的数据信息 
	 * 
	 * 注意：本函数只能调用一次，下次调用会覆盖上一次的设置 
	 * 
	 * @param array 设置需要发送的数据信息，一个类似于 array('name1'=>'value1', 'name2'=>'value2') 的一维数组 
	 * @return void 
	 */  
	public function setVar($vars) {  
		if (empty($vars)) {  
			return;  
		}  
		if (is_array($vars)) {  
			$this->vars = $vars;  
		}   
	}  
	
	/** 
	 * 设置要请求的URL地址 
	 * 
	 * @param string $url 需要设置的URL地址 
	 * @return void 
	 */  
	public function setUrl($url) {  
		if ($url != '') {  
			$this->uri = $url;  
		}  
	}  
	 
   
	/** 
	 * 发送HTTP GET请求 
	 * 
	 * @param string $url 如果初始化对象的时候没有设置或者要设置不同的访问URL，可以传本参数 
	 * @param array $vars 需要单独返送的GET变量 
	 * @param array/string 需要设置的头信息，可以是一个 类似 array('Host: example.com', 'Accept-Language: zh-cn') 的头信息数组 
	 *         或单一的一条类似于 'Host: example.com' 头信息字符串 
	 * @param string/array 需要设置的Cookie信息，一个类似于 'name1=value1&name2=value2' 的Cookie字符串信息， 
	 *         或者是一个 array('name1'=& gt;'value1', 'name2'=>'value2') 的一维数组 
	 * @param int $timeout 连接对方服务器访问超时时间，单位为秒 
	 * @return unknown 
	 */  
	public function get($url = '', $vars = array(), $header = array(), $cookie = '', $timeout = 30){  
		$this->setUrl($url);  
		$this->setHeader($header);  
		$this->setCookie($cookie);  
		$this->setVar($vars);  
		return $this->send('GET', $timeout);  
	}   
	
   
	/** 
	 * 发送HTTP POST请求 
	 * 
	 * @param string $url 如果初始化对象的时候没有设置或者要设置不同的访问URL，可以传本参数 
	 * @param array $vars 需要单独返送的GET变量 
	 * @param array/string 需要设置的头信息，可以是一个 类似 array('Host: example.com', 'Accept-Language: zh-cn') 的头信息数组 
	 *         或单一的一条类似于 'Host: example.com' 头信息字符串 
	 * @param string/array 需要设置的Cookie信息，一个类似于 'name1=value1&name2=value2' 的Cookie字符串信息， 
	 *         或者是一个 array('name1'=& gt;'value1', 'name2'=>'value2') 的一维数组 
	 * @param int $timeout 连接对方服务器访问超时时间，单位为秒 
	 * @param array $options 当前操作类一些特殊的属性设置 
	 * @return unknown 
	 */  
	public function post($url = '', $vars = array(), $header = array(), $cookie = '', $timeout = 5, $options = array()) {  
		$this->setUrl($url);  
		$this->setHeader($header);  
		$this->setCookie($cookie);  
		$this->setVar($vars);  
		return $this->send('POST', $timeout);  
	}
	
	protected function unchunkHttp11($data) {
		$fp = 0;
		$outData = '';
		while ($fp < strlen($data)) {
			$rawnum = substr($data, $fp, strpos(substr($data, $fp), "\r\n") + 2);
			$num = hexdec(trim($rawnum));
			$fp += strlen($rawnum);
			$chunk = substr($data, $fp, $num);
			$outData .= $chunk;
			$fp += strlen($chunk);
		}
		return $outData;
	}
}


 
   
   
 /** 
  * 使用CURL 作为核心操作的HTTP访问类 
  * 
  * @desc CURL 以稳定、高效、移植性强作为很重要的HTTP 协议访问客户端，必须在PHP中安装 CURL 扩展才能使用本功能 
  */  
class EmStatic_Http_Curl extends EmStatic_Http_Basic {
	/** 
	 * 发送HTTP请求核心函数 
	 * 
	 * @param string $method 使用GET还是 POST方式访问 
	 * @param array $vars 需要另外附加发送的GET/POST数据 
	 * @param int $timeout 连接对方服务器访问超时时间，单位为秒 
	 * @param array $options 当前操作类一些特殊的属性设置 
	 * @return string 返回服务器端读取的返回数据 
	 */  
	public function send($method = 'GET', $timeout = 30, $options = array()) {  
		// 处理参数是否为空  
		if ($this->uri == '') {  
			throw new Exception(__CLASS__ .": Access url is empty");  
		}  

		// 初始化CURL  
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_HEADER, 0);  
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);  

		// 设置特殊属性  
		if (!empty($options)){  
			curl_setopt_array($ch , $options);  
		}          
		// 处理GET请求参数  
		if ($method == 'GET' && !empty($this->vars)) {  
			$query = Http::makeQuery($this->vars);  
			$parse = parse_url($this->uri);  
			$sep = isset($parse['query'])  ?  '&'  : '?';  
			$this->uri .= $sep . $query;  
		}  
		// 处理POST请求数据  
		if ($method == 'POST'){  
			curl_setopt($ch, CURLOPT_POST, 1 );  
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->vars);  
		}  

		// 设置cookie信息  
		if (!empty($this->cookies)) {  
			curl_setopt($ch, CURLOPT_COOKIE, $this->cookies);  
		}  
		// 设置HTTP缺省头  
		if (empty($this->header)) {  
			$this->header = array(  
				'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1)',  
				//'Accept-Language: zh-cn',            
				//'Cache-Control: no-cache',  
			);  
		}  
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);  
		// 发送请求读取输数据  
		curl_setopt($ch, CURLOPT_URL, $this->uri);          
		$data = curl_exec($ch);  
		if ($err = curl_error($ch)) {  
			curl_close($ch);  
			throw new  Exception(__CLASS__ ." error: ". $err);  
		}  
		curl_close($ch);  
		return $data;  
	}
}  

class EMStatic_Pinyin {

	
	protected $_index = array();
	
	private static $_instance;
	
	private function __construct() {
		$fp = fopen(EM_STATIC_ROOT.'/res/pinyin.dat', 'r');
		while (!feof($fp)) {
			$line = trim(fgets($fp));
			$this->_index[$line[0] . $line[1]] = substr($line, 3, strlen($line) - 3);
		}
		fclose($fp);		
	}
	
	public function __destruct() {
		unset($this->_index);
	}
	
	public static function get_instance() {
		if ( ! self::$_instance) {
			self::$_instance = new EMStatic_Pinyin();
		}
		return self::$_instance;
	}
	
	
	public function cover($str, $head_only = 0) {
		if (function_exists('iconv')) 
		{
			$str = iconv('utf-8', 'GBK', $str);
		}
		else if (function_exists('mb_convert_encoding')) 
		{
			$str = mb_convert_encoding($str, 'GBK', 'utf-8');
		}
		
		$restr = '';
		$str = trim($str);
		$slen = strlen($str);
		if ($slen < 2) {
			return $str;
		}
		for ($i = 0; $i < $slen; $i++) {
			if (ord($str[$i]) > 0x80) {
				$c = $str[$i] . $str[$i + 1];
				$i++;
				if (isset($this->_index[$c])) {
					if ($head_only == 0) {
						$restr .= $this->_index[$c];
					} else {
						$restr .= $this->_index[$c][0];
					}
				} else {
					$restr .= "_";
				}
			} else if (preg_match("/[A-Za-z0-9]/", $str[$i])) {
				$restr .= $str[$i];
			} else {
				$restr .= "_";
			}
		}
		return $restr;
	}	
}