#URL en la que buscar. Se puede pasar por POST o añadirla directamente entre ""
$url = file_get_contents($_POST['direcciones']);
             
//creamos la variabale para el DOM
$dom = new DOMDocument();
//cargamos el html de la url. Se le añade el @ para evitar que se cuele algún error
@$dom->loadHTML($url);
//creamos la variable para DOMXPATH 
$xpath = new DOMXPath($dom);

//buscamos dentro de $xpath con evaluate los enlaces dentro de la etiqueta body  y dentro de la de html
$hrefs = $xpath->evaluate("/html/body//a");

//buscamos la dirección del logo
$logos = $xpath->evaluate("/html/body//a//img");

//Línea informativa. La variable POST indica la URL que se le pasa
echo "#EXTM3U";
echo "<p>#EXTINF:0 tvg-logo='http://3.bp.blogspot.com/-y4unZ0eDvwI/Va0iM4h5RUI/AAAAAAAAAXI/kzRDvCxSVxg/s1600/m3u.jpg', [B][COLOR red]Listado de canales importables desde ".$_POST['direcciones']." (Pueden tardar un minuto o así en cargar, en caso de que funcione.)[/COLOR][/B]<br/>http://pornicoidico.net</p><br/>";

//Bucle para recorrer todos los enlaces de la página web
for ($i = 0; $i < $hrefs->length; $i++) {
     //buscamos la dirección del canal
     $href = $hrefs->item($i);
     //buscamos la dirección del logo
     
     //nos quedamos con el valor del href             
     $cadena = $href->getAttribute('href');
     
     //nos aseguramos que tenemos una url para el logo             
     if($logos->item($i)!==null){
            //guardamos la iteración
            $logo = $logos->item($i);
            //nos quedamos con el valor del src
            $logoF  = $logo->getAttribute('src');
            //Primera parte de cada uno de los enlaces
            echo '#EXTINF:-1 tvg-id="" tvg-name="" tvg-logo="" group-title="ESPAÑA", '.@$cadena.'<br />';
            //Segunda parte de cada uno de los enlaces
            echo 'plugin://plugin.video.SportsDevil/?mode=1&amp;item=catcher%3dstreams%26url='.@$cadena.'%26referer={Aquí hay que colocar el dominio} <br/><br/>';
      }

}
