//
exports.ListConcat = function(){
    this.itens = new Array();
    
    this.add = function(pack){
        this.itens.push(pack);
    };
    
    this.getDebugList = function(){
        var a = new Object();
        for(var i in this.itens){
            pack = this.itens[i];
            a[pack.getDebugFile()] = pack.origens; 
        }
        return a;
    };
    
     this.getDistList = function(){
        var a = new Object();
        for(var i in this.itens){
            pack = this.itens[i];
            a[pack.getDistFile()] = pack.origens; 
        }
        return a;
    }; 
    
    this.addComponente = function(componente){
        var tmpComp = new PackJS('componentes/'+componente, [ 'js/componentes/'+componente+'/*']);
        this.add(tmpComp);
    };
    
    
};
