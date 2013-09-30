<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>

<jdoc:include type="head" />

<style type="text/css" media="screen">
@import url( <?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css );
</style>

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/print.css" type="text/css" media="print" />

<!--[if lte IE 6]>
	<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/iehacks.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 7]>
	<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie7hacks.css" rel="stylesheet" type="text/css" />
<![endif]-->

</head>
<body>

<div id="accessibility">
 <a href="index.php#menu">Valikko</a>
 <a href="index.php#content">Sisältö</a>
</div>

<div id="ylatunniste">

<div id="otsikko">
<h1><a href="/"><span class="korvaus"></span><?php echo $mainframe->getCfg('sitename');?></a></h1>
</div> <!-- Otsikko paattyy -->

<?php
if($this->countModules('header')) {
?>
<jdoc:include type="modules" name="header" style="xhtml" />
<?php
}
?>
</div> <!-- Ylatunniste paattyy -->

<div id="kaikki">

<div id="laatikko">

<div id="ydinpalkki">

<div id="sisalto-a">
<div id="sisalto-b">
<div id="sisalto-c">
<div id="sisalto-d">
<div id="sisalto-e">
<div id="sisalto-f">

<div id="sivupalkki-1">
<a name="menu"></a>
<?php
if($this->countModules('menu')) { ?>
<div id="valikko">
<jdoc:include type="modules" name="menu" style="rounded" />
</div>
<?php }
?>
<jdoc:include type="modules" name="left" style="rounded" />
</div> <!-- Sivupalkki-1 paattyy -->


<?php if( $this->countModules('breadcrumb') && JRequest::getVar( 'view' ) != 'frontpage' ) {
/* Tässä kohtaa on tarkoitus näyttää VAIN breadcrumb-moduuli, mikäli se on ylipäänsä määritelty näkymään - mutta etusivulla sitä EI missään tapauksessa näytetä. */
/* Se tulostetaan 'raw'-tyylillä, eli ilman otsikkoa ja ympäröivää div-elementtiä.  */
?>
<div id="navipolku">
<jdoc:include type="modules" name="breadcrumb" style="raw" />
</div>
<?php
}
?>

<a name="content"></a>

<jdoc:include type="modules" name="top" style="xhtml" />

<?php if( JRequest::getVar( 'view' ) != 'frontpage' ) {
/* Komponentti näytetään vain, jos ei olla etusivulla */
?>
<jdoc:include type="component" />
<?php
}
?>

<jdoc:include type="modules" name="bottom" style="rounded" />

</div><!-- sisalto-f kiinni -->
</div><!-- sisalto-e kiinni -->
</div><!-- sisalto-d kiinni -->
</div><!-- sisalto-c kiinni -->
</div><!-- sisalto-b kiinni -->
</div><!-- sisalto-a kiinni -->

</div> <!-- 'ydinpalkki' paattyy -->

<?php
if($this->countModules('right')) {
/* Oikeaa sivupalkkia ei näytetä, jos käyttäjä ei ole sijoittanut sinne yhtään moduulia */
?>
<div id="sivupalkki-2">
<div id="sivupalkki-2-sisalto">
<jdoc:include type="modules" name="right" style="xhtml" />
</div> <!-- Sivupalkki-2-sisalto paattyy -->
</div> <!-- Sivupalkki-2 paattyy -->
<?php
}
?>

<?php
if($this->countModules('footer')) {
/* Alatunnistetta ei näytetä, jos käyttäjä ei ole sijoittanut sinne yhtään moduulia */
?>
<div id="alatunniste">
<jdoc:include type="modules" name="footer" style="xhtml" />
</div>
<?php
}
?>

</div> <!-- 'laatikko' paattyy -->

</div> <!-- 'kaikki' paattyy -->

</body>
</html>