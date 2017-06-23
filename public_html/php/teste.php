<?php
$con = mysqli_connect('localhost', 'root', '', 'phpaula');
$resultado = mysqli_query($con, 'SELECT * FROM Pessoa');

echo "<table>";
while($linha = mysqli_fetch_assoc($resultado)) {
echo "<td>" .$linha['codpessoa'] . "</td>";
echo "<td>" .$linha['nome'] . "</td>";
echo "<td>" .$linha['endereco'] . "</td>";
echo "<td>" .$linha['telefone'] . "</td>";
echo "<input type='submit' value='Enviar'>";

}
echo "</table>";
?>


<form name='formulario' action='inserir.php'>
<input type="text" placeholder="nome" name="nome">
<input type="text" placeholder="endereco" name="endereco">
<input type="text" placeholder="telefone" name="telefone">
<input type="submit" value="Enviar">
</form>