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
	/* Lis�t��n ylim��r�inen span-elementti a:n sis��n. */
		$node->addChild("span");
	}
	
	if ($node->name() == 'span' && !$node->data()) {
	/* Annetaan �sken lis�tylle tyhj�lle span-elementille classiksi 'korvaus' ja sis�ll�ksi yksi v�liy�nti */
	/* V�lily�nnin ainoa tarkitus on est�� IE7:aa menem�st� sekaisin - kuten tapahtuu, jos t�ll� spanilla ei ole sis�lt��. */
		$node->addAttribute('class', 'korvaus');
		$node->setData(" ");
		
	}
	
	if (($node->name() == 'li') && ($id = $node->attributes('id'))) {
	/* Annetaan li-elementille classiksi "item" + luku, joko kertoo, kuinka mones valikkolinkki on j�rjestyksess�, */
	/* sek� "id" + luku, joka kertoo, mik� on ko. valikkolinkin menu-id Joomlan tietokannassa ja yll�pidossa. */
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
