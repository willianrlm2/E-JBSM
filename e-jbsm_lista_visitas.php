<?php
isUserInRole(array("usuario", "administrador", "orientador", "bolsista"));
;
$inicio_consulta = "";
$info = "";
if (isset($_GET["inicio_consulta"])) {
    $inicio_consulta = $_GET["inicio_consulta"];
}
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<ul class="nav nav-tabs" role="tablist" id="visitas">
    <li role="presentation"><a href="e-jbsm_cadastro_visita.php">Cadastro de visita</a></li>
    <li role="presentation" class="active"><a href="">Lista de visitas</a></li>
    <?php if ($user_permissao != "usuario") { ?>
        <form action="e-jbsm_lista_visitas.php" method="get" style="margin-top: 10px;">
            <div class="input-group">
                <input type="text" name="instituicao" autocomplete="off">
                <button type="submit" class="btn btn-info" value="Pesquisar por instituição">
                    <span class="glyphicon glyphicon-search"></span>
                    Pesquisar por nome de instituição
                </button>
            </div>
        </form>
    <?php } ?>
</ul>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="alert alert-info">
            Aqui você encontra as visitas cadastradas listadas abaixo em 10 registros. Use a paginação no final da
            página para acessar registros mais antigos.
        </div>
        <h3>Lista de visitas</h3>
        <?php
        if ($info == "excluida")
            echo "<div class='alert alert-danger' role='alert' id='excluida'>Visita excluida!</div>";
        elseif ($info == "editada")
            echo "<div class='alert alert-warning' role='alert' id='editada'>Visita editada!</div>";
        if ($user_permissao != "usuario") {
            if ($inicio_consulta != "" and $inicio_consulta > 0) {
                $sql = "select * from ejbsm_visita where excluida = 'nao' order by id desc limit 10 offset $inicio_consulta;";
            } elseif (isset($_GET["instituicao"])) {
                $instituicao = $_GET["instituicao"];
                $sql = "select * from ejbsm_visita where instituicao like '%$instituicao%' order by id desc;";
            } else {
                $sql = "select * from ejbsm_visita WHERE excluida = 'nao' ORDER BY id DESC limit 10";
            }
        } else {
            if ($inicio_consulta != "" and $inicio_consulta > 0)
                $sql = "select * from ejbsm_visita where excluida = 'nao' and login = '$user_login' order by id desc limit 10 offset $inicio_consulta;";
            else
                $sql = "select * from ejbsm_visita where excluida = 'nao' and login = '$user_login' order by id desc limit 10;";
        }
        $result = $link->query($sql) or die(mysqli_error($link));
        $j = 0;
        while ($visita = mysqli_fetch_object($result)) {
            $j++;
            ?>
            <div id='cssmenu'>
                <ul>
                    <li class='active has-sub'>
                        <a>
                        <span>
                            <div class="input-group">
                                <b>ID: </b> <span style="color: green"><?php echo "$visita->id " ?></span>
                                <?php if ($visita->status == "Confirmada") {
                                    echo "<span class='glyphicon glyphicon-ok'>";
                                } elseif ($visita->status == "Em espera") {
                                    echo "<span class='glyphicon glyphicon-warning-sign'>";
                                } else {
                                    echo "<span class='glyphicon glyphicon-remove'>";
                                }
                                echo " $visita->status";
                                ?>
                                <b> Data: </b><span style="color: green"><?php echo "{$visita->data}"; ?></span>
                                <b> Hora: </b><span style="color: green"><?php echo "{$visita->hora}"; ?></span>
                                <b> Instituicao/Grupo: </b><span style="color: green"><?php echo "{$visita->instituicao}"; ?></span>
                            </div>
                        </span>
                        </a>
                        <ul>
                            <li class='has-sub'>
                                <a>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <b>Usuário: </b><?php echo  $visita->login ?><br>
                                                    <b>Data: </b><?php echo  $visita->data ?><br>
                                                    <b>Hora: </b><?php echo  $visita->hora ?><br>
                                                    <b>Oficina:</b><?php echo  $visita->oficina; ?><br>
                                                </div>
                                                <div class="col-md-3">
                                                    <b>Duração de visita:</b><?php echo  $visita->duracao; ?><br>
                                                    <b>Insituicao/Grupo:</b><?php echo  $visita->instituicao; ?><br>
                                                    <b>Tipo de Instituicao:</b><?php echo  $visita->tipo_instituicao; ?><br>
                                                    <b>Monitor:</b><?php echo  $visita->monitor ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <b>Responsável: </b><?php echo  $visita->responsavel; ?><br>
                                                    <b>Cidade: </b><?php echo  $visita->cidade; ?><br>
                                                    <b>Curso / Ano: </b><?php echo  $visita->curso; ?><br>
                                                    <b>Numero de Visitantes: </b><?php echo  $visita->visitantes; ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <b>Telefone: </b><?php echo  $visita->fone; ?><br>
                                                    <b>Conteudo: </b><?php echo  $visita->conteudo; ?><br>
                                                    <b>Auxilio para desenvolver conteudo: </b><?php echo  $visita->auxilio; ?>
                                                    <br>.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <?php if ($visita->status != "Confirmada") { ?>
                                                    <div class="col-md-3">
                                                        <form action="controller/SystemController.php" method="post">
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo  $j ?>">
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                                Excluir visita
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="myModal<?php echo  $j ?>" tabindex="-1"
                                                                 role="dialog"
                                                                 aria-labelledby="myModalLabel"
                                                                 aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span>
                                                                            </button>
                                                                            <h4 class="modal-title" id="myModalLabel">
                                                                                Confirmar exclusão.</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <h3>Deseja mesmo excluir esta visita?
                                                                                (ID: <?php echo  $visita->id ?>)</h3>
                                                                            <h5>Ao excluir a visita, ela poderá ser
                                                                                recuperada através da lixeira.</h5>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                    class="btn btn-default"
                                                                                    data-dismiss="modal">Cancelar
                                                                            </button>
                                                                            <input type="hidden"
                                                                                   value="<?php echo  $visita->id ?>"
                                                                                   name="id">
                                                                            <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::EXCLUIR_VISITA?>">
                                                                            <button type="submit" class="btn btn-danger">
                                                                                <span class="glyphicon glyphicon-remove"></span>
                                                                                Excluir visita
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                <?php } ?>
                                                <?php if ($user_permissao != "usuario") { ?>
                                                    <div class="col-md-3">
                                                        <form action="e-jbsm_editar_visita.php" method="post">
                                                            <div class="input-group">
                                                                <input type="hidden" value="<?php echo  $visita->id ?>"
                                                                       name="id">
                                                                <button type="submit" class="btn btn-warning"
                                                                        value="Editar visita"
                                                                        name="opcao">
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                    Editar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <br>
        <?php } ?>
        <nav class="paginacao">
            <ul class="pagination">
                <?php
                if ($inicio_consulta != "" and $inicio_consulta != 0) {
                    ?>
                    <li>
                        <a href="e-jbsm_lista_visitas.php?inicio_consulta=<?php echo  $inicio_consulta - 10 ?>#visitas">&laquo;</a>
                    </li>
                <?php } ?>
                <li><a href="e-jbsm_lista_visitas.php?inicio_consulta=<?php echo  0 ?>">1</a></li>
                <li><a href="e-jbsm_lista_visitas.php?inicio_consulta=<?php echo  10 ?>">2</a></li>
                <li><a href="e-jbsm_lista_visitas.php?inicio_consulta=<?php echo  20 ?>">3</a></li>
                <li><a href="e-jbsm_lista_visitas.php?inicio_consulta=<?php echo  30 ?>">4</a></li>
                <li><a href="e-jbsm_lista_visitas.php?inicio_consulta=<?php echo  40 ?>">5</a></li>
                <li>
                    <a href="e-jbsm_lista_visitas.php?inicio_consulta=<?php echo  $inicio_consulta + 10 ?>#visitas">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
</div>