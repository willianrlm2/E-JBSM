<?
$permissao = array("administrador", "orientador");
include 'functions/permitir.php';
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Editar dados de bolsista</h3>
        <form action="controller/Controller.php" method="post">
            <?
            if(isset($_POST["bolsista_login"])) {
                $bolsista_login = $_POST["bolsista_login"];
            }
            $consulta = "select * from ejbsm_usuario, ejbsm_integrante where ejbsm_integrante.login = '$bolsista_login' and ejbsm_usuario.login=ejbsm_integrante.login";
            $resultado = $link->query($consulta) or die(mysqli_error($link));
            $user = mysqli_fetch_object($resultado);
            ?>
            <table class="table table-hover">
                <tr>
                    <td>
                        <b>Dados</b>
                    </td>
                    <td>
                        <b>Valores Atuais</b>
                    </td>
                    <td>
                        <b>Novos Valores</b>
                    </td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td><?= $user->nome; ?></td>
                    <td colspan="2"><input type="text" class="form-control" value="<?= $user->nome; ?>" name="nome" required></td>
                </tr>
                <tr>
                    <td>Matricula:</td>
                    <td><?= $user->id; ?></td>
                    <td><input type="number" class="form-control" value="<?= $user->id; ?>" name="matricula" required></td>
                </tr>
                <tr>
                    <script>
                        function setText() {
                            var x = document.getElementById('select1')
                            value = x.options[x.selectedIndex].value
                            if (value == 'Sim') {
                                campo1.innerHTML = "<input type='password' placeholder='inisra a senha...' class='form-control' name='senha'>"
                            }
                            else {
                                campo1.innerHTML = "";
                            }
                        }
                    </script>
                    <td>Alterar senha?</td>
                    <td>
                        <select class="form-control" onChange='setText()' id='select1'>
                            <option>Não</option>
                            <option>Sim</option>
                        </select>
                    </td>
                    <td id="campo1">

                    </td>
                </tr>
                <tr>
                    <td>Área de atuação:</td>
                    <td><?= $user->area; ?></td>
                    <td><input type="text" class="form-control" value="<?= $user->area; ?>" name="area" required></td>
                </tr>
                <tr>
                    <td>Ênfase:</td>
                    <td><?= $user->subarea; ?></td>
                    <td><input type="text" class="form-control" value="<?= $user->subarea; ?>" name="subarea" required></td>
                </tr>
                <tr>
                    <td>Projeto:</td>
                    <td><?= $user->projeto; ?></td>
                    <td><textarea cols="60" class="form-control" rows="3" name="projeto"
                                  required><?= $user->projeto; ?></textarea></td>
                </tr>
                <tr>
                    <td>Bolsa</td>
                    <td><?= $user->bolsa; ?></td>
                    <td>
                        <select name="bolsa" class="form-control" required>
                            <option value="PRAE">PRAE</option>
                            <option value="FIEX">FIEX</option>
                            <option value="Sem bolsa">Sem bolsa</option>
                            <option value="Outra">Outra</option>
                        </select>
                    </td>
                </tr>
                <!-- sdds -->
                <tr>
                    <td>E-mail:</td>
                    <td><?= $user->email; ?></td>
                    <td><input type="email" class="form-control" value="<?= $user->email; ?>" name="email" required></td>
                </tr>
                <tr>
                    <td>Fixo:</td>
                    <td><?= $user->fixo; ?></td>
                    <td><input type="tel" class="form-control" value="<?= $user->fixo; ?>" name="fixo" required></td>
                </tr>
                <tr>
                    <td>Celular:</td>
                    <td><?= $user->celular; ?></td>
                    <td><input type="text" class="form-control" value="<?= $user->celular; ?>" name="celular" required></td>
                </tr>
                <tr>
                    <td>RG:</td>
                    <td><?= $user->rg; ?></td>
                    <td><input type="text" class="form-control" value="<?= $user->rg; ?>" name="rg" required></td>
                </tr>
                <tr>
                    <td>Orgão:</td>
                    <td><?= $user->orgao; ?></td>
                    <td><input type="text" class="form-control" value="<?= $user->orgao; ?>" name="orgao" required></td>
                </tr>
                <tr>
                    <td>CPF:</td>
                    <td><?= $user->cpf; ?></td>
                    <td><input type="text" class="form-control" value="<?= $user->cpf; ?>" name="cpf" required></td>
                </tr>
                <tr>
                    <td>Conta:</td>
                    <td><?= $user->conta; ?></td>
                    <td><input type="text" class="form-control" value="<?= $user->conta; ?>" name="conta" required></td>
                </tr>
                <tr>
                    <td>Banco:</td>
                    <td><?= $user->banco; ?></td>
                    <td><input type="text" class="form-control" value="<?= $user->banco; ?>" name="banco" required></td>
                </tr>
                <tr>
                    <td>Agência:</td>
                    <td><?= $user->agencia; ?></td>
                    <td><input type="text" class="form-control" value="<?= $user->agencia; ?>" name="agencia" required></td>
                </tr>
                <tr>
                    <td>Tipo de Conta</td>
                    <td><?= $user->tipo_conta; ?></td>
                    <td>
                        <select name="tipoconta" class="form-control" required>
                            <option value="Corrente">Corrente</option>
                            <option value="Poupança">Poupança</option>
                            <option value="Outra">Outra</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td><?= $user->status; ?></td>
                    <td>
                        <select name="status" class="form-control" required>
                            <option value="Ativo">Ativo</option>
                            <option value="Inativo">Inativo</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?$login_usuario=$user->login;
                        include 'e-jbsm_bolsista_horario.php';?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="loginBolsista" value="<?= $bolsista_login ?>">
                        <button type="submit" class="btn btn-success" name="opcao" value="Editar bolsista">
                            Salvar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>