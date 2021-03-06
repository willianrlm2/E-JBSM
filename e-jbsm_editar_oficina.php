<?php
isUserInRole(array("administrador", "orientador", "bolsista"));
;
if(isset($_POST["id"])){
    $id = $_POST["id"];
}
$sql = "select * from ejbsm_oficina WHERE id = $id";
$qr = $link->query($sql);
$r = mysqli_fetch_object($qr);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Editar dados de oficina</h3>

        <form action="controller/SystemController.php" method="post">
            <table class="table">
                <tr>
                    <td>Nome
                        <input type="text" class="form-control" placeholder="Nome da oficina" name="nome"
                               value="<?php echo $r->nome ?>" required>
                    </td>
                    <td>Monitor
                        <select name="nome_monitor" class="form-control" required>
                            <?php
                            $sql = "select * from ejbsm_usuario, ejbsm_integrante WHERE ejbsm_usuario.login = ejbsm_integrante.login and monitor AND status != 0";
                            $qr = $link->query($sql);
                            while ($row = mysqli_fetch_object($qr)) {
                                $Pnome = explode(" ", $row->nome);
                                ?>
                                <option value="<?php echo $Pnome[0] ?>"><?php echo "$row->login / ";
                                    echo "$Pnome[0]"; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td colspan="2">Orientador
                        <select name="orientador" class="form-control" required>
                            <?php
                            $sql = "select * from ejbsm_usuario where permissao = 'orientador' or permissao = 'administrador' and status != 0;";
                            $result = $link->query($sql);
                            while ($row = mysqli_fetch_object($result)) {
                                $Pnome = explode(" ", $row->nome);
                                ?>
                                <option value="<?php echo $row->nome ?>"><?php echo "$row->login / ";
                                    echo "$Pnome[0]"; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Descrição
                            <textarea class="form-control" cols="80" rows="3" placeholder="Descrição" name="descricao"
                                      required><?php echo $r->descricao ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Material utilizado
                            <textarea class="form-control" cols="80" rows="3" placeholder="Material" name="material"
                                      required><?php echo $r->material ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Link para mais informações
                            <textarea class="form-control" cols="80" rows="3" placeholder="Link" name="link"
                                      required><?php echo $r->anexo ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input class="form-control" type="hidden" name="id" value="<?php echo $r->id ?>">
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::EDITAR_OFICINA?>">
                        <button class="btn btn-success" type="submit">
                            <span class="glyphicon glyphicon-save"></span>
                            Salvar edição
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>