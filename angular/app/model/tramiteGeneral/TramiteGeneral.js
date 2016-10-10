"use strict";
var TramiteGeneral = (function () {
    function TramiteGeneral(id, vehiculoId, numeroQpl, fechaInicial, fechaFinal, valor, numeroLicencia, numeroSustrato, nombre) {
        this.id = id;
        this.vehiculoId = vehiculoId;
        this.numeroQpl = numeroQpl;
        this.fechaInicial = fechaInicial;
        this.fechaFinal = fechaFinal;
        this.valor = valor;
        this.numeroLicencia = numeroLicencia;
        this.numeroSustrato = numeroSustrato;
        this.nombre = nombre;
    }
    return TramiteGeneral;
}());
exports.TramiteGeneral = TramiteGeneral;
//# sourceMappingURL=TramiteGeneral.js.map