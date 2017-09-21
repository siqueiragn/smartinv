Alguns padrões adotados.

<h2>Versionamento</h2>
O padrão de versionamento é o conhecido como semantico 1.0.0 e pode ser visto em:
http://semver.org/lang/pt-BR/
Sempre que criar uma classe adicione a versão corrente do código atualmente em 0. Não estável e não lançada. 

<h4>Não deixe de ler o <a href="https://about.gitlab.com/2016/03/08/gitlab-tutorial-its-all-connected/">Tutorial de navegação do Gitlab</h4>.

<h2>Regras de Commit</h2>

Se possível (e quando necessário), o commit deve manter um corpo estrutural padronizado.
Utilizaremos o padrão utilizado em alguns projetos do Google (simplificado)

<code> TYPE(TARGET): DESCRIPTION. </code>

O <code>TARGET</code> é o alvo de modificações do commit. Pode ser um arquivo, ou um módulo da aplicação.

<h3>Types Permitidos</h3>

* FEAT: Commits com adição de funcionalidade (Seja ela pronta ou em progresso);
* FIX: Um bugfix. Se houver uma Issue relacionada, deve-se fechá-la;
* REFACT: Algumas melhorias de código (Sejam elas de performance, de limpeza, ou de documentação);

<h3>Fechando Issues</h3>

Para fechar uma Issue cadastrada aqui no Gitlab, o commit message deve conter (Após o ponto, por padrão):

<code>COMMIT_MESSAGE. closes #ISSUE_NUMBER.</code>

<code>COMMIT_MESSAGE</code> sendo a mensagem em si e <code>ISSUE_NUMBER</code> o número da Issue aqui no Gitlab.

<h3>Mudando o status de tarefas</h3>

Se queres mudar o status de alguma tarefa ou issue, vá até ela e adicione a label.

<h3>Status permitidos</h3>

* done: Feshow! dê um close na issue;
* in_progress: Apenas faça o assign de quem está fazendo a tarefa;
* stat:cursed: É amaldiçoado mesmo. Nesse caso, a tarefa está presa em algumas linhas de código :astonished:;
* needs:review: Adicione essa label para quando quiser indicar que o trabalho a ser commitado não se encaixa com o que foi requisitado. Precisando de revisão;
* needs:test: Essa label serve para incar que o trabalho commitado necessita de testes para ser homologado;

<h3>Chamando alguem (ou @all todo mundo)</h3>

Se queres chamar alguém na sua commit message, não tenha vergonha :kissing:

<code>Basta chamar com @USER_NAME.</code>


