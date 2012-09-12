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
 *
 * -----------------------------------------------------
 * library/LukeGB/AreYouHuman/Override.php:
 * Class for hooking xF code events
 */

/**
 * "Override" class for xF code events.
 */
class LukeGB_AreYouHuman_Override {
	/*
	 * Hook for option_captcha_render to add Are You a Human? to the list of available CAPTCHAs.
	 */
	public static function codeEventOptionCaptchaRender(&$extraChoices, $view, $preparedOption) {
		// add Are You a Human? to the choices list
		$extraChoices['LukeGB_AreYouHuman_Captcha'] = array(
			"label" => "Use Are You a Human?",
			"hint" => "<a href='admin.php?options/list/lukegb_ayah'>Set your keys</a>",
			"value" => "LukeGB_AreYouHuman_Captcha"
			);
	}
}