<?
$permissao = array("administrador", "orientador", "bolsista");
include 'functions/permitir.php';

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel-body">
    <? include 'forum_texto.php'; ?>
    <h4>Aqui você pode sugerir a criação de uma nova área.</h4>
    <?php if ($info == "area_sugerida") { ?>
        <div class="alert alert-success" role="alert">Sua sugestão de área foi cadastrada</div>
    <?php } ?>
    <form action="controller/Forum_Controller.php" method="post">
        <table class="table">
            <tr>
                <td>Nome da área
                    <input type="text" class="form-control" name="nome" placeholder="Nome da nova área" required="">
                </td>
            </tr>
            <tr>
                <td>Descrição da área
                    <textarea class="form-control" cols="80" name="descricao" placeholder="Descrição da nova área"
                              required=""></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" class="btn btn-success" name="opcao" value="Sugerir área">
                        <span class="glyphicon glyphicon-send"></span>
                        Enviar sugestão
                    </button>
                </td>
            </tr>
        </table>
    </form>
    <h4>Aqui você pode sugerir a criação de uma nova subárea.</h4>
    <?php if ($info == "subarea_sugerida") { ?>
        <div class="alert alert-success" role="alert">Sua sugestão de subárea foi cadastrada</div>
    <?php } ?>
    <form action="controller/Forum_Controller.php" method="post">
        <table class="table">
            <tr>
                <td style="width: 30%">Área
                    <select name="area" class="form-control" required="">
                        <?php
                        $sql = "select * from ejbsm_forum_area where status = 'ativa';";
                        $exec = $link->query($sql) or die(mysql_error());
                        while ($area = mysqli_fetch_object($exec)) {
                            ?>
                            <option value="<?= $area->id ?>"><?= $area->nome ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>Nome da subárea
                    <input type="text" class="form-control" name="nome" placeholder="Nome da nova subárea" required="">
                </td>
            </tr>
            <tr>
                <td colspan="2">Descrição da subárea
                    <textarea class="form-control" cols="80" name="descricao" placeholder="Descrição da nova subárea"
                              required=""></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" class="btn btn-success" name="opcao" value="Sugerir subárea">
                        <span class="glyphicon glyphicon-send"></span>
                        Enviar sugestão
                    </button>
                </td>
            </tr>
        </table>
    </form>
    <?php if ($info == "area_deletada") { ?>
        <div class="alert alert-success" role="alert">Sugestão de área deletada</div>
    <?
    }
    $sql = "select * from ejbsm_forum_area where status != 'ativa'";
    $result = $link->query($sql);
    $numero = mysqli_num_rows($result);
    echo "<h4>Sugestões de áreas ($numero)</h4>";
    while ($area = mysqli_fetch_object($result)) {
        ?>
        <div id='cssmenu'>
            <ul>
                <li class='active has-sub'>
                    <a>
                        <span>
                            <font color="green"><b>Nome da área: </b></font> <? echo $area->nome ?><br><br>
                            <font color="green"><b>Descrição da área: </b></font> <? echo $area->descricao ?>
                        </span>
                    </a>
                    <? if ($user_permissao == "bolsista" or $user_permissao == "administrador" or $user_permissao == "orientador") { ?>
                        <ul>
                            <li class='has-sub'>
                                <a>
                                    <table class="table">
                                        <form action="controller/Forum_Controller.php" method="post">
                                            <tr>
                                                <td colspan="2">Nome da área
                                                    <input type="text" class="form-control" name="area_nome"
                                                           value="<?= $area->nome ?>" required="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Descrição da área
                                                    <textarea name="area_descricao" class="form-control"
                                                              required=""><?= $area->descricao ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="hidden" value="<?= $area->id ?>"
                                                           name="id">
                                                    <input type="hidden" value="<?= $area->nome ?>"
                                                           name="area_nome_antigo">
                                                    <button type="submit" class="btn btn-success" value="Editar área"
                                                            name="opcao">
                                                        <span class="glyphicon glyphicon-save"></span>
                                                        Aceitar esta sugestão
                                                    </button>
                                                </td>
                                        </form>
                                        <form action="controller/Forum_Controller.php" method="post">
                                            <td>

                                                <input type="hidden" value="forum_sugestao" name="local">
                                                <input type="hidden" value="<?= $area->id ?>"
                                                       name="id">
                                                <button type="submit" class="btn btn-danger"
                                                        value="Deletar área"
                                                        name="opcao">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                    Excluir esta sugestão
                                                </button>
                                            </td>
                                        </form>
                                        </tr>
                                    </table>
                                </a>
                            </li>
                        </ul>
                    <? } ?>
                </li>
            </ul>
        </div>
        <hr>
    <?
    }
    ?>
    <?php if ($info == "subarea_deletada") { ?>
        <hr>
        <div class="alert alert-success" role="alert">Sugestão de subárea deletada</div>
    <?
    }
    $sql = "select * from ejbsm_forum_subarea where status != 'ativa'";
    $result = $link->query($sql);
    $numero = mysqli_num_rows($result);
    echo "<h4>Sugestões de subáreas ($numero)</h4>";
    while ($subarea = mysqli_fetch_object($result)) {
        ?>
        <div id='cssmenu'>
            <ul>
                <li class='active has-sub'>
                    <a>
                        <span>
                            <font color="green"><b>Nome da subárea: </b></font> <? echo $subarea->nome ?><br><br>
                            <font color="green"><b>Descrição da área: </b></font> <? echo $subarea->descricao ?><br><br>
                            <?
                            $sql = "select nome from ejbsm_forum_area where id = $subarea->id_area";
                            $pega_nome = mysqli_fetch_object($link->query($sql));
                            $nome_area = $pega_nome->nome;
                            ?>
                            <font color="green"><b>Área: </b></font> <? echo $nome_area ?>
                        </span>
                    </a>
                    <? if ($user_permissao != "usuario") { ?>
                        <ul>
                            <li class='has-sub'>
                                <a>
                                    <table class="table">
                                        <form action="controller/Forum_Controller.php" method="post">
                                            <tr>
                                                <td style="width:30%;">
                                                    <select name="subarea_area" class="form-control">
                                                        <?php
                                                        $sql2 = "select * from ejbsm_forum_area;";
                                                        $qr2 = $link->query($sql2) or die(mysqli_error($link));
                                                        while ($area = mysqli_fetch_object($qr2)) {
                                                            ?>
                                                            <option value="<?= $area->id ?>"><?= $area->nome ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="subarea_nome"
                                                           value="<?= $subarea->nome ?>" required="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="subarea_descricao" class="form-control"
                                                              required=""><?= $subarea->descricao ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="hidden" value="<?= $subarea->id ?>"
                                                           name="id">
                                                    <button type="submit" class="btn btn-success" value="Editar subárea"
                                                            name="opcao">Aceitar esta sugestão
                                                    </button>
                                                </td>
                                        </form>
                                        <form action="../sistema_servlet/forum_controller.php" method="post">
                                            <td>
                                                <input type="hidden" value="<?= $subarea->id ?>"
                                                       name="id">
                                                <button type="submit" class="btn btn-danger"
                                                        value="Deletar subárea"
                                                        name="opcao">Excluir esta sugestão
                                                </button>
                                            </td>
                                            </tr>
                                        </form>
                                    </table>
                                </a>
                            </li>
                        </ul>
                    <? } ?>
                </li>
            </ul>
        </div>
        <hr>
    <?php
    }
    ?>
</div>