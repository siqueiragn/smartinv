{*Gerado automaticamente com GC - 1.0 02/11/2015*}
<fieldset class="formPadrao">
     <legend>Usuário</legend>
             <input type="hidden" id="idUsuario" name="idUsuario" value="{$usuario->getIdUsuario()}" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="login">Login</label>
              <div class="col-sm-8">
                 <input type="text" id="login" name="login" value="{$usuario->getLogin()}" class=" form-control" required  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="password">Password</label>
              <div class="col-sm-8">
                 <input type="hidden" id="password" name="password" value="{$usuario->getPassword()}" class=" form-control" required  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="email">Email</label>
              <div class="col-sm-8">
                 <input type="text" id="email" name="email" value="{$usuario->getEmail()}" class=" form-control" required  />
              </div>
         </div>
</fieldset>

