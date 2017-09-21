/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function makeAutoPattern(value, legenda) {
    for (var a in legenda) {
        if (parseFloat(legenda[a].minimo) <= value && parseFloat(legenda[a].maximo) >= value) {
            return makePattern(legenda[a].cor, legenda[a].pattern);
        }
    }
    return makePattern('#666666', 'solid');
}


/**
 * 
 * @param {type} color
 * @param {type} pattern
 * @returns {pattern}
 */
function makePattern(color, pattern) {
    
    if(!isNull(arguments[2])){
        var cnv = arguments[2];
    }else{
        var cnv = document.createElement('canvas');       
    }
     var ctx = cnv.getContext('2d');
    

    var patterns = new Object();

    patterns.linear = function () {
        cnv.width = 6;
        cnv.height = 6;
        ctx.fillStyle = color;

        for (var i = 0; i < 6; ++i) {
            ctx.fillRect(i, i, 1, 1);
        }

        return ctx.createPattern(cnv, 'repeat');
    };
       
    patterns.linear2 = function () {
        cnv.width = 6;
        cnv.height = 6;
        ctx.fillStyle = color;

        for (var i = 0; i < 6; ++i) {
            ctx.fillRect(i, i, 2, 2);
        }

        return ctx.createPattern(cnv, 'repeat');
    };
    
    patterns.verticalLinear = function () {
        cnv.width = 6;
        cnv.height = 1;
        ctx.fillStyle = color;

        for (var i = 0; i < 6; ++i) {
            ctx.fillRect(1, 0, 1, 1);
        }

        return ctx.createPattern(cnv, 'repeat');
    };

    patterns.dashed = function () {

        cnv.width = 6;
        cnv.height = 6;
        ctx.fillStyle = color;


        for (var i = 0; i < 6; ++i) {
            ctx.fillRect(i, i, 4, 1);
        }

        return ctx.createPattern(cnv, 'repeat');
    };

    patterns.solid = function () {
        cnv.height = 6;
        cnv.width = 6;
        ctx.fillStyle = color;

        ctx.fillRect(6, 6, 6, 6);

        return ctx.createPattern(cnv, 'repeat');
    };



    if (isNull(patterns[pattern])) {
        return patterns.solid();
    } else {
        console.log('oiiii')
        return patterns[pattern]();
    }


}

