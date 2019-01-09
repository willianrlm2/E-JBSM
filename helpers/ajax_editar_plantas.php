<?php

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== null) {
    if($q=="")
        $sql = "select * from ejbsm_planta limit 10";
    else
        $sql = "select * from ejbsm_planta where nome_popular LIKE '%$q%' or ejbsm_planta.especie LIKE '%$q%' limit 10";
    $result = $link->query($sql);
    $j = 0;
    echo "<br>";
    while ($a = mysqli_fetch_object($result)) {
        ?>
        <a href='app_editar_planta.php?id=<?=$a->id?>'>
            <div class="media alert alert-info">
                <div class="media-left">
                    <?
                    imagemPlanta($a->img)
                    ?>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?= $a->nome_popular ?></h4>
                    Espécie: <?= $a->especie ?><br>
                    Descrição: <?=$a->descricao?>
                </div>
            </div>
        </a>
        <?
        $j++;
    }
}
if ($j == 0)
// Output "no suggestion" if no hint was found or output correct values
    echo $hint === "" ? "Sem resultados para '$q'" : $hint;

?>