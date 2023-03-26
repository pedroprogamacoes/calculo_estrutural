d<?php

    header('Content-Type: text/html; charset=utf-8');
    session_start();
    if (!empty($_POST)) {

        // Cria a conexão
        //credenciais de acesso
        $servidor = "localhost";
        $utilizador = "root";
        $password = "";
        $basedados = "u784567453_db_bravoscap";

        //$link = mysql_connect("localhost", "root", "root");
        //mysql_select_db("psim19");
        //mysql_set_charset('utf8', $link);

        $ligacao = mysqli_connect($servidor, $utilizador, $password, $basedados) or exit('Erro de ligação à bd');
        mysqli_select_db($ligacao, $basedados);
        mysqli_set_charset($ligacao, "utf8");

        // verifica a conexão
        if (!$ligacao) {
            die('Problemas de Ligação: ' . mysqli_error());
        } else {
            $username = mysqli_real_escape_string($ligacao, $_POST['username']);
            $password = md5($_POST['password']);

            // var_dump($username);
            // var_dump($password);

            // define o query para verificar se o user está registado e com os dados corretos
            $consulta = "SELECT userid, username FROM users WHERE username = '$username' AND password = '$password' ";
            $login = mysqli_query($ligacao, $consulta);
            if ($login && mysqli_num_rows($login) == 1) {
                // o utilizador está correctamente validado
                // guardamos temporariamente os dados encontados na variável $registo
                $registo = mysqli_fetch_array($login, MYSQLI_ASSOC);

                // guardamos as suas informações numa sessão
                $_SESSION['id'] = $registo['userid'];
                $_SESSION['username'] = $registo['username'];

                //$_SESSION['id'] = mysql_result($login, 0, 0);
                //$_SESSION['username'] = mysql_result($login, 0, 1);

                mysqli_free_result($login);
                mysqli_close($ligacao);
            } else {
                // utilizador não validade... remete novamente para página de Login
                echo "<p>Utilizador ou password inválidos. <a href=\"index.php\">Tente novamente</a></p>";
            }
        }
    }

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 5 Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Sistema de calculos estruturais</h1>
        <p>Calculo de sapata</p>
    </div>

    <div class="container mt-5">
        <div style='text-align:right'>
            <p>Bem vindo(a), <?= $_SESSION['username']; ?></p>
        </div>
        <!-- <div class='container'> -->

        <div class="row">

            <div class="col-lg-12">
                <h1>Calculo de sapata</h1>
            </div>

            <hr>
            <fieldset>
                <!-- início form BRAVOS -->

                <form class="form-group" action="action_bravos.php" method="post" id='form-contato' enctype='multipart/form-data'>
                    <div class="row">


                        <div class="col-lg-3">

                            <div class="form-group">
                                <label for="pilar_a">Pilar A</label>
                                <input type="text" class="form-control" id="pilar_a" name="pilar_a" placeholder="Digite a primeira medida do pilar (cm) - Lado A:">
                                <span class='msg-erro msg-pilar_a'></span>
                            </div>

                        </div>

                        <div class="col-lg-3">

                            <div class="form-group">
                                <label for="pilar_b">Pilar B</label>
                                <input type="text" class="form-control" id="pilar_b" name="pilar_b" placeholder="Digite a segunda medida do pilar (cm) - Lado B:">
                                <span class='msg-erro msg-pilar_b'></span>
                            </div>

                        </div>

                        <div class="col-lg-5">

                            <div class="form-group">
                                <label for="carga">Carga</label>
                                <input type="text" class="form-control" id="carga" name="carga" placeholder="Qual a carga está atuando sobre esse pilar (kN/cm²)?">
                                <span class='msg-erro msg-carga'></span>
                            </div>

                        </div>



                        <hr style="margin-top:3%;">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="solo">Solo</label>
                                <select class="form-control" name="solo" id="solo">
                                    <option value="">Qual dado do solo prefere inserir?</option>
                                    <option value="1 - Tensão do solo"> 1 - Tensão do solo</option>
                                    <option value="2 - NSPT da base de apoio"> 2 - NSPT da base de apoio</option>

                                </select>
                                <span class='msg-erro msg-solo'></span>
                            </div>
                        </div>


                        <div class="col-lg-4">

                            <div class="form-group">
                                <label for="MPa">Tensão do solo</label>
                                <input type="text" class="form-control" id="MPa" name="MPa" placeholder="Digite o valor da tensão do solo (MPa): ">
                                <span class='msg-erro msg-MPa'></span>
                            </div>


                        </div>

                        <div class="col-lg-3">

                            <div class="form-group">
                                <label for="NSPT"> NSPT de base:</label>
                                <input type="text" class="form-control" id="NSPT" name="NSPT" placeholder="Digite o NSPT de base: ">
                                <span class='msg-erro msg-NSPT'></span>
                            </div>

                        </div>

                    </div>

                    <hr style="margin-top:3%;">

                    <div class="row">

                        <div class="col-lg-4">

                            <div class="form-group">
                                <label for="profundidade">Profundidade</label>
                                <input type="text" class="form-control " id="profundidade" name="profundidade" placeholder="Qual a profundidade que a sapata será assentada?">
                                <span class='msg-erro msg-profundidade'></span>
                            </div>

                        </div>

                        <div class="col-lg-4">

                            <div class="form-group">
                                <label for="fck">FCK</label>
                                <input type="text" class="form-control " id="fck" name="fck" placeholder="FYK do aço a ser utilizado (kN/cm²):  ">
                                <span class='msg-erro msg-fck'></span>
                            </div>


                        </div>

                        <div class="col-lg-4">

                            <div class="form-group">
                                <label for="fyk">FYK</label>
                                <input type="text" class="form-control " id="fyk" name="fyk" placeholder="FCK do concreto a ser utilizado (MPa): ">
                                <span class='msg-erro msg-fyk'></span>
                            </div>

                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-3">



                        </div>
                        <div class="row">
                         >


                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="peso" title="Deslise a barra até seu peso atual">Peso</label>
                                    <input type="range" class="custom-range" id="peso" name="peso" value="0" min="0" max="200" oninput="display.value=value" onchange="display.value=value">
                                    <input type="text" class="form-control" id="display" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="altura" title="Deslise a barra até a sua altura atual">Altura</label>
                                    <input type="range" class="custom-range" id="altura" name="altura" min="0" max="3" step='.01' value='0' oninput="display2.value=value" onchange="display2.value=value">
                                    <input type="text" class="form-control" id="display2" value="0" readonly>
                                </div>
                            </div>

                        </div>

              

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="telefone">Telefone</label>
                                    <input type="telefone" class="form-control" id="telefone" maxlength="12" name="telefone" placeholder="Informe o Telefone da família">
                                    <span class='msg-erro msg-telefone'></span>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="celular">Celular Whatsapp</label>
                                    <input type="celular" class="form-control" id="celular" maxlength="13" name="celular" placeholder="Informe o Celular da família">
                                    <span class='msg-erro msg-celular'></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="endereco">Endereço</label>
                                    <textarea class="form-control" id="endereco" name="endereco" placeholder="Infome o endereço"></textarea>
                                    <span class='msg-erro msg-endereco'></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                 
                        <hr>

                        <label class="form-group">
                            <label for="doenca">Selecione um ou mais itens abaixo, caso o alistado possua:</label><br>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group checkbox">
                                        <label><input type="checkbox" class="custom-control-label" name="alergia" id="alergia" value="sim">Alergia</label><br>
                                    </div>
                                    <div class="form-group checkbox">
                                        <label><input type="checkbox" class="custom-control-label" name="coracao" id="coracao" value="sim">Doença de coração</label><br>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group checkbox">
                                        <label><input type="checkbox" class="custom-control-label" name="respiracao" id="respiracao" value="sim">Doença respiratória</label><br>
                                    </div>
                                    <div class="form-group checkbox">
                                        <label><input type="checkbox" class="custom-control-label" name="especial" id="especial" value="sim">Necessidade especial</label><br>
                                    </div>
                                    <div class="form-group checkbox">
                                        <label><input type="checkbox" class="custom-control-label" name="outros" id="outros" value="sim">Outros...</label><br>
                                    </div>
                                    <span class='msg-erro msg-doenca'></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observacao">Descreva abaixo o que fazer em caso de emergência</label>
                                <textarea class="form-control" id="observacao" name="observacao" placeholder="Descrição dos itens acima selecionados"></textarea>
                                <span class='msg-erro msg-observacao'></span>
                            </div>

                            <div>
                                <label align="justify" for="adesao">Eu(Nós), <u> <span id='sinc2' name='sinc2'></span></u>,(e)
                                    <u> <span id='sinc3' name='sinc3'></span></u> responsável(eis) legal pelo alistado acima <u>
                                        <span id='sinc1' name='sinc1'></span></u>, autorizo(amos) a adesão ao grupo BRAVOS no
                                    projeto de escotismo da CAP (Casa de Adoração Profética) e ao o Sr. Fabricio Duarte Alves RG
                                    2725449 SSP/DF, tomar as medidas necessárias em caso de emergência, bem como disciplina a
                                    ser aplicada em relação aos princípios trabalhados por esta iniciativa.
                                </label><br>
                            </div>

                           

                       
                            <br><br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <input type="hidden" name="acao" value="incluir_publico">
                                    <input type="hidden" name="status" value="Ativo">
                                    <button type="submit" class="btn btn-primary" id='botao'>
                                        Gravar
                                    </button>
                                    <a href='index.php' class="btn btn-danger">Cancelar</a>
                                </div>
                            </div>
                </form>
            </fieldset>
        </div>
        <script type="text/javascript" src="js/custom.js"></script>

        <script>
            //validação de confirmação de senha
            var senha = document.getElementById("senha"),
                confirmacao = document.getElementById("confirmacao");

            function validatePassword() {

                if (senha.value != confirmacao.value) {
                    alert("Senhas diferentes!");
                    confirmacao.value = "";
                    senha.value = "";
                    senha.focus();
                    return false;
                }
            }
        </script>

</html>


</div>

</body>

</html>