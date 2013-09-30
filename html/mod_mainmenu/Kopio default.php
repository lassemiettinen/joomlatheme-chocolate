<?php

// no direct access
defined('_JEXEC') or die('Restricted access');


if ( ! defined('customModMainMenuXMLCallbackDefined') )
{
function customModMainMenuXMLCallback(&$node, $args)
{
	$user	= &JFactory::getUser();
	$menu	= &JSite::getMenu();
	$active = $menu->getActive();
	$path	= isset($active) ? array_reverse($active->tree) : null;
	global $jarjestys;
	
	if (($args['end']) && ($node->attributes('level') >= $args['end']))
	{
		$children = $node->children();
		foreach ($node->children() as $child)
		{
			if ($child->name() == 'ul') {
				$node->removeChild($child);
			}
		}
	}

	if ($node->name() == 'ul') {
		foreach ($node->children() as $numero => $child)
		{
			$jarjestys[$child->attributes('id')] = $numero;
			if ($child->attributes('access') > $user->get('aid', 0)) {
				$node->removeChild($child);
			}
		}
	}
				
	if (($node->name() == 'li') && isset($node->ul)) {
		$node->addAttribute('class', 'parent');
	}

	if (isset($path) && (in_array($node->attributes('id'), $path) || in_array($node->attributes('rel'), $path)))
	{
		if ($node->attributes('class')) {
			$node->addAttribute('class', $node->attributes('class').' active');
		} else {
			$node->addAttribute('class', 'active');
		}
	}
	else
	{
		if (isset($args['children']) && !$args['children'])
		{
			$children = $node->children();
			foreach ($node->children() as $child)
			{
				if ($child->name() == 'ul') {
					$node->removeChild($child);
				}
			}
		}
	}
	
	if ($node->name() == 'a') {
	/* Lisätään ylimääräinen span-elementti a:n sisään. */
		$node->addChild("span");
	}
	
	if ($node->name() == 'span' && !$node->data()) {
	/* Annetaan äsken lisätylle tyhjälle span-elementille classiksi 'korvaus' ja sisällöksi yksi väliyönti */
	/* Välilyönnin ainoa tarkitus on estää IE7:aa menemästä sekaisin - kuten tapahtuu, jos tällä spanilla ei ole sisältöä. */
		$node->addAttribute('class', 'korvaus');
		$node->setData(" ");
		
	}
	
	if (($node->name() == 'li') && ($id = $node->attributes('id'))) {
	/* Annetaan li-elementille classiksi "item" + luku, joko kertoo, kuinka mones valikkolinkki on järjestyksessä, */
	/* sekä "id" + luku, joka kertoo, mikä on ko. valikkolinkin menu-id Joomlan tietokannassa ja ylläpidossa. */
		if ($node->attributes('class')) {
			$node->addAttribute('class', $node->attributes('class').' item'.$jarjestys[$id].' id'.$id);
		} else {
			$node->addAttribute('class', 'item'.$jarjestys[$id].' id'.$id);
		}
	}
	
	if (isset($path) && $node->attributes('id') == $path[0]) {
		$node->addAttribute('id', 'current');
	} else {
		$node->removeAttribute('id');
	}
	$node->removeAttribute('rel');
	$node->removeAttribute('level');
	$node->removeAttribute('access');
}
	define('customModMainMenuXMLCallbackDefined', true);
}

modMainMenuHelper::render($params, 'customModMainMenuXMLCallback');
