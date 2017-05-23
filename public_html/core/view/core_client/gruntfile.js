var fs = require('fs');


GLOBAL.PackJS = require('./compiler/PackJS.js').PackJS;
GLOBAL.ListConcat = require('./compiler/ListConcat.js').ListConcat;

if(fileExists('../../../app/view/gruntLocal.js')){
    GLOBAL.AppendTasks = require('../../../app/view/gruntLocal.js').ListConcat;
}


function fileExists(filePath)
{
    try
    {
        return fs.statSync(filePath).isFile();
    }
    catch (err)
    {
        return false;
    }
}

function libJS(lib){

    var destino = (new PackJS(lib)).rootJS;
    var ret = { src: 'js/' + lib + '/' + lib + '.js' };
    if (arguments[1]){
        ret.dest = destino + 'debug/' + lib + '/' + lib + '.js';
       
    }else {
        ret.dest = destino + 'dist/' + lib + '/' + lib + '.js';
    }
    return ret;
}

var concatLibs = new ListConcat();

var mapa = new PackJS('componentes/mapa', [ 'js/componentes/mapa/**']);
concatLibs.add(mapa);

concatLibs.addComponente('date_picker');
concatLibs.addComponente('color_picker');
concatLibs.addComponente('frame_post');

    
var enyalius = new PackJS('enyalius', [ 'js/enyalius/*']);
concatLibs.add(enyalius);


var tabelaManterDados =   new PackJS('componentes/tabela');
    tabelaManterDados.prefix = 'js/componentes/tabela/';
   tabelaManterDados.setOrigem(['tabela.js', 'tabela_manter_dados.js']);
   tabelaManterDados.mainFile  = 'tabela_manter_dados';
   concatLibs.add(tabelaManterDados);
   
var tabelaRelatorio =   new PackJS('componentes/tabela');
    tabelaRelatorio.prefix = 'js/componentes/tabela/';
   tabelaRelatorio.setOrigem(['tabela.js', 'tabela_relatorio.js']);   
   tabelaRelatorio.mainFile  = 'tabela_relatorio';
    concatLibs.add(tabelaRelatorio);
   
var jqgrid = new PackJS('jqgrid');
    jqgrid.origens = ['js/jqgrid/jqgrid.js', 'js/jqgrid/i18n/grid.locale-pt-br.js' ];
  concatLibs.add(jqgrid);
 
var tasks =
        {
        uglify : {
            options : {
                // mangle : false
            },            
            target : {
                files: concatLibs.getDistList()
            }
        }, // uglify
        concat: {
            basic_and_extras: {
              files: concatLibs.getDebugList()
            }
          },
        
        copy: {
            main: {
                files: [ {  expand: true, src: ['media/**','css/fonts/**'], dest: '../../../www/'},   
                            libJS('openlayers', true),
                             libJS('bootstrap', true)
                        ]
            }
        }, //copy
        
        sass: {
           dist: {
                options: {                       // Target options
                    style: 'compressed'
                },
                files: [{
                    expand: true,
                    cwd: 'css',
                    src: ['**/*.scss', '**/*.css'],
                    dest: '../../../www/css/',
                    ext: '.css'
             }]
           }
        },// sass

        watch : {
            dist : {
                files : [
                        'js/**/*',
                        'css/**/*'
                ],
                tasks : [ 'concat', 'sass']
            }
        } // watch
    };

//Inicio do módulo do grunt
module.exports = function(grunt) {
    grunt.initConfig(tasks);
    // Plugins do Grunt
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    
    // Tarefas que serão executadas
    grunt.registerTask('default', [ 'concat', 'uglify:target' ]);
    
    // Tarefa para Watch
    grunt.registerTask('w', [ 'watch' ]);
    // Tarefa para install
    grunt.registerTask('i', [ 'concat', 'uglify', 'copy', 'sass' ]);
    grunt.registerTask('s', [ 'sass' ]);
};
