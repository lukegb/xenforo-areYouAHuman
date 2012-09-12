<?php

/*
   Copyright 2012 Luke Granger-Brown

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

/*
 * Are You a Human? CAPTCHA implementation for xenForo
 * by Luke Granger-Brown
 *
 * Are You Human? code is (c) 2012 Are You a Human
 */

require_once('ayah.php');

/**
 * At present this class uses AYAH's PHP reference implementation.
 *
 * This is irritating because it does several things OOB of xenForo and Zend,
 * such as accessing $_REQUEST directly.
 *
 * It does, however, make it much easier to update this.
 */
class LukeGB_AreYouHuman_Captcha extends XenForo_Captcha_Abstract {
 	/**
 	 * Are You a Human? publisher key and scoring key configuration
 	 *
 	 * I do not provide global keys. Sorry.
 	 */
 	protected $_config = array(
 		'publisher_key' => '',
 		'scoring_key' => ''
	);

	/**
	 * Internal AYAH object
	 */
	protected $_ayah;

	public function __construct(array $config = null)
	{
		if ($config)
		{
			$this->_config = array_merge($this->_config, $config);
		}
		else
		{
			// try xenForo
			$global_options = XenForo_Application::get('options');
			$this->_config['publisher_key'] = $global_options->ayahPublisherKey;
			$this->_config['scoring_key'] = $global_options->ayahScoringKey;
		}

		$this->_ayah = new AYAH($this->_config);
	}

	protected function _captchaWorkable()
	{
		return ($this->_config['publisher_key'] && $this->_config['scoring_key']);
	}

	public function isValid(array $input)
	{
		// check both our publisher key and scoring key are sensible
		// NB empty string is falsy in PHP
		if (!$this->_captchaWorkable())
		{
			return true;
		}

		// check AYAH result
		$result = $this->_ayah->scoreResult();

		// return
		return $result;
	}

	public function renderInternal(XenForo_View $view)
	{
		if (!$this->_captchaWorkable())
		{
			return '';
		}

		return $this->_ayah->getPublisherHTML();
	}
 }