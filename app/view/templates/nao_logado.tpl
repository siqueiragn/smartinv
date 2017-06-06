<div class="container">
    <form id="formLogin" class="login-form" action="/login/valida" method="post">        
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" name="usuario" class="form-control" placeholder="Usuário" autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input name="senha" type="password" class="form-control" placeholder="Senha">
            </div>
            <label class="checkbox">
                <input type="checkbox" name="lembrar" value="remember-me"> Lembrar de mim nos próximos login
                <span class="pull-right"> <a href="#"> Perdeu a senha?</a></span>
            </label>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            <button class="btn btn-info btn-lg btn-block" type="submit" id="cadastroTelaBt">Cadastro</button>
        </div>
      </form>
</div>

    

