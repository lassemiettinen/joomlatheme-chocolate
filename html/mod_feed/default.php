<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div style="direction: <?php echo $rssrtl ? 'rtl' :'ltr'; ?>; text-align: <?php echo $rssrtl ? 'right' :'left'; ?> ! important">
<?php
if( $feed != false )
{
	//image handling
	$iUrl 	= isset($feed->image->url)   ? $feed->image->url   : null;
	$iTitle = isset($feed->image->title) ? $feed->image->title : null;
	?>
	<?php
	// feed title
	if (!is_null( $feed->title ) && $params->get('rsstitle', 1)) {
		?>
<h4 class="feedin_linkki">
<a href="<?php echo str_replace( '&', '&amp', $feed->link ); ?>" target="_blank"><?php echo $feed->title; ?></a>
</h4>
<?php
	}

	// feed description or image
	if ($params->get('rssdesc', 1) || ($params->get('rssimage', 1) && $iUrl)) {
	?>
	<div class="kuvaus">
		<?php echo $feed->description; ?>
		<image src="<?php echo $iUrl; ?>" alt="<?php echo @$iTitle; ?>"/>
	</div>
		<?php
	}

	$actualItems = count( $feed->items );
	$setItems    = $params->get('rssitems', 5);

	if ($setItems > $actualItems) {
		$totalItems = $actualItems;
	} else {
		$totalItems = $setItems;
	}
	?>
	<ul class="lista artikkelit feed"  >
	<?php
	$words = $params->def('word_count', 0);
	for ($j = 0; $j < $totalItems; $j ++)
	{
		$currItem = & $feed->items[$j];
		// item title
		?>
		<li>
		<?php
		if ( !is_null( $currItem->get_link() ) ) {
		?>
		<p><a href="<?php echo $currItem->get_link(); ?>" target="_blank"><?php echo $currItem->get_date("j\.n\.Y").' '.$currItem->get_title(); ?></a></p>
		<?php
		}

		// item description
		if ($params->get('rssitemdesc', 1))
		{
			// item description
			$text = $currItem->get_description();
			$text = str_replace('&apos;', "'", $text);

				// word limit check
			if ($words)
			{
				$texts = explode(' ', $text);
				$count = count($texts);
				if ($count > $words)
				{
					$text = '';
					for ($i = 0; $i < $words; $i ++) {
						$text .= ' '.$texts[$i];
					}
					$text .= '...';
				}
			}
			?>
			<div class="kuvaus" style="text-align: <?php echo $params->get('rssrtl', 0) ? 'right': 'left'; ?> ! important">
				<?php echo $text; ?>
			</div>
			<?php
		}
		?>
		</li>
		<?php
	}
	?>
	</ul>

<?php } ?>
</div>
