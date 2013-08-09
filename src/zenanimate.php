<?php
/**
 * Zen Animate
 * @version 1.1
 * @author Joomla Bamboo
 * http://www.joomlabamboo.com
 * Based on JW AllVideos Plugin by Joomlaworks.gr and Xtypo from www.templateplazza.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 *
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgSystemzenanimate extends JPlugin {

	function onAfterRoute() {
		
		$app        = JFactory::getApplication();
		if($app->isAdmin()) {
			return;
		}
		
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base() . 'media/zenanimate/css/animate.css');
	}

	function onAfterRender() {
				
		// Get Plugin info
		jimport( 'joomla.html.parameter' );
		$plugin		= JPluginHelper::getPlugin('system','zenanimate');
		$app        = JFactory::getApplication();
		$document   = JFactory::getDocument();
		$doctype    = $document->getType();
		$output     = JResponse::getBody();
		$urlOption  = JRequest::getVar('option','none');
		$urlTask    = JRequest::getVar('task','none');
		
		$param		= new JForm( $plugin->params );
		$enabled   = $this->params->get('enabled', 1);
		
		if($app->isAdmin()) {
					return;
				}
		
				if($doctype !== 'html') {
					return;
				}
		
				if(($urlOption == 'com_content') and ($urlTask == 'edit')) {
					return;
				}

		unset($app, $doctype, $urlTask, $urlOption, $param, $plugin);

		$regex = array(

			// Animation
			'flash' => array('<span class="animated flash">***code***</span>', '#{flash}(.*?){/flash}#s') ,
			'shake' => array('<span class="animated shake">***code***</span>', '#{shake}(.*?){/shake}#s') ,
			'bounce' => array('<span class="animated bounce">***code***</span>', '#{bounce}(.*?){/bounce}#s') ,
			'tada' => array('<span class="animated tada">***code***</span>', '#{tada}(.*?){/tada}#s') ,
			'swing' => array('<span class="animated swing">***code***</span>', '#{swing}(.*?){/swing}#s') ,
			'wobble' => array('<span class="animated wobble">***code***</span>', '#{wobble}(.*?){/wobble}#s') ,
			'wiggle' => array('<span class="animated wiggle">***code***</span>', '#{wiggle}(.*?){/wiggle}#s') ,
			'pulse' => array('<span class="animated pulse">***code***</span>', '#{pulse}(.*?){/pulse}#s') ,
			'flip' => array('<span class="animated flip">***code***</span>', '#{flip}(.*?){/flip}#s') ,
			'flipX' => array('<span class="animated flipInX">***code***</span>', '#{flipX}(.*?){/flipX}#s') ,
			'flipY' => array('<span class="animated flipInY">***code***</span>', '#{flipY}(.*?){/flipY}#s') ,
			'fade' => array('<span class="animated fadeIn">***code***</span>', '#{fadeIn}(.*?){/fadeIn}#s') ,
			'fadeUp' => array('<span class="animated fadeInUp">***code***</span>', '#{fadeUp}(.*?){/fadeUp}#s') ,
			'fadeDown' => array('<span class="animated fadeInDown">***code***</span>', '#{fadeDown}(.*?){/fadeDown}#s') ,
			'fadeLeft' => array('<span class="animated fadeInLeft">***code***</span>', '#{fadeLeft}(.*?){/fadeLeft}#s') ,
			'fadeRight' => array('<span class="animated fadeInRight">***code***</span>', '#{fadeRight}(.*?){/fadeRight}#s') ,
			'fadeUpBig' => array('<span class="animated fadeInUpBig">***code***</span>', '#{fadeUpBig}(.*?){/fadeUpBig}#s') ,
			'fadeDownBig' => array('<span class="animated fadeInDownBig">***code***</span>', '#{fadeDownBig}(.*?){/fadeDownBig}#s') ,
			'fadeLeftBig' => array('<span class="animated fadeInLeftBig">***code***</span>', '#{fadeLeftBig}(.*?){/fadeLeftBig}#s') ,
			'fadeRightBig' => array('<span class="animated fadeInRightBig">***code***</span>', '#{fadeRightBig}(.*?){/fadeRightBig}#s') ,
			'bounce' => array('<span class="animated bounceIn">***code***</span>', '#{bounce}(.*?){/bounce}#s') ,
			'bounceUp' => array('<span class="animated bounceInUp">***code***</span>', '#{bounceUp}(.*?){/bounceUp}#s') ,
			'bounceDown' => array('<span class="animated bounceInDown">***code***</span>', '#{bounceDown}(.*?){/bounceDown}#s') ,
			'bounceLeft' => array('<span class="animated bounceInLeft">***code***</span>', '#{bounceLeft}(.*?){/bounceLeft}#s') ,
			'bounceRight' => array('<span class="animated bounceInRight">***code***</span>', '#{bounceRight}(.*?){/bounceRight}#s') ,
			'rotate' => array('<span class="animated rotateIn">***code***</span>', '#{rotate}(.*?){/rotate}#s') ,
			'rotateUpLeft' => array('<span class="animated rotateInUpLeft">***code***</span>', '#{rotateUpLeft}(.*?){/rotateUpLeft}#s') ,
			'rotateDownLeft' => array('<span class="animated rotateInDownLeft">***code***</span>', '#{rotateDownLeft}(.*?){/rotateDownLeft}#s') ,
			'rotateUpRight' => array('<span class="animated rotateInUpRight">***code***</span>', '#{rotateUpRight}(.*?){/rotateUpRight}#s') ,
			'rotateDownRight' => array('<span class="animated rotateInDownRight">***code***</span>', '#{rotateDownRight}(.*?){/rotateDownRight}#s') ,
			'lightSpeedIn' => array('<span class="animated lightSpeedIn">***code***</span>', '#{lightSpeedIn}(.*?){/lightSpeedIn}#s') ,
			'lightSpeedOut' => array('<span class="animated lightSpeedOut">***code***</span>', '#{lightSpeedOut}(.*?){/lightSpeedOut}#s') ,
			'hinge' => array('<span class="animated hinge">***code***</span>', '#{hinge}(.*?){/hinge}#s') ,
			'rollIn' => array('<span class="animated rollIn">***code***</span>', '#{rollIn}(.*?){/rollIn}#s') ,
			'rollOut' => array('<span class="animated rollOut">***code***</span>', '#{rollOut}(.*?){/rollOut}#s') ,
		);

		// Remove tag from Breadcrumbs
		$breadcrumbRegex = '/\<(div|span).*class=".*breadcrumbs.*".*\>(.*[^0-9,\n\r]*.*)\<\/\1\>/im';
		if (preg_match_all($breadcrumbRegex, $output, $breadcrumbs, PREG_PATTERN_ORDER) > 0) {

			unset($breadcrumbRegex);

			$breadcrumbs = $breadcrumbs[2];

			$cleanbc = null;
			foreach ($breadcrumbs as $breadcrumb) {
				$cleanbc = $breadcrumb;

				foreach ($regex as $key => $value) {
					if (preg_match_all($value[1], $cleanbc, $matches, PREG_PATTERN_ORDER) > 0) {
						$matches = $matches[0];

						foreach ($matches as $match) {
								$cleanbc = preg_replace('/{'.$key.'}(.*[\n\r.]*.*){\/'.$key.'}/im', '$1', $cleanbc);
						}
					}
				}
				$breadcrumb = preg_quote($breadcrumb);
				$breadcrumb = str_replace('#', '\#', $breadcrumb);
				$output = preg_replace('#('.$breadcrumb.')#Us',$cleanbc, $output);
			}

			unset($cleanbc, $breadcrumbs, $breadcrumb, $matches, $match, $key, $value);
		}

		if ( ! $enabled ) {
			foreach ($regex as $key => $value) {
				unset($value);
				$output = preg_replace( $regex[$key][1], '', $output );
			}

			return;
		}
		unset($enabled);

		// Remove jbtags from meta tags
		$metaRegex = '/(<meta.*content=")(.*)("[^>]*\/>)/im';
		if (preg_match_all($metaRegex, $output, $meta) > 0) {
			$i = 0;
			foreach($meta[0] as $metaDirty)
			{
				$metaClean = $meta[1][$i];
				$metaClean .= preg_replace('/{[\/]*jb_[^}]*}/i', '', $meta[2][$i]);
				$metaClean .= $meta[3][$i];
				$output = str_replace($metaDirty, $metaClean, $output);
				$i++;
			}
		}
		unset($metaRegex, $metaClean, $meta, $metaDirty, $i);

		// Remove jbtags from title tag
		$titleRegex = '/(<title[^>]*>)(.*)(<\/title>)/im';
		if (preg_match($titleRegex, $output, $title) > 0) {
			$titleClean = preg_replace('/{[\/]*jb_[^}]*}/im', ' ', $title[2]);
			$titleClean = preg_replace('/[\s]+/im', ' ', $titleClean);
			$titleClean = $title[1].trim($titleClean).$title[3];
			$output = str_replace($title[0], $titleClean, $output);
		}
		unset($titleRegex, $titleClean, $title);

		// Parse JB Tags
		$startcode       = '';
		$endcode         = '';

		foreach ($regex as $key => $value) {

			if (preg_match_all($value[1], $output, $matches, PREG_PATTERN_ORDER) > 0) {
				foreach ($matches[1] as $match) {

					$classes[] = $key;

					$code = str_replace("***code***", $match, $value[0]);
					$output = str_replace("{".$key."}".$match."{/".$key."}", $startcode.$code.$endcode , $output);
					
				}
		 	}
		}
		unset(
			$key,
			$value,
			$regex,
			$match,
			$matches,
			$code,
			$startcode,
			$endcode/*,
				$tagsToStrip,
				$tagsToExclude,*/
			);

		

		unset(
			$document
			);

		// Remove tags from title in page
		$titleRegex = '/(<div[^>]*id="topHeaderRight">[\n.\s\t\w\r]*<h2[^>]*>)(.*)(<\/h2>)/im';
		if (preg_match_all($titleRegex, $output, $title) > 0) {
			$title = $title[2][0];
			$title = preg_replace('/<br[^>]*>/i', '&nbsp;', $title);
			$cleanTitle = strip_tags($title); // Remove just tags
			$output = preg_replace($titleRegex, '$1'.$cleanTitle.'$3', $output);
		}

		unset($titleRegex, $title, $cleanTitle, $attribs);

		JResponse::setBody($output);

		unset($output);

		return true;
	}
}
?>