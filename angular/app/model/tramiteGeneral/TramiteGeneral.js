"use strict";
var TramiteGeneral = (function () {
    function TramiteGeneral(id, vehiculoId, numeroQpl, fechaInicial, fechaFinal, valor, numeroLicencia, numeroSustrato, nombre, apoderado, empresaId, ciudadanoId) {
        this.id = id;
        this.vehiculoId = vehiculoId;
        this.numeroQpl = numeroQpl;
        this.fechaInicial = fechaInicial;
        this.fechaFinal = fechaFinal;
        this.valor = valor;
        this.numeroLicencia = numeroLicencia;
        this.numeroSustrato = numeroSustrato;
        this.nombre = nombre;
        this.apoderado = apoderado;
        this.empresaId = empresaId;
        this.ciudadanoId = ciudadanoId;
    }
    return TramiteGeneral;
}());
exports.TramiteGeneral = TramiteGeneral;
//# sourceMappingURL=TramiteGeneral.js.map