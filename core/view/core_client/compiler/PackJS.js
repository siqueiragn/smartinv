//Sources para o concat e o uglify
exports.PackJS = function (local) {

    this.rootJS = '../../../www/js/';
    this.prefix = '';
    this.destino = local;
    this.origens = null === arguments[1] ? new Array() : arguments[1];
    this.mainFile = 'main';

    this.setOrigem = function (array) {
        this.origens = new Array();
        for (var a in array) {
            this.origens.push(this.prefix + array[a])
        }
    };

    this.getDistFile = function () {
        return this.rootJS + 'dist/' + this.destino + '/' + this.mainFile + '.js';
    };

    this.getDebugFile = function () {
        return this.rootJS + 'debug/' + this.destino + '/' + this.mainFile + '.js';
    };

    this.getCompile = function () {
        return {
            src: this.origens,
            dest: this.getDistFile()
        };
    };

    this.getDebug = function () {
        return {
            src: this.origens,
            dest: this.getDebugFile()
        };
    };

    //private functions
};
