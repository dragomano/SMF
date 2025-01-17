<?php
/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines https://www.simplemachines.org
 * @copyright 2025 Simple Machines and individual contributors
 * @license https://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 3.0 Alpha 2
 */

use SMF\Config;
use SMF\Lang;
use SMF\Utils;

/**
 * The template for sending newsletters
 */
function template_email_members()
{
	// Are we done sending the newsletter?
	if (!empty(Utils::$context['newsletter_sent']))
		echo '
	<div class="infobox">', Lang::$txt['admin_news_newsletter_' . Utils::$context['newsletter_sent']], '</div>';

	echo '
		<form action="', Config::$scripturl, '?action=admin;area=news;sa=mailingcompose" method="post" id="admin_newsletters" class="flow_hidden" accept-charset="', Utils::$context['character_set'], '">
			<div class="cat_bar">
				<h3 class="catbg">', Lang::$txt['admin_newsletters'], '</h3>
			</div>
			<div class="information noup">
				', Lang::$txt['admin_news_select_recipients'], '
			</div>
			<div class="windowbg noup">
				<dl class="settings">
					<dt>
						<strong>', Lang::$txt['admin_news_select_group'], '</strong><br>
						<span class="smalltext">', Lang::$txt['admin_news_select_group_desc'], '</span>
					</dt>
					<dd>';

	foreach (Utils::$context['groups'] as $group)
		echo '
						<label for="groups_', $group['id'], '"><input type="checkbox" name="groups[', $group['id'], ']" id="groups_', $group['id'], '" value="', $group['id'], '" checked> ', $group['name'], '</label> <em>(', $group['member_count'] ?? Lang::$txt['not_applicable'], ')</em><br>';

	echo '
						<br>
						<label for="checkAllGroups"><input type="checkbox" id="checkAllGroups" checked onclick="invertAll(this, this.form, \'groups\');"> <em>', Lang::$txt['check_all'], '</em></label>
					</dd>
				</dl>
				<div id="advanced_panel_header" class="title_bar">
					<h3 class="titlebg">
						<span id="advanced_panel_toggle" class="toggle_down floatright" style="display: none;"></span>
						<a href="#" id="advanced_panel_link">', Lang::$txt['advanced'], '</a>
					</h3>
				</div>
				<div id="advanced_panel_div" class="padding">
					<dl class="settings">
						<dt>
							<strong>', Lang::$txt['admin_news_select_email'], '</strong><br>
							<span class="smalltext">', Lang::$txt['admin_news_select_email_desc'], '</span>
						</dt>
						<dd>
							<textarea name="emails" rows="5" cols="30" style="width: 98%;"></textarea>
						</dd>
						<dt>
							<strong>', Lang::$txt['admin_news_select_members'], '</strong><br>
							<span class="smalltext">', Lang::$txt['admin_news_select_members_desc'], '</span>
						</dt>
						<dd>
							<input type="text" name="members" id="members" value="" size="30">
							<span id="members_container"></span>
						</dd>
					</dl>
					<hr class="bordercolor">
					<dl class="settings">
						<dt>
							<strong>', Lang::$txt['admin_news_select_excluded_groups'], '</strong><br>
							<span class="smalltext">', Lang::$txt['admin_news_select_excluded_groups_desc'], '</span>
						</dt>
						<dd>';

	foreach (Utils::$context['groups'] as $group)
		echo '
							<label for="exclude_groups_', $group['id'], '"><input type="checkbox" name="exclude_groups[', $group['id'], ']" id="exclude_groups_', $group['id'], '" value="', $group['id'], '"> ', $group['name'], '</label> <em>(', $group['member_count'], ')</em><br>';

	echo '
							<br>
							<label for="checkAllGroupsExclude"><input type="checkbox" id="checkAllGroupsExclude" onclick="invertAll(this, this.form, \'exclude_groups\');"> <em>', Lang::$txt['check_all'], '</em></label><br>
						</dd>
						<dt>
							<strong>', Lang::$txt['admin_news_select_excluded_members'], '</strong><br>
							<span class="smalltext">', Lang::$txt['admin_news_select_excluded_members_desc'], '</span>
						</dt>
							<dd>
							<input type="text" name="exclude_members" id="exclude_members" value="" size="30">
							<span id="exclude_members_container"></span>
						</dd>
					</dl>
					<hr class="bordercolor">
					<dl class="settings">
						<dt>
							<label for="email_force"><strong>', Lang::$txt['admin_news_select_override_notify'], '</strong></label><br>
							<span class="smalltext">', Lang::$txt['email_force'], '</span>
						</dt>
						<dd>
							<input type="checkbox" name="email_force" id="email_force" value="1">
						</dd>
					</dl>
				</div><!-- #advanced_panel_div -->
				<br>
				<input type="submit" value="', Lang::$txt['admin_next'], '" class="button">
				<input type="hidden" name="', Utils::$context['session_var'], '" value="', Utils::$context['session_id'], '">
			</div><!-- .windowbg -->
		</form>';

	// This is some javascript for the simple/advanced toggling and member suggest
	echo '
	<script>
		var oAdvancedPanelToggle = new smc_Toggle({
			bToggleEnabled: true,
			bCurrentlyCollapsed: true,
			aSwappableContainers: [
				\'advanced_panel_div\'
			],
			aSwapImages: [
				{
					sId: \'advanced_panel_toggle\',
					altExpanded: ', Utils::escapeJavaScript(Lang::$txt['hide']), ',
					altCollapsed: ', Utils::escapeJavaScript(Lang::$txt['show']), '
				}
			],
			aSwapLinks: [
				{
					sId: \'advanced_panel_link\',
					msgExpanded: ', Utils::escapeJavaScript(Lang::$txt['advanced']), ',
					msgCollapsed: ', Utils::escapeJavaScript(Lang::$txt['advanced']), '
				}
			]
		});
	</script>
	<script>
		var oMemberSuggest = new smc_AutoSuggest({
			sSelf: \'oMemberSuggest\',
			sSessionId: smf_session_id,
			sSessionVar: smf_session_var,
			sSuggestId: \'members\',
			sControlId: \'members\',
			sSearchType: \'member\',
			bItemList: true,
			sPostName: \'member_list\',
			sURLMask: \'action=profile;u=%item_id%\',
			sTextDeleteItem: \'', Lang::$txt['autosuggest_delete_item'], '\',
			sItemListContainerId: \'members_container\',
			aListItems: []
		});
		var oExcludeMemberSuggest = new smc_AutoSuggest({
			sSelf: \'oExcludeMemberSuggest\',
			sSessionId: \'', Utils::$context['session_id'], '\',
			sSessionVar: \'', Utils::$context['session_var'], '\',
			sSuggestId: \'exclude_members\',
			sControlId: \'exclude_members\',
			sSearchType: \'member\',
			bItemList: true,
			sPostName: \'exclude_member_list\',
			sURLMask: \'action=profile;u=%item_id%\',
			sTextDeleteItem: \'', Lang::$txt['autosuggest_delete_item'], '\',
			sItemListContainerId: \'exclude_members_container\',
			aListItems: []
		});
	</script>';
}

/**
 * The form for composing a newsletter
 */
function template_email_members_compose()
{
	echo '
	<div id="preview_section"', isset(Utils::$context['preview_message']) ? '' : ' class="hidden"', '>
		<div class="cat_bar">
			<h3 class="catbg">
				<span id="preview_subject">', empty(Utils::$context['preview_subject']) ? '' : Utils::$context['preview_subject'], '</span>
			</h3>
		</div>
		<div class="windowbg">
			<div class="post" id="preview_body">
				', empty(Utils::$context['preview_message']) ? '<br>' : Utils::$context['preview_message'], '
			</div>
		</div>
	</div>
	<br>';

	echo '
		<form name="newsmodify" action="', Config::$scripturl, '?action=admin;area=news;sa=mailingsend" method="post" accept-charset="', Utils::$context['character_set'], '">
			<div class="cat_bar">
				<h3 class="catbg">
					<a href="', Config::$scripturl, '?action=helpadmin;help=email_members" onclick="return reqOverlayDiv(this.href);" class="help"><span class="main_icons help" title="', Lang::$txt['help'], '"></span></a> ', Lang::$txt['admin_newsletters'], '
				</h3>
			</div>
			<div class="information noup">
				', Lang::getTxt('email_variables', ['scripturl' => Config::$scripturl]), '
			</div>
			<div class="windowbg noup">
				<div class="', empty(Utils::$context['error_type']) || Utils::$context['error_type'] != 'serious' ? 'noticebox' : 'errorbox', '"', empty(Utils::$context['post_error']['messages']) ? ' style="display: none"' : '', ' id="errors">
					<dl>
						<dt>
							<strong id="error_serious">', Lang::$txt['error_while_submitting'], '</strong>
						</dt>
						<dd class="error" id="error_list">
							', empty(Utils::$context['post_error']['messages']) ? '' : implode('<br>', Utils::$context['post_error']['messages']), '
						</dd>
					</dl>
				</div>
				<dl id="post_header">
					<dt>
						<label', (isset(Utils::$context['post_error']['no_subject']) ? ' class="error"' : ''), ' for="subject" id="caption_subject">', Lang::$txt['subject'], '</label>
					</dt>
					<dd id="pm_subject">
						<input type="text" id="subject" name="subject" value="', Utils::$context['subject'], '" tabindex="', Utils::$context['tabindex']++, '" size="80" maxlength="84"', isset(Utils::$context['post_error']['no_subject']) ? ' class="error"' : '', '>
					</dd>
				</dl>
				<div id="bbcBox_message"></div>';

	// What about smileys?
	if (!empty(Utils::$context['smileys']['postform']) || !empty(Utils::$context['smileys']['popup']))
		echo '
				<div id="smileyBox_message"></div>';

	// Show BBC buttons, smileys and textbox.
	echo '
				', template_control_richedit(Utils::$context['post_box_name'], 'smileyBox_message', 'bbcBox_message');

	echo '
				<ul>
					<li><label for="send_pm"><input type="checkbox" name="send_pm" id="send_pm"', !empty(Utils::$context['send_pm']) ? ' checked' : '', ' onclick="checkboxes_status(this);"> ', Lang::$txt['email_as_pms'], '</label></li>
					<li><label for="send_html"><input type="checkbox" name="send_html" id="send_html"', !empty(Utils::$context['send_html']) ? ' checked' : '', ' onclick="checkboxes_status(this);"> ', Lang::$txt['email_as_html'], '</label></li>
					<li><label for="parse_html"><input type="checkbox" name="parse_html" id="parse_html" checked disabled> ', Lang::$txt['email_parsed_html'], '</label></li>
				</ul>
				<span id="post_confirm_buttons">
					', template_control_richedit_buttons(Utils::$context['post_box_name']), '
				</span>
			</div><!-- .windowbg -->
			<input type="hidden" name="', Utils::$context['session_var'], '" value="', Utils::$context['session_id'], '">
			<input type="hidden" name="email_force" value="', Utils::$context['email_force'], '">
			<input type="hidden" name="total_emails" value="', Utils::$context['total_emails'], '">';

	foreach (Utils::$context['recipients'] as $key => $values)
		echo '
			<input type="hidden" name="', $key, '" value="', implode(($key == 'emails' ? ';' : ','), $values), '">';

	echo '
			<script>';

	// The functions used to preview a posts without loading a new page.
	echo '
				var txt_preview_title = "', Lang::$txt['preview_title'], '";
				var txt_preview_fetch = "', Lang::$txt['preview_fetch'], '";
				function previewPost()
				{
					if (window.XMLHttpRequest)
					{
						// Opera didn\'t support setRequestHeader() before 8.01.
						// @todo Remove support for old browsers
						if (\'opera\' in window)
						{
							// Handle the WYSIWYG editor.
							if (textFields[i] == ', Utils::escapeJavaScript(Utils::$context['post_box_name']), ' && ', Utils::escapeJavaScript('oEditorHandle_' . Utils::$context['post_box_name']), ' in window && oEditorHandle_', Utils::$context['post_box_name'], '.bRichTextEnabled)
								x[x.length] = \'message_mode=1&\' + textFields[i] + \'=\' + oEditorHandle_', Utils::$context['post_box_name'], '.getText(false).php_to8bit().php_urlencode();
							else
								x[x.length] = textFields[i] + \'=\' + document.forms.newsmodify[textFields[i]].value.php_to8bit().php_urlencode();
						}
						// @todo Currently not sending poll options and option checkboxes.
						var x = new Array();
						var textFields = [\'subject\', ', Utils::escapeJavaScript(Utils::$context['post_box_name']), '];
						var checkboxFields = [\'send_html\', \'send_pm\'];

						for (var i = 0, n = textFields.length; i < n; i++)
							if (textFields[i] in document.forms.newsmodify)
							{
								// Handle the WYSIWYG editor.
								if (textFields[i] == ', Utils::escapeJavaScript(Utils::$context['post_box_name']), ' && ', Utils::escapeJavaScript('oEditorHandle_' . Utils::$context['post_box_name']), ' in window && oEditorHandle_', Utils::$context['post_box_name'], '.bRichTextEnabled)
									x[x.length] = \'message_mode=1&\' + textFields[i] + \'=\' + oEditorHandle_', Utils::$context['post_box_name'], '.getText(false).replace(/&#/g, \'&#38;#\').php_to8bit().php_urlencode();
								else
									x[x.length] = textFields[i] + \'=\' + document.forms.newsmodify[textFields[i]].value.replace(/&#/g, \'&#38;#\').php_to8bit().php_urlencode();
							}
						for (var i = 0, n = checkboxFields.length; i < n; i++)
							if (checkboxFields[i] in document.forms.newsmodify && document.forms.newsmodify.elements[checkboxFields[i]].checked)
								x[x.length] = checkboxFields[i] + \'=\' + document.forms.newsmodify.elements[checkboxFields[i]].value;

						x[x.length] = \'item=newsletterpreview\';

						sendXMLDocument(smf_prepareScriptUrl(smf_scripturl) + \'action=xmlhttp;sa=previews;xml\', x.join(\'&\'), onDocSent);

						document.getElementById(\'preview_section\').style.display = \'\';
						setInnerHTML(document.getElementById(\'preview_subject\'), txt_preview_title);
						setInnerHTML(document.getElementById(\'preview_body\'), txt_preview_fetch);

						return false;
					}
					else
						return submitThisOnce(document.forms.newsmodify);
				}
				function onDocSent(XMLDoc)
				{
					if (!XMLDoc)
					{
						document.forms.newsmodify.preview.onclick = new function ()
						{
							return true;
						}
						document.forms.newsmodify.preview.click();
					}

					// Show the preview section.
					var preview = XMLDoc.getElementsByTagName(\'smf\')[0].getElementsByTagName(\'preview\')[0];
					setInnerHTML(document.getElementById(\'preview_subject\'), preview.getElementsByTagName(\'subject\')[0].firstChild.nodeValue);

					var bodyText = \'\';
					for (var i = 0, n = preview.getElementsByTagName(\'body\')[0].childNodes.length; i < n; i++)
						bodyText += preview.getElementsByTagName(\'body\')[0].childNodes[i].nodeValue;

					setInnerHTML(document.getElementById(\'preview_body\'), bodyText);
					document.getElementById(\'preview_body\').className = \'post\';

					// Show a list of errors (if any).
					var errors = XMLDoc.getElementsByTagName(\'smf\')[0].getElementsByTagName(\'errors\')[0];
					var errorList = new Array();
					for (var i = 0, numErrors = errors.getElementsByTagName(\'error\').length; i < numErrors; i++)
						errorList[errorList.length] = errors.getElementsByTagName(\'error\')[i].firstChild.nodeValue;
					document.getElementById(\'errors\').style.display = numErrors == 0 ? \'none\' : \'\';
					setInnerHTML(document.getElementById(\'error_list\'), numErrors == 0 ? \'\' : errorList.join(\'<br>\'));

					// Adjust the color of captions if the given data is erroneous.
					var captions = errors.getElementsByTagName(\'caption\');
					for (var i = 0, numCaptions = errors.getElementsByTagName(\'caption\').length; i < numCaptions; i++)
						if (document.getElementById(\'caption_\' + captions[i].getAttribute(\'name\')))
							document.getElementById(\'caption_\' + captions[i].getAttribute(\'name\')).className = captions[i].getAttribute(\'class\');

					if (errors.getElementsByTagName(\'post_error\').length == 1)
						document.forms.newsmodify.', Utils::$context['post_box_name'], '.style.border = \'1px solid red\';
					else if (document.forms.newsmodify.', Utils::$context['post_box_name'], '.style.borderColor == \'red\' || document.forms.newsmodify.', Utils::$context['post_box_name'], '.style.borderColor == \'red red red red\')
					{
						if (\'runtimeStyle\' in document.forms.newsmodify.', Utils::$context['post_box_name'], ')
							document.forms.newsmodify.', Utils::$context['post_box_name'], '.style.borderColor = \'\';
						else
							document.forms.newsmodify.', Utils::$context['post_box_name'], '.style.border = null;
					}
					location.hash = \'#\' + \'preview_section\';
				}
			</script>';

	echo '
			<script>
				function checkboxes_status (item)
				{
					if (item.id == \'send_html\')
						document.getElementById(\'parse_html\').disabled = !document.getElementById(\'parse_html\').disabled;
					if (item.id == \'send_pm\')
					{
						if (!document.getElementById(\'send_html\').checked)
							document.getElementById(\'parse_html\').disabled = true;
						else
							document.getElementById(\'parse_html\').disabled = false;
						document.getElementById(\'send_html\').disabled = !document.getElementById(\'send_html\').disabled;
					}
				}
			</script>
		</form>';
}

/**
 * The page shown while the newsletter is being sent
 */
function template_email_members_send()
{
	echo '
		<form action="', Config::$scripturl, '?action=admin;area=news;sa=mailingsend" method="post" accept-charset="', Utils::$context['character_set'], '" name="autoSubmit" id="autoSubmit">
			<div class="cat_bar">
				<h3 class="catbg">
					<a href="', Config::$scripturl, '?action=helpadmin;help=email_members" onclick="return reqOverlayDiv(this.href);" class="help"><span class="main_icons help" title="', Lang::$txt['help'], '"></span></a> ', Lang::$txt['admin_newsletters'], '
				</h3>
			</div>
			<div class="windowbg">
				<div class="progress_bar">
					<span>', Lang::getTxt('email_done', Utils::$context), '</span>
					<div class="bar" style="width: ', Utils::$context['percentage_done'], '%;"></div>
				</div>
				<hr>
				<input type="submit" name="b" value="', Lang::$txt['email_continue'], '" class="button">
				<input type="hidden" name="', Utils::$context['session_var'], '" value="', Utils::$context['session_id'], '">
				<input type="hidden" name="subject" value="', Utils::$context['subject'], '">
				<input type="hidden" name="message" value="', Utils::$context['message'], '">
				<input type="hidden" name="start" value="', Utils::$context['start'], '">
				<input type="hidden" name="total_members" value="', Utils::$context['total_members'], '">
				<input type="hidden" name="total_emails" value="', Utils::$context['total_emails'], '">
				<input type="hidden" name="send_pm" value="', Utils::$context['send_pm'], '">
				<input type="hidden" name="send_html" value="', Utils::$context['send_html'], '">
				<input type="hidden" name="parse_html" value="', Utils::$context['parse_html'], '">';

	// All the things we must remember!
	foreach (Utils::$context['recipients'] as $key => $values)
		echo '
				<input type="hidden" name="', $key, '" value="', implode(($key == 'emails' ? ';' : ','), $values), '">';

	echo '
			</div><!-- .windowbg -->
		</form>

	<script>
		var countdown = 2;
		doAutoSubmit();

		function doAutoSubmit()
		{
			if (countdown == 0)
				document.forms.autoSubmit.submit();
			else if (countdown == -1)
				return;

			document.forms.autoSubmit.b.value = "', Lang::$txt['email_continue'], ' (" + countdown + ")";
			countdown--;

			setTimeout("doAutoSubmit();", 1000);
		}
	</script>';
}

/**
 * The settings page.
 */
function template_news_lists()
{
	if (!empty(Utils::$context['saved_successful']))
		echo '
			<div class="infobox">', Lang::$txt['settings_saved'], '</div>';

	template_show_list('news_lists');
}

?>