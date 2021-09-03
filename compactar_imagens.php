<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL | E_STRICT);

$dir = "";

$itens = new DirectoryIterator($dir);

foreach($itens as $item)
{
    if($item->gettype() !== 'dir')
    {
        $arquivos[] = $item->getFilename();
    }
    else
    {
    	$subdiretorios[] = $item->getFilename();
    }
}

if($subdiretorios)
{
	foreach($subdiretorios as $subdiretorio)
	{
		$itemsub = new DirectoryIterator($dir . DIRECTORY_SEPARATOR . $subdiretorio);

		foreach($itemsub as $arquivosub)
		{
		    if($arquivosub->gettype() !== 'dir')
		    {
		    	if($subdiretorio !== "." && $subdiretorio !== "..")
		    	{
		        	$arquivossub[] = $dir . DIRECTORY_SEPARATOR . $subdiretorio . DIRECTORY_SEPARATOR . $arquivosub->getFilename();
		        }
		    }
		}
	}
}

if($arquivos)
{
	foreach($arquivos as $arquivo)
	{
		$dest = $dir . DIRECTORY_SEPARATOR . $arquivo;
		comprimeImagem($dest, $dest, 50);
	}
}

if($arquivossub)
{
	foreach($arquivossub as $arquivosub)
	{
		$dest = $arquivosub;
		comprimeImagem($dest, $dest, 50);
	}
}

function comprimeImagem($caminho_de_origem, $pasta_destino, $qualidade) 
{
    $info = getimagesize($caminho_de_origem);

    if ($info['mime'] == 'image/jpeg') 
    {
        $image = imagecreatefromjpeg($caminho_de_origem);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($caminho_de_origem);
    }

    imagejpeg($image, $pasta_destino, $qualidade);

    return $pasta_destino;
}



?>