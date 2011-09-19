<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Client
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * HTTP client class.
 *
 * @package     Joomla.Platform
 * @subpackage  Client
 * @since       11.1
 */
class JGithubGists
{
	/**
	 * Github Connector
	 *
	 * @var    JGithub
	 * @since  11.3
	 */
	protected $connector = null;

	/**
	 * Constructor.
	 *
	 * @param   array  $options  Array of configuration options for the client.
	 *
	 * @return  void
	 *
	 * @since   11.1
	 */
	public function __construct($connector, $options = array())
	{
		$this->connector = $connector;
	}

	protected function paginate($url, $page = 0, $per_page = 0)
	{
		//TODO: Make a new base class and move paginate into it
		$query_string = array();
		
		if ($page > 0) {
			$query_string[] = 'page='.(int)$page;
		}

		if ($per_page > 0) {
			$query_string[] = 'per_page='.(int)$per_page;
		}

		if (isset($query_string[0])) {
			$query = implode('&', $query_string);
		} else {
			$query = '';
		}

		if (strlen($query) > 0) {
			if (strpos($url, '?') === false) {
				$url .= '?'.$query;
			} else {
				$url .= '&'.$query;
			}
		}

		return $url;
	}

	public function getAll($page = 0, $per_page = 0)
	{
		$url = '/gists';
		return $this->connector->sendRequest($this->paginate($url, $page, $per_page));
	}

	public function getByUser($user, $page = 0, $per_page = 0)
	{
		$url = '/users/'.$user.'/gists';
		return $this->connector->sendRequest($this->paginate($url, $page, $per_page));
	}

	public function getPublic($page = 0, $per_page = 0)
	{
		$url = '/gists/public';
		return $this->connector->sendRequest($this->paginate($url, $page, $per_page));
	}

	public function getStarred($page = 0, $per_page = 0)
	{
		$url = '/gists/starred';
		return $this->connector->sendRequest($this->paginate($url, $page, $per_page));
	}

	public function get($id)
	{
		return $this->connector->sendRequest('/gists/'.(int)$id);
	}

	public function create($files, $public = false, $description = null)
	{
		$gist = new stdClass;
		$gist->public = $public;
		$gist->files = $files;

		if (!empty($description)) {
			$gist->description = $description;
		}

		return $this->connector->sendRequest('/gists', $gist, 'post');
	}

	public function edit($id, $files, $description = null)
	{
		$gist = new stdClass;
		$gist->files = $files;

		if (!empty($description)) {
			$gist->description = $description;
		}

		return $this->connector->sendRequest('/gists/'.(int)$id, $gist, 'patch');
	}
}
