"use strict";
var Almacen = (function () {
    function Almacen(id, servicioId, organismoTransitoId, consumibleId, claseId, rangoInicio, rangoFin, lote) {
        this.id = id;
        this.servicioId = servicioId;
        this.organismoTransitoId = organismoTransitoId;
        this.consumibleId = consumibleId;
        this.claseId = claseId;
        this.rangoInicio = rangoInicio;
        this.rangoFin = rangoFin;
        this.lote = lote;
    }
    return Almacen;
}());
exports.Almacen = Almacen;
//# sourceMappingURL=Almacen.js.map