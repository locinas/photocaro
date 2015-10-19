<?php

/**
 * Eécupère toutes les photos le l'album et les affichent dans des div.
 * @param $nomAlbum Le nom de l'album pour lesquelles les photos douvent être construites en HTML.
 */
function construireDivImages($nomAlbum) {
	$dir = "photos/" . $nomAlbum;
	$tabImages = creationAssociationImage($dir);
	
	foreach ($tabImages as $smallImage => $bigImage) {
		$pathSmallImage = $dir.'/'.$smallImage;
		$pathBigImage = $dir.'/'.$bigImage;
	
		echo '<div class="grid_4"> <div class="box">
			  <a href="'.$pathBigImage.'" class="gall_item"><img src="'.$pathSmallImage.'" alt=""><span></span></a>		
			  </div> </div>';		
	}
} 

/**
 * Créé un tableau clé / valeur qui contiendra les photos du dossier.
 * @param $dir L'album dans lequel il y a les photos.
 * @return L'association petite image et image affichée en grand.
 */
function creationAssociationImage($dir) {
	$tabImages = scandir($dir);
	
	$tabBig = array();
	$tabSmall = array();
	
	foreach ($tabImages as $image) {
		if(substr_count($image, 'small') > 0){
			array_push($tabSmall, $image);
		} elseif(isImage($image)) {
			array_push($tabBig, $image);
		}
	}
	
	$association = array_fill_keys($tabSmall, '');
	
	foreach ($association as $key => $valeur2) {
		$nomImage = preg_replace('#small#', '', $key);
		foreach ($tabBig as $value) {
			if(substr_count(strtolower($nomImage), strtolower($value)) > 0) {
				$association[$key]= $value;
			}
		}	
	}
	
	return $association;
}

/**
 * Teste si le fichier est une image.
 * @param $image Le fichier à tester.
 * @return true si le fichier est une image.
 */
function isImage($image) {
	if(@!is_array(getimagesize($image)) && "." !== $image && ".." !== $image){
		return true;
	}
	else {
		return false;
	}
}

?>