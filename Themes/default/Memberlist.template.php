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
use SMF\Theme;
use SMF\Utils;

/**
 * Displays a sortable listing of all members registered on the forum.
 */
function template_main()
{
	echo '
	<div class="main_section" id="memberlist">
		<div class="pagesection">
			', template_button_strip(Utils::$context['memberlist_buttons'], 'right'), '
			<div class="pagelinks floatleft">', Utils::$context['page_index'], '</div>
		</div>
		<div class="cat_bar">
			<h3 class="catbg">
				<span class="floatleft">', Lang::$txt['members_list'], '</span>';

	if (!isset(Utils::$context['old_search']))
		echo '
				<span class="floatright">', Utils::$context['letter_links'], '</span>';
	echo '
			</h3>
		</div>';

	echo '
		<div id="mlist">
			<table class="table_grid">
				<thead>
					<tr class="title_bar">';

	// Display each of the column headers of the table.
	foreach (Utils::$context['columns'] as $key => $column)
	{
		// @TODO maybe find something nicer?
		if ($key == 'email_address' && !Utils::$context['can_send_email'])
			continue;

		// This is a selected column, so underline it or some such.
		if ($column['selected'])
			echo '
						<th scope="col" class="', $key, isset($column['class']) ? ' ' . $column['class'] : '', ' selected" style="width: auto;"' . (isset($column['colspan']) ? ' colspan="' . $column['colspan'] . '"' : '') . '>
							<a href="' . $column['href'] . '" rel="nofollow">' . $column['label'] . '</a><span class="main_icons sort_' . Utils::$context['sort_direction'] . '"></span></th>';

		// This is just some column... show the link and be done with it.
		else
			echo '
						<th scope="col" class="', $key, isset($column['class']) ? ' ' . $column['class'] : '', '"', isset($column['width']) ? ' style="width: ' . $column['width'] . '"' : '', isset($column['colspan']) ? ' colspan="' . $column['colspan'] . '"' : '', '>
						', $column['link'], '</th>';
	}

	echo '
					</tr>
				</thead>
				<tbody>';

	// Assuming there are members loop through each one displaying their data.
	if (!empty(Utils::$context['members']))
	{
		foreach (Utils::$context['members'] as $member)
		{
			echo '
					<tr class="windowbg"', empty($member['sort_letter']) ? '' : ' id="letter' . $member['sort_letter'] . '"', '>
						<td class="is_online centertext">
							', Utils::$context['can_send_pm'] ? '<a href="' . $member['online']['href'] . '" title="' . $member['online']['text'] . '">' : '', Theme::$current->settings['use_image_buttons'] ? '<span class="' . ($member['online']['is_online'] == 1 ? 'on' : 'off') . '" title="' . $member['online']['text'] . '"></span>' : $member['online']['label'], Utils::$context['can_send_pm'] ? '</a>' : '', '
						</td>
						<td class="real_name lefttext">', $member['link'], '</td>';

			if (!isset(Utils::$context['disabled_fields']['website']))
				echo '
						<td class="website_url centertext">', $member['website']['url'] != '' ? '<a href="' . $member['website']['url'] . '" target="_blank" rel="noopener"><span class="main_icons www" title="' . $member['website']['title'] . '"></span></a>' : '', '</td>';

			// Group and date.
			echo '
						<td class="id_group centertext">', empty($member['group']) ? $member['post_group'] : $member['group'], '</td>
						<td class="registered centertext">', $member['registered_date'], '</td>';

			if (!isset(Utils::$context['disabled_fields']['posts']))
			{
				echo '
						<td class="post_count centertext">';

				if (!empty($member['posts']))
					echo '
							<div class="generic_bar">
								<div class="bar" style="width: ', $member['post_percent'], '%;"></div>
								<span>', $member['posts'], '</span>
							</div>';

				echo '
						</td>';
			}

			// Show custom fields marked to be shown here
			if (!empty(Utils::$context['custom_profile_fields']['columns']))
				foreach (Utils::$context['custom_profile_fields']['columns'] as $key => $column)
					echo '
						<td class="', $key, ' centertext">', $member['options'][$key], '</td>';

			echo '
					</tr>';
		}
	}
	// No members?
	else
		echo '
					<tr>
						<td colspan="', Utils::$context['colspan'], '" class="windowbg">', Lang::$txt['search_no_results'], '</td>
					</tr>';

	echo '
				</tbody>
			</table>
		</div><!-- #mlist -->';

	// Show the page numbers again. (makes 'em easier to find!)
	echo '
		<div class="pagesection">
			<div class="pagelinks floatleft">', Utils::$context['page_index'], '</div>';

	// If it is displaying the result of a search show a "search again" link to edit their criteria.
	if (isset(Utils::$context['old_search']))
		echo '
			<div class="buttonlist floatright">
				<a class="button" href="', Config::$scripturl, '?action=mlist;sa=search;search=', Utils::$context['old_search_value'], '">', Lang::$txt['mlist_search_again'], '</a>
			</div>';
	echo '
		</div>
	</div><!-- #memberlist -->';

}

/**
 * A page allowing people to search the member list.
 */
function template_search()
{
	// Start the submission form for the search!
	echo '
	<form action="', Config::$scripturl, '?action=mlist;sa=search" method="post" accept-charset="', Utils::$context['character_set'], '">
		<div id="memberlist">
			<div class="pagesection">
				', template_button_strip(Utils::$context['memberlist_buttons'], 'right'), '
			</div>
			<div class="cat_bar">
				<h3 class="catbg mlist">
					<span class="main_icons filter"></span>', Lang::$txt['mlist_search'], '
				</h3>
			</div>
			<div id="advanced_search" class="roundframe">
				<dl id="mlist_search" class="settings">
					<dt>
						<label><strong>', Lang::$txt['search_for'], '</strong></label>
					</dt>
					<dd>
						<input type="text" name="search" value="', Utils::$context['old_search'], '" size="40">
					</dd>
					<dt>
						<label><strong>', Lang::$txt['mlist_search_filter'], '</strong></label>
					</dt>
					<dd>
						<ul>';

	foreach (Utils::$context['search_fields'] as $id => $title)
		echo '
							<li>
								<input type="checkbox" name="fields[]" id="fields-', $id, '" value="', $id, '"', in_array($id, Utils::$context['search_defaults']) ? ' checked' : '', '>
								<label for="fields-', $id, '">', $title, '</label>
							</li>';

	echo '
						</ul>
					</dd>
				</dl>
				<input type="submit" name="submit" value="' . Lang::$txt['search'] . '" class="button floatright">
			</div><!-- #advanced_search -->
		</div><!-- #memberlist -->
	</form>';
}

?>